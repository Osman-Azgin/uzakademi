<?php
/** Yazan: Osman Azgin */

class her_sayfada_olan {

    public $vtb;
    public $mesajlar="";
    public $mesajsayisi;
    public $en_buyuk_meaj_id;
    public $bildirimler;
    public $bildirim_sayisi;
    public $en_buyuk_bildirim_id;

    function her_sayfada_olan ()
    {
        $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
    }

    function mesaj_getir ()
    {
        if($deger = $this->sorgula("select * from mesaj where malici = '" . $_SESSION['id'] . "' and mdurum = 0"))
		{

		 if($deger==null)
		{
          $this->mesajlar = $this->mesajlar . "Mesajınız yok";
		}
		else
		{
		  foreach ($deger as $d)
		  {
            $this->mesajlar = $this->mesajlar . "<li><img src='" . $d['mfoto'] . "' style='border-radius:200px;box-shadow:black 0px 0px 1px;' width='40' height='40'><h4 style='margin-top:-34px;margin-left:53px;'>" . $d['mgonderen'] . "</h4><p style=margin-top:24px;>" . $d['micerik'] . "</p></li>";
		  }
		}

		}
		else
		{
          $this->mesajlar = $this->mesajlar . "Mesajınız yok";
		}
    }



    function kontrol ()
    {
        $mk=$this->vtb->query("select count(*) from mesaj where  malici = " . $_SESSION['id'])->fetchColumn();

            if ($mk > $_POST['ms'] ){ echo "1"; }
            else { echo "0"; }
        $bk=$this->vtb->query("select count(*) from bildirimler where uyeid = " . $_SESSION['id'])->fetchColumn();
        if ($bk > $_POST['bs']){ echo "1"; }
        else {echo "0";}

    }


    function mesaj_guncelle ()
    {
        $yenimesaj=$this->sorgula("select * from mesaj where mesajid > " . $_POST['ebmid'] . " and malici = " . $_SESSION['id']);
        if ($yenimesaj != null){
            foreach ($yenimesaj as $y)
            {
                echo "<div><img src='" . $y['mfoto'] . "'/><p>" . $y['mgonderen'] . "</p><p>" . $y['micerik'];
            }
        }
    }


   function idal ()
   {
       $id = $this->vtb->query("select max(*) from mesaj where mesajid > " . $_POST['ebmid'] . " and malici = " . $_SESSION['id'])->fetchColumn();

           echo $id['mesajid'];

   }




    function sayial ()
    {
        $sayi = $this->vtb->query("select count(*) from mesaj where  malici =" . $_SESSION['id'])->fetchColumn();

        echo $sayi;
    }






    function bildirim_getir ()
    {
         $deger = $this->sorgula("select * from bildirimler where uyeid = " . $_SESSION['id']);
        if ($deger != null)
        {
            $this->bildirimler = $deger;
        }
         $bilsay = $this->vtb->query("select count(*) from bildirimler where uyeid = " . $_SESSION['id'])->fetchColumn();
        if ($bilsay != null)
        {
            $this->bildirim_sayisi = $bilsay;
        }
        $en_b_b_id = $this->vtb->query("select max(*) from bildirimler where uyeid = " . $_SESSION['id']);
        if ($en_b_b_id != null)
        {
            $this->en_buyuk_bildirim_id = $en_b_b_id['bildirimid'];
        }
    }







    function bilditrim_guncelle ()
    {
        $deger = $this->sorgula("select * from bildirimler where uyeid =" .$_SESSION['id'] . " and bildirimid > " . $this->en_buyuk_bildirim_id);
        if ($deger != null)
        {
            echo "function () {";
            foreach ($deger as $m)
            {
                echo "bildirimbasliklari.push('" . $m['bbaslik'] . "');";
                echo "bildirimicerkleri.push('" . $m['bildirimicerik'] . "');";
                echo " bildirimtarihleri.push('" . $m['btarih'] . "');";
                echo "bildirimsayisi ++;";
            }
            echo  "bildirimvarmi = 1;";

            echo "}";
        }
    }





    function sorgula ($sorgu)
    {
        if ( $sorgula=$this->vtb->query($sorgu) )
        {
            $donecek = $sorgula->fetchAll();
            return $donecek;
        }
        else { return null; }

    }


} 