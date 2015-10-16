<?php
 class istek 
 {
 	private $vtb;
	
 	function istek ()
	{
		try {
        $this->vtb=new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
        }
        catch (PDOException $e)
        {
            $this->vtb=null;
        }

	}

    function istek_yaz ()
    {
        echo 'INSERT INTO `istekler`(`iypnid`, `iyplnid`, `tur`, `dersvysnfid`) VALUES(' . $_SESSION['id'] . ',' . $_GET['ypln'] . ',"' . $_GET['tur'] . '",' . $_GET['drsid'] . ')';
        if($k=$this->vtb->exec('INSERT INTO `istekler`(`iypnid`, `iyplnid`, `tur`, `dersvysnfid`) VALUES(' . $_SESSION['id'] . ',' . $_GET['ypln'] . ',"' . $_GET['tur'] . '",' . $_GET['drsid'] . ')')) {
            header('location:../systemVISUAL/ders_profil.php?dersid=' . $_GET['drsid']);
        }
    }

     function istek_sil ()
     {
         echo 'UPDATE  FROM `istekler`  SET `aktifmi` = "0" WHERE `istekler`.`iypnid`=' . $_SESSION['id'] . ' and `istekler`.`iyplnid`=' . $_GET['ypln'] . ' and `istekler`.`tur`="' . $_GET['tur'] . '" and `istekler`.`dersvysnfid`=' . $_GET['drsid'];
         if($k=$this->vtb->exec('UPDATE  `istekler`  SET `aktifmi` = "0" WHERE `istekler`.`iypnid`=' . $_SESSION['id'] . ' and `istekler`.`iyplnid`=' . $_GET['ypln'] . ' and `istekler`.`tur`="' . $_GET['tur'] . '" and `istekler`.`dersvysnfid`=' . $_GET['drsid'])) {
             header('location:../systemVISUAL/ders_profil.php?dersid=' . $_GET['drsid']);
         }
     }

     function  istek_kabul_et ()
     {
        
         if ($istek=$this->vtb->query('select * from istekler where iid = ' . $_GET['istekid']))
         {
             $istek=$istek->fetch();
             
             if($kayit=$this->vtb->exec('INSERT INTO `' . $istek['tur'] . '_secimleri` (`uyeid`, `' . $istek['tur'] . 'id`) VALUES (' . $istek['iypnid'] . ',' . $istek['dersvysnfid'] . ')'))
             {
                 $sev=$this->vtb->query('select * from ders_seviyeler where dersid = ' . $istek['dersvysnfid'] . " and seviyeno = 1")->fetch();
                 $this->vtb->exec("INSERT INTO `seviye_secimleri` (uyeid,dersid,seviyeid,seviyeno) VALUES (" . $istek['iypnid'] . "," .  $istek['dersvysnfid'] . "," . $sev['seviyeid'] . ",1)");
                 $dersadi=$this->vtb->query('select dersadi from dersler where dersid = ' . $istek['dersvysnfid']);
                 $dersadi=$dersadi->fetchColumn();
                 $kayit=$this->vtb->exec('INSERT INTO `bildirmler` (`bbaslik`, `bildirimicerik`, `uyeid`) VALUES ("' . $dersadi . '","' . $dersadi . ' dersine Katılma isteğiniz onaylandı",' . $istek['iypnid'] . ')');
                 $this->vtb->exec('UPDATE `istekler` SET `aktifmi`="0" WHERE `istekler`.`iid`=' . $_GET['istekid']);
                 echo "1";
             }
         }
     }
	
	
	
 }

session_start();

if ($_GET['komut'] == 'iy')
{
    $is = new istek();
    $is->istek_yaz();
}

if ($_GET['komut'] == 'ii')
{
    $is = new istek();
    $is->istek_sil();
}

if ($_GET['komut'] == 'ik')
{
    $is = new istek();
    $is->istek_kabul_et();
}