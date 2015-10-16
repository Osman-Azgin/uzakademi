<?php


class ogrencisoru
{
	public $vtb;

	function __construct()
	{
		try {
       $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');

		} catch (Exception $e) {
			$this->vtb=null;
		}
	}

	function ogretmen_soru_getir ()
	{
		$dliste=array($_SESSION['id']);

		if (isset($_POST['seviye'])) {
			$seviye=$_POST['seviye'];
			$sv=" and seviye = ?";
			array_push($dliste,$_POST['seviye']);
		}
		else {
			$sv="";
		}
    $sorsay=$this->vtb->prepare("select count(*) from ogrenci_sorulari where ogretmenid = ? and cevaplandidi = 0 " . $sv);
    $sorsay->execute($dliste);
    $sorsay=$sorsay->fetchColumn();
		$sorular=$this->vtb->prepare('select * from ogrenci_sorulari where ogretmenid = ? ' . $sv . ' and cevaplandidi = 0 limit ' . $_POST['limit']);
		$sorular->execute($dliste);
    $sorular = $sorular->fetchAll();
		$arry=array('isim' => 'dada');
    foreach ($sorular as $sor)
    {
	    $ogr=$this->vtb->prepare("select * from ogrenciuye where uyeid = ?");
	    $ogr->execute(array($sor['uyeid']));
    	$ogr=$ogr->fetch();
	    $sor['user']=$ogr['user'];
	    $sor['res']=$ogr['foto'];
      array_push($arry, $sor);
		}
		unset($arry['isim']);
		echo json_encode($arry);

	}

	function ogrenci_cevap_getir ()
	{
		$dliste=array($_SESSION['id']);

		if (isset($_POST['seviye'])) {
			$seviye=$_POST['seviye'];
			$sv=" and seviye = ?";
			array_push($dliste,$_POST['seviye']);
		}
		else {
			$sv="";
		}

		if (isset($_POST['cevap'])) {
			$cevap=$_POST['cevap'];
			$cv = " and cevaplandidi = ?";
			array_push($dliste,$cevap);
		}
		else {
			$cv="";
		}

		$cevaplar=$this->vtb->prepare('select * from ogrenci_sorulari where uyeid = ? ' . $sv . ' ' . $cv . ' order by osoruid desc limit 0,30');
		$cevaplar->execute($dliste);
		$cevaplar=$cevaplar->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($cevaplar);
	}

	function ogretmen_soru_cevapla ()
	{
        if($cevap = $this->vtb->exec("UPDATE `ogrenci_sorulari` SET `cevap`='" . $_POST['cevap'] . "', `cevaplandidi` = 1 WHERE `ogrenci_sorulari`.`osoruid`=" . $_POST['osid']))
        {
        	echo "1";
        }
	}

	function ogrenciSoruSor ()
	{
        $sorusor=$this->vtb->prepare("INSERT INTO `ogrenci_sorulari`(`osoruicerik`, `ogretmenid`, `uyeid`, `seviye`) VALUES (?,?,?,?)");
        $sorusor->execute(array($_POST['soru'],$_POST['ogrtid'],$_SESSION['id'],$_POST['sid']));
	}

	function ogrenciSoruGetir ()
	{
		$sorular=$this->vtb->prepare("select * from ogrenci_sorulari where uyeid = ? order by osoruid");
		$sorular->execute(array($_SESSION['id']));
		$sorular=$sorular->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($sorular);
	}
}

session_start();

if ($_POST['komut'] == 'orsg')
{
	$soru= new ogrencisoru();
	$soru->ogretmen_soru_getir();
}

if ($_POST['komut'] == 'sc')
{
	$soru= new ogrencisoru();
	$soru->ogretmen_soru_cevapla ();
}

if ($_POST['komut'] == 'ocg')
{
	$soru= new ogrencisoru();
	$soru->ogrenci_cevap_getir();
}

if ($_POST['komut']=="ogrncsg")
{
	$soru = new ogrencisoru();
	$soru->ogrenciSoruGetir();
}

if ($_POST['komut'] == "oss")
{
	$soru = new ogrencisoru();
	$soru->ogrenciSoruSor();
}

?>
