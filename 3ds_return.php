<?php
$secretkey='SECRET_KEY';	
if(!isset($_POST['HASH']) || !empty($_POST['HASH'])){
	$arParams=$_POST;
	unset($arParams['HASH']);
	$hashstring='';
	foreach ($arParams as $val) {
		 $hashstring.=strlen($val).$val;
	}
	$expectedhash = hash_hmac("md5", $hashstring, $secretkey);
	if($expectedhash != @$_POST['HASH']){
		die("Hash hatası.");
	}
	$referans=$_POST['REFNO'];
	$odenen=$_POST['AMOUNT'];
	$para_birimi=$_POST['CURRENCY'];
	$taksit=$_POST['INSTALLMENTS_NO'];
	if(($_POST['STATUS'])=="SUCCESS"){
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
		echo "Hata".$_POST['RETURN_MESSAGE']."[".$_POST['RETURN_CODE']."]";
	}
}else{
	die("Hatta");
}
?>