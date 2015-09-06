<?php
session_start();
if(!isset($_SESSION['sepet']))die("hata");
    $db=new mysqli("localhost","root","","store");
	if($db->connect_errno)die("Baglantı hatası:".$db->connect_error);
	$db->set_charset("utf8");
	$sql=$db->query("select * from siparis");
	if($sql->num_rows<1)echo "Siparişiniz yok";
	$table='<table border=1>
	<tr>
	<td>Id</td>
	<td>Musteri_adı</td>
	<td>Sipariş verilen ürün bilgisi</td>
	<td>Telefon</td>
	<td>Email</td>
	<td>Adres</td>
	<td>Payu referansı</td>
	<td>tarih</td>
	</tr>';
	foreach ($sql->fetch_all() as $row) {
	$table.='<tr>'
	.'<td>'.$row[0].'</td>'
	.'<td>'.$row[1].'</td>'
	.'<td>'.$row[2].'</td>'
	.'<td>'.$row[3].'</td>'
	.'<td>'.$row[4].'</td>'
	.'<td>'.$row[5].'</td>'
	.'<td>'.$row[6].'</td>'
	.'<td>'.$row[7].'</td>'
	.'</tr>';
	}
$table='</table>';
echo $table;
$db->close();
	?>