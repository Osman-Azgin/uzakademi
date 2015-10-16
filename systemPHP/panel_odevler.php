<?php
class sorgubul
{
    public $sorgu;
    function sorgubul ($secilecektablo,$sinanacakalan,$operator,$liste,$limit,$baglac)
    {

        if (count($liste) > 1){
            $sorgu = $secilecektablo . " where " . $sinanacakalan ." ". $operator ." ". $liste[1];
            $deger = count($liste) - 1;
            for ($i=2; $i <= $deger ; $i++) {
                $sorgu = $sorgu . " " . $baglac . " " . $sinanacakalan. " " . $operator . " " . $liste[$i];
            }
            $sorgu = $sorgu . " limit " . $limit;
            $this->sorgu = $sorgu;
        }
        else
        { $this->sorgu = null; }
    }
}

//class yazi
//{
  //  public $html=" ";

//    function yazi ($taglar,$indisler,$sorgusonuclari)
 //   {
  //      foreach ($sorgusonuclari as $s)
  //      {
  ///          for ($i=0;$i<=count($taglar);$i++)
   //         {
   //             if ($i==count($taglar))
   //             {
   //                 $this->html = $this->html . $taglar[$i];
   //             }
   //             else
//            {
   //                $this->html = $this->html . $taglar[$i];
   //                $this->html = $this->html . $s[$indisler[$i]];
  //              }
  //          }
 //       }
 //   }
//}


class odev
{
    private $vtb;

    function odev ()
    {
        $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
    }

    function ogretmen_odev_getir ()
    {
       // $sorgu = "select * from odevler where veren = " . $_SESSION['id'] . " and odurum = 1";
       // if($odev=$this->vtb->query($sorgu))
      //  {
        //   $odevlist = $odev->fetchAll();

       //     foreach ($odevlist as $o)
        //    {
       //           echo "<div class='panel_akis_kutusu'>"."<p>" . $o['odevadi'] . "</p>" . "<p>" . $o['dersadi']  . "</p><p>". $o['dtarih'] . "  ". $o['ttarih'] . "</p></div>" ;
      //      }
       // }
        $sorgu=new sorgubul("select * from seviye_odevleri","dersid","=",$_SESSION['dersler'],"0,30","or");
        $sorgu=$sorgu->sorgu;

        if ($odev=$this->vtb->query($sorgu))
        {
            $odevlist = $odev->fetchAll();

            foreach ($odevlist as $o)
            {
                if ($a=$this->vtb->query("select count(*) from seviye_odev_teslimleri where odevid = " . $o['soid']) and $b =$this->vtb->query("select count(*) from seviye_odev_teslimleri where odevid = " . $o['soid'] . ' and okundumu = 0') )
                {
                     $c = $a->fetchColumn();
                     $d = $b->fetchColumn();
                     $derssev=$this->vtb->prepare("select seviyeno,dersid from ders_seviyeler where seviyeid = ?");
                     $derssev->execute(array($o['seviye']));
                     $derssev=$derssev->fetch();
                     $ders=$this->vtb->prepare("select dersadi from dersler where dersid = ?");
                     $ders->execute(array($o['dersid']));
                     $ders=$ders->fetchColumn();
                    echo "<div class='isbox' style='height:auto;overflow:hidden;'> "." <div class='isboxust'><p class='icerik' style='color: #048CAD; margin:5px 5px 0px 0px;'>" . $o['odevbaslik'] . " > " . $ders . " > " . $derssev['seviyeno'] . ". Seviye</p></div>" . "<div class='icerik' style='position:relative;'><p >" . $o['odevmetni']  . "</p></div><div class='isboxalt'><p style='padding: 10px 0px 0px 100px;float:left;'>". $c . " kişi teslim etti,". $d . " kişiyi okumadınız</p><a style='margin-left:20px;' class='soruonay' href='ogretmen_ders_goruntuleme.php?dersid=" . $derssev['dersid'] . "&seviyeno=" . $derssev['seviyeno'] . "&dersadi=" . $ders ."'>Kontrol et</a></div></div>" ;

                }
                else
                {
                    echo "<div class='isbox' style='height:auto;overflow:hidden;'> "." <div class='isboxust'><p class='icerik' style='color: #048CAD; margin:5px 5px 0px 0px;'>" . $o['odevbaslik'] . " > " . $ders . " > " . $derssev['seviyeno'] . ". Seviye</p></div>" . "<div class='icerik' style='position:relative;'><p >" . $o['odevmetni']  . "</p></div><div class='isboxalt'><p>Kimse teslim etmedi</p></div></div>" ;
                }
            }
        }

    }

    function odev_getir ()
    {

       $seviyeler=$this->vtb->query('select * from seviye_secimleri where uyeid = ' . $_SESSION['id']);
       $seviyeler=$seviyeler->fetchAll();
       $ksev=array(' ');
       foreach ($seviyeler as $s)
       {
          array_push($ksev, $s['seviyeid']);
       }
       $sorgu=new sorgubul("select * from seviye_odevleri","seviye","=",$ksev,"0,30","or");
        $sorgu=$sorgu->sorgu;

        if ($odev=$this->vtb->query($sorgu))
        {
            $odevlist = $odev->fetchAll();

            echo '<div style="margin-top:-115px;">';
            if (count($odevlist)>0){
               foreach ($odevlist as $o)
               {
                   $dersadi = $this->vtb->query("select dersadi from dersler where dersid = " . $o['dersid'])->fetchColumn();
                   echo "<div class='isbox'><div class='isboxust'><p class='icerik' style='color: #048CAD; margin:5px 5px 0px 0px;'>". $dersadi ." > " . $o['odevbaslik'] . "</p></div>" . "<div class='icerik' style='position:relative;'>" . $o['odevmetni']  . "</div><div class='isboxalt'><p style='padding: 10px 0px 0px 100px;float:left;'>Ders sayfasından teslim edebilirsiniz.</p><a style='margin-left:20px;' class='soruonay' href='ders_goruntuleme.php?dersid=" . $o['dersid'] . "&dersadi=" . $dersadi . "&tab=odev'>Teslim et</a></div></div>" ;
               }
           }
           else {
             echo "<div class='baslik'>Teslim Edilecek Ödev Yok";
           }

            echo "</div>";
        }
    }

}

session_start();

$komut = $_POST['komut'];

if ($komut == "ogrtog")
{
     $odv= new odev();
     $odv->ogretmen_odev_getir();
}

if ($komut == "og")
{

  $odv= new odev();
  $odv->odev_getir();

}


?>
