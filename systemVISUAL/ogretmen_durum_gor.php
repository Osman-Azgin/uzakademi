<?php 
class ilerleme
{
	public $vtb;

	function ilerleme ()
	{
	   try
       {
		 $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');
	   }
	   catch (PDOException $e)
	   {
			$this->vtb=null;
	   }
	}
    
    function ogretmen_ileleme_getir ()
    {
    	if ($secimler=$this->vtb->query('select * from seviye_secimleri where dersid = ' . $_POST['dersid']))
    	{
            $secimler=$secimler->fetchAll();

            foreach ($secimler as $sec) 
            {
            	$seviye=$this->vtb->query('select * from ders_seviyeler where seviyeid = ' . $sec['seviyeid']);
            	$ogrenci=$this->vtb->query('select * from ogrenciuye where uyeid = ' . $sec['uyeid']);
            	$doksay=$this->vtb->query('select count(*) from ders_dokuman_paylasimlari where seviye = ' . $sec['seviyeid']);
            	$gormeler=$this->vtb->query('select count(*) from dokuman_gormeleri where uyeid = ' . $sec['uyeid'] . ' and seviyeid = ' . $sec['seviyeid']);
            	$seviye=$seviye->fetch();
            	$ogrenci=$ogrenci->fetch();
            	$doksay=$doksay->fetchColumn();
            	$gormeler=$gormeler->fetchColumn();
            	echo "<div class='panel_akis_kutusu'><img src='" . $ogrenci['foto'] . "' width='100' height='100' /><p>" . $ogrenci['uyeadi'] . "</p><br /><p>" . $seviye['seviyeno'] . ". seviyede " . $doksay . " dökümandan " . $gormeler . " döküman inceledi.";
            }
    	}	
    }

}

?>