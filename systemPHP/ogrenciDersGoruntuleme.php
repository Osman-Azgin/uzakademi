<?php

session_start();

include("dersGoruntuleme.php");

$cmd=$_POST['cmd'];

$ders = new dersGoruntuleme();

if($cmd=="dersgetir")
{
   $ders->ogrenciDersGetir();
   if($ders->mesaj==null)
   {
      $gonderilecekler = array('dersadi' => $ders->dersadi, 'seviyeid' => $ders->seviyeid, 'seviyeno' => $ders->seviyeno, 'sgd' => $ders->sgd, 'seviyeozellik' => $ders->seviyeozellik, 'yuzde' => $ders->yuzde, 'ogretmenadi' => $ders->ogretmenadi, 'ogretmenid' => $ders->ogretmenid, 'ogretmenfoto' => $ders->ogretmenfoto);
      echo json_encode($gonderilecekler);
   }
   else
   {
      echo $ders->mesaj();
   }
}

if($cmd=="dokumangetir")
{
   $ders->seviyeid=$_POST['seviyeid'];
   $ders->dokuman_getir();
}

if($cmd=="sinavbilgileri")
{
   $ders->seviyeid=$_POST['seviyeid'];
   $ders->ogrenciSinavBilgileri();
   $gonderilecekler = array('sinavsure' => $ders->sinavsure, 'girdimi' => $ders->girdimi, 'sinavnot' => $ders->sinavnot, 'sorusay' => $ders->sorusay);
   echo json_encode($gonderilecekler);
}

if($cmd=="odevgetir")
{
   $ders->seviyeid=$_POST['seviyeid'];
   $ders->odevGetir();
   $gonderilecekler = array('odevadi' => $ders->odevadi, 'odevmetni' => $ders->odevmetni, 'odevvarmi' => $ders->odevvarmi, 'odevnotu' => $ders->odevnotu, 'odevid' => $ders->odevid, 'odevadres' => $ders->odevadres, 'okundumu' => $ders->okundumu,'dosad' => $ders->dosad);
   echo json_encode($gonderilecekler);
}

if ($cmd=="otdg") 
{
	$ders->ogrenci_dokuman_gor();
}

if ($cmd=="osg")
{
   $ders->sinav_getir();
}



?>