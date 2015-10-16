<?php

class dersIslem
{
    public $vtb;
    public $dersid;
    public $dersadi;
    public $seviyeid;

    function dersIslem()
    {
        try {
            $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17', 'Uzakademi2014');
        } catch (PDOException $e) {
            $this->vtb = null;
        }
    }

    function ders_olustur()
    {
        $varmi = $this->vtb->prepare("select count(*) from dersler where dersadi = ? and ogretmenid = ?");
        $varmi->execute(array($_POST['dersadi'], $_SESSION['id']));
        $varmi = $varmi->fetchColumn();

        if ($varmi > 0) {
            echo "[0:1]";
        } elseif ($varmi == 0) {
          //  $tar = date("d-m-Y");
            $ders = $this->vtb->prepare("INSERT INTO dersler(dersadi, ogretmenid, daciklama) VALUES (?, ?, ?)");
            $ders->execute(array($_POST['dersadi'], $_SESSION['id'], $_POST['dersacik']));

            $varmi = $this->vtb->prepare("select count(*) from dersler where dersadi = ? and ogretmenid = ?");
            $varmi->execute(array($_POST['dersadi'], $_SESSION['id']));
            $varmi = $varmi->fetchColumn();

            if ($varmi > 0) {
                $varmi = $this->vtb->prepare("select * from dersler where dersadi = ? and ogretmenid = ?");
                $varmi->execute(array($_POST['dersadi'], $_SESSION['id']));
                $varmi = $varmi->fetch();
                $this->dersid = $varmi['dersid'];
                $this->dersadi = $varmi['dersadi'];
            } elseif ($varmi == 0) {
                echo "[0:11]";
            }
        }
    }


    function seviye_olustur()
    {
        $svarmi = $this->vtb->prepare("select count(*) from ders_seviyeler where dersid = ?");
        $svarmi->execute(array($this->dersid));
        $svarmi = $svarmi->fetchColumn();

        if ($svarmi > 0) {
            $svarmi = $this->vtb->prepare('select max(seviyeno) from ders_seviyeler where dersid = ?');
            $svarmi->execute(array($this->dersid));
            $svarmi = $svarmi->fetchColumn();
            $seviyeno = $svarmi+1;
        } elseif ($svarmi == 0) {
            $seviyeno = 1;
        }
        $ekle = $this->vtb->prepare("INSERT INTO `ders_seviyeler`(`seviyeno`, `seviyeozellik`, `seviyegecmedurumu`, `dersid`) VALUES (?,?,?,?)");
        $ekle->execute(array($seviyeno, 'n', $_POST['sg'], $this->dersid));

        $svarmi = $this->vtb->prepare("select count(*) from ders_seviyeler where dersid = ? and seviyeno = ?");
        $svarmi->execute(array($this->dersid, $seviyeno));
        $svarmi = $svarmi->fetchColumn();

        if ($svarmi > 0) {
            $svarmi = $this->vtb->prepare("select * from ders_seviyeler where dersid = ? and seviyeno = ?");
            $svarmi->execute(array($this->dersid, $seviyeno));
            $svarmi = $svarmi->fetch();
            $this->seviyeid = $svarmi['seviyeid'];
        } elseif ($svarmi == 0) {
            echo "[0:2]";
        }

    }

    function dokuman_yukle()
    {


        $dokumanlar = array_keys($_POST);

        foreach ($dokumanlar as $g) {


            if (substr($g, 0, 7) == 'dokuman') {
                $id = substr($g, 7, strlen($g));
                $ekle = $this->vtb->prepare("INSERT INTO `ders_dokuman_paylasimlari`(`dersid`, `seviye`, `dosyaid`, `aktifmi`) VALUES(?,?,?,?)");
                $ekle->execute(array($this->dersid, $this->seviyeid, $id, 1));
            }
        }

    }

    function sinav_olustur()
    {

        $sinav = $this->vtb->prepare("INSERT INTO `sinav`(`dersid`, `seviye`, `sinavsure`) VALUES (?,?,?)");
        $sinav->execute(array($this->dersid, $this->seviyeid, '60'));

        $sinav = $this->vtb->prepare('select count(*) from sinav where seviye = ?');
        $sinav->execute(array($this->seviyeid));
        $sinav = $sinav->fetchColumn();

        if ($sinav > 0) {
            $sinav = $this->vtb->prepare('select * from sinav where seviye = ?');
            $sinav->execute(array($this->seviyeid));
            $sinav = $sinav->fetch();

            $gettekiler = array_keys($_POST);

            foreach ($gettekiler as $g) {
                if (substr($g, 0, 4) == 'soru') {
                    $id = substr($g, 4, strlen($g));

                    $ekle = $this->vtb->prepare("INSERT INTO `sinav_soru_paylasimlari`(`sivavid`, `soruid`) VALUES (?,?)");
                    $ekle->execute(array($sinav['sinavid'], $id));
                    $svarmi = $this->vtb->prepare("select count(*) from sinav_soru_paylasimlari where sivavid = ? and soruid = ?");
                    $svarmi->execute(array($sinav['sinavid'], $id));
                    $svarmi = $svarmi->fetchColumn();

                    if ($svarmi == 0) {
                        echo "[0:3]";
                    }

                }
            }
        } elseif ($sinav == 0) {
            echo "[0:33]";
        }

    }


    function odev_ver()
    {

        $odev = $this->vtb->prepare("INSERT INTO `seviye_odevleri`(`odevbaslik`,`odevmetni`,`dersid`,`seviye`) VALUES (?,?,?,?)");
        $odev->execute(array($_POST['odevbaslik'], $_POST['odevaciklamasi'], $this->dersid, $this->seviyeid));

        $kodev = $this->vtb->prepare('select count(*) from seviye_odevleri where seviye = ?');
        $kodev->execute(array($this->seviyeid));
        $kodev = $kodev->fetchColumn();

        if ($kodev == 0) {
            echo "[0:4]";
        }
    }


    function sinav_kontrol()
    {
        $s = $this->vtb->prepare('select * from sinav where seviye = ?');
        $s->execute(array($_POST['seviyeid']));
        $sinav = $s->fetch();

        $syc = $this->vtb->prepare('select count(*) from sinav_soru_paylasimlari where sivavid = ? and aktifmi = 1');
        $syc->execute(array($sinav['sinavid']));
        $syc = $syc->fetchColumn();
        $ds = 0;
        $ys = 0;
        $konular = array();

        $gettekiler = array_keys($_POST);

        foreach ($gettekiler as $g) {
            if (substr($g, 0, 1) == 'c') {
                $k = substr($g, 1, strlen($g));
                $soru = $this->vtb->prepare('select * from sorular where soruid = ?');
                $soru->execute(array($k));
                $soru = $soru->fetch();
                if ($soru['dc'] == $_POST[$g]) {
                    $ds++;
                    if (isset($konular[$k])) {
                        $konular[$k]['ss']++;
                        $konular[$k]['dp'] = $konular[$k]['dp'] + $soru['zorluk'];
                        $konular[$k]['tp'] = $konular[$k]['tp'] + $soru['zorluk'];
                    } else {
                        $konular[$k]['ss'] = 1;
                        $konular[$k]['dp'] = $soru['zorluk'];
                        $konular[$k]['tp'] = $soru['zorluk'];
                    }
                } else {
                    if (isset($konular[$k])) {
                        $konular[$k]['ss']++;
                        $konular[$k]['dp'] = $konular[$k]['dp'] + $soru['zorluk'];
                        $konular[$k]['tp'] = $konular[$k]['tp'] + $soru['zorluk'];
                    } else {
                        $konular[$k]['ss'] = 1;
                        $konular[$k]['dp'] = 0;
                        $konular[$k]['tp'] = $soru['zorluk'];
                    }
                    $ys++;
                }

            }
        }


        $sp = 100 / $syc;
        $not = $sp * $ds;

        $r = $this->vtb->query('select count(*) from ssonuc where sinavid = ' . $sinav['sinavid'] . " and uyeid = " . $_SESSION['id']);
        $z = $r->fetchColumn();
        if ($z > 0) {
            if ($n = $this->vtb->query('select * from ssonuc where sinavid = ' . $sinav['sinavid'] . " and uyeid = " . $_SESSION['id'])) {
                $n = $n->fetch();
                if ($sk = $this->vtb->exec('UPDATE `neduzaka_uzakakademi17`.`ssonuc` SET `puan` = "' . $not . '" WHERE `ssonuc`.`sonucid` = ' . $n['sonucid'] . ';')) {
                    echo "<h1>" . $not . "</h1>";
                }
            }
        } else {
            if ($sk = $this->vtb->exec('INSERT INTO `ssonuc`(`uyeid`, `sinavid`, `dersid`, `puan`, `durum`, `seviyeid`) VALUES (' . $_SESSION['id'] . ',' . $sinav['sinavid'] . ',' . $_POST['dersid'] . ',' . $not . ',1,' . $_POST['seviyeid'] . ')')) {
                echo $not;
            }
        }

        $kidler = array_keys($konular);

        foreach ($kidler as $ki) {
            if ($n = $this->vtb->exec('INSERT INTO `sinav_konu_analizleri`(`sinavid`,`konuid`,`dp`,`tp`,`uyeid`) VALUES(' . $sinav['sinavid'] . ',' . $ki . ',' . $konular[$ki]['dp'] . ',' . $konular[$ki]['tp'] . ',' . $_SESSION['id'] . ')')) {
                echo "ok";
            }
        }


        if ($_POST['sgd'] == 's') {
            $this->seviye_gecir($_POST['seviyeid'], $_SESSION['id'], $_POST['dersid'], $_POST['sevno'], $_POST['sgd'], $not, null);
        }

        if ($_POST['sgd'] == 'so') {
            if ($ont = $this->vtb->query('select * from seviye_odev_teslimleri where uyeid = ' . $_SESSION['id'] . " and seviyeid = " . $_POST['seviyeid'])) {
                $odnt = $ont->fetch();
                $this->seviye_gecir($_POST['seviyeid'], $_SESSION['id'], $_POST['dersid'], $_POST['sevno'], $_POST['sgd'], $not, $odnt['puan']);
            }
        }


    }


    function seviye_gecir($sid, $id, $drsid, $sevno, $sgd, $snot, $onot)
    {
        if ($sgd == 's') {
            if ($snot != null) {

                if ($snot > 59) {
                    $ysevno = $sevno + 1;

                    $svy = $this->vtb->query('select count(*) from ders_seviyeler where dersid =' . $drsid . ' and seviyeno = ' . $ysevno);
                    $sv = $svy->fetchColumn();
                    if ($sv > 0) {
                        if ($svy = $this->vtb->query('select * from ders_seviyeler where dersid =' . $drsid . ' and seviyeno = ' . $ysevno)) {
                            $sev = $svy->fetch();
                            $n = $this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_secimleri` SET `seviyeid` = '" . $sev['seviyeid'] . "' , `seviyeno` = '" . $ysevno . "' WHERE `seviye_secimleri`.`uyeid` =" . $id . " and `seviye_secimleri`.`dersid` =" . $drsid . ";");
                        }
                    } else {
                        $n = $this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_secimleri` SET `seviyeid` = '0' , `seviyeno` = '" . $ysevno . "' WHERE `seviye_secimleri`.`uyeid` =" . $id . " and `seviye_secimleri`.`dersid` =" . $drsid . ";");

                    }
                }
            }
        }


        if ($sgd == 'so') {

            if ($snot != null and $onot != null) {
                if ($snot > 59 and $onot > 59) {
                    $ysevno = $sevno + 1;
                    $svy = $this->vtb->query('select count(*) from ders_seviyeler where dersid =' . $drsid . ' and seviyeno = ' . $ysevno);
                    $svy = $svy->fetchColumn();
                    if ($svy > 0) {
                        if ($svy = $this->vtb->query('select * from ders_seviyeler where dersid =' . $drsid . ' and seviyeno = ' . $ysevno)) {
                            $sev = $svy->fetch();
                            $n = $this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_secimleri` SET `seviyeid` = '" . $sev['seviyeid'] . "' , `seviyeno` = '" . $ysevno . "' WHERE `seviye_secimleri`.`uyeid` =" . $id . " and `seviye_secimleri`.`dersid` =" . $drsid . ";");
                        }
                    } else {
                        $n = $this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_secimleri` SET `seviyeid` = '0' , `seviyeno` = '" . $ysevno . "' WHERE `seviye_secimleri`.`uyeid` =" . $id . " and `seviye_secimleri`.`dersid` =" . $drsid . ";");

                    }
                }
            }
        }


        if ($sgd == 'o') {
            if ($onot != null) {
                if ($onot > 59) {
                    $ysevno = $sevno + 1;
                    $svy = $this->vtb->query('select count(*) from ders_seviyeler where dersid =' . $drsid . ' and seviyeno = ' . $ysevno);
                    $svy = $svy->fetchColumn();
                    if ($svy > 0) {
                        if ($svy = $this->vtb->query('select * from ders_seviyeler where dersid =' . $drsid . ' and seviyeno = ' . $ysevno)) {
                            $sev = $svy->fetch();
                            $n = $this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_secimleri` SET `seviyeid` = '" . $sev['seviyeid'] . "' , `seviyeno` = '" . $ysevno . "' WHERE `seviye_secimleri`.`uyeid` =" . $id . " and `seviye_secimleri`.`dersid` =" . $drsid . ";");
                        }
                    } else {
                        $n = $this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_secimleri` SET `seviyeid` = '0' , `seviyeno` = '" . $ysevno . "' WHERE `seviye_secimleri`.`uyeid` =" . $id . " and `seviye_secimleri`.`dersid` =" . $drsid . ";");

                    }
                }
            }
        }

    }

    function odeveNotVer()
    {
        if ($this->vtb != null) {

            if ($x = $this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_odev_teslimleri` SET `okundumu` = '1' , `puan` = '" . $_POST['not'] . "' WHERE `seviye_odev_teslimleri`.`oid` =" . $_POST['odevtid'] . " ;")) {
                echo "1";
            }

            if ($_POST['not'] > 59) {
                if ($_POST['sgd'] == 'o') {
                    $this->seviye_gecir($_POST['seviyeid'], $_POST['uyeid'], $_POST['dersid'], $_POST['sevno'], $_POST['sgd'], null, $_POST['not']);
                }

                if ($_POST['sgd'] == 'so') {
                    if ($ont = $this->vtb->query('select * from ssonuc where uyeid = ' . $_POST['uyeid'] . " and seviyeid = " . $_POST['seviyeid'])) {
                        $odnt = $ont->fetch();
                        $this->seviye_gecir($_POST['seviyeid'], $_POST['uyeid'], $_POST['dersid'], $_POST['sevno'], $_POST['sgd'], $odnt['puan'] , $_POST['not']);
                    }
                }

            }


        }

    }


    function ogretmen_sinnav_getir()
    {
        if ($this->vtb != null) {

            if ($si = $this->vtb->query('select * from ders_seviyeler where dersid = ' . $_GET['ders'] . ' and seviyeno = ' . $_GET['seviyeno'])) {
                $si = $si->fetch();
                $si = $si['seviyeid'];

                $si = $this->vtb->query('select * from sinav where seviye = ' . $si);
                $si = $si->fetch();
                $si = $si['sinavid'];

                if ($sor = $this->vtb->query('select * from sinav_soru_paylasimlari where sivavid = ' . $si . ' and aktifmi = 1')) {
                    $sor = $sor->fetchAll();
                    $syc = 1;
                    echo "<div class='frm' style='width:80%;overflow-y:scroll;'><h1 class='baslik'>Sorduğunuz Sorular</h1>";
                    foreach ($sor as $b) {
                        if ($a = $this->vtb->query('select * from sorular where soruid = ' . $b['soruid'])) {
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


    function ogretmen_sinav_guncelle()
    {
        if ($this->vtb != null) {
            $n = array_keys($_POST);

            foreach ($n as $no) {
                $r = substr($no, 0, 4);

                if ($r == "soru") {
                    $l = strlen($no);
                    $l = substr($no, 4, $l);
                    $g = $this->vtb->prepare("INSERT INTO `sinav_soru_paylasimlari`(`sivavid`, `soruid`) VALUES(?,?)");
                    $g->execute(array($_POST['sinavid'],$l));
                }

                if ($r == "ksor") {
                    $l = strlen($no);
                    $l = substr($no, 4, $l);
                    $g = $this->vtb->prepare("UPDATE `neduzaka_uzakakademi17`.`sinav_soru_paylasimlari` SET `aktifmi` = '0' WHERE `sinav_soru_paylasimlari`.`soruid`= ? and `sinav_soru_paylasimlari`.`sivavid` = ?");
                    $g->execute(array($l,$_POST['sinavid']));
                }


            }
        }
    }


    function odev_guncelle()
    {
        $g = $this->vtb->prepare("UPDATE `neduzaka_uzakakademi17`.`seviye_odevleri` SET `odevbaslik` = ?, `odevmetni` = ? WHERE `seviye_odevleri`.`soid`= ?");
        $g->execute(array($_POST['obas'],$_POST['oacik'],$_POST['oid']));
    }


    function dokumanKaldir()
    {
        $kaldir = $this->vtb->prepare("UPDATE `neduzaka_uzakakademi17`.`ders_dokuman_paylasimlari` SET `aktifmi` = '0' WHERE `ders_dokuman_paylasimlari`.`dosyaid`= ? and `ders_dokuman_paylasimlari`.`seviye` = ?");
        $kaldir->execute(array($_POST['dosyaid'],$this->seviyeid));
        $dgkaldir = $this->vtb->prepare("UPDATE `neduzaka_uzakakademi17`.`dokuman_gormeleri` SET `aktifmi` = '0' WHERE `dokuman_gormeleri`.`dokumanid`= ? ");
        $dgkaldir->execute(array($_POST['dosyaid']));
    }


}