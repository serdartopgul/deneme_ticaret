<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>2. El Kitap Satışı</title>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/windowopen.js"></script>
<script type="text/javascript" src="js/boxOver.js"></script>
<script src="http://code.jquery.com/jquery-1.11.3.js"></script>
<style>
.azcok{
  margin:15px 0;
}
.art{
  background:grey;
  padding:10px;
  border-radius: 10px 0 0 10px;
  border:0;
  margin-right:-3px;
  cursor:pointer;
}
.say{
    background:lightgrey;
  padding:10px;
  margin:0;
  border:0;
  width:50px;

}
.eks{
  background:grey;
  padding:10px;
  border-radius:0 10px 10px 0;
  margin-left:-3px;
  cursor:pointer;
}
</style>
<script>

  $(document).ready(function(){    
    $('.art').click(function(){
      var deger = $('.say').text();
      $('.say').html(parseInt(deger)+1);

    })
    $('.eks').click(function(){
      var deger = $('.say').text();
      $('.say').html(parseInt(deger)-1);

    })

  })
</script>
</head>

<body>

  <?php
  session_start();
  if(!isset($_SESSION['sepet']))die("Hatalı istek");
  require("baglanti.php");
  $detay=$bag->prepare("select * from urunler where id = ? ");
  $detay->bind_param("i",$_GET['urun']);
  $detay->execute();
  $res=$detay->get_result();

  ?>
  <?php

  if(!isset($_SESSION['sepet'])){
     $_SESSION['sepet']=array();
  }
  if($_POST){
    if(is_array($_SESSION['sepet'][$_POST['id']])){
        $_SESSION['sepet'][$_POST['id']]['adet']+=1;
    }else{
        $_SESSION['sepet'][$_POST['id']]=$_POST;
    }
    header("location:".substr($_SERVER['REQUEST_URI'],7));
  }
  if(@$_GET['urun_id']){
    if(is_array($_SESSION['sepet'][$_GET['urun_id']])){
      unset($_SESSION['sepet'][$_GET['urun_id']]);
     header("location:index.php");
    }
    
  }
function parabirimi($para){ 
  if(stristr($para, ".")==false){
     $deger=$para.",00";
  }else{
    $oncesi=stristr($para, ".",true);
    $sonrasi=stristr($para, ".");
    $sonrasi=substr($sonrasi,0,3);
    $sonrasi=str_replace(".", ",", $sonrasi);
    $sonrasi=str_pad($sonrasi,3,"0",STR_PAD_RIGHT);
    $deger= $oncesi.$sonrasi;
  }
      return $deger;
}
  ?>

<div id="main_container">
  <div class="top_bar">
   <div class="top_search">
      <div class="search_text"><a href="#">Site içi arama...</a></div>
      <input type="text" class="search_input" name="search" />
      <input type="image" src="images/search.gif" class="search_bt"/>
    </div>
    
  </div>
  <div id="header">
    <div id="logo"> <a href="#"><img src="images/logo.png" alt="" border="0" width="237" height="140" /></a> </div>
    <div class="oferte_content">
      <div class="top_divider"><img src="images/header_divider.png" alt="" width="1" height="164" /></div>
      <div class="oferta">
        <div class="oferta_content"> <img src="images/laptop.png" width="94" height="92" alt="" border="0" class="oferta_img" />
          <div class="oferta_details">
            <div class="oferta_title">Samsung GX 2004 LM</div>
            <div class="oferta_text"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco </div>
            <a href="details.html" class="details">details</a> </div>
        </div>
        <div class="oferta_pagination"> <span class="current">1</span> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> </div>
      </div>
      <div class="top_divider"><img src="images/header_divider.png" alt="" width="1" height="164" /></div>
    </div>
    <!-- end of oferte_content-->
  </div>
  <div id="main_content">
     <div id="menu_tab">
      <div class="left_menu_corner"></div>
      <ul class="menu">
        <li><a href="#" class="nav1">Anasayfa</a></li>
        <li class="divider"></li>
        <li><a href="#" class="nav2">Hakkımızda</a></li>
        <li class="divider"></li>
        <li><a href="#" class="nav3">Fırsatlar</a></li>
        <li class="divider"></li>
        <li><a href="#" class="nav4">İletişim</a></li>
        <li class="divider"></li>
        <li><a href="contact.html" class="nav5">Üye Girişi</a></li>
        <li class="divider"></li>
        

      </ul>
      <div class="right_menu_corner"></div>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> <span class="current">Ürün Detay</span> </div>
    <div class="left_content">
      <div class="title_box">Kategoriler</div>
      <ul class="left_menu">
        <li class="odd"><a href="#">Edebiyat</a></li>
        <li class="even"><a href="#">Araştırma</a></li>
        <li class="odd"><a href="#">Akademik</a></li>
        <li class="even"><a href="#">Eğitim</a></li>
        <li class="odd"><a href="#">Çocuk</a></li>
        <li class="even"><a href="#">Hobi</a></li>
        <li class="odd"><a href="#">Dergi</a></li>
        <li class="even"><a href="#">E-Kitap</a></li>
        <li class="odd"><a href="#">Sesli Kitap</a></li>
          </ul>
      
    
     
    </div>
    <!-- end of left content -->
    <div class="center_content">
        <?php  while($row=$res->fetch_row()){
            $cikar=$row[4]*($row[5]/100);
   ?>
   <form action="" method="post">
      <div class="center_title_bar"><?php echo $row[1]; ?></div>
     <input type="hidden" name="id" value="<?php echo $row[0]; ?>"/>
     <input type="hidden" name="urun" value="<?php echo $row[1]; ?>"/>
     <input type="hidden" name="fiyat" value="<?php echo parabirimi($row[4]-$cikar); ?>"/>
     <input type="hidden" name="adet" value="1"/>
      <div class="prod_box_big">
        <div class="top_prod_box_big"></div>
      
        <div class="center_prod_box_big">
          <div class="product_img_big"> <a href="javascript:popImage('urunler/<?php echo $row[2]; ?>','<?php echo $row[1]; ?>')" title="header=[Zoom] body=[&nbsp;] fade=[on]"><img width="94" height="92" src="urunler/<?php echo $row[2]; ?>" alt="" border="0" /></a>
            <div class="thumbs"> <a href="#" title="header=[Thumb1] body=[&nbsp;] fade=[on]"><img src="urunler/<?php echo $row[2]; ?>" alt="" border="0" /></a> <a href="#" title="header=[Thumb2] body=[&nbsp;] fade=[on]"><img src="urunler/<?php echo $row[2]; ?>" alt="" border="0" /></a> <a href="#" title="header=[Thumb3] body=[&nbsp;] fade=[on]"><img src="urunler/<?php echo $row[2]; ?>" alt="" border="0" /></a> </div>
          </div>
          <div class="details_big_box">
            <div class="product_title_big"><?php echo $row[1]; ?></div>
            <div class="specifications"> Stok Durumu: <span class="blue"><?php echo $row[8];?></span><br />
              Yazar: <span class="blue"><?php echo $row[7];?></span><br />
              Kategorisi: <span class="blue"><?php echo $row[6];?></span><br />
             <div class="azcok"> Adet:
              <span class="art">+</span>
              <span class="say" value="">0</span>
              <span class="eks">-</span></div>
              <span style="background:red;"><?php echo "% ".$row[5]." indirim";?></span><br />
        
             
            </div>
            <div class="prod_price_big"><span class="reduce"><?php echo parabirimi($row[4]);?></span> <span class="price"><?php echo parabirimi($row[4]-$cikar);?>TL</span></div>
            <button >Sepete Ekle</button>  </div>
        </div>
            </form>
        <div class="bottom_prod_box_big"></div>
      </div>
        <?php } ;?>
      
    </div>
    <!-- end of center content -->
    <div class="right_content">
      <div class="shopping_cart">
        <div class="cart_title">Sepetim</div>
        <div class="cart_details"> 
           <?php
           if(count($_SESSION['sepet'])>0){
            $adetler=count($_SESSION['sepet']);
            echo "<table border=0>";
              foreach($_SESSION['sepet'] as $diz => $sepet){
           echo "<tr><td>".$sepet['urun']."</td><td><a href='details.php?urun_id=".$sepet['id']."'>SİL</a></td></tr>";
           echo "<tr><td>".$sepet['fiyat']."</td></tr>";
                $carp=$sepet['adet']*$sepet['fiyat'];
                @$toplam+=$carp;

              }
             echo "</table>";
               echo ' <span class="border_cart"></span> Total:'.parabirimi($toplam).' TL</br>';
              echo ' <span class="border_cart"></span> Ürün:'.$adetler.' adet</br>';
             echo "<div><a href='sepet.php'>Alış verişi tamamla</div>";
           }else{

            echo ' <span class="border_cart"></span> Total:0 TL</br>';
            echo ' <span class="border_cart"></span> Ürün:0 adet</br>';
           }
           ?>
        
      </div>
    
      
    
    </div>
    <!-- end of right content -->
  </div>
  <!-- end of main content -->
  <div class="footer">
    <div class="left_footer"> <img src="images/footer_logo.png" alt="" width="170" height="49"/> </div>
    <div class="center_footer"> 2015 Serdar Topgül &copy;<br />
     <br />
      <img src="images/payment.gif" alt="" /> </div>
    <div class="right_footer"> <a href="#">anasayfa</a> <a href="#">hakkımızda</a> <a href="#">siteharitası</a> <a href="#">ürün iade</a> <a href="contact.html">iletişim</a> </div>
  </div>
</div>
<!-- end of main_container -->
</body>
</html>
