<?php

class dosya
{

    private $vtb;
    public $ad;
    public $tip;
    public $boyut;
    public $dosya;
    private $num = "";
    private $adres;


    function dosya ()
    {
        $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
    }

    function dosya_kaydet ($yer)
    {
        if ($this->vtb != null)
        {
            try
            {
                if ($yer == 'o')
                {
                    $x=$this->vtb->query('select count(*) from seviye_odev_teslimleri where uyeid = ' . $_SESSION['id'] . ' and odevid = ' . $_POST['odevid']);
                    $j=$x->fetchColumn();
                    if ($j > 0)
                    {
                        if ($x=$this->vtb->query('select ysay,oid,adres from seviye_odev_teslimleri where uyeid = ' . $_SESSION['id'] . ' and odevid = ' . $_POST['odevid']))
                          {
                            $y = $x->fetch();
							unlink( $y['adres']);
                            $y['ysay']++;
                            if($this->vtb->exec("UPDATE `neduzaka_uzakakademi17`.`seviye_odev_teslimleri` SET `adres` = 'http://www.uzakademi.org/usersHOME/homeworkFILES/" . $_SESSION['Kullanici'] . $this->ad . "', `puan` = 0, `okundumu` = 0, `ysay` = " . $y['ysay'] . ", `dosad`='" . $this->ad . "'  WHERE `seviye_odev_teslimleri`.`oid` = " . $y['oid'] .";"))
							{
                                return "basarili";
							}
                          }
                    }
                    else
                    {
                       $n = $this->vtb->exec("INSERT INTO `seviye_odev_teslimleri`( `dersid`, `uyeid`, `okundumu`, `odevid`,`seviyeid`,`adres`,`puan`,`dosad`) VALUES (" . $_POST['dersid'] ."," . $_SESSION['id'] ." ,0," . $_POST['odevid'] . "," . $_POST['seviyeid'] . ",'" . "http://www.uzakademi.org/usersHOME/homeworkFILES/" . $_SESSION['Kullanici'] . $this->ad ."',0,'" . $this->ad . "')");
                        return "basarili";
                    }
                }
                else
                {
                    if($this->vtb->exec("INSERT INTO `dosyalar`( `dsahipid`, `dadi`, `dosya`, `dboyut`, `dtip`, `konuid`) VALUES (" . $_SESSION['id'] .",'" . $_FILES['dosya']['name'] . "','http://www.uzakademi.org/usersHOME/elementaryFILES/" . $this->adres . "'," . $this->boyut . ",'" . $this->tip . "'," . $_POST['konu'] . ")"))
                    {
                      return "basarili";
                    }
                }

            }

            catch (PDOException $e)
            {
                return "hata";
            }
        }
    }


 function dosya_yuke ($sebep){
if(isset($_FILES['dosya']))
{
    $hata=$_FILES['dosya']['error'];
      if($hata != 0)
      {
          return "yüklemede hata";
      }
      else
      {
          $this->boyut=$_FILES['dosya']['size'];
          if($this->boyut > (1024*1024*1024))
          {
              return "Dosya çok büyük";
          }
          else
          {
              $this->tip=$_FILES['dosya']['type'];
              $this->ad=$_FILES['dosya']['name'];
              //$uzanti = explode('.',$this->ad);
              //$uzanti=$uzanti[count($uzanti)-1];
              if($this->tip=='run' || $this->tip=='exe')
              {
                 return "Bu dosya yüklenemez";
              }
              else
              {
                  if ($sebep == 'o')
                  {
                      $this->dosya=$_FILES['dosya']['tmp_name'];
                      copy($this->dosya,'usersHOME/homeworkFILES/'. $_SESSION['Kullanici'] .$this->ad);
                      return "basarili";
                  }
                  else
                  {
                      $dossay = $this->vtb->query('select count(*) from dosyalar where dadi = "' . $this->ad . '"');
                      $dossay = $dossay->fetchColumn();
                        $this->dosya=$_FILES['dosya']['tmp_name'];
                        copy($this->dosya,'usersHOME/elementaryFILES/'. $_SESSION['Kullanici'] . $dossay .$this->ad);
                        $this->adres=$_SESSION['Kullanici'] . $dossay .$this->ad;
                        return "basarili";
                  }


              }
          }

      }
}
 }
}

session_start();


$dsy=new dosya();

if ($_POST['komut'] == 'odev')
{
    $ykm = $dsy->dosya_yuke('o');

    if ($ykm == "basarili")
    {
        $kbm =  $dsy->dosya_kaydet('o');
        if ($kbm == "basarili")
        {
            echo "yüklendi";
        }
        else
        {
            echo "basarisiz";
        }
    }
    else
    {
        echo "basarisiz";
    }
}




else
{
    $ykm = $dsy->dosya_yuke('n');
 if ($ykm == "basarili")
 {
    $kbm =  $dsy->dosya_kaydet('d');
     if ($kbm == "basarili")
     {
         echo "1";
     }
     else
     {
         echo "basarısız";
     }
 }
else
{
    echo "basarısız";
}
}

?>

