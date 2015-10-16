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

        $ders=$this->vtb->query('select * from siniflar where sinifid = ' . $_GET['sinid']);
        $ders=$ders->fetch();
        $this->ogretmenid=$ders['shocasi'];
        $this->dersadi = $ders['sinifadi'];
        $ders=$this->vtb->query('select count(*) from sinif_secimleri where uyeid = ' . $_SESSION['id'] . ' and sinifid = ' . $_GET['sinid']);
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
        $ders=$this->vtb->query('select count(*) from istekler where dersvysnfid  = ' . $_GET['sinid'] . ' and tur = "sinif" and iypnid = ' . $_SESSION['id'] . " and aktifmi=1");
        $ders=$ders->fetchColumn();
        if($ders > 0)
        {
            $this->ivarmi=1;
        }
        else
        {
            $this->ivarmi=0;
        }
		
		$ogrsay=$this->vtb->query('select count(*) from sinif_secimleri where sinifid = ' . $_GET['sinid']);
		$this->ogrencisayisi=$ogrsay->fetchColumn();
    }
}



session_start();

$dp = new ders_profil();

 ?>
 <html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Panel</title>
     <link rel="stylesheet" type="text/css" href="theme/panel.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
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

        
    
    </script>
    <script type="text/javascript" language="javascript">

        $(document).ready(function(){


            //Select the first tab and div by default
            $('#tab_nav > ul > li > a').eq(0).addClass( "selected" );
            $('#tab_nav > div').eq(0).addClass( "selected" );


            //EVENT DELEGATION
            //This assigns an onclick event listener to the UL tag.
            //Then it checks what A tag was selected.
            $('#tab_nav > ul').on('click','a',function(){

                var aElement = $('#tab_nav > ul > li > a');
                var divContent = $('#tab_nav > div');

                /*Handle Tab Nav*/
                aElement.removeClass( "selected");
                $(this).addClass( "selected");

                /*Handle Tab Content*/
                var clicked_index = aElement.index(this);
                divContent.css('display','none');
                divContent.eq(clicked_index).css('display','block');

                $(this).blur();
                return false;

            });


        }); </script>
    <script language="javascript" type="text/javascript">
        var ebsi = 0;

        window.onload = dosyalarigetir;

        function dosyalarigetir ()
        {
            $.ajax({
                type:'POST',
                url:'son_dokumanlar.php',
                data : { komut : 'dg' },
                success : function (data) { document.getElementById('envanter').innerHTML = data; }
            });
        }

        function soru_ekle ()
        {
            ebsi ++;
            document.getElementById('sinav').innerHTML +=  '<br /><input type="text" name="soru' + ebsi + '" /><br /><input type="radio" name="soru' + ebsi + 'dc" value="a" /><input type="text" name="soru' + ebsi + 'a" /><br /><input type="radio" name="soru'+ ebsi + 'dc" value="b" /><input type="text" name="soru' + ebsi + 'b" /><br /><input type="radio" name="soru' + ebsi + 'dc" value="c" /><input type="text" name="soru' + ebsi + 'c" /><br /><input type="radio" name="soru' + ebsi + 'dc" value="d" /><input type="text" name="soru' + ebsi + 'd" />';
        }

        function sinav_dunenle ()
        {
            document.getElementById('sinavmenager').style.top="300px";
        }

        function test_sinav ()
        {
            var sny = document.getElementById('soru_sayisi').value;
            document.getElementById('sinavmenager').style.top="-250px";
            for (var n= 1; n <= sny  ; n++)
            {
                soru_ekle();
            }
            document.getElementById('sinav').style.top="80px";

        }
        function odevi_ac ()
        {
            document.getElementById('odev').style.top="80px";
        }

        function eskiye_don ()
        {
            document.getElementById('sinav').style.top="-500%";
            document.getElementById('odev').style.top="-500%";
        }

        function seac ()
        {
            document.getElementById('sek').style.top='15%';
            document.getElementById('sek').src= "ogretmen_seviye_olustur.php?sevno="+document.getElementById('sn').value+"&dersid="+document.getElementById('di').value;
        }

    </script>

</head>
<body style="background-color:#CBCBC5;">
<div class="container">
<div style="position:fixed;z-index: 30;margin-top:0px;"  class="topbar">
       <form action="arama_sonuclari.php" method="get">
  <input type="search" name="aranacak" placeholder="Arama">
</form>
        <img src="images/yenilogo.png" alt="" class="logo">
         <div class="dropdown-title" id="toggle-login" >
                <div class="box" >

                <img class="panel_profil_resmi" src="<?php echo $_SESSION['resim']; ?>" />
                    <p class="panel_kisi_adi"><?php echo $_SESSION['isim']; ?>
                    </p><div class="arrow"></div>
                </div>

            </div>

    </div>
     <div style="margin-top:50px;" id="login">
  <div id="triangle"></div>
  <ul id="drop-down">
  <li>Ayarlar</li>
  <li>Kullanım Koşulları</li>
  <li><a style="color:black;text-decoration:none;" href="index.php">Çıkış Yap</a></li>
  </ul>
</div>
<div style="width:100%;height:400px;background:white;margin-top:51px;position:absolute;box-shadow:black 0px 0px 1px;">

<h1 class="baslik" style="text-decoration:none;margin-left: 58%;margin-top: 25px;font-size:27px;"><?php echo $dp->dersadi; ?></h1>
	<h2 style="margin-left: 58%;margin-top: 4px;font-size: 17px;color: #383636;" class="baslik">Açıklama:</h2>
	<div style="margin-left: 58%;width: 33%;overflow-x: hidden;font-family: cursive;font-size: 14px;">fgjhkghgfdsadfghjuıopıuytrewqertyuıopıulkjyhtrewqWERTYUIOUKHJGFDSADRTYUIOUYTREWQ	WERTYUIOUKHJGFDSAAsertyuıhjgfd</div>
    <p><img src="<?php echo $dp->ogremenfoto; ?>" width="150" height="150" style="border-radius:800px;box-shadow:black 0px 0px 1px;margin-left: 3%;margin-top: -115px;"><h3 style="margin-top: -130px;margin-left: 17%;" class="baslik"><?php echo $dp->ogretmenadi; ?></h3><h3 style="margin-top: -3px;margin-left: 17%;color: #6C6262;font-size: 16px;text-decoration: none;" class="baslik">Grup Yöneticisi</h3></p>
</div>
<div>
    <?php
    if($dp->varmi == 0)
    {
        if($dp->ivarmi==0)
        {
            echo "<a class='soruonay' style='margin-top: -68px;margin-left: -74px;' href='istekler.php?komut=iy&tur=sinif&drsid=" . $_GET['sinid'] . "&ypln=" . $dp->ogretmenid . "'>Katıl</a>";
        }
        else
        {
            echo "<a class='soruonay' style='margin-top: -68px;margin-left: -74px;' href='istekler.php?komut=ii&tur=sinif&drsid=" . $_GET['sinid'] . "&ypln=" . $dp->ogretmenid . "'>Katılım isteğni iptal et</a>";
        }
    }
    ?>
</div>