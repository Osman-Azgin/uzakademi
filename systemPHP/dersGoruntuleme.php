<?php

class dersGoruntuleme
{
    public $vtb;
    public $seviyeid;
    public $ebsno;
    public $veriler="";
    public $ogrencisayisi;
    public $sevsay;

    public $odevid;
    public $odevadi;
    public $odevmetni;
    public $odevvarmi;
    public $odevnotu;
    public $odevadres;
    public $okundumu = null;
    public $dosad;

    public $seviyeno;
    public $yuzde;
    public $sgd;
    public $seviyeozellik;
    public $dersadi;

    public $mesaj=null;

    public $ogretmenadi;
    public $ogretmenid;
    public $ogretmenfoto;

    public $sinavid;
    public $sorusay;
    public $sinavsure;
    public $girdimi;
    public $sinavnot;

    function dersGoruntuleme ()
    {
        try {
            $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
        }
        catch (PDOException $e)
        {
            $this->vtb=null;
        }
    }

    function ogrenciDersGetir ()
    {
        $ders=$this->vtb->prepare("select * from dersler where dersid = ?");
        $ders->execute(array($_POST['dersid']));
        $ders=$ders->fetch();
        $this->dersadi = $ders['dersadi'];
        $kontrol=$this->vtb->prepare("select count(*) from ders_secimleri where dersid = ? and uyeid = ? ");
        $kontrol->execute(array($_POST['dersid'],$_SESSION['id']));
        $kontrol=$kontrol->fetchColumn();
        if ($kontrol>0)
        {
            $seviye=$this->vtb->prepare("select * from seviye_secimleri where dersid = ? and uyeid = ?");
            $seviye->execute(array($_POST['dersid'],$_SESSION['id']));
            $seviye=$seviye->fetch();
            $this->seviyeid=$seviye['seviyeid'];
            $this->seviyeno=$seviye['seviyeno'];
            $ssid=$seviye['ssid'];
            if ($this->seviyeid == '0')
            {
                $yeniseviye=$this->vtb->prepare('select count(*) from ders_seviyeler where dersid = ? and seviyeno = ?');
                $yeniseviye->execute(array($_POST['dersid'],$this->seviyeno));
                $yeniseviye=$yeniseviye->fetchColumn();
                if ($yeniseviye==0)
                {
                    $this->mesaj="shd";
                }
                else
                {
                    $seviye=$this->vtb->prepare("select * from ders_seviyeler where dersid = ? and seviyeno = ?");
                    $seviye->execute(array($_POST['dersid'],$this->seviyeno));
                    $seviye=$seviye->fetch();
                    $guncelle = $this->vtb->prepare("UPDATE `seviye_secimleri` SET `seviyeid`=?  WHERE `seviye_secimleri`.`ssid` =?");
                    $guncelle->execute(array($seviye['seviyeid'],$ssid));
                    $this->sgd=$seviye['seviyegecmedurumu'];
                    $this->seviyeozellik=$seviye['seviyeozellik'];
                    $this->seviyeid=$seviye['seviyeid'];
                }

            }
            else
            {
                $seviye = $this->vtb->prepare("select * from ders_seviyeler where seviyeid = ?");
                $seviye->execute(array($this->seviyeid));
                $seviye = $seviye->fetch();
                $this->sgd = $seviye['seviyegecmedurumu'];
                $this->seviyeozellik = $seviye['seviyeozellik'];
            }
            $doksay=$this->vtb->prepare("select count(*) from ders_dokuman_paylasimlari where seviye = ? and aktifmi = 1");
            $doksay->execute(array($this->seviyeid));
            $doksay=$doksay->fetchColumn();
            $gorsay=$this->vtb->prepare("select count(*) from dokuman_gormeleri where seviyeid = ? and uyeid = ? and aktifmi = 1");
            $gorsay->execute(array($this->seviyeid,$_SESSION['id']));
            $gorsay=$gorsay->fetchColumn();
            $x=$gorsay / $doksay;
            $this->yuzde = $x * 100;
            $ogretmen = $this->vtb->prepare("select user,uyeid,foto from ogrenciuye where uyeid = ?");
            $ogretmen->execute(array($ders['ogretmenid']));
            $ogretmen=$ogretmen->fetch();
            $this->ogretmenadi=$ogretmen['user'];
            $this->ogretmenid=$ogretmen['uyeid'];
            $this->ogretmenfoto=$ogretmen['foto'];
        }
        else
        {
            $this->mesaj = "ga";
        }
    }

    function ogretmenDersGetir ()
    {
        $ders=$this->vtb->prepare('select * from dersler where dersid = ?');
        $ders->execute(array($_POST['dersid']));
        $ders=$ders->fetch();
        $this->dersadi = $ders['dersadi'];
        $kontrol=$this->vtb->prepare("select count(*) from dersler where dersid = ? and  ogretmenid = ? ");
        $kontrol->execute(array($_POST['dersid'],$_SESSION['id']));
        $kontrol=$kontrol->fetchColumn();
        if ($kontrol>0)
        {
            $seviye=$this->vtb->prepare("select * from ders_seviyeler where dersid = ? and seviyeno = ?");
            $seviye->execute(array($_POST['dersid'],$_POST['seviyeno']));
            $seviye=$seviye->fetch();
            $this->seviyeid=$seviye['seviyeid'];
            $this->seviyeno=$seviye['seviyeno'];
            $this->sgd = $seviye['seviyegecmedurumu'];
            $this->seviyeozellik = $seviye['seviyeozellik'];
            $seviye=$this->vtb->prepare("select max(seviyeno) from ders_seviyeler where dersid = ?");
            $seviye->execute(array($_POST['dersid']));
            $seviye=$seviye->fetchColumn();
            $this->ebsno=$seviye;
            $seviye=$this->vtb->prepare("select count(*) from ders_secimleri where dersid = ? and aktifmi = 1");
            $seviye->execute(array($_POST['dersid']));
            $seviye=$seviye->fetchColumn();
            $this->ogrencisayisi=$seviye;
            $seviye=$this->vtb->prepare("select count(*) from ders_seviyeler where dersid = ?");
            $seviye->execute(array($_POST['dersid']));
            $seviye=$seviye->fetchColumn();
            $this->sevsay=$seviye;
        }
        else
        {
            $this->mesaj = "ga";
        }
    }

    function dokuman_getir ()
    {
            $sev = $this->vtb->prepare("select * from ders_dokuman_paylasimlari where seviye = ? and aktifmi = 1" );
            $sev->execute(array($this->seviyeid));
            $dokumanlar = $sev->fetchAll();
            $didler = array(" ");

             foreach ($dokumanlar as $d)
             {
                  array_push($didler,$d['dosyaid']);
             }


             if ($dsy = $this->vtb->query($this->sorgubul("select * from dosyalar","did","=",$didler,"0,30","or")))
             {
                 $dosyalar = $dsy->fetchAll(PDO::FETCH_ASSOC);
                 echo json_encode($dosyalar);
             }
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
        { $sorgu = $secilecektablo . " where " . $sinanacakalan ." ". $operator ." ". $liste[1]; return $sorgu
            ; }
    }

    function ebsnogetir ()
    {
        if ($x=$this->vtb->query('select max(seviyeno) from ders_seviyeler where dersid = ' . $_GET['dersid']))
        {
            $y=$x->fetchColumn();

            echo $y;
        }
    }

    function sid_gtr ()
    {
        if ($n=$this->vtb->query('select * from ders_seviyeler where dersid = ' . $_GET['ders'] . ' and seviyeno = ' . $_GET['seviyeno']))
        {
            $n=$n->fetch();

            if ($x=$this->vtb->query('select sinavid from sinav where dersid = ' . $_GET['ders'] . ' and seviye = ' . $n['seviyeid']))
            {
                $y=$x->fetchColumn();

                return $y;
            }
        }
    }

    function sevnolari_getir ()
    {
        $sevs=$this->vtb->query('select * from ders_seviyeler where  dersid = ' . $_GET['dersid'])->fetchAll();
        foreach ($sevs as $se)
        {
            echo "<a href='ogretmen_ders_goruntuleme.php?dersid=" . $_GET['dersid'] . "&seviyeno=" . $se['seviyeno'] . "'><div style='padding:18px 24px 18px 24px;float:left;border-radius:200px;box-shadow:black 0px 0px 5px;margin-left:1%;'><p style='padding:none;margin:0px;text-decoration:none;' class='baslik'>" . $se['seviyeno'] . "</p></div></a>";
        }
    }

    function ogrenci_dokuman_gor ()
    {
        $dok=$this->vtb->prepare('select dosya,dtip,dadi from dosyalar where did = ?');
        $dok->execute(array($_POST['did']));
        $dok=$dok->fetch(PDO::FETCH_ASSOC);
        if($varmi=$this->vtb->query('select count(*) from dokuman_gormeleri where uyeid = ' . $_SESSION['id'] . ' and dokumanid = ' . $_POST['did'] . ' and seviyeid=' . $_POST['seviyeid']))
        {
            $varmi=$varmi->fetchColumn();

            if($varmi > 0)
            {
                echo json_encode($dok);
            }
            else
            {
                if($kayit=$this->vtb->exec('INSERT INTO `dokuman_gormeleri`(`seviyeid`, `uyeid`, `dokumanid`, `aktifmi`) VALUES(' . $_POST['seviyeid'] . ',' . $_SESSION['id'] . ',' . $_POST['did'] . ',1)'))
                {
                    echo json_encode($dok);
                }
            }
        }
    }

    function odevGetir ()
    {
        $odev = $this->vtb->prepare('select * from seviye_odevleri where seviye = ?');
        $odev->execute(array($this->seviyeid));
        $odev = $odev->fetch();
        $this->odevid = $odev['soid'];
        $this->odevadi = $odev['odevbaslik'];
        $this->odevmetni = $odev['odevmetni'];
        $odevvarmi=$this->vtb->prepare("select count(*) from seviye_odev_teslimleri where odevid = ? and uyeid = ?");
        $odevvarmi->execute(array($odev['soid'],$_SESSION['id']));
        $odevvarmi=$odevvarmi->fetchColumn();
        if($odevvarmi>0)
        {
            $odevvarmi=$this->vtb->prepare("select * from seviye_odev_teslimleri where odevid = ? and uyeid = ?");
            $odevvarmi->execute(array($odev['soid'],$_SESSION['id']));
            $odevvarmi=$odevvarmi->fetch();
            $this->odevvarmi=1;
            $this->odevnotu=$odevvarmi['puan'];
            $this->odevadres=$odevvarmi['adres'];
            $this->okundumu=$odevvarmi['okundumu'];
            $this->dosad=$odevvarmi['dosad'];
        }
        else
        {
            $this->odevvarmi=0;
            $this->odevnotu='bos';
            $this->odevadres='bos';
        }
    }

    function ogretmenOdevGetir()
    {
        $odev = $this->vtb->prepare('select * from seviye_odevleri where seviye = ?');
        $odev->execute(array($this->seviyeid));
        $odev = $odev->fetch();
        $this->odevid = $odev['soid'];
        $this->odevadi = $odev['odevbaslik'];
        $this->odevmetni = $odev['odevmetni'];
    }

    function ogretmenOdevTeslimleriniGetir ()
    {
    	$odevt = $this->vtb->prepare("select count(*) from seviye_odev_teslimleri where odevid =  ? and okundumu = 0");
    	$odevt->execute(array($_POST['soid']));
    	$odevt=$odevt->fetchColumn();
    	if($odevt>0)
    	{
    	  $odevt = $this->vtb->prepare("select * from seviye_odev_teslimleri where odevid =  ? and okundumu = 0");
    	  $odevt->execute(array($_POST['soid']));
    	  $odevt = $odevt->fetchAll(PDO::FETCH_ASSOC);
    	   $sy=0;
    	   foreach ($odevt as $ogr) 
    	   {
    	   	  $ogrenci=$this->vtb->prepare("select * from ogrenciuye where uyeid = ?");
    	   	  $ogrenci->execute(array($ogr['uyeid']));
    	   	  $ogrenci=$ogrenci->fetchAll(PDO::FETCH_ASSOC);
    	   	  $odevt[$sy]['user'] = $ogrenci[0]['user'];
    	   	  $odevt[$sy]['foto'] = $ogrenci[0]['foto'];
              $odevt[$sy]['uyeid'] = $ogrenci[0]['uyeid'];
    	   	  //unset($odevt[$sy]['uyeid']);
    	   	  $sy++;
      	   }
    	  echo json_encode($odevt);
    	}
    }

    function seviye_bitirme_durumu ()
    {
        if ($toplam = $this->vtb->query('select count(*) from ders_dokuman_paylasimlari where seviye = ' . $this->seviyeid . " and aktifmi = 1"))
        {
            if ($bakilan = $this->vtb->query('select count(*) from dokuman_gormeleri where seviyeid = ' . $this->seviyeid . " and uyeid = " . $_SESSION['id'] . " and aktifmi = 1"))
            {
                $toplam = $toplam->fetchColumn();
                $bakilan = $bakilan->fetchColumn();
                $birim = $toplam / 100 ;
                $this->yuzde = $bakilan / $birim;
            }
        }

    }

    function ogretmenSivavGoster ()
    {
        $sid=$this->sid_gtr();
        $slist = $this->vtb->query("select * from sinav_soru_paylasimlari where sivavid = " . $sid . " and aktifmi = 1");
        $slist=$slist->fetchAll();
        echo "<h1 class='baslik'>Sınav Özeti</h1><div style='width:100%;height:300px;overflow-y:scroll; margin-top:30px; box-shadow:black 0px 0px 1px;'>";
        foreach ($slist as $soru) {
            $ssoru = $this->vtb->query("select * from sorular where soruid = " . $soru['soruid'])->fetch();
            echo "<div>" . $ssoru['sorumet'] . "</div>";
        }
        echo "</div>";
    }

    function seviyeId ()
    {
        if ($q=$this->vtb->query("select seviyeid from ders_seviyeler where seviyeno = " . $_GET['seviyeno'] . " and dersid = " . $_GET['dersid']))
        {
            $q=$q->fetchColumn();
            return $q;
        }
    }

    function dersTur ()
    {
        if ($tur = $this->vtb->query("select seviyegecmedurumu from ders_seviyeler where dersid = " . $_GET['dersid'] . " and seviyeno = " . $_GET['sevno']))
        {
            $tur = $tur->fetch();
            echo $tur['seviyegecmedurumu'];
        }
    }

    function dersadi ()
    {
        if ($ad=$this->vtb->query('select dersadi from dersler where dersid = ' . $_GET['did']))
        {
            $ad=$ad->fetchColumn();
            echo $ad;
        }
    }



    function sinav_getir ()
    {
        $sinav=$this->vtb->prepare('select * from sinav where seviye = ?');
        $sinav->execute(array($_POST['seviyeid']));
        $sinav = $sinav->fetch();
        $sinav_soru_paylasimlari = $this->vtb->prepare('select * from sinav_soru_paylasimlari where sivavid = ? and aktifmi = 1');
        $sinav_soru_paylasimlari->execute(array($sinav['sinavid']));
        $sinav_soru_paylasimlari = $sinav_soru_paylasimlari->fetchAll();
        $sorular = array("s");
        foreach ($sinav_soru_paylasimlari as $pay)
        {
            array_push($sorular,$pay['soruid']);
        }
        $sorularc = $this->vtb->query($this->sorgubul('select * from sorular','soruid',"=",$sorular,"0,1000","or"));
        $sorularc=$sorularc->fetchAll(PDO::FETCH_ASSOC);
        $sorular = array("sorular" => $sorularc , "sinavid" => $sinav['sinavid']);
        echo json_encode($sorular);

    }

    function ogretmen_sinnav_getir ()
    {
        if ($this->vtb != null)
        {

            if($si=$this->vtb->query('select * from ders_seviyeler where dersid = ' . $_GET['ders'] . ' and seviyeno = ' . $_GET['seviyeno']))
            {
                $si=$si->fetch();
                $si=$si['seviyeid'];

                $si=$this->vtb->query('select * from sinav where seviye = ' . $si);
                $si=$si->fetch();
                $si = $si['sinavid'];

                if ($sor = $this->vtb->query('select * from sinav_soru_paylasimlari where sivavid = ' . $si . ' and aktifmi = 1'))
                {
                    $sor = $sor->fetchAll();
                    $syc = 1;
                    echo "<div class='frm' style='width:80%;overflow-y:scroll;'><h1 class='baslik'>Sorduğunuz Sorular</h1>";
                    foreach ($sor as $b) {
                        if ($a = $this->vtb->query('select * from sorular where soruid = ' . $b['soruid']))
                        {
                            $a = $a->fetch();

                            echo "<p>" . $a['sorumet'] . "</p>";
                            echo "<p>" . $a['a'] . "</p><br /><p>" . $a['b'] . "</p><br /><p>" . $a['c'] . "</p><br /><p>" . $a['d'] . "</p>";
                            echo "<p><input type='checkbox' name='ksor" . $b['pid'] . "'>Bu Soruyu Kaldır</p><hr style='margin-top:35px;' />";
                        }
                    }

                    echo "</div>";
                }
            }
        }
    }


    function ogrenciSinavBilgileri()
    {
        $sinav=$this->vtb->prepare("select * from sinav where seviye = ?");
        $sinav->execute(array($this->seviyeid));
        $sinav=$sinav->fetch();
        $this->sinavsure=$sinav['sinavsure'];
        $ss=$this->vtb->prepare('select count(*) from sinav_soru_paylasimlari where sivavid = ? and aktifmi = 1');
            $ss->execute(array($sinav['sinavid']));
            $this->sorusay=$ss->fetchColumn();
        $varmi=$this->vtb->prepare("select count(*) from ssonuc where sinavid = ? and uyeid = ? ");
        $varmi->execute(array($sinav['sinavid'],$_SESSION['id']));
        $varmi=$varmi->fetchColumn();
        if($varmi>0)
        {
            $this->girdimi=1;
            $puan=$this->vtb->prepare("select puan from ssonuc where sinavid = ? and uyeid = ? ");
            $puan->execute(array($sinav['sinavid'],$_SESSION['id']));
            $puan=$puan->fetchColumn();
            $this->sinavnot=$puan;
        }
        else
        {
            $this->girdimi=0;
            $this->sinavnot="bos";
        }
    }


    function ogretmenSinavBigileri ()
    {
            $sinav=$this->vtb->prepare("select * from sinav where seviyeid = ?");
            $sinav->execute(array($this->seviyeid));
            $this->sinavsure=$sinav['sinavsure'];
            $this->sinavid=$sinav['sinavid'];
    }


    function ogrenciListesi ()
    {
    	$ogrsay=$this->vtb->prepare("select count(*) from ders_secimleri where dersid = ?");
    	$ogrsay->execute(array($this->dersid));
    	$ogrsay=$ogrsay->fetchColumn();
    	if($ogrsay>0)
    	{
    	   $ogrencilers=$this->vtb->prepare("select * from ders_secimleri where dersid = ? limit " . $_POST['limit']);
    	   $ogrencilers->execute(array($this->dersid));
    	   $ogrencilers=$ogrencilers->fetchAll();
    	  // echo "[";
    	   $arry=array('isim' => 'dada');
    	   $sy=0;
    	   foreach ($ogrencilers as $ogr) 
    	   {
    	   	  $ogrenci=$this->vtb->prepare("select * from ogrenciuye where uyeid = ?");
    	   	  $ogrenci->execute(array($ogr['uyeid']));
    	   	  $ogrenci=$ogrenci->fetchAll(PDO::FETCH_ASSOC);
    	   	  $ogrenci[0]['starih']=$ogr['starih'];
    	   	  array_push($arry, $ogrenci[0]);
    	   }
    	   unset($arry['isim']);
    	   echo json_encode($arry);
        }
    }


}