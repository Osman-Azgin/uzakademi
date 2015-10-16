<?php

session_start();

$dbc = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');

$kisi=$dbc->prepare("select * from ogrenciuye where user = ?");
$kisi->execute(array($_GET['usr']));
$kisi=$kisi->fetch();

$paylasimsay=$dbc->prepare("select count(*) from akislar where uyeid = ?");
$paylasimsay->execute(array($kisi['uyeid']));
$paylasimsay=$paylasimsay->fetchColumn();

if ($paylasimsay>0) {
  $paylasimlar=$dbc->prepare("select * from akislar where uyeid = ? order by akisid desc limit 0,30");
  $paylasimlar->execute(array($kisi['uyeid']));
  $paylasimlar=$paylasimlar->fetchAll();
}
else {
  $paylasimlar=array();
}

if ($kisi['yetki']==0){
   $derssay=$dbc->prepare("select count(*) from ders_secimleri where uyeid = ?");
   $derssay->execute(array($kisi['uyeid']));
   $derssay=$derssay->fetchColumn();
    if ($derssay>0){
      $dersler=$dbc->prepare("select * from ders_secimleri where uyeid = ? ");
      $dersler->execute(array($kisi['uyeid']));
      $dersler=$dersler->fetchAll();
    }
    else {
      $dersler=array();
    }
}

else {
  $derssay=$dbc->prepare("select count(*) from dersler where ogretmenid = ?");
  $derssay->execute(array($kisi['uyeid']));
  $derssay=$derssay->fetchColumn();
   if ($derssay>0){
     $dersler=$dbc->prepare("select * from dersler where ogretmenid = ?");
     $dersler->execute(array($kisi['uyeid']));
     $dersler=$dersler->fetchAll();
   }
   else {
     $dersler=array();
   }
}

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
 <title><?php echo $_GET['usr']; ?></title>
 <link rel="stylesheet" type="text/css" href="../systemTHEME/styles.css">
 <link rel="stylesheet" href="../systemTHEME/panel.css">
 <style type="text/css">
 .icerik {

     margin: 65px 0px 0px 45px;

     position: absolute;

     font-family: 'Raleway', sans-serif;

     font-weight: 400;

 }
 </style>
 <script type="text/javascript" src="../systemJS/jquery-1.11.1.min.js"></script>
     <script type="text/javascript">
         $(document).ready(
             function(){
                 $('#login').hide();
                 $('#toggle-login').click(function(){
                     $('#login').toggle();
                 });
             });
         $(document).ready(function(){
             $('.menu-container').hover(
                 function(){
                     $('.profile-actions').slideDown('fast');
                     $('.list-icon').addClass('active');
                 },
                 function(){
                     $('.profile-actions').slideUp('fast');
                     $('.list-icon').removeClass('active');
                 }
             );

         });

         $(document).ready(function(){
             $('#drpdwn').hide();
             $('#drpdwn2').hide();
             $('#drpdwn3').hide();
             $('#bildirim').click(function(){
                 $('#drpdwn2').toggle();
                 $('#drpdwn').hide();
                 $('#drpdwn3').hide();
             });
             $('#mesaj').click(function(){
                 $('#drpdwn').toggle();
                 $('#drpdwn2').hide();
                 $('#drpdwn3').hide();
             });
             $('#istek').click(function(){
                 $('#drpdwn').hide();
                 $('#drpdwn2').hide();
                 $('#drpdwn3').toggle();

             });
         });



     </script>
    <script language="javascript" type="text/javascript">
    function istekYap ()
    {
      $.ajax({
        type : 'POST',
        url : '../systemPHP/arkadslik_islemleri.php',
        data : { komut : 'iy' , tedilen : '<?php echo $kisi['uyeid']; ?>' },
        success : function (data) {
          if (data==1) {
            window.location.reload(false);
          }
          else {
            alert("Bir Sorundan Dolayı İşlem Yapılamadı Lütfen Daha Sonra Tekrar Denyin!");
          }
        }
      });
    }

    function istekSil ()
    {
      $.ajax({
        type : 'POST',
        url : '../systemPHP/arkadslik_islemleri.php',
        data : { komut : 'is' , tedilen : '<?php echo $kisi['uyeid']; ?>' },
        success : function (data) {
          if (data==1) {
            window.location.reload(false);
          }
          else {
            alert("Bir Sorundan Dolayı İşlem Yapılamadı Lütfen Daha Sonra Tekrar Denyin!");
          }
        }
      });
    }

 </script>
 <style type="text/css">
     a
     {
         color:black;
         text-decoration: none;
     }
 </style>
 </head>
 <body style="background-color:#FAFAFA;"  >
 <div class="wrapper">
 <div style="margin-top: -109px;" class="topbar">
     <form action="arama_sonuclari.php" method="get">
         <input type="search" name="aranacak" placeholder="Arama">
     </form>
     <img src="../Graphics/images/yenilogo.png" alt="" class="logo">
     <a href="#" id="mesaj"> <img src="../Graphics/svg/mesaj.png" alt="" style="margin-left: 720px;
 margin-top: 8px;" ></a>
     <div class="drpdwn" id="drpdwn" >
         <ul id="drop-down">
             <?php
             echo $hso->mesajlar;
             ?>
     </div>
     <a href="#" id="bildirim"> <img src="../Graphics/svg/bildirim.png" alt="" style="width:30px;margin-left: 30px"></a>
     <div class="drpdwn2" id="drpdwn2" >
         <ul id="drop-down">
             <li>BILDIRIM1</li>
             <li>BILDIRIM2</li>
             <li>BILDIRIM3</li>
             <li>BILDIRIM4</li>
         </ul>
     </div>
     <a href="#" id="istek"> <img src="../derslr.png" alt="" style="width:30px;margin-left: 30px"></a>
     <div class="drpdwn2" id="drpdwn3" >
         <ul id="drop-down">
             <?php
             foreach ($_SESSION['istekler'] as $is)
             {
                 echo $is;
             }
             ?>
         </ul>
     </div>
     <div class="dropdown-title" id="toggle-login" >
         <div class="box" >

             <img class="panel_profil_resmi" src="<?php echo $_SESSION['resim']; ?>" />
             <p class="panel_kisi_adi"><?php echo $_SESSION['isim']; ?>
             </p><div class="arrow"></div>
         </div>

     </div>
 </div>
 <div id="login" style="display: block; margin-top: -58px; margin-left: 82%;">
     <ul id="drop-down">
         <li>Ayarlar</li>
         <li>Kullanım Koşulları</li>
         <li><a style="color:black;text-decoration:none;" href="index.php">Çıkış Yap</a></li>
     </ul>
 </div>
      <div class="newLauncher">
          <div  class="newLauncherLink" style="background-color: #f5f5f5;">
              <img style="border-radius:100px;" src="../Graphics/svg/user.svg" />
              <p>Kişi</p>
          </div>
          <div onclick="window.location='<?php if($_SESSION['yetki']==1){ echo "ogretmen_paneli.php"; } else { echo "panel.php"; } ?>'" id="sonuclar" class="newLauncherLink">

              <img alt="Sonuçlar" src="../Graphics/svg/home.svg" />
              <p>Anasayfa</p>
          </div>
      </div>


      <div style="width: 75%;margin-top: 108px;margin-left: 10%;margin-bottom:30px;" class="panel_akis_tasiyici" id="at">
          <div id="asders">

              <div id="das" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
                  <div style="width: 100%;padding: 13px 0px 37px 0px;border-bottom: 1px solid #e5e5e5;">
                      <p id="bslk" onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;"><?php echo $_GET['usr']; ?>  Adlı Kişinin Profili <?php
                      if (in_array($kisi['user'], $_SESSION['arkads'])){
                        echo '<div style="background: #3680b8;width: 200px;text-align: center;padding: 10px 0px 10px 0px;margin-top: -13px;margin-left:50%;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;float:left;box-shadow: #000000 0px 0px 1px;">Arkadaşsınız</div>';
                      }
                      else {
                        $istekvarmi = $dbc->prepare("select count(*) from arkadasliklar where tedenid = ? and tedilenid = ? and aktifmi = 0");
                        $istekvarmi->execute(array($_SESSION['id'],$kisi['uyeid']));
                        $istekvarmi=$istekvarmi->fetchColumn();
                        if ($istekvarmi>0) {
                          echo '<div style="background: #3680b8;width: 200px;text-align: center;padding: 10px 0px 10px 0px;margin-top: -13px;margin-left:50%;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;float:left;box-shadow: #000000 0px 0px 1px;" onclick="istekSil()">Arkadaşlık İsteğini İptal Et</div>';
                        }
                        else {
                          echo '<div style="background: #3680b8;width: 200px;text-align: center;padding: 10px 0px 10px 0px;margin-top: -13px;margin-left:50%;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;float:left;box-shadow: #000000 0px 0px 1px;" onclick="istekYap()">Arkadaşlık İsteği Gönder</div>';
                        }
                      }
                    ?></p>
                  </div>
                  <div style="width:100%;height:138px;">
                     <img src="<?php echo $kisi['foto']; ?>" style="width:100px; height:100px; border-radius:200px;margin-top:20px;margin-left:20px;box-shadow:black 0px 0px 1px;" />
                     <p style="margin-top:-100px;font-size:20px;font-family:Exo;margin-left:145px;">İsmi: <?php echo $kisi['uyeadi']; ?> Soyismi: <?php echo $kisi['uyesoyadi']; ?></p>
                      <p style="margin-top:20px;font-size:20px;font-family:Exo;margin-left:145px;"><?php if ($kisi['yetki']==0) {echo "Öğrenci";} else {echo "Öğretmen";}?></p>
                  </div>
              </div>

          </div>

     </div>


     <div style="width:30%;margin-left: 12%;float:left;">
        <p style="font-family:Exo;border-bottom:solid 1px black">Bu kişiden Birkaç Paylaşım</p>
        <?php
        if (count($paylasimlar)>0) {
          foreach ($paylasimlar as $paylasim) {
              echo "<div style='width: 97%;' class='isbox'><div class='panel_profil_resmi' style=background-image:url('" . $paylasim['foto'] . "')" . "></div>"."<p class='panel_kisi_adi' style='color:black;'>" . $paylasim['user'] . "</p>" . "<div class='icerik'>" . $paylasim['aicerik']  . "</div></div>" ;
          }
        }
        else {
          echo "Paylasim yok";
        }
        ?>
     </div>

     <div style="width:30%;margin-left: 47%;float: left;position: absolute;">
        <p style="font-family:Exo;border-bottom:solid 1px black">Bu Kişinin Dersleri</p>
        <?php
           if ($kisi['yetki']==1){
             if (count($dersler)>0) {
               foreach ($dersler as $ders) {
                   echo "<a style='text-decoration:none;color:black;float:left;' href='ders_profil.php?dersid=" . $ders['dersid'] . "'><div style='float:left;margin-top:10px;margin-left:10px;width:160px;padding:10px 10px 10px 10px;box-shadow:black 0px 0px 1px;border-radius:1px;'><img src='../Graphics/images/drsicn.png' style='width: 100%;height: 100px;' /><p style='font-family: Exo, sans-serif;text-align:center;'>" . $ders['dersadi'] . "</p><div style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' >Derse Git</div></div></a>";
               }
             }
             else {
               echo "Ders yok";
             }
           }
           else {
             if (count($dersler)>0) {
               foreach ($dersler as $der) {
                   $ders=$dbc->prepare("select * from dersler where dersid = ?");
                   $ders->execute(array($der['dersid']));
                   $ders=$ders->fetch();
                   echo "<a style='text-decoration:none;color:black;float:left;' href='ders_profil.php?dersid=" . $ders['dersid'] . "'><div style='float:left;margin-top:10px;margin-left:10px;width:160px;padding:10px 10px 10px 10px;box-shadow:black 0px 0px 1px;border-radius:1px;'><img src='../Graphics/images/drsicn.png' style='width: 100%;height: 100px;' /><p style='font-family: Exo, sans-serif;text-align:center;'>" . $ders['dersadi'] . "</p><div style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' >Derse Git</div></div></a>";
               }
             }
             else {
               echo "Ders yok";
             }
           }
        ?>
    </div>

      <div class="kisilerKutusu">
          <div class="sagpanel"><div class="ders-list"><div class="user-h">
                      <p>Dersler</p>
                  </div>
                  <ul class="derslist">
                      <?php
                      $ar = $_SESSION['dersler'];
                      for ($i=1;$i<=count($ar)-1;$i++){ echo "<li><a href='ogretmen_ders_goruntuleme.php?dersid=" . $_SESSION['dersler'][$i] ."&dersadi=" . $_SESSION['dersadlari'][$i] ."&seviyeno=1'>" . $_SESSION['dersadlari'][$i] . "</a></li>"; }
                      echo "<li><a href='ogretmen_ders_olustur.php'>Ders Oluşturun</a></li>";
                      ?>

                  </ul></div></div>
          <div class="user-list">
              <div class="user-h">
                  <p>Arkadaşlar</p>
              </div>
              <ul id="arkadaslar">
                  <?php
                  for ($i=1;$i <= count($_SESSION['arkids'])-1;$i++)
                  {
                      echo '<li>';
                      echo '<p><img src="' . $_SESSION['arkfots'][$i] . '" width="22px" class="ava"/> ' . $_SESSION['arkads'][$i] . '</p>';
                      echo '</li>';
                  }
                  ?>
              </ul>

          </div>


      </div>

 </body>
