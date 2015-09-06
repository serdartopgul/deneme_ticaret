<?php
session_start();
//if(!isset($_SESSION['uye']) || !isset($_COOKIE['uye']))die("Giriş Yapınız!");
require("baglanti.php");
$liste=$bag->query("select * from urunler limit 0,2");
$urunsayisi=$bag->query("select count(*) from urunler");
$say=$urunsayisi->fetch_row();
foreach ($say as $sayfa) {
	 $sayfa;
}


?>
<div style="width:80%;border:solid 1px;margin:20px auto;background:#dedede;padding:10px;height:500px">
	<div style="height:40px;background:red;border-radius:10px; "></div>
	<div style="margin-top:20px;padding:10px;background:#f1f1f1;height:400px">
		<div style="float:left;width:300px;height:100%;">
			<div style="text-align:center;background:#dedede;margin-top:50px"><b>Hoşgeldiniz SN.</b></div>
			<div style="text-align:center;background:#dedede;margin-top:30px">Ziyaretçi Sayısı:</div>
			<div style="text-align:center;background:#dedede;margin-top:10px">Ürün Sayısı:<?php echo $sayfa; ?></div>
			<div style="text-align:center;background:#dedede;margin-top:10px">Toplam TL:</div>
			<div style="text-align:center;background:#dedede;margin-top:10px">Satılan Ürün Sayısı:</div>
			<div style="text-align:center;background:#dedede;margin-top:10px">Satılan ürün TL:</div>
			<div style="text-align:center;background:#dedede;margin-top:10px;height:18px"></div>
			<div style="text-align:center;background:#dedede;margin-top:10px;height:18px"></div>
			<div style="text-align:center;background:#dedede;margin-top:10px;height:18px"></div>
			<div style="text-align:center;background:#dedede;margin-top:10px;height:18px"></div>
		</div>
		<div style="float:left;width:737px;height:100%;margin-left:5px">
			<div style="text-align:center;background:#dedede;margin-top:50px;height:18px">Ürünler</div>
			<div style="text-align:center;background:#dedede;margin-top:30px">
				<table border=1>
					<tr>
						<td width=50px>ID</td>
						<td width=150px>Ürün</td>
						<td width=100px> Resim</td>
						<td width=150px>Ürün Açıklaması</td>
						<td width=50px>Fiyat</td>
						<td width=100px>Kategori</td>
						<td width=100px>Yazar</td>
						<td>Stok</td>
					</tr>
					
						<?php 
						while($row=$liste->fetch_row()){ ;
						?>		
						<tr>
							<td><?php echo $row[0]; ?></td>
							<td><?php echo $row[1]; ?></td>
							<td><?php 

							echo "<img width=104px height=58px src=urunler/{$row[2]}>"; 

							?></td>
							<td><?php if(strlen($row[3])>50){
								echo substr($row[3],0,50)."..." ;
							}
							 ?></td>
							<td><?php echo $row[4]; ?></td>
							<td><?php echo $row[6]; ?></td>
							<td><?php echo $row[7]; ?></td>
							<td><?php echo $row[8]; ?></td>



						</tr>
						<?php } ;?>
				
				</table>

			</div>

		</div>
	</div>

</div>