<?php



class ders_profil
{
    private $vtb;
    public $ogretmenid;
    public $dersadi;
    public $sevsay;
    public $varmi;
    public $ogretmenadi;
    public $ogremenfoto;
    public $ivarmi;
	public $ogrencisayisi;

    function ders_profil ()
    {
        try {
            $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
        }
        catch (PDOException $e)
        {
            $this->vtb=null;
        }

        $ders=$this->vtb->query('select * from dersler where dersid = ' . $_GET['dersid']);
        $ders=$ders->fetch();
        $this->ogretmenid=$ders['ogretmenid'];
        $this->dersadi = $ders['dersadi'];
        $ders=$this->vtb->query('select count(*) from ders_seviyeler where dersid = ' . $_GET['dersid']);
        $this->sevsay=$ders->fetchColumn();
        $ders=$this->vtb->query('select count(*) from ders_secimleri where uyeid = ' . $_SESSION['id'] . ' and dersid = ' . $_GET['dersid']);
        $ders=$ders->fetchColumn();
        if($ders > 0)
        {
            $this->varmi=1;
        }
        else
        {
            $this->varmi=0;
        }
        $ders=$this->vtb->query('select * from ogrenciuye where uyeid = ' .$this->ogretmenid);
        $ders=$ders->fetch();
        $this->ogretmenadi=$ders['user'];
        $this->ogremenfoto=$ders['foto'];
        $ders=$this->vtb->query('select count(*) from istekler where dersvysnfid  = ' . $_GET['dersid'] . ' and tur = "ders" and iypnid = ' . $_SESSION['id'] . " and aktifmi=1");
        $ders=$ders->fetchColumn();
        if($ders > 0)
        {
            $this->ivarmi=1;
        }
        else
        {
            $this->ivarmi=0;
        }

		$ogrsay=$this->vtb->query('select count(*) from ders_secimleri where dersid = ' . $_GET['dersid']);
		$this->ogrencisayisi=$ogrsay->fetchColumn();
    }
}



session_start();

$dp = new ders_profil();

 ?>
 <html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Dersin Profili</title>
     <link rel="stylesheet" type="text/css" href="../systemTHEME/panel.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <script type="text/javascript" src="../systemJS/jquery-1.11.1.min.js"></script>
    <script src="../systemJS/jquery.pKisalt.js"></script>
    <script type='text/javascript' src='/applications/ckeditor/ckeditor.js'></script>
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

    </script>
</head>
<body style="background-color:whitesmoke;">
  <div class="wrapper">
  <div class="topbar">
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
  <div id="login" style="display: block; margin-top: 50px; margin-left: 82%;">
      <ul id="drop-down">
          <li>Ayarlar</li>
          <li>Kullanım Koşulları</li>
          <li><a style="color:black;text-decoration:none;" href="index.php">Çıkış Yap</a></li>
      </ul>
  </div>
<div class="newLauncher">
  <div  class="newLauncherLink"  style="background-color: #f5f5f5;">
   <img style="border-radius:100px;" src="../Graphics/images/drsicn.png" />
   <p>Ders</p>
  </div>
  <div onclick="window.location='<?php if($_SESSION['yetki']==1){ echo "ogretmen_paneli.php"; } else { echo "panel.php"; } ?>'" id="sonuclar" class="newLauncherLink">

      <img alt="Sonuçlar" src="../Graphics/svg/home.svg" />
      <p>Anasayfa</p>
  </div>
</div>
<div class="panel_akis_tasiyici" id="at" style="margin-left:14%;margin-top: 24px;">
<div style="width: 64%; height: 400px; background: none repeat scroll 0% 0% white; margin-top: 51px; position: absolute; box-shadow: 0px 0px 1px black;">

<h1 class="baslik" style="text-decoration:none;margin-left: 58%;margin-top: 25px;font-size:27px;"><?php echo $dp->dersadi; ?></h1>
	<h2 style="margin-left: 58%;margin-top: 4px;font-size: 17px;color: #383636;" class="baslik">Açıklama:</h2>
	<div style="margin-left: 58%;width: 33%;overflow-x: hidden;font-family: cursive;font-size: 14px;">fgjhkghgfdsadfghjuıopıuytrewqertyuıopıulkjyhtrewqWERTYUIOUKHJGFDSADRTYUIOUYTREWQ	WERTYUIOUKHJGFDSAAsertyuıhjgfd</div>
    <p><img src="<?php echo $dp->ogremenfoto; ?>" width="150" height="150" style="border-radius:800px;box-shadow:black 0px 0px 1px;margin-left: 3%;margin-top: -115px;"><h3 style="margin-top: -130px; margin-left: 21%;" class="baslik"><?php echo $dp->ogretmenadi; ?></h3><h3 style="margin-top: -3px; margin-left: 21%;color: #6C6262;font-size: 16px;text-decoration: none;" class="baslik">Ders öğretmeni</h3></p>
</div>
<div>
    <?php
    if ($_SESSION['yetki']==0) {
        if($dp->varmi == 0)
        {
            if($dp->ivarmi==0)
            {
                echo "<a class='soruonay' style='margin-top: -68px;margin-left: -74px;' href='../systemPHP/istekler.php?komut=iy&tur=ders&drsid=" . $_GET['dersid'] . "&ypln=" . $dp->ogretmenid . "'>Katıl</a>";
            }
            else
            {
                echo "<a class='soruonay' style='margin-top: -68px;margin-left: -74px;' href='../systemPHP/istekler.php?komut=ii&tur=ders&drsid=" . $_GET['dersid'] . "&ypln=" . $dp->ogretmenid . "'>Katılım isteğni iptal et</a>";
            }
        }
      }
      else {
        echo "<a class='soruonay' style='margin-top: -68px;margin-left: -74px;width:300px;' href='#'>Öğretmenler Derse Katılamaz</a>";
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
</html>
