<?php

session_start();

include("her_sayfada_olan.php");


$komut = $_POST['komut'];



if ($komut == "m_b")
{
  $mb_guncelle = new her_sayfada_olan();

  $mb_guncelle->kontrol();
}

if ($komut == "m_g")
{
    $mb_guncelle = new her_sayfada_olan();

    $mb_guncelle->mesaj_guncelle();
}


if ($komut == "mid")
{
    $mb_guncelle = new her_sayfada_olan();

    $mb_guncelle->idal();
}

if ($komut=='mssg')
{
    $mb_guncelle = new her_sayfada_olan();

    $mb_guncelle->sayial();
}






if ($komut == "b_g")
{
    $mb_guncelle = new her_sayfada_olan();
    $mb_guncelle->en_buyuk_bildirim_id = $_POST['e_b_b_id'];
    $mb_guncelle->bilditrim_guncelle();
}

if ($komut == "m_k")
{
    $mb_guncelle = new her_sayfada_olan();
    $mb_guncelle->mesaj_kontrol();
}

if ($komut == "e_b_m")
{

}
?>