<?php

session_start();


include("dersGoruntuleme.php");


$cmd=$_POST['cmd'];

$ders = new dersGoruntuleme();

if($cmd=="dersgetir")
{

        $ders->ogretmenDersGetir();
        if ($ders->mesaj == null) {
            $gonderilecekler = array('dersadi' => $ders->dersadi, 'seviyeid' => $ders->seviyeid, 'seviyeno' => $ders->seviyeno, 'sgd' => $ders->sgd, 'seviyeozellik' => $ders->seviyeozellik, 'ogrencisay' => $ders->ogrencisayisi, 'ebsno' => $ders->ebsno, 'sevsay' => $ders->sevsay);
            echo json_encode($gonderilecekler);
        } else {
            echo $ders->mesaj();
        }


}

if($cmd=="dokumangetir")
{
    $ders->seviyeid=$_POST['seviyeid'];
    $ders->dokuman_getir();
}

if($cmd=="sinavgetir")
{
    $ders->seviyeid=$_POST['seviyeid'];
    $ders->sinav_getir();
}

if($cmd=="odevgetir")
{
    $ders->seviyeid=$_POST['seviyeid'];
    $ders->ogretmenOdevGetir();
    $gonderilecekler = array('odevadi' => $ders->odevadi, 'odevmetni' => $ders->odevmetni, 'odevid' => $ders->odevid);
    echo json_encode($gonderilecekler);
}

if ($cmd == "otgetir") 
{
	$ders->ogretmenOdevTeslimleriniGetir();
}

if ($cmd=="oglist") 
{
	$ders->dersid=$_POST['dersid'];
	$ders->ogrenciListesi();
}



?>