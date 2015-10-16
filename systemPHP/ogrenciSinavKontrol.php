<?php

session_start();

include('dersISLEM.php');

$ders = new dersIslem();

$ders->sinav_kontrol();