<?php
session_start();
if(!isset($_SESSION['kadi']))die("Üye girişi yapnız");
$aylar=array();
for($a=12;$a>0;$a--){
	$aylar[]=array(
		'text'=>str_pad($a,2,"0",STR_PAD_LEFT),
		'value'=>str_pad($a,2,"0",STR_PAD_LEFT)
		);

}
$yil=date("Y");
$yillar=array();
for($i=$yil;$i<$yil+10;$i++){
	$yillar[]=array(
		'text'=>$i,
		'value'=>$i
		);
}

?>
<div style="width:200px;">
<form method="post" action="satinal.php">
Peşin ödeme:<input type="radio" value="0" name="taksit" checked/>
Taksit:		<input type="radio" value="2" name="taksit" />
Kart adı:	<input type="text" name="ad"/>
Kart soyadı:<input type="text" name="soyad"/>
Eposta:		<input type="text" name="email"/>
Telefon:	<input type="text" name="tel"/>
Kart no:	<input type="text" name="kartno"/>
Son.Kull.Tar:
<select name="ay">
<?php foreach($aylar as $ay){
	echo "<option value='".$ay['value']."'>".$ay['text']."</option>";
}
?>
</select>
<select name="yil">
<?php foreach($yillar as $yil){
	echo "<option value='".$yil['value']."'>".$yil['text']."</option>";
}

?>
</select>
Cvv2:	<input type="text" name="cvv"/>
Adres: <textarea name="adres" rows=3 cols=30></textarea>
<input type="submit"/>
</form>
</div>