<?php

  class not
  {
    private $vtb;

    function not ()
    {
       $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
    }

    function not_ekle ()
    {
       $nt=$this->vtb->prepare('INSERT INTO `notlar`(`uyeid`, `notbaslik`, `noticerik`, `dersid`, `seviyeid`, `nottarih`) VALUES(?,?,?,?,?,?)');
       $nt->execute(array($_SESSION['id'],$_POST['baslik'],$_POST['not'],$_POST['dersid'],$_POST['seviye'],date("d-m-Y")));
       echo 'INSERT INTO `notlar`(`uyeid`, `notbaslik`, `noticerik`, `dersid`, `seviyeid`, `nottarih`) VALUES(' . $_SESSION['id'] . ',"' . $_POST['baslik'] . '","' . $_POST['not'] . '",' . $_POST['dersid'] . ',' . $_POST['seviye'] . ',"' . date("d-m-Y") .'")';
    }

    function not_getir ($dersid,$seviye,$class)
    {
       $sorgu = "select * from notlar where ";
       if ($dersid != null)
       {
	 $sorgu=$sorgu . "dersid = " . $dersid . " and ";
       }
       if ($seviye != null)
       {
	 $sorgu=$sorgu . "seviyeid = " . $seviye;
       }
       else
       {
	 $sorgu = $sorgu . " uyeid = " . $_SESSION['id'];
       }

       $sorgu = $sorgu . " and aktifmi = 1 order by notid desc limit 0,30";
       if ($notlar=$this->vtb->query($sorgu))
       {
	 $notlar=$notlar->fetchAll(PDO::FETCH_ASSOC);
	 echo json_encode($notlar);
         //$id = 1;
	 //foreach ($notlar as $not)
	// {
	  // echo "<div class='" . $class ."'><h2>" . $not['notbaslik'] . "</h2><p id='not" . $id . "'>" . $not['noticerik'] . "</p><a href='javascript: not_duz_ac (" . $not['notid'] . "," . $id . ")'>Düzenle</a></div>";
     //     $id ++;
	 //}
       }
    }


    function not_guncelle ()
    {
       $nt=$this->vtb->exec('UPDATE  `notlar` SET `noticerik` = "' . $_POST['not'] . '" WHERE `notlar`.`notid` = ' . $_POST['notid'] );
    }

    function notSil ()
    {
    	$ns=$this->vtb->prepare('UPDATE  `notlar` SET `aktifmi` = "0" WHERE `notlar`.`notid` = ? ');
    	$ns->execute(array($_POST['notid']));
    }
    

  }

session_start();

if ($_POST['komut']=='ne') 
{
	$n=new not();
	$n->not_ekle();
}

if ($_POST['komut']=='sng') 
{
	$n=new not();
	$n->not_getir(null,null,'isbox');
}

if ($_POST['komut']=='dsng') 
{
	$n=new not();
	$n->not_getir(null,$_POST['seviye'],'dokuman_kutusu');
}

if ($_POST['komut']=='ng')
{
      $n=new not();
      $n->not_guncelle ();
}

if($_POST['komut']=='ns')
{
	$n=new not();
    $n->notSil();
}



?>
