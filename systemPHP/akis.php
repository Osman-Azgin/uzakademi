<?php



class akis
{
    private $vtb;
	public $siniflar;
    public $sinifsorgu;

    function akis ()
    {
        $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');

        //if($sinifal = $this->vtb->query("select * from sinif_secimleri where uyeid = " . $_SESSION['id']))
       // {
         //   $siniflari = $sinifal->fetchAll();
         //   $this->siniflar = array(" ");
         //   foreach ($siniflari as $s)
          //  {
            //    array_push($this->siniflar,$s['sinifid']);


           // }

            $syc=count($_SESSION['arkids']) -1; for ($i = 1;$i <= $syc; $i++) { if ($i == 1) { $this->sinifsorgu = "uyeid = " . $_SESSION['arkids'][$i]; } else { $this->sinifsorgu = $this->sinifsorgu .  " or uyeid = " . $_SESSION['arkids'][$i]; }  }


    }

	function akisiyazdir()
	{


      if (count($_SESSION['arkids']) >  1)
      {
       if($akis = $this->vtb->query("select * from akislar where " . $this->sinifsorgu . " or uyeid = " . $_SESSION['id'] . " order by akisid desc limit 0,30"))
       {
        $akislar = $akis->fetchAll();


        foreach ($akislar as $a)
        {
           echo "<div class='isbox'><div class='isboxust'><div class='panel_profil_resmi' style=background-image:url('" . $a['foto'] . "')" . "></div>"."<p class='panel_kisi_adi' style='color:#048CAD;margin-top:1px;' >" . $a['user'] . "</p></div>" . "<div class='icerik'>" . $a['aicerik']  . "</div></div>" ;
        }


       }

      }
       else
       {
	      if($akis = $this->vtb->query("select * from akislar where  uyeid = " . $_SESSION['id'] . " order by akisid desc limit 0,30"))
       {
        $akislar = $akis->fetchAll();


        foreach ($akislar as $a)
        {
           echo "<div class='isbox'><div class='isboxust'><div class='panel_profil_resmi' style=background-image:url('" . $a['foto'] . "')" . "></div>"."<p class='panel_kisi_adi' style='color:#048CAD;margin-top:1px;' >" . $a['user'] . "</p></div>" . "<div class='icerik'>" . $a['aicerik']  . "</div></div>" ;
        }


       }
	   }
	}


    function akisiguncelle ()
    {


       $sorgu = $this->vtb->query("select * from akislar where " .$this->sinifsorgu . " or uyeid = " . $_SESSION['id'] );
       $yeniakislar = $sorgu->fetchAll();

        foreach ($yeniakislar as $a)
        {
            if ($a['akisid'] > $_POST['ebakid'] ){
            echo "<div class='isbox'><div class='panel_profil_resmi' style=background-image:url('" . $a['foto'] . "')" . "></div>"."<p class='panel_kisi_adi' style='color:black;'>" . $a['user'] . "</p>" . "<div class='icerik'>" . $a['aicerik']  . "</div></div>" ;
            }
        }

    }
    function idbul ()
    {

        if (
        $aid = $this->vtb->query("select max(akisid) from akislar where " . $this->sinifsorgu )
        )
        {
            $ebaid = $aid->fetchColumn();
            echo $ebaid;
        }
    }

    function sayibul ()
    {

       if(
        $as = $this->vtb->query("select count(*) from akislar where " . $this->sinifsorgu )
        )
        {
            $akissayisi = $as->fetchColumn();
            echo $akissayisi;
        }
    }

    function ekle ()
    {
        if ($this->vtb != null){
            $x=$this->vtb->exec("INSERT INTO `akislar`( `uyeid`, `user`, `foto`, `aicerik`, `atarihi`, `sinifid`) VALUES (" . $_SESSION['id'] .",'" . $_SESSION['Kullanici'] . "','" . $_SESSION['resim'] ."','" . $_POST['icerik'] ."','00-22-00',0)");
            echo "1";
        }
    }

    function sorgubul ($secilecektablo,$sinanacakalan,$operator,$liste,$limit,$baglac)
    {

        if (count($liste) > 0){
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

    function limitsizsorgubul ($secilecektablo,$sinanacakalan,$operator,$liste,$baglac)
    {

        if (count($liste) > 1){
            $sorgu = $secilecektablo . " where " . $sinanacakalan ." ". $operator ." ". $liste[1];
            $deger = count($liste) - 1;
            for ($i=2; $i <= $deger ; $i++) {
                $sorgu = $sorgu . " " . $baglac . " " . $sinanacakalan. " " . $operator . " " . $liste[$i];
            }
            return $sorgu;
        }
        else
        { return null; }
    }

}
session_start();

$komut = $_POST['komut'];


if ($komut == "ay")
{
    $aks = new akis();
    $aks->akisiyazdir();
}

if ($komut == "ebaid")
{
    $aks = new akis();
    $aks->idbul();
}

if ($komut == "asbul")
{
    $aks = new akis();
    $aks->sayibul();
}

if ($komut == "ag")
{
    $aks = new akis();
    $aks->akisiguncelle();
}

if ($komut=="ae")
{
    $aks = new akis();
    $aks->ekle();
}

?>
