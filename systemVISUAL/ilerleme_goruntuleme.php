<?php
session_start();
?>

<html>
<head>
<meta charset="UTF-8">
    <title>İlerlemeler-UzakaAkademi</title>
	<link rel="stylesheet" href="theme/panel.css">
    <link rel="stylesheet" href="styles.css">
    <script src="../systemJS/jquery-1.11.1.min.js"></script>
    <script src="../systemJS/jquery.pKisalt.js"></script>
    <script type="text/javascript">
       $(document).ready(
    function(){
        $('#login').hide();
       $('#toggle-login').click(function(){
  $('#login').toggle();
});
    });
                $(document).ready(function(){
            $('.menu-container').hover(
                function(){
                    $('.profile-actions').slideDown('fast');
                  $('.list-icon').addClass('active');
                },
                function(){
                    $('.profile-actions').slideUp('fast');
                  $('.list-icon').removeClass('active');
                }
            );
            
        });

        

    </script>
	<script language="javascript" type="text/javascript">
	    
		function analiz (did,tid)
		{
             var dat =  document.getElementById('kutu' + tid).innerHTML;
			 document.getElementById('progress').innerHTML='<h1 id="progressbas" style="margin-top:250px;text-align:center;" class="baslik">Yükleniyor..</h1>';
			 $.ajax({
                type: 'POST',
                url: 'ilerlemeler.php',
                data: {
                    komut: 'gg',
                    dersid:did
                },
                success: function (data) {
                    document.getElementById('progress').innerHTML = data;
                }
            });
		}
	</script>
</head>
<body>
	 <div class="topbar">
       <form action="arama_sonuclari.php" method="get">
  <input type="search" name="aranacak" placeholder="Arama">
</form>
        <img src="images/yenilogo.png" alt="" class="logo">
         <div class="dropdown-title" id="toggle-login" >
                <div class="box" >
                    
                <img class="panel_profil_resmi" src="<?php echo $_SESSION['resim']; ?>" />
                    <p class="panel_kisi_adi"><?php echo $_SESSION['isim']; ?>
                    </p><div class="arrow"></div>
                </div>
               
            </div>
           
    </div>
     <div id="login">
  <div id="triangle"></div>
  <ul id="drop-down">
  <li>Ayarlar</li>
  <li>Kullanım Koşulları</li>
  <li><a style="color:black;text-decoration:none;" href="index.php">Çıkış Yap</a></li>
  </ul>
</div>
	
	<div class="newLauncher" style="width:10%;" id="derkut">
      <?php  
		$sayac=1;
        for ($i=1;$i <= count($_SESSION['dersler']);$i++)
		{
             echo "<div class='newLauncherLink' style='font-family: sans-serif;' id='kutu" . $sayac . "' onclick='javascript: analiz(" . $_SESSION['dersler'][$i] . "," . $sayac . ");'>" . $_SESSION['dersadlari'][$i] . "</div>";
			$sayac ++;
		}
		?>
	</div> 

  <div id="progress" style="width:90%;left:10%;position:absolute;margin-top:50px;">
    <h1 id="progressbas" style="margin-top:250px;text-align:center;" class="baslik">Yan Taraftan Seçtiğiniz Ders İle İlgili Analizler Burada Görünecek </h1>
  </div>

</body>
</html>