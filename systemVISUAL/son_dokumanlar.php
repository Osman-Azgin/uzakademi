<?php
class sondokuman
{
    private $vtb;

    function sondokuman ()
    {
        $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
    }

    function sondokumangetir ()
    {
        if($sd = $this->vtb->query("select * from dosyalar where dsahipid = " .$_SESSION['id'] . " and aktifmi = 1 order by did desc limit 0,30"))
        {$somdok = $sd->fetchAll();

        foreach ($somdok as $s)
        {
            echo "<div class='panel_akis_kutusu' ><p> " . $s['dadi'] . "</p><p>" . $s['dgrup'] . "</p><a href='" . $s['dosya'] . "'>".$s['dosya']."</a></div>";
        }
        }
        else {echo "null";}
    }

    
}

session_start();

$komut = $_POST['komut'];

if ($komut == 'sdg')
{
$snd = new sondokuman();
$snd->sondokumangetir();
}

?>