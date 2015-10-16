<?php

class arkadaslik
{
    private $vtb;

    function arkadaslik () {
      $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
    }


    function istekYap ()
    {
    	if ($this->vtb->exec("insert into arkadasliklar (`tedenid`, `tedilenid`, `aktifmi`) values(" . $_SESSION['id'] . "," . $_POST['tedilen'] . ",0)"))
    	{
    		echo "1";
    	}
    }

    function istekOnayla ()
    {
    	if ($this->vtb->exec("update `arkadasliklar` set `aktifmi`= 1 where `arkadasliklar`.`arkid`=" . $_POST['arkid']))
    	{
    		echo "1";
    	}
    }

    function istekReddet ()
    {
    	if ($this->vtb->exec("update `arkadasliklar` set `red`= 1 where `arkadasliklar`.`arkid`=" . $_POST['arkid']))
    	{
    		echo "1";
    	}
    }

    function istekSil ()
    {
      if ($this->vtb->exec("delete from arkadasliklar where tedenid  = " . $_SESSION['id'] . " and tedilenid = " . $_POST['tedilen']))
    	{
    		echo "1";
    	}
    }

}

session_start();

if ($_POST['komut']=='iy')
{
	$arkadas=new arkadaslik();
	$arkadas->istekYap();
}

if ($_POST['komut']=='io')
{
	$arkadas=new arkadaslik();
	$arkadas->istekOnayla();
}

if ($_POST['komut']=='ir')
{
	$arkadas=new arkadaslik();
	$arkadas->istekReddet();
}

if ($_POST['komut']=='is')
{
	$arkadas=new arkadaslik();
	$arkadas->istekSil();
}
