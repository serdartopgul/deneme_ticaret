<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>2. El Kitap Satışı</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
$(document).ready(function(){
  $('#giris').click(function(){
    $('#pan').toggle(1000);
  });

})
</script>
<style>
#pan input[type=text],#pan input[type=password]{
  margin-top:15px;
}
#pan input[type=submit]{
  margin-top:15px;
}
</style>
</head>
<body>
  <?php
  session_start();
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
            <a href="details.html" class="details">İncele...</a> </div>
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
<?php if(isset($_SESSION['kadi'])){

              echo '<li id="ac" style="position:relative"><b style="float:left;margin:0 20px;color:#676d77">Hoş gelidniz SN.'.$_SESSION["kadi"].'</b> </li>';
              echo '<li class="divider"></li><li><a href="giris.php?cikis=cikis">Çıkış</a></li>';
              }else{ ;?>

        <li id="ac" style="position:relative"><b id="giris" style="cursor:pointer;float:left;margin:0 20px;color:#676d77">Üye Girişi</b>
        <div id="pan" style="display:none;box-shadow:5px 5px 5px;width:300px;height:150px;position:absolute;top:50px;left:-109px;background: url(images/menu_bg.gif) ;background-size:cover;">
            <div style="text-align:center;">
              
            <form action="giris.php" method="post">
              <input type="text" name="kadi"/>
              <input type="password" name="sifre" /></br>
              Beni hatırla<input type="checkbox" name="hatirla"/>
              <input type="submit"/>
            </form>
</div>
        </div>

        </li>
        <?php } ;?>




        <li class="divider"></li>
        

      </ul>
      <div class="right_menu_corner"></div>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"><span class="current">Anasayfa</span> </div>
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
      <div class="center_title_bar">Son Eklene Ürünler</div>
     <?php
  require("baglanti.php");
  $urunler=$bag->query("select * from urunler");
  $sonuc=$urunler->fetch_all(MYSQLI_ASSOC);
foreach ($sonuc as $key => $dondur) {
  $cikar=$dondur['fiyat']*($dondur['indirim']/100);
         
  ?>
      <div class="prod_box">

        <div class="top_prod_box"></div>

        <div class="center_prod_box">
        
              <form action="" method="post">
          <div class="product_title"><a href="details.php?urun=<?php  echo $dondur['id'];?>"><?php  echo $dondur['urun'];?></a></div>
          <input type="hidden" value="<?php  echo $dondur['urun'];?>" name="urun"/>
          <input type="hidden" value="<?php  echo $dondur['id'];?>" name="id"/>
          <input type="hidden" value=1 name="adet"/>
           <input type="hidden" value="<?php  echo parabirimi($dondur['fiyat']-$cikar);?>" name="fiyat"/>
          <div class="product_img"><a href="details.php?urun=<?php  echo $dondur['id'];?>"><img src="urunler/<?php  echo $dondur['resim'];?>" alt="" border="0" /></a></div>
          <div class="prod_price"><span style="background:red;margin-bottom:15px;"><?php  echo "%".$dondur['indirim']."indirim";?></span></br><span class="reduce"><?php  echo parabirimi($dondur['fiyat']);?></span> <span class="price"><?php  echo parabirimi($dondur['fiyat']-$cikar);?></span></div>
        </div>
        <div class="bottom_prod_box"></div>
        <a style="color:#BD8888;"href="<?php echo 'details.php?urun='.$dondur['id'] ; ?>"><div class="prod_details_tab" style="text-align:center;font-size:18px">Gözat </div></a>
      </div>

             </form>
    <?php } ; ?>
     
 
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
           echo "<tr><td>".$sepet['urun']."</td><td><a href='index.php?id=".$sepet['id']."'><img width='14px' alt='Sil' title='Sil' src='images/no.png'></a></td></tr>";
           echo "<tr><td>".$sepet['fiyat']." TL </td></tr>";
                $carp=$sepet['adet']*$sepet['fiyat'];
                @$toplam+=$carp;

              }
             echo "</table>";
             echo '<div style="text-align:center"> <span class="border_cart"></span><b> Ürün:</b>'.$adetler.' adet</br>';
             echo ' <span class="border_cart"></span> <b> Toplam:</b>'.$toplam.' TL</div></br>';
              
             echo '<div  style="text-align:center;"><a style="color:red;text-decoration:none;" href="sepet.php">Alış verişi tamamla</div>';
           }else{

            echo ' <span class="border_cart"></span> Total:0 TL</br>';
            echo ' <span class="border_cart"></span> Ürün:0 adet</br>';
           }
           
           ?>
           
            

          
       
       

          <span class="price">
             
                 
                  

                

              </span> 

              </div>
        
      </div>
        
      <!--sepet-->
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
