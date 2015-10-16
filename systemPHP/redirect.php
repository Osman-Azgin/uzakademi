<?php
 class oturum {

 public $siniflari;
 public $arkadaslistesi;
 public $istekler;
 public $dersler;
 public $deradlari;
 public $vt;


    function oturum ($kulad,$sfr)
    {
       $this->siniflari=array("siniflar");
	   $this->dersler=array("dersler");
	   $this->dersadlari=array("dersler");
       $this->istekler=array("istek");


         try {

           $this->vt = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');

           $varmi = $this->vt->query('select count(*) from ogrenciuye where user = "'.$kulad.'"')->fetchColumn();

           if($varmi>0)
           {
              $sonuc = $this->vt->query('select * from ogrenciuye where user = "'.$kulad.'"')->fetch();
              $kullaniciadi = $sonuc['user'];
              $sifre=$sonuc['pass'];
              $yetki=$sonuc['yetki'];
              $resim=$sonuc['foto'];
              $id=$sonuc['uyeid'];
              $isim = $sonuc['uyeadi'];
               $_SESSION['Kullanici']=$kullaniciadi;
               $_SESSION['resim']=$resim;
               $_SESSION['id']=$id;
               $_SESSION['isim'] = $isim;
               $_SESSION['yetki'] = $yetki;

               $cev = $this->sorgula("select * from sinif_secimleri where uyeid = " . $_SESSION['id']);
               if ($cev != null )
               {
                   foreach ($cev as $c) {
                       array_push($this->siniflari, $c['sinifid']);
                   }
               }
               else
               { $this->siniflari=null;}



               $cev=$this->sorgula('select * from istekler where iyplnid = ' . $_SESSION['id'] . " and aktifmi = 1");
               foreach ($cev as $c)
               {
                   $n=$this->vt->query('select user from ogrenciuye where uyeid = ' . $c['iypnid'])->fetchColumn();
                   $k=$this->vt->query('select dersadi from dersler where dersid = ' . $c['dersvysnfid'])->fetchColumn();
                   $yzlck = "<div id='i" . $c['iid'] ."'><p>" . $n . ' sizin ' . $k . " dersinize katılmak istiyor.<br /><a href='javascript: istek_onayla(" . $c['iid'] . "," . $c['iid'] . ");'>Onayla</a><a href='javascript: istek_reddet(" . $c['dersvysnfid'] . ");'>Reddet</a></p></div>";
                   array_push($this->istekler, $yzlck);
               }
               $_SESSION['istekler'] = $this->istekler;




               if ($sifre==$sfr)
               {

                  if ($yetki==0)
                  {
                      $cev = $this->sorgula("select * from ders_secimleri where uyeid = " .$_SESSION['id']);
                      if ($cev != null )
                      {
                          foreach ($cev as $c) {
                              $k=$this->vt->query('select * from dersler where dersid = ' . $c['dersid'])->fetch();
                              array_push($this->dersler, $c['dersid']);
                              array_push($this->dersadlari, $k['dersadi']);

                          }
                          $_SESSION['dersler']=$this->dersler;
                          $_SESSION['dersadlari'] = $this->dersadlari;

                      }
                      else
                      { $this->dersler=null; }

                      $arkids = array("arks");
                      $arkads = array("arks");
                      $arkfots = array("arkfots");

                      $cev = $this->sorgula("select * from arkadasliklar where aktifmi = 1 and  tedenid = " . $_SESSION['id'] . " or aktifmi = 1 and tedilenid = " . $_SESSION['id'] . " ");
                      if ($cev != null)
                      {
                          foreach ($cev as $c)
                          {
                              if ($c['tedenid'] == $_SESSION['id'])
                              {
                                  array_push($arkids, $c['tedilenid']);
                                  $adrkadi = $this->vt->prepare("select user,foto from ogrenciuye where uyeid = ?");
                                  $adrkadi->execute(array($c['tedilenid']));
                                  $adrkadi=$adrkadi->fetch();
                                  array_push($arkads,$adrkadi['user']);
                                  array_push($arkfots,$adrkadi['foto']);

                              }
                              elseif ($c['tedilenid'] == $_SESSION['id'])
                              {
                                  array_push($arkids, $c['tedenid']);
                                  $adrkadi = $this->vt->prepare("select user,foto from ogrenciuye where uyeid = ?");
                                  $adrkadi->execute(array($c['tedenid']));
                                  $adrkadi=$adrkadi->fetch();
                                  array_push($arkads,$adrkadi['user']);
                                  array_push($arkfots,$adrkadi['foto']);
                              }
                          }

                          $_SESSION['arkids']=$arkids;
                          $_SESSION['arkads']=$arkads;
                          $_SESSION['arkfots']=$arkfots;
                      }


                      header("location:../systemVISUAL/panel.php");
                  }

                  if ($yetki==1)
                  {
                      $cev = $this->sorgula("select * from dersler where ogretmenid = " .$_SESSION['id']);
                      if ($cev != null )
                      {
                          foreach ($cev as $c) {
                              array_push($this->dersler, $c['dersid']);
                              array_push($this->dersadlari, $c['dersadi']);
                          }
                          $_SESSION['dersler']=$this->dersler;
                          $_SESSION['dersadlari']=$this->dersadlari;
                      }
                      else
                      {
                          $this->dersler=null;
                      }

                      $arkids = array("arks");
                      $arkads = array("arks");
                      $arkfots = array("arks");

                      $cev = $this->sorgula("select * from arkadasliklar where aktifmi = 1 and tedenid = " . $_SESSION['id'] . " or aktifmi = 1 and tedilenid = " . $_SESSION['id']);
                      if ($cev != null)
                      {
                          foreach ($cev as $c)
                          {
                              if ($c['tedenid'] == $_SESSION['id'])
                              {
                                  array_push($arkids, $c['tedilenid']);
                                  $adrkadi = $this->vt->prepare("select user,foto from ogrenciuye where uyeid = ?");
                                  $adrkadi->execute(array($c['tedilenid']));
                                  $adrkadi=$adrkadi->fetch();
                                  array_push($arkads,$adrkadi['user']);
                                  array_push($arkfots,$adrkadi['foto']);
                              }
                              elseif ($c['tedilenid'] == $_SESSION['id'])
                              {
                                  array_push($arkids, $c['tedenid']);
                                  $adrkadi = $this->vt->prepare("select user,foto from ogrenciuye where uyeid = ?");
                                  $adrkadi->execute(array($c['tedenid']));
                                  $adrkadi=$adrkadi->fetch();
                                  array_push($arkads,$adrkadi['user']);
                                  array_push($arkfots,$adrkadi['foto']);
                              }
                          }

                          $_SESSION['arkids']=$arkids;
                          $_SESSION['arkads']=$arkads;
                          $_SESSION['arkfots']=$arkfots;
                      }

                      header("location:../systemVISUAL/ogretmen_paneli.php");

                  }

               }

               else
               {
                  header("location:ans.html");
               }



           }
           else
           {
            	header("location:ans.html");
           }


        }
        catch (Exception $e)
        {
            header("location:tset.html");
        }
    }


     function sorgula ($sorgu)
     {
       if ($deger=$this->vt->query($sorgu))
       {
         $donecek = $deger->fetchAll();
         return $donecek;
       }
       else { return null; }

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
         { return null; }
     }

}


session_start();
  echo "an";
  //postta veri var ise yapılacaklar
if ($_POST)
{
    $ad=$_POST['kullaniciadi'];
    $sif=$_POST['sifre'];
    echo "an";
    //oyurum sınıfından bitane türetildi va bu sınıf komtrulleri ve yönlendirmeleri yapacak
    $baslat= new oturum($ad,$sif);
}
