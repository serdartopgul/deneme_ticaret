<?php
$bag=@new mysqli("localhost","root","","store");
if($bag->connect_errno)die("Baglantı hatası:".$bag->connect_error);
$bag->set_charset("utf8");
?>