<?php
session_start();
if(!isset($_SESSION['sepet']))die("Hatalı istek");
$url="https://secure.payu.com.tr/order/alu.php";
$secretkey='SECRET_KEY';
$veri=array(
	"MERCHANT"=>"OPU_TEST",
	"ORDER_REF"=>rand(1000,9999),
	"ORDER_DATE"=>gmdate('Y-m-d H:i:s')
	);
$urun=array();
$siparis='';
foreach ($_SESSION['sepet'] as $id => $v) {
		$i=0;
		$toplam=$v['adet']*$v['fiyat'];
		@$topla+=$toplam;
		$urun += array(
			"ORDER_PNAME[$i]" => $v['urun'],
			"ORDER_PCODE[$i]" => $v['id'],
			"ORDER_PINFO[$i]" => $v['urun'],
			"ORDER_PRICE[$i]" => $toplam,
			"ORDER_QTY[$i]" => $v['adet']
			);
		 $i++;

		 $siparis.="<b>".$v['urun']."</b>";
		 $siparis.="Adet:".$v['adet'];
		 $siparis.="Fiyat:".$v['fiyat']*$v['adet']."</br>";
		
		}

$siparis.="Toplam:".$topla;
@$_SESSION['form'] = $_POST['ad'].' '.$_POST['soyad'].' * '.$siparis.' * '.$_POST['email'].' * '.$_POST['tel'].' * '.$_POST['adres'];
$hesap=array(
	"PRICES_CURRENCY"=>"TRY",
	"PAY_METHOD"=>"CCVISAMC",
	"SELECTED_INSTALLMENTS_NUMBER"=>$_POST['taksit'],
	"CC_NUMBER"=>$_POST['kartno'],
	"EXP_MONTH"=>$_POST['ay'],
	"EXP_YEAR"=>$_POST['yil'],
	"CC_CVV"=>$_POST['cvv'],
	"CC_OWNER"=>$_POST['ad'].' '.$_POST['soyad'],
	"BACK_REF"=>"http://localhost/store/3ds_return.php",
	"CLIENT_IP"=>$_SERVER['REMOTE_ADDR'],
	"BILL_LNAME"=>$_POST['soyad'],
	"BILL_FNAME"=>$_POST['ad'],
	"BILL_EMAIL"=>$_POST['email'],
	"BILL_PHONE"=>$_POST['tel'],
	"BILL_COUNTRYCODE"=>"TR",
	);

$arParams=$veri+$urun+$hesap;

ksort($arParams);
$hashstring='';
foreach ($arParams as $key => $val) {
	$hashstring .=strlen($val).$val;
}

 $arParams['ORDER_HASH']=hash_hmac("md5", $hashstring, $secretkey);
// hash hesaplama bitti.
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arParams));
$response= curl_exec($ch);
$curlcode=curl_errno($ch);
$curlerr=curl_error($ch);

if(empty($curlerr) && empty($curlcode)){
	$parsedxml=@simplexml_load_string($response);
	if($parsedxml !== FALSE){
		$referans=$parsedxml->REFNO;
		if($parsedxml->STATUS == 'SUCCESS'){
			if(($parsedxml->RETURN_CODE=="3DS_ENROLLED") && (!empty($parsedxml->URL_3DS))){
				header("location:".$parsedxml->URL_3DS);
				die();
			}
			$db=new mysqli("localhost","root","","store");
			if($db->connect_errno)die("Baglantı hatası:".$db->connect_error);
			$db->set_charset("utf8");
			list($ad,$siparis,$tel,$email,$adres)= explode(' * ',$_SESSION['form']);
			$sql=$db->prepare('insert into siparis values (NULL,?,?,?,?,?,?,NULL)');
			if($sql ===false)die("sorgu hatası:".$db->error);
			$sql->bind_param('ssssss',$ad,$siparis,$tel,$email,$adres,$referans);
			$sql->execute();
			$sql->close();
			$db->close();
			unset($_SESSION['form'],$_SESSION['sepet']);
			echo "Teşekkürler[payu hesabınız:".$referans."]";
		}else{
			$mes=$parsedxml->RETURN_MESSAGE;
			if($parsedxml->RETURN_CODE=='ORDER_TOO_OLD'){
				echo "<b>Bu sipariş zaten mevcut.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='INVALID_PAYMENT_INFO') {
				echo "<b>Geçersiz Kart Numarası.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='INVALID_PAYMENT_METHOD_CODE') {
				echo "<b>Bu hesap için geçersiz ödeme yöntemi:CCVISAMC</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='AUTHORIZATION_FAILED') {
				echo "<b>Yetkilendirme red edildi.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='INVALID_CUSTOMER_INFO') {
				echo "<b>HATALI MÜŞTERİ BİLGİSİ.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='INVALID_ACCOUNT') {
				echo "<b>geçersiz hesap.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='REQUEST_EXPIRED') {
				echo "<b>iSTEK ZAMANAŞIMINA UGRADI.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='INVALID_CURRENCY') {
				echo "<b>HATALI PARA BİRİMİ</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='HASH_MISMATCH') {
				echo "<b>HASH HESAPLAMADA HATA VAR.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='GWERROR_-9') {
				echo "<b>KARTIN SON KULLANAM TARHİ GEÇMİŞ.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='GWERROR_14') {
				echo "<b>BÖYLE BİR KART BULUNMAMAKTADIR.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='GWERROR_34') {
				echo "<b>KREDİ KARTO ÇALINTIDIR</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='GWERROR_54') {
				echo "<b>KART KULLANILMIYOR.</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='GWERROR_84') {
				echo "<b>CVV2 HATALI</b>".$mes;
			}
			else if ($parsedxml->RETURN_CODE=='10101') {
				echo "<b>SATICI TAKSİTLİ ÖDEME İZNİ VERMEMİŞ.</b>".$mes;
			}
			else{
			echo $parsedxml->RETURN_CODE.' : '.$mes;
		}
		if(!empty($referans)){
			echo "<p>referans nosu:".$referans;
			}
		}
	}
} else{
	echo "curl error:".$curlerr;
}

?>