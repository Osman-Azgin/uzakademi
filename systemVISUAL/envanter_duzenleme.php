<?php
session_start();


//include("http://localhost/uzakademi.org/systemPHP/her_sayfada_olan.php");

//$hso = new her_sayfada_olan();
//$hso->mesaj_getir();
//$hso->bildirim_getir();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Envanteriniz Uzak Akademi </title>
        <link rel="stylesheet" href="../systemTHEME/panel.css">
        <link rel="stylesheet" href="../styles.css">
    <script src="../systemJS/jquery-1.11.1.min.js"></script>
    <script src="../systemJS//jquery.pKisalt.js"></script>
    <script src="../systemAPPS/ckeditor/ckeditor.js"></script>
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
       
        $(document).ready(function(){
            $('#drpdwn').hide();
            $('#drpdwn2').hide();
			$('#drpdwn3').hide();
       $('#bildirim').click(function(){
  $('#drpdwn2').toggle();
  $('#drpdwn').hide();
		   $('#drpdwn3').hide();
              });
      $('#mesaj').click(function(){
  $('#drpdwn').toggle();
  $('#drpdwn2').hide();   
		  $('#drpdwn3').hide();
        });
			$('#istek').click(function(){
  $('#drpdwn').hide();
  $('#drpdwn2').hide();
			$('#drpdwn3').toggle();

        });
       });


    
    </script>
    <script language="javascript" type="text/javascript">

    var envbil;

    window.onload=envanterBilgileri;
        
       function envanterBilgileri ()
       {
           $('#dblg').css('display' , 'block');
           $.ajax({
               type : 'POST',
               url : '../systemPHP/envanter.php',
               data : { komut : 'eb' },
               success : function (data)
               {
                       envbil = $.parseJSON(data);
                       document.getElementById('dad').innerHTML += envbil['dossay'];
                       document.getElementById('sevsay').innerHTML += envbil['sorsay'];
                       document.getElementById('sgd').innerHTML += envbil['unsay'];
                       document.getElementById('ks').innerHTML += envbil['konsay'];
               }
           });
       }

        function dokumanlar ()
       {
           $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'block');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#doks').css('background' , "white");
           $('#sorutas').css('display' , 'none');
           $('#untas').css('display' , 'none');
           //$('#odevtas').css('display' , 'none');
           //$('#ogrtas').css('display' , 'none');
           //$('#ogrsorutas').css('display' , 'none');
           uniteGetir(1);
           tumKonulariGetir ('derkon');
       }

       function sorular () {
       	 $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'none');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#sinavs').css('background' , "white");
           $('#sorutas').css('display' , 'block');
           $('#untas').css('display' , 'none');
           //$('#odevtas').css('display' , 'none');
           //$('#ogrtas').css('display' , 'none');
           //$('#ogrsorutas').css('display' , 'none');
           uniteGetir(2);
           tumKonulariGetir ('skonu');
       }


       function uniteler ()
       {
           $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'none');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#sinavs').css('background' , "white");
           $('#sorutas').css('display' , 'none');
           $('#untas').css('display' , 'block');
           unite_getir();
       }
    

    </script>
    <script language="javascript" type="text/javascript">

        function uniteGetir (sd)
        {
            var yer;
            if(sd==1)
            {
                yer = "d";
            }
            else
            {
                yer ="s"
            }
            $.ajax({
                type : 'POST',
                url : "../systemPHP/envanter.php",
                data : { komut: 'ug' },
                success : function (data)
                {
                    if(data!="unite yok")
                    {
                        var uniteler = $.parseJSON(data);
                        var yazilacak = "";
                        for(var i =0;i<=uniteler.length-1;i++)
                        {
                            yazilacak += "<div id='dun" + i + "' style='width:100%;text-align:center;padding: 10px 0px 10px 0px;box-shadow:black 0px 0px 1px;' onclick='konuGetir(" + uniteler[i]['uid'] + "," + i + "," + sd + ")'>" + uniteler[i]['uadi'] + "</div>";
                        }
                        document.getElementById( yer + 'uniteler').innerHTML=yazilacak;
                    }
                }
            });
        }

        function konuGetir (uid,tid,sd)
        {
            var yer;
            var istenen;
            if(sd==1)
            {
                yer = "d";
                istenen = "dokuman"
            }
            else
            {
                yer ="s"
                istenen = "soru"
            }
            $.ajax({
                type : 'POST',
                url : "../systemPHP/envanter.php",
                data : { komut: 'kg', uniteid : uid },
                success : function (data)
                {
                    if(data!="konu yok")
                    {
                        $("#dun" + tid).css("background" , "#4B77BE");
                        $("#dun" + tid).css("color" , "white")
                        var uniteler = $.parseJSON(data);
                        var yazilacak = "";
                        for(var i =0;i<=uniteler.length-1;i++)
                        {
                            yazilacak += "<div id='dkon" + i + "' style='width:100%;text-align:center;padding: 10px 0px 10px 0px;box-shadow:black 0px 0px 1px;' onclick='" + istenen + "Getir(" + uniteler[i]['konuid'] + "," + i + "," + sd + ")'>" + uniteler[i]['konuadi'] + "</div>";
                        }
                        document.getElementById( yer + 'konular').innerHTML=yazilacak;
                    }
                }
            });
        }

        function dokumanGetir (kid,tid)
        {
            $.ajax({
                type : 'POST',
                url : "../systemPHP/envanter.php",
                data : { komut: 'dg', konuid : kid },
                success : function (data)
                {
                    if(data!="dokuman yok")
                    {
                        $("#dkon" + tid).css("background" , "#4B77BE");
                        $("#dsunitelerkon" + tid).css("color" , "white");
                        var uniteler = $.parseJSON(data);
                        var yazilacak = "";
                        for(i =0;i<=uniteler.length-1;i++)
                        {
                            yazilacak += "<div id='dok" + i + "' style='width:100%;padding: 20px 0px 20px 0px;box-shadow:black 0px 0px 1px;'> <img src='http://localhost/uzakademi.org/Graphics/svg/koleksiyon.fw.png' width='50' height='50' style='float: left;margin-top: -12px;' /> <p id='dis" + i +"' style='margin-left:20px;float:left;'>" + uniteler[i]['dadi'].substring(0,20) + "</p> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href=javascript:wiewFile('" + uniteler[i]['dosya'] + "') >Göster</a>   <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href='javascript:envanterdenDokumanSil(" + uniteler[i]['did'] + "," + i + ");'> Sil </a> </div>";
                        }
                        document.getElementById('dicerik').innerHTML=yazilacak;
                    }
                }
            });
        }


        function soruGetir (kid,tid)
        {
            $.ajax({
                type : 'POST',
                url : "../systemPHP/envanter.php",
                data : { komut: 'sg', konuid : kid },
                success : function (data)
                {
                    if(data!="soru yok")
                    {
                        $("#dkon" + tid).css("background" , "#4B77BE");
                        $("#dkon" + tid).css("color" , "white");
                        var uniteler = $.parseJSON(data);
                        var yazilacak = "";
                        for(var i =0;i<=uniteler.length-1;i++)
                        {
                            yazilacak += "<div id='sor" + i + "' style='width:100%;padding: 20px 0px 20px 0px;box-shadow:black 0px 0px 1px;'> <p id='sis" + i +"' style='margin-left:20px;'>" + uniteler[i]['sorumet'] + "</p>  <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href='javascript:soruEkle(" + uniteler[i]['soruid'] + "," + i + ");'> Ekle </a> </div>";
                        }
                        document.getElementById('sicerik').innerHTML=yazilacak;

                    }
                }
            });
        }


        function unite_getir() {
            $.ajax({
                type: 'post',
                url: '../systemPHP/envanter.php',
                data: {
                    komut: 'ug'
                },
                success: function (data) {
                    if(data!="unite yok")
                    {
                        var uniteler = $.parseJSON(data);
                        var yazilacak = "";
                        for(var i =0;i<=uniteler.length-1;i++)
                        {
                            yazilacak += "<option value='" + uniteler[i]['uid'] + "'>" + uniteler[i]['uadi'] + "</option>";
                        }
                        document.getElementById("unsel").innerHTML=yazilacak;
                    }
                }
            });
        }


        
        function envanterdenDokumanSil (kdid,tid)
        {
            var x= document.getElementById('dok' + tid).innerHTML;
            document.getElementById('dok' + tid).innerHTML = "<p style='margin-left:20px;float:left;'>Eminmisiniz?</p> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' id='dkal" + tid + "' >Sil</a> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' id='dkalma" + tid + "'> İptal </a>";
            $('#dkal' + tid).click(function () {
        	 $.ajax({
                type : 'POST',
                url : "../systemPHP/envanter.php",
                data : { komut: 'dk', did : kdid },
                success : function (data)
                {
                    document.getElementById('dok' + tid).remove();
                }
            });
        	});
        	$('#dkalma' + tid).click(function () {
              $('#dok' + tid).html(x);
        	});
        }

        function tumKonulariGetir (yer)
        {
        	$.ajax({
                type : 'POST',
                url : "../systemPHP/envanter.php",
                data : { komut: 'dykg' },
                success : function (data)
                {
                    var konus = $.parseJSON(data);
                    var yazilacak="";
                    for (var i = 0;i<=konus.length-1;i++) 
                    {
                       yazilacak += "<option value='" + konus[i]['konuid'] + "'>" + konus[i]['konuadi'] + "</option>";
                    }
                    $('#' + yer).html(yazilacak);
                }
            });
        }

        function envantereDosyaYukle ()
        {
            var formData = new FormData(document.getElementById('ekdata'));
            $.ajax({
                url: "../dosya_yukle.php",
            type: 'POST',
                data:  formData,
            mimeType:"multipart/form-data",
            contentType: false,
                cache: false,
                processData:false,
            success: function(data)
            {
                if (data.length == 2)
                {
                    alert("Yeni Dosyanız Eklendi");
                }
                else
                {
                    alert("Dosya Eklenemedi Daha Sonra Tekrar Deneyin!");
                }
            },
             error: function(jqXHR, textStatus, errorThrown) 
             {
             }          
            });     
        }


        function dokumanEkle (did,tid)
        {
            var ad =  document.getElementById("dis" + tid).innerHTML;
            document.getElementById('eklenendokuman').innerHTML += "<div id='ekldok" + tid + "' style='width:100%;padding: 20px 0px 20px 0px;box-shadow:black 0px 0px 1px;'> <img src='http://localhost/uzakademi.org/Graphics/svg/koleksiyon.fw.png' width='50' height='50' style='float: left;margin-top: -12px;' /> <p id='dis" + tid +"' style='margin-left:20px;float:left;'>" + ad + "</p> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href='javascript:dokumanKaldir(" + tid + ");'> Kaldır </a> <input type='hidden' name='dokuman" + did + "' value='on'/> </div>";
        }

        function soruEkle (sid,tid)
        {
            var ad =  document.getElementById("sis" + tid).innerHTML;
            document.getElementById('eklenensoru').innerHTML += "<div id='eklsor" + tid + "' style='width:100%;padding: 20px 0px 20px 0px;box-shadow:black 0px 0px 1px;'>  <p id='sis" + tid +"' style='margin-left:20px;float:left;'>" + ad + "</p> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href='javascript:soruKaldir(" + tid + ");'> Kaldır </a> <input type='hidden' name='soru" + sid + "' value='on'/> </div>";
        }

        function dokumanKaldir (tid)
        {
            document.getElementById('ekldok' + tid).remove();
        }

        function soruKaldir (tid)
        {
            document.getElementById('eklsor' + tid).remove();
        }

        function envantereKonuEkle ()
        {
            $.ajax({
                url: "../systemPHP/envanter.php",
                type: 'POST',
                data:  $('#konuekle').serializeArray(),
                success: function(data)
                {
                    if(data==1)
                    {
                        alert("Yeni Konunuz Eklendi");
                    }
                    if(data==0)
                    {
                        alert("Yeni Konunuz Eklenemedi Veri Girişinizi Kontrol Edin!");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert("Bir hata ile karşılaşıldı sonra tekrar deneyin.");
                }
            });
        }


        function envantereUniteEkle()
        {
            $.ajax({
                url: "../systemPHP/envanter.php",
                type: 'POST',
                data: {
                  komut : "ue",
                  uniteadi : $('#unad').val()
                },
                success: function(data)
                {
                    if(data==1)
                    {
                        alert("Yeni Üniteniz Eklendi");
                    }
                    if(data==0)
                    {
                        alert("Yeni Üniteniz Eklenemedi Veri Girişinizi Kontrol Edin!");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert("Bir hata ile karşılaşıldı sonra tekrar deneyin.");
                }
            });
        }


        function envantereSoruEkle ()
        {
            CKupdate();

            $.ajax({
                url: "../systemPHP/envanter.php",
                type: 'POST',
                data:  $('#sorek').serializeArray(),
                success: function(data)
                {
                    if (data = "1") {alert("Srunuz Eklendi.");}
                    else { alert("Soru Eklenemedi Veri Girişinizi Kontrol Edin.") }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert("Bir hata ile karşılaşıldı sonra tekrar deneyin.");
                }
            });
        }


        function CKupdate(){
            for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
        }

    </script>
    <script type="text/javascript" language="javascript">
      $(document).ready(function () {
      	$('#bil').click(function () {
      		$('#webden').css('display' , 'none');
      		$('#emped').css('display' , 'none');
      		$('#bilden').css('display' , 'block');
      		$('#bil').css('color' , '#048CAD');
      		$('#web').css('color' , '#e5e5e5');
      		$('#emp').css('color' , '#e5e5e5');
      	});
      	$('#web').click(function () {
            $('#webden').css('display' , 'block');
            $('#emped').css('display' , 'none');
      		$('#bilden').css('display' , 'none');
      		$('#bil').css('color' , '#e5e5e5');
      		$('#web').css('color' , '#048CAD');
      		$('#emp').css('color' , '#e5e5e5');
      	});
      	$('#emp').click(function () {
      		$('#webden').css('display' , 'none');
            $('#emped').css('display' , 'block');
      		$('#bilden').css('display' , 'none');
      		$('#bil').css('color' , '#e5e5e5');
      		$('#web').css('color' , '#e5e5e5');
      		$('#emp').css('color' , '#048CAD')
      	});
      });
    </script>
    
    <script type="text/javascript" language="javascript">
        
        function openDataWindow ()
        {
        	$('#beyaz').css('margin-top' , '0px');
        	$('#pencere').css('margin-top' , '100px');
        }

        function wiewFile (adres)
        {
        	var indeks = adres.lastIndexOf('.');
        	var uzanti = adres.substring(indeks,adres.length);
        	if(uzanti=='.jpg'||uzanti=='.png')
        	{
        	   openDataWindow();
        	   $('#icerik').html('<img style="width:100%;height:100%;background:white;border:0;" src="' + adres + '"  />');
            }
            if(uzanti=='.mp4'||uzanti=='.wmp')
        	{
        	   openDataWindow();
        	   $('#icerik').html('<img style="width:100%;height:100%;background:white;border:0;" src="' + adres + '"  />');
            }
            else
            {
            	openDataWindow();
        	   $('#icerik').html('<iframe style="width:100%;height:100%;background:white;border:0;" src="' + adres + '"  /></iframe>');
            }
        }

        function closeDataWindow ()
        {
        	$('#beyaz').css('margin-top' , '-100%');
        	$('#pencere').css('margin-top' , '-100%');
        }

    </script>
    
    <style type="text/css">
     div
     {
     	font-family: 'Exo' sans-serif;
     	cursor:default;
     }
     a
     {
     	font-family: 'Exo' sans-serif;
     }
    </style>
</head>
<body style="font-family:'Exo' sans-serif;">
   <div style="position:fixed;width:100%;height:100%;background:white;opacity:0.5;z-index:998;margin-top:-100%;" id="beyaz"></div>	
<div style="margin-top:-100%;position:fixed;width:50%;height:70%;margin-left:25%;background:white;border-radius:5px;box-shadow:black 0px 00px 1px;z-index:999;" id="pencere">
  <span style="background: #8B2828;width:50px;padding:5px 5px 5px 5px;color:white;border-bottom-left-radius:5px;border-bottom-right-radius:5px;text-align:center;float:right;margin-right:10px;" onclick="closeDataWindow();">x</span>
  <div style="width:100%;height:80%;margin-top:7%;background:black;" id="icerik"></div>
</div>
   <div class="wrapper">
    <div class="topbar">
       <form action="arama_sonuclari.php" method="get">
  <input type="search" name="aranacak" placeholder="Arama">
</form>
        <img src="../Graphics/images/yenilogo.png" alt="" class="logo">
        <a href="#" id="mesaj"> <img src="../Graphics/svg/mesaj.png" alt="" style="margin-left: 720px;
margin-top: 8px;" ></a>
       <div class="drpdwn" id="drpdwn" > 
  <ul id="drop-down">
  <?php
   echo $hso->mesajlar;
  ?>
</div>
       <a href="#" id="bildirim"> <img src="../Graphics/svg/bildirim.png" alt="" style="width:30px;margin-left: 30px"></a>
        <div class="drpdwn2" id="drpdwn2" > 
  <ul id="drop-down">
  <li>BILDIRIM1</li>
  <li>BILDIRIM2</li>
  <li>BILDIRIM3</li>
  <li>BILDIRIM4</li>
  </ul>
</div>
		<a href="#" id="istek"> <img src="../derslr.png" alt="" style="width:30px;margin-left: 30px"></a>
        <div class="drpdwn2" id="drpdwn3" > 
  <ul id="drop-down">
   <?php 
                          foreach ($_SESSION['istekler'] as $is) 
                          {
                            echo $is;
                          }
                          ?>
  </ul>
</div>
         <div class="dropdown-title" id="toggle-login" >
                <div class="box" >

                <img class="panel_profil_resmi" src="<?php echo $_SESSION['resim']; ?>" />
                    <p class="panel_kisi_adi"><?php echo $_SESSION['isim']; ?>
                    </p><div class="arrow"></div>
                </div>

            </div>
	   </div>
        <div id="login">
  <ul id="drop-down">
  <li>Ayarlar</li>
  <li>Kullanım Koşulları</li>
  <li><a style="color:black;text-decoration:none;" href="index.php">Çıkış Yap</a></li>
  </ul>
</div>
    <div class="newLauncher">
      <div  class="newLauncherLink">
       <img style="border-radius:100px;" src="<?php echo $_SESSION['resim']; ?>" />
       <p>Envanteriniz</p>
      </div>
        <div onclick="dokumanlar()" id="notlar" class="newLauncherLink">
         <img alt="Notlarınız" src="../Graphics/images/noteicon.png" />
         <p>Dökümanlar</p>
        </div> 

        <div onclick="sorular()" id="cevaplar" class="newLauncherLink">
         <img alt="Cevaplar" src="../Graphics/images/cevpicon.png" />
         <p>Sorular</p>
        </div>

        <div onclick="uniteler()" id="odevler" class="newLauncherLink">

        <img alt="Ödevlriniz" src="../Graphics/images/odevicon.png" />
         <p>Üniteler
        </div>  

</div>

<div style="width: 75%;margin-top: 58px;margin-left: 135px;margin-bottom:30px;" class="panel_akis_tasiyici" id="at">

      <div id="envanter">

         <div id="dblg" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
             <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                 <p id="ssec" onclick="" style=" margin-left: 10px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Envanter Bilgileri</p>
             </div>
             <h1 style="margin-top: 10px;" id="dad" class="baslik">Dosya Sayısı: </h1>
             <h1 style="margin-top: 10px;" id="sevsay" class="baslik">Soru Sayısı: </h1>
             <h1 style="margin-top: 10px;" id="sgd" class="baslik">Ünite Sayısı : </h1>
             <h1 style="margin-top: 10px;" id="ks" class="baslik">Konu Sayısı : </h1>
         </div>

     </div>

     <div id="dokumantas" style="display:none;">

        <div style="width: 90%;height: auto;margin-top:45px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
        	 <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                 <p id="ssec" onclick="" style=" margin-left: 10px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Envanterinizdeki Dökümanlar</p>
             </div>
            <div style="margin-top: 30px;width: 100%;left: 9%; height: 410px;" id="doktasiyici">
                <div id="unbtas" style="width: 20%;float:left;height: 300px;">
                    <div id="unbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                        Üniteler
                    </div>
                    <div id="duniteler" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

                    </div>
                </div>
                <div id="konbtas" style="width: 20%;float:left;height: 300px;">
                    <div id="konbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                        Konular
                    </div>
                    <div id="dkonular" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

                    </div>
                </div>
                <div id="doktas" style="width: 60%;float:left;height: 300px;">
                    <div id="dokbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                        Dökümanlar
                    </div>
                    <div id="dicerik" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

                    </div>
                </div>

            </div>



        </div>

        <div style="width: 90%; transition:all 0.2s ease; -ebkit-transition:all 0.2s ease; height: auto;margin-top:45px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <form id="ekdata">
                <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">

                    <p onclick="" style=" margin-left: 10px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Envanterinize Döküman Yükleyin</p>
                     <select style="float: left;margin-left: 33%;margin-top: -13px;background: white;border: none;box-shadow: none;color: rgb(82, 67, 67);" name="konu" id="derkon" class="konusec"></select>
                     <p id="bil" onclick="" style="margin-left:30px;float:left;color: #048CAD;font-family: 'Exo', sans-serif;">Dosya</p>
                     <p id="web" onclick="" style="margin-left:30px;float:left;color: #e5e5e5;font-family: 'Exo', sans-serif;">Web'den</p>
                     <p id="emp" onclick="" style="margin-left:30px;float:left;color: #e5e5e5;font-family: 'Exo', sans-serif;">Emped</p>
                </div>

                  <div id="bilden">
                    <input id="ekldosy" type="file" style="display:block;position: static;margin-top: 30px;margin-left: 37%;margin-bottom: 30px;width: inherit;" name="dosya" class="soruonay">
                  </div>
                  
                  <div style="display:none;" id="webden">
                    <input name="adres" id="adres" type="text" style=" width: 80%; padding: 10px 10px 10px 10px; margin-left: 8%; margin-top: 50px;margin-bottom:50px;display:block;" placeholder="Web'deki dosyanın adresini buraya yapıştırın...">
                  </div>
                  <div style="display:none;" id="emped">
                    <input name="kod" id="kod" type="text" style=" width: 80%; padding: 10px 10px 10px 10px; margin-left: 8%; margin-top: 50px;margin-bottom:50px;display:block;" placeholder="Emped kodunu buraya yapıştırın...">
                  </div>
                <div style="float:left;width: 100%;padding: 10px 0px 10px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
                   <input type="hidden" name="komut" value="dokuman">
                   <div id="dy" onclick="envantereDosyaYukle()" class="soruonay" style="position: static;margin-left: 37%;width: 100px;margin:0;padding:5px 5px 5px 5px;float: right;padding: 1px 1px 1px 1px;margin-right:10px;">Dosyayı Yükle</div>
                </div>
            </div>
          </form>
        </div>



    <div id="untas" style="display: none;">

        <div id="une" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                <p id="ssec" onclick="" style=" margin-left: 10px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Envanterinize Konu ve Ünite Ekleyin </p>
            </div>
            <input id="unad" style=" width: 80%; padding: 10px 10px 10px 10px; margin-left: 8%; margin-top: 50px;margin-bottom:50px;display:block;" type="text" placeholder="Yeni Ünitenizin Adı" > <input onclick="envantereUniteEkle()" style="position: absolute;margin-top: -89px;margin-left: 77%;background: white;border: solid 1px rgb(169, 169, 169);font-family: inherit;padding: 10px 16px 10px 16px;" type="button" value="Ekle">
            <div style="  border-bottom: 1px solid #e5e5e5;width: 81%;margin-left: 9%;"></div>
            <form method="post" id="konuekle">
              <select class="konusec" style="background: none;box-shadow: none;margin-top: 0px;position: absolute;margin-left: 7%;border: darkgrey 1px solid;border-radius: 0px;width: 9.3%;height: 39px;" name="unite" id="unsel"></select>
              <input type="hidden" name="komut" value="ke">
              <input name="konuadi" style=" width: 70%; padding: 10px 10px 10px 10px; margin-left: 18%; margin-top: 50px;margin-bottom:50px;display:block;" type="text" placeholder="Yeni Konunuzun Adı" > <input onclick="envantereKonuEkle()" style="position: absolute;margin-top: -89px;margin-left: 77%;background: white;border: solid 1px rgb(169, 169, 169);font-family: inherit;padding: 10px 16px 10px 16px;" type="button" value="Ekle">
            </form>
        </div>

    </div>



</div>


   <div style="display: none;" id="sorutas">

    <div id="sinkut" style="width: 66%;height: auto;margin-top:45px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 13%;position: absolute;margin-top: 130px;box-shadow:black 0px 0px 1px;">
        <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
            <p id="ssec" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Envanterinizdeki Sorular</p>
        </div>

        <div style="margin-top: 30px;width: 100%;left: 9%; height: 410px;" id="sintasiyici">
            <div id="unbtas" style="width: 20%;float:left;height: 300px;">
                <div id="unbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                    Üniteler
                </div>
                <div id="suniteler" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

                </div>
            </div>
            <div id="konbtas" style="width: 20%;float:left;height: 300px;">
                <div id="konbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                    Konular
                </div>
                <div id="skonular" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

                </div>
            </div>
            <div id="doktas" style="width: 60%;float:left;height: 300px;">
                <div id="dokbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                    Sorular
                </div>
                <div id="sicerik" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

                </div>
            </div>

        </div>


        <div style=" display: none; margin-top: 30px;width: 100%;left: 9%; height: 410px;" id="estas">
            <div id="ekbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                Ekledikleriniz
            </div>
            <div id="eklenensoru" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

            </div>

            </div>

        </div>


       <div class="frm yazma" >

           <h1 class="baslik">Yeni Bir Soru Yazın +</h1>

           <form id="sorek" action="envanter.php" method="post" class="yeni_soru">

               <input type="hidden" name="komut" value="sorek" />
               <textarea class="ckeditor" cols="100" id="sorumet" rows="15" name="sorumet"></textarea>
               <div style="width:50%;float:left;">
                   <input type="radio" name="dc" value="a">

                   <br />
                   <div style="width:100%;">
                       <textarea class="ckeditor" cols="30" id="a" rows="10" name="a"></textarea>
                   </div>
               </div>


               <div style="width:50%;float:left;">
                   <input type="radio" name="dc" value="b">
                   <br />
                   <div style="width:100%;">
                       <textarea class="ckeditor" cols="30" id="b" rows="10" name="b"></textarea>
                   </div>
               </div>


               <div style="width:50%;float:left;">
                   <input type="radio" name="dc" value="c">
                   <br />
                   <div style="width:100%;">
                       <textarea class="ckeditor" cols="30" id="c" rows="10" name="c"></textarea>
                   </div>
               </div>


               <div style="width:50%;float:left;">
                   <input type="radio" name="dc" value="d">
                   <br />
                   <div style="width:100%;">
                       <textarea class="ckeditor" cols="30" id="d" rows="10" name="d"></textarea>
                   </div>
               </div>

               <select name="zorluk" id="zorluk">
                   <option value="1">Kolay</option>
                   <option value="2">Orta</option>
                   <option value="3">Zor</option>
               </select>
               <select style="float: left;margin-left: 33%;margin-top: -13px;background: white;border: none;box-shadow: none;color: rgb(82, 67, 67);" name="konu" id="skonu" class="konusec"></select>
               <input type="button" onclick="envantereSoruEkle()" value="Soruyu Ekle" id="soruonay" style="top: auto; left: auto;" />
           </form>
       </div>


    </div>




<div class="kisilerKutusu">
<div class="sagpanel"><div class="ders-list"><div class="user-h">
      <p>Dersler</p>
    </div>
     <ul class="derslist">
      <?php
      $ar = $_SESSION['dersler'];
      for ($i=1;$i<=count($ar)-1;$i++){ echo "<li><a href='ogretmen_ders_goruntuleme.php?dersid=" . $_SESSION['dersler'][$i] ."&dersadi=" . $_SESSION['dersadlari'][$i] ."&seviyeno=1'>" . $_SESSION['dersadlari'][$i] . "</a></li>"; }
echo "<li><a href='ogretmen_ders_olustur.php'>Ders Oluşturun</a></li>";
?>

    </ul></div></div>
<div class="user-list">
    <div class="user-h">
      <p>Arkadaşlar</p>
    </div>
    <ul id="arkadaslar">
     <?php
      $sar = $_SESSION['arkadaslar'];
      for ($i=1;$i <= count($sar)-1;$i++)
      {
        echo '<li>';
        echo '<p><img src="' . $_SESSION['arkadaslar'][$i]['arkfoto'] . '" width="22px" class="ava"/> ' . $_SESSION['arkadaslar'][$i]['arkadi'] . '</p>';
        echo '</li>';
      }    
     ?>
    </ul>
    
  </div>
  

</div>
</body>
</html>
