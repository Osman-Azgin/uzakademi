<?php

class envanter 
{
	private $vtb; 
	
	function __construct()
	{
		try {
          $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
			
		} catch (Exception $e) {
			$this->vtb=null;
		}
	}

	function envanterBilgileri ()
	{
		$doksay=$this->vtb->prepare("select count(*) from dosyalar where dsahipid = ? and aktifmi = 1");
        $doksay->execute(array($_SESSION['id']));
        $doksay=$doksay->fetchColumn();
        $sorsay=$this->vtb->prepare("select count(*) from sorular where ogretmen = ? and varmi = 1");
        $sorsay->execute(array($_SESSION['id']));
        $sorsay=$sorsay->fetchColumn();
        $unsay=$this->vtb->prepare("select count(*) from uniteler where ogretmenid = ?");
        $unsay->execute(array($_SESSION['id']));
        $unsay=$unsay->fetchColumn();
        $konsay=$this->vtb->prepare("select count(*) from konular where ogremenid = ?");
        $konsay->execute(array($_SESSION['id']));
        $konsay=$konsay->fetchColumn();
        $yazdir=array('dossay' => $doksay , 'sorsay' => $sorsay , 'unsay' => $unsay , 'konsay' => $konsay);
        echo json_encode($yazdir);
	}

	function dokumangetir ()
    {
    	$doksay=$this->vtb->prepare("select count(*) from dosyalar where konuid = ? and aktifmi = 1");
        $doksay->execute(array($_POST['konuid']));
        $doksay=$doksay->fetchColumn();
        if($doksay>0)
        {
            $dokumanlar=$this->vtb->prepare("select * from dosyalar where konuid = ? and aktifmi = 1");
            $dokumanlar->execute(array($_POST['konuid']));
            $dokumanlar=$dokumanlar->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($dokumanlar);
        }
        else
        {
            echo "dokuman yok";
        }
    }

    function dokuman_sil ()
    {
        if ($this->vtb->exec('UPDATE `ders_dokuman_paylasimlari` SET `aktifmi` = "0" WHERE `ders_dokuman_paylasimlari`.`dosyaid`=' . $_POST['did']))
        {
            $adres = $this->vtb->query('select dosya from dosyalar where did = ' . $_POST['did']);
            $adres=$adres->fetchColumn();
            unlink($adres);
            $this->vtb->exec('UPDATE `dosyalar` SET `aktifmi` = "0" WHERE `dosyalar`.`did`=' . $_POST['did']);
            $this->vtb->exec('UPDATE `dokuman_gormeleri` SET `aktifmi` = "0" WHERE `dokuman_gormeleri`.`dokumanid`=' . $_POST['did']);

        }
        else
        {
            $adres = $this->vtb->query('select dosya from dosyalar where did = ' . $_POST['did']);
            $adres=$adres->fetchColumn();
            unlink($adres);
            $this->vtb->exec('UPDATE `dosyalar` SET `aktifmi` = "0" WHERE `dosyalar`.`did`=' . $_POST['did']);   
        }
    }

    function unite_ekle ()
    {
        $n=$this->vtb->exec('INSERT INTO `uniteler`(`uadi`, `ogretmenid`) VALUES("' . $_POST['uniteadi'] . '",' . $_SESSION['id'] . ')');
        $n=$this->vtb->query("SELECT COUNT(*) FROM uniteler WHERE uadi = '" . $_POST['uniteadi'] . "' AND ogretmenid = " . $_SESSION['id']);
        $n=$n->fetchColumn();
        if($n > 0)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    } 

    function konu_ekle ()
    {
        $n=$this->vtb->exec('INSERT INTO `konular`(`konuadi`, `uniteid` , `ogremenid`) VALUES("' . $_POST['konuadi'] . '",' . $_POST['unite'] . ',' . $_SESSION['id'] . ')');
        $n=$this->vtb->query("SELECT COUNT(*) FROM konular WHERE konuadi = '" . $_POST['konuadi'] . "' AND uniteid = " . $_POST['unite'] . " AND ogremenid = " . $_SESSION['id']);
        $n=$n->fetchColumn();
        if($n > 0)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }


    function soru_ekle ()
    {
    	if ($this->vtb != null)
    	{
    		$ekle = $this->vtb->prepare("INSERT INTO `sorular`(`konuid`, `zorluk`, `a`, `b`, `c`, `d`, `dc`, `sorumet` , `ogretmen`) VALUES (?,?,?,?,?,?,?,?,?)");
            $ekle->execute(array($_POST['konu'],$_POST['zorluk'],$_POST['a'],$_POST['b'],$_POST['c'],$_POST['d'] ,$_POST['dc'],$_POST['sorumet'],$_SESSION['id']));
    		echo "1";
    	}
    }
	
	
	function soru_duzenle ()
	{
		if ($this->vtb != null)
    	{
            echo 'UPDATE `sorular` SET `zorluk` = ' . $_POST['zorluk'] .',`a`= "' . $_POST['a'] .'",`b`="' . $_POST['b'] .'",`c`= "' . $_POST['c'] .'",`d`= "' . $_POST['d'] .'",`dc`= "' . $_POST['dc'] .'",`sorumet`= "' . $_POST['sorumet'] .'" WHERE `sorular`.`soruid`=' . $_POST['soruid'];;
    		if ($this->vtb->exec('UPDATE `sorular` SET `zorluk` = ' . $_POST['zorluk'] .',`a`= "' . $_POST['a'] .'",`b`="' . $_POST['b'] .'",`c`= "' . $_POST['c'] .'",`d`= "' . $_POST['d'] .'",`dc`= "' . $_POST['dc'] .'",`sorumet`= "' . $_POST['sorumet'] .'"  WHERE `sorular`.`soruid`=' . $_POST['soruid']))
            {
               header('location:envanter_duzenleme.php');
            }
    	}
	}


	function soru_sil ()
	{
		if ($this->vtb != null)
    	{
    		if ($this->vtb->exec('UPDATE `sorular` SET `varmi`=0 WHERE soruid = ' . $_POST['soruid']))
    		{
    			if ($this->vtb->exec('UPDATE `sinav_soru_paylasimlari` SET `aktifmi`=0 WHERE `sinav_soru_paylasimlari`.`soruid` = ' . $_POST['soruid']))
    		    {
                   echo "1";
    		    }
    	    }
	    }

    }

	
	function unite_getir ()
	{
   		$uniteler=$this->vtb->prepare('select count(*) from uniteler where ogretmenid = ?');
        $uniteler->execute(array($_SESSION['id']));
        $uniteler = $uniteler->fetchColumn();

        if($uniteler>0)
        {
            $uniteler=$this->vtb->prepare('select * from uniteler where ogretmenid = ?');
           $uniteler->execute(array($_SESSION['id']));
            $uniteler = $uniteler->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($uniteler);
        }
        else
        {
            echo "unite yok";
        }
	}
	
	function konu_getir ()
	{
        $uniteler=$this->vtb->prepare('select count(*) from konular where uniteid = ?');
        $uniteler->execute(array($_POST['uniteid']));
        $uniteler = $uniteler->fetchColumn();

        if($uniteler>0)
        {
            $uniteler=$this->vtb->prepare('select * from konular where uniteid = ?');
            $uniteler->execute(array($_POST['uniteid']));
            $uniteler = $uniteler->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($uniteler);
        }
        else
        {
            echo "konu yok";
        }
    }
	
    function soru_getir ()
    {
        $doksay=$this->vtb->prepare("select count(*) from sorular where konuid = ? and varmi = 1");
        $doksay->execute(array($_POST['konuid']));
        $doksay=$doksay->fetchColumn();
        if($doksay>0)
        {
            $dokumanlar=$this->vtb->prepare("select * from sorular where konuid = ? and varmi = 1");
            $dokumanlar->execute(array($_POST['konuid']));
            $dokumanlar=$dokumanlar->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($dokumanlar);
        }
        else
        {
            echo "soru yok";
        }
    }

    function dy_konu_getir ()
    {
        $k=$this->vtb->prepare('select * from konular where ogremenid = ?');
        $k->execute(array($_SESSION['id']));
        $k=$k->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($k);
    }

    function webdenDosyaYukle ($tur)
    {
    	$kayit=$this->vtb->prepare("INSERT INTO `dosyalar`( `dsahipid`, `dadi`, `dosya`, `dboyut`, `dtip`, `konuid`) VALUES (?,?,?,?,?,?");
    	$kayit->execute(array($_SESSION['id'],$_POST['dadi'],$_POST['adres'],'0',$tur,$_POST['konuid']));
        $kayit=$this->vtb->prepare("SELECT COUNT(*) FROM `dosyalar` WHERE dsahipid = ? , dadi = ? , dosya = ? , dboyut = ?, dtip = ?, konuid = ?");
        $kayit->execute(array($_SESSION['id'],$_POST['dadi'],$_POST['adres'],'0',$tur,$_POST['konuid']));
        if ($kayit > 0)
        {
            echo "basarili";
        }
        else
        {
            echo "basarisiz";
        }
    }

}

session_start();

if ($_POST['komut'] == 'sorek')
{
	$env = new envanter();
	$env->soru_ekle();
}

if ($_POST['komut'] == 'sorsil')
{
	$env = new envanter();
	$env->soru_sil();
}

if ($_POST['komut'] == 'sorduz')
{
	$env = new envanter();
	$env->soru_duzenle();
}

if ($_POST['komut'] == 'dg')
{
	$env = new envanter();
	$env->dokumangetir();
}

if ($_POST['komut'] == 'ug')
{
	$env = new envanter();
	$env->unite_getir();
}

if ($_POST['komut'] == 'kg')
{
	$env = new envanter();
	$env->konu_getir();
}

if ($_POST['komut'] == 'sg')
{
	$env = new envanter();
	$env->soru_getir();
}

if ($_POST['komut'] == 'sd')
{
    $env = new envanter();
    $env->soru_duzenle();
}

if ($_POST['komut'] == 'dk')
{
    $env = new envanter();
    $env->dokuman_sil();
}

if ($_POST['komut'] == 'ss')
{
    $env = new envanter();
    $env->soru_sil();
}

if ($_POST['komut'] == 'dykg')
{
    $env = new envanter();
    $env->dy_konu_getir();
}

if ($_POST['komut'] == 'ue')
{
    $env = new envanter();
    $env->unite_ekle();
}
 
if ($_POST['komut'] == 'ke')
{
    $env = new envanter();
    $env->konu_ekle();
}

if ($_POST['komut'] == 'eb')
{
    $env = new envanter();
    $env->envanterBilgileri();
}

if ($_POST['komut'] == "wdy")
{
	$env = new envanter();
	$env->webdenDosyaYukle($_POST['tur']);
}


?>