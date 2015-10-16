<?php

session_start();

class arama
{
  public $vtb;
  public $dersler="";
  public $kisiler="";

  function arama ()
  {
    try {
            $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
        }
        catch (PDOException $e)
        {
            $this->vtb=null;
        }
  }

  function aramayap ()
  {
    $aramaSorgusu = "";
    $kisilerIcinAramaSorgusu="";

    $kelimeler = explode(" ",$_GET['aranacak']);

    $buyuk=strtoupper($_GET['aranacak']);
    $kucuk=strtolower($_GET['aranacak']);
    $ilkhb = ucfirst($_GET['aranacak']);
    $hb = ucwords($_GET['aranacak']);

    $aramaSorgusu=" dersadi like '%" . $buyuk . "%' or dersadi like '%" . $kucuk . "%' or dersadi like '%" . $ilkhb . "%' or dersadi like '%" . $hb . "%' or dersadi like '%" . $_GET['aranacak'] . "%'" . " or daciklama like '%" . $buyuk . "%' or daciklama like '%" . $kucuk . "%' or daciklama like '%" . $ilkhb . "%' or daciklama like '%" . $hb . "%' or daciklama like '%" . $_GET['aranacak'] . "%'";
    $kisilerIcinAramaSorgusu=" user like '%" . $buyuk . "%' or user like '%" . $kucuk . "%' or user like '%" . $ilkhb . "%' or user like '%" . $hb . "%' or user like '%" . $_GET['aranacak'] . "%'" . " or uyeadi like '%" . $buyuk . "%' or uyeadi like '%" . $kucuk . "%' or uyeadi like '%" . $ilkhb . "%' or uyeadi like '%" . $hb . "%' or uyeadi like '%" . $_GET['aranacak'] . "%'" . " or uyesoyadi like '%" . $buyuk . "%' or uyesoyadi like '%" . $kucuk . "%' or uyesoyadi like '%" . $ilkhb . "%' or uyesoyadi like '%" . $hb . "%' or uyesoyadi like '%" . $_GET['aranacak'] . "%'";

    if (count($kelimeler)>1) {
        foreach ($kelimeler as $kelime) {
            $sbuyuk=strtoupper($kelime);
            $skucuk=strtolower($kelime);
            $silkhb = ucfirst($kelime);
            $shb = ucwords($kelime);
           $aramaSorgusu=$aramaSorgusu . " or dersadi like '%" . $kelime . "%' or dersadi like '%" . $sbuyuk . "%' or dersadi like '%" . $skucuk . "%' or dersadi like '%" . $silkhb . "%' or dersadi like '%" . $shb . "%'";
           $kisilerIcinAramaSorgusu= $kisilerIcinAramaSorgusu . " or user like '%" . $sbuyuk . "%' or user like '%" . $skucuk . "%' or user like '%" . $silkhb . "%' or user like '%" . $shb . "%' or user like '%" . $_GET['aranacak'] . "%'" . " or uyeadi like '%" . $sbuyuk . "%' or uyeadi like '%" . $skucuk . "%' or uyeadi like '%" . $silkhb . "%' or uyeadi like '%" . $shb . "%' or uyeadi like '%" . $_GET['aranacak'] . "%'" . " or uyesoyadi like '%" . $sbuyuk . "%' or uyesoyadi like '%" . $skucuk . "%' or uyesoyadi like '%" . $silkhb . "%' or uyesoyadi like '%" . $shb . "%' or uyesoyadi like '%" . $_GET['aranacak'] . "%'";
        }
    }

  if (isset($_GET['derslimit'])){
      $limit = $_GET['derslimit'];
  }
  else{
      $limit = "0,30";
  }

   $sayi=$this->vtb->query("select count(*) from dersler where " . $aramaSorgusu);
   $sayi=$sayi->fetchColumn();
   if($sayi>0) {
       $sonuc = $this->vtb->query("select * from dersler where " . $aramaSorgusu . " limit " . $limit);
       $sonuc = $sonuc->fetchAll();
       foreach ($sonuc as $s) {
           $this->dersler=$this->dersler . "<a style='text-decoration:none;color:black;float:left;' href='ders_profil.php?dersid=" . $s['dersid'] . "'><div style='float:left;margin-top:10px;margin-left:10px;width:160px;padding:10px 10px 10px 10px;box-shadow:black 0px 0px 1px;border-radius:1px;'><img src='../Graphics/images/drsicn.png' style='width: 100%;height: 100px;' /><p style='font-family: Exo, sans-serif;text-align:center;'>" . $s['dersadi'] . "</p><div style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' >Derse Git</div></div></a>";
       }
       $ssayisi=ceil($sayi/30);
       $ilksay=0;
       $sonsay=30;
       $this->dersler=$this->dersler .'<div style="float:left;width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">';
       for ($i=1;$i<=$ssayisi;$i++){
          $this->dersler=$this->dersler . "<a style='padding: 10px;  border: solid 1px rgb(182, 175, 175); margin-left: 1%;' href='javascript:derslimit(" . $ilksay . "," . $sonsay .")'>" . $i . "</a>";
          $ilksay = $ilksay +30;
          $sonsay=$sonsay +30;
       }
       $this->dersler=$this->dersler .'</div>';
       $this->dersler=$this->dersler . "<input type='hidden' id='derlim' value='". $limit ."' />";
   }
   else {
       $this->dersler=$this->dersler .  "<h1 style='font-family:Exo;font-size: 30px;margin-top: 6px;'>Sonuç Bulunamadı</h1>";
   }

   if (isset($_GET['uyelimit'])){
      $limit = $_GET['uyelimit'];
   }
   else{
      $limit = "0,30";
   }

   $sayi=$this->vtb->query("select count(*) from ogrenciuye where " . $kisilerIcinAramaSorgusu);
   $sayi=$sayi->fetchColumn();
   if($sayi>0) {
      $sonuc = $this->vtb->query("select * from ogrenciuye where " . $kisilerIcinAramaSorgusu . " limit " . $limit);
       $sonuc = $sonuc->fetchAll();
       foreach ($sonuc as $s) {
           $this->kisiler=$this->kisiler . "<a style='text-decoration:none;color:black;float:left;' href='kisiProfil.php?usr=" . $s['user'] . "'><div style='float:left;margin-top:10px;margin-left:10px;width:160px;padding:10px 10px 10px 10px;box-shadow:black 0px 0px 1px;border-radius:1px;'><img src='" . $s['foto'] . "' style='width: 100%;height: 100px;' /><p style='font-family: Exo, sans-serif;text-align:center;'>" . $s['user'] . "</p><div style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' >Profil</div></div></a>";
       }

       $ssayisi=ceil($sayi/30);
       $ilksay=0;
       $sonsay=30;
       $this->kisiler=$this->kisiler .'<div style="float:left;width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">';
       for ($i=1;$i<=$ssayisi;$i++){
          $this->kisiler=$this->kisiler . "<a style='padding: 10px;  border: solid 1px rgb(182, 175, 175); margin-left: 1%;' href='javascript:kisilimit(" . $ilksay . "," . $sonsay .")'>" . $i . "</a>";
          $ilksay = $ilksay +30;
          $sonsay=$sonsay +30;
       }
       $this->kisiler=$this->kisiler .'</div>';
       $this->kisiler=$this->kisiler . "<input type='hidden' id='uyelim' value='" . $limit . "' />";
   }
    else {
       $this->kisiler=$this->kisiler .  "<h1 style='font-family:Exo;font-size: 30px;margin-top: 6px;'>Sonuç Bulunamadı</h1>";
   }

  }
}

class panel
 {

  public $siniflari;
  private $vtb;


  function panel ()
  {
       $this->siniflari=array("siniflar");
     $this->dersler=array("dersler");
     $this->dersadlari=array("dersler");
     $this->istekler=array("istek");
       $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');

        $cev = $this->sorgula("select * from sinif_secimleri where uyeid =".$_SESSION['id']);
        if ($cev != null )
        {
        foreach ($cev as $c) {
         array_push($this->siniflari, $c['sinifid']);
       }
        }
        else
        { $this->siniflari=null;}



       $cev = $this->sorgula("select * from dersler where ogretmenid = " .$_SESSION['id']);
       if ($cev != null )
       {
        foreach ($cev as $c) {
         array_push($this->dersler, $c['dersid']);
         array_push($this->dersadlari, $c['dersadi']);
       }
        $_SESSION['dersler']=$this->dersler;
    //$_SESSION['dersler']['ad']=$this->dersadlari;
       }
        else
        { $this->dersler=null; }

        $cev=$this->sorgula('select * from istekler where iyplnid = ' . $_SESSION['id'] . " and aktifmi = 1");
        foreach ($cev as $c)
        {
          $n=$this->vtb->query('select user from ogrenciuye where uyeid = ' . $c['iypnid'])->fetchColumn();
          $k=$this->vtb->query('select dersadi from dersler where dersid = ' . $c['dersvysnfid'])->fetchColumn();
           $yzlck = "<div id='i" . $c['iid'] ."'><p>" . $n . ' sizin ' . $k . " dersinize katılmak istiyor.<br /><a href='javascript: istek_onayla(" . $c['iid'] . "," . $c['iid'] . ");'>Onayla</a><a href='javascript: istek_reddet(" . $c['dersvysnfid'] . ");'>Reddet</a></p></div>";
          array_push($this->istekler, $yzlck);
        }
   }


     function sorgula ($sorgu)
     {
       if (
       $sorgula=$this->vtb->query($sorgu)
       )
       {
         $donecek = $sorgula->fetchAll();
           return $donecek;
       }
         else { return null; }

     }




     function sorgubul ($secilecektablo,$sinanacakalan,$operator,$liste,$limit,$baglac)
     {

         if (count($liste) > 1){
         $sorgu = $secilecektablo . " where " . $sinanacakalan ." ". $operator ." ". $liste[1];
         $deger = count($liste) - 1;
         for ($i=2; $i <= $deger ; $i++) {
             $sorgu = $sorgu . " " . $baglac . " " . $sinanacakalan. " " . $operator . " " . $liste[$i];
         }
         $sorgu = $sorgu . " limit " . $limit;
         return $sorgu;
         }
         else
         { return null; }
     }




 }


$pnl=new panel();
$a=new arama();
$a->aramayap();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<title>Panel</title>
<link rel="stylesheet" type="text/css" href="systemTHEME/styles.css">
<link rel="stylesheet" href="../systemTHEME/panel.css">
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
<script type="text/javascript" language="javascript">

    function kisilimit(ilksay,sonsay){
      window.location="arama_sonuclari.php?aranacak=<?php echo $_GET['aranacak']; ?>&derslimit=" + $('#derlim').val() + "&uyelimit=" + ilksay + "," + sonsay;
    }

    function derslimit(ilksay,sonsay){
      window.location="arama_sonuclari.php?aranacak=<?php echo $_GET['aranacak']; ?>&derslimit=" + ilksay + "," + sonsay + "&uyelimit=" + $('#uyelim').val();
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
             <img style="border-radius:100px;" src="../Graphics/images/assearch.png" />
             <p>Arama</p>
         </div>
         <div onclick="window.location='<?php if($_SESSION['yetki']==1){ echo "ogretmen_paneli.php"; } else { echo "panel.php"; } ?>'" id="sonuclar" class="newLauncherLink">

             <img alt="Sonuçlar" src="../Graphics/svg/home.svg" />
             <p>Anasayfa</p>
         </div>
     </div>


     <div style="width: 75%;margin-top: 108px;margin-left: 135px;margin-bottom:30px;" class="panel_akis_tasiyici" id="at">
         <div id="asders">

             <div id="das" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
                 <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                     <p id="bslk" onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;"><?php echo $_GET['aranacak']; ?>  İçin Ders Arama Sonuçları</p>
                 </div>

                 <?php
                   echo $a->dersler;
                 ?>

             </div>

         </div>


         <div id="asders" style="margin-top: 45px;">

             <div id="das" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
                 <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                     <p id="bslk" onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;"><?php echo $_GET['aranacak']; ?>  İçin Kişi Arama Sonuçları</p>
                 </div>

                 <?php
                   echo $a->kisiler;
                 ?>

             </div>

         </div>


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
