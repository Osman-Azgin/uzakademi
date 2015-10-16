<?php

session_start();

include("dersISLEM.php");

if ($_POST['komut']=="do")
{
    $drs=new dersIslem();
    $drs->ders_olustur();
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

    $durum = array('durum' => 'OK' , 'dersid' => $drs->dersid );

    echo json_encode($durum);
}

?>
