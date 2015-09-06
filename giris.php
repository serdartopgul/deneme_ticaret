<?php
ob_start();
if(@$_GET['cikis']){
	session_start();
	session_destroy();
	echo" çıkış başarılı";
		header('refresh:3; url=http:/store/index.php');
}
if($_POST){
	$kadi=$_POST['kadi'];
	$sifre=$_POST['sifre'];
$bag=new mysqli("localhost","root","","store");
if($bag->connect_errno)die("Hatalı".$bag->connect_error);
$bag->set_charset('utf8');
$giris=$bag->prepare("select * from uyeler where ad = ? and sifre = ? ");
$giris->bind_param("ss",$kadi,$sifre);
$giris->execute();
$resul=$giris->get_result();
if($resul->num_rows >0){
while($row = $resul->fetch_object()){
	session_start();
	$_SESSION['kadi']=$row->ad;
	setcookie("kadi",'$row->ad');
	echo "siteye yönlendiriliyorsunuz.";
		header('Location:index.php');
}


}else{
	Echo "Kullanıcı hatası";
	header('refresh:3; url=http:/store/index.php');
}
}

ob_end_flush();



?>