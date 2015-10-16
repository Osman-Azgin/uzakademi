<?php


class uyelik {
	
 public	$vtb;
	
	function __construct() 
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
	
	function uyeol ()
	{
		
		if ($x=$this->vtb->query('select * from ogrenciuye where user = ' . $_POST['user']))
		{
			header("location:index.php");
		}
		else 
		{
			if(isset($_FILES['foto']))
            {
               $hata=$_FILES['foto']['error'];
               if($hata != 0)
               {
                   echo $hata;
               }
               else
               {
                   $this->boyut=$_FILES['foto']['size'];
                   if($this->boyut > (1024*1024*1024))
               {
                   
               }
               else
               {
                   $this->tip=$_FILES['foto']['type'];
                   $this->ad=$_FILES['foto']['name'];
                   $uzanti = explode('.',$this->ad);
                   $uzanti=$uzanti[count($uzanti)-1];
                   
                   
                    $this->dosya=$_FILES['foto']['tmp_name'];
                    copy($this->dosya,'resimler/'.$_POST['user'] . $uzanti);
                    //move_uploaded_file($this->dosya,'dosyalar/'.$this->ad);
                        
                  
            }

          }
      }
			
			if($n = $this->vtb->exec('INSERT INTO `ogrenciuye`(`uyeadi`,  `uyesoyadi`,`user`,`foto`,`pass`,`yetki`) VALUES("' . $_POST['uyeadi'] . '","' . $_POST['uyesoyadi'] . '","' . $_POST['user'] . '","resimler/' . $_POST['user'] . $uzanti . '","' . $_POST['pass'] . '",0)'))
			{
				echo "lütfen ayasayfadan giriş yapın.";
			}
			if($_POST['yetki']=='1')
			{
				if($kisi=$this->vtb->query('select user from ogrenciuye where user = "' . $_POST['user'] . '"'))
				{
                    $kisi=$kisi->fetchColumn();
					$k=$this->vtb->query('INSERT INTO `ogretmenlik_istekleri`(`uyeid`) VALUES(' . $kisi . ')' );
					echo "<br />Öğretmenlik isteğiniz değerlendiriliyor.";
				}
			}
		}
	
}
}


if ($_POST['komut'] == "uo")
{
	$u=new uyelik();
	$u->uyeol();
}

?>
<html>
	<head>
			<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	</head>
</html>