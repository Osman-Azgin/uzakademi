<?php 
session_start();
class ilerleme
{
   public $vtb;
   public $yazi="";
	
   function ilerleme ()
   {
       $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
   }
	
   function ogrenci_sinav_analiz ()
   {
       $sinavlar=$this->vtb->query("select * from sinav where dersid = " . $_POST['dersid']);
	     $sinavlar = $sinavlar->fetchAll();
	   echo "<h2 style='margin-top:35px;' class='baslik'>Grafik Analiz</h2><div style='float:left;overflow-x:scroll;width:97%;height:100px;padding:20px 20px 20px 20px;'><div style='width:" . count($sinavlar) * 200 . "px;'>";

	   foreach ($sinavlar as $s)
	   {
           $sonuc = $this->vtb->query("select count(*) from ssonuc where sinavid = " . $s['sinavid'] . " and uyeid = " . $_SESSION['id'])->fetchColumn();
           if ($sonuc > 0)
           {
            if ($sonuc = $this->vtb->query("select * from ssonuc where sinavid = " . $s['sinavid'] . " and uyeid = " . $_SESSION['id']))
		        {
             
		          $sonuc = $sonuc->fetch();

		          $top = 100 - $sonuc['puan'];

		          echo "<span style='margin-left:1%;float:left;width:100px;background:blue;position:relative;height:" . $sonuc['puan'] . ";margin-top:" . $top . "'><p style='color:white;text-align:center;margin-top:" . $sonuc['puan'] / 2 . "px;font-family: sans-serif;'>" . $sonuc['puan'] . "</p></span>";
              $this->ogrenci_konu_analiz($s['sinavid']);

		        }
           }
	   }
     echo "</div></div>";
     echo "<h2 class='baslik'>Konu analizi</h2>";
     echo $this->yazi;
   }
	
	
	function ogrenci_konu_analiz ($sid)
	{
      $analizler = $this->vtb->query("select count(*) from sinav_konu_analizleri where sinavid = " . $sid . " and uyeid = " . $_SESSION['id'])->fetchColumn();
      if ($analizler > 0 )
      {
        if($analizler = $this->vtb->query("select * from sinav_konu_analizleri where sinavid = " . $sid . " and uyeid = " . $_SESSION['id']))
        {
        	$analizler = $analizler->fetchAll();
          $this->yazi = $this->yazi ."<table width='600'><tr><td>Konu</td><td>Başarı oranı</td></tr>";
        	foreach ($analizler as $an) {
        		$konu=$this->vtb->query("select * from konular where konuid = " . $an['konuid'])->fetch();
        		$puan = $an['dp'] / $an['tp'];
        		$puan = $puan * 100;
        		$this->yazi = $this->yazi . "<tr><td>" . $konu['konuadi'] . "</td><td>%" . $puan . "</td></tr>";
        	}
         $this->yazi = $this->yazi . "</table>";
        }
        else
        {
        	$this->yazi = $this->yazi . "yok(0)";
        }
      }
	}
}


if ($_POST['komut'] == "gg")
{
   $il = new ilerleme();
   $il->ogrenci_sinav_analiz();
}

if ($_POST['komut'] == "ka")
{
	$il = new ilerleme();
	$il->ogrenci_konu_analiz();
}

?>