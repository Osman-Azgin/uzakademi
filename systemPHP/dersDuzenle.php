<?php

session_start();

include('dersISLEM.php');

$cmd = $_POST['cmd'];

$dersIs = new dersIslem();

if($cmd == "doksil")
{
	$dersIs->seviyeid = $_POST['seviyeid'];
	$dersIs->dokumanKaldir();
}

if($cmd=="dokekle")
{
	$dersIs->seviyeid = $_POST['sid'];
	$dersIs->dersid = $_POST['drsid'];
	$dersIs->dokuman_yukle();
}

if ($cmd == "sinavduzenle")
{
	$dersIs->ogretmen_sinav_guncelle();
}

if($cmd=="odevduzenle")
{
	$dersIs->odev_guncelle();
}

if($cmd=="odevnot")
{
	$dersIs->odeveNotVer();
}

if ($cmd=="so")
{
    $drs=new dersIslem();
    $drs->dersid=$_POST['dersid'];
    $drs->seviye_olustur();
    $drs->dokuman_yukle();
    if($_POST['sg']=='s' or $_POST['sg']=='so')
    {
        $drs->sinav_olustur();
    }
    if ($_POST['sg']=='o' or $_POST['sg']=='so') 
    {
        $drs->odev_ver();
    }
    $sev=$_POST['ebsno'] +1;
    $durum = array('durum' => 'OK' , 'dersid' => $drs->dersid , 'seviyeno' => $sev );

    echo json_encode($durum);
}