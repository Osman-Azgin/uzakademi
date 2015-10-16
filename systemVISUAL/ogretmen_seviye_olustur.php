<?php
session_start();

if ($_SESSION['yetki'] == '0')
{
    header("location:panel.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<title>Dersinize Yeni Seviye Ekleyin</title>
<link rel="stylesheet" type="text/css" href="../systemTHEME/styles.css">
<link rel="stylesheet" type="text/css" href="../systemTHEME/panel.css">
<script type="text/javascript" src="../systemJS//jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../systemAPPS/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    jQuery(function($) {
        $('.dropdown-title .box').click(function() {
            if(!$(this).parent().hasClass('active'))
                $(this).parent().addClass('active');
            else
                $(this).parent().removeClass('active');
        });
    });
</script>
<script type="text/javascript" language="javascript">

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
    <script type="text/javascript" language="javascript">

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
                        $("#dkon" + tid).css("color" , "white");
                        var uniteler = $.parseJSON(data);
                        var yazilacak = "";
                        for(var i =0;i<=uniteler.length-1;i++)
                        {
                            yazilacak += "<div id='dok" + i + "' style='width:100%;padding: 20px 0px 20px 0px;box-shadow:black 0px 0px 1px;'> <img src='http://localhost/uzakademi.org/Graphics/svg/koleksiyon.fw.png' width='50' height='50' style='float: left;margin-top: -12px;' /> <p id='dis" + i +"' style='margin-left:20px;float:left;'>" + uniteler[i]['dadi'] + "</p> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' target='_blank' href='" + uniteler[i]['dosya'] + "'>Göster</a> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href='javascript:dokumanEkle(" + uniteler[i]['did'] + "," + i + ");'> Ekle </a> </div>";
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


    </script>
    <script language="javascript" type="text/javascript">

        var gsgd=null;
        var olustumu=0;
        var dersid = <?php echo $_GET['dersid']; ?>;
        var ebsno = <?php echo $_GET['ebsno']; ?>;

         window.onload = seviyeGecmeDurumu;

         function seviyeGecmeDurumu ()
         {
             $('#tasiyici').css('margin-top',"-500px");
         }

         function sgdAyar (sgd)
         {
             if(sgd=="s")
             {
                 $('#sgdmesaj').html("Öğrenciler Bu Seviyeyi Geçmek İçin Sizin Hazırladığınız Bir Sınava Girecek");
                 $('#odev').css('display',"none");
                 $('#sinav').css('display',"block");
                 $('#sinbaslik').css('visibility',"visible");
                 $('#sinkut').css('visibility',"visible");
                 $('#odbas').css('visibility',"hidden");
                 $('#obs').css('visibility',"hidden");
                 $('#oac').css('visibility',"hidden");
             }
             if(sgd=="o")
             {
                 $('#sgdmesaj').html("Öğrenciler Bu Seviyeyi Geçmek İçin Sizin Belirlediğiniz Bir Ödev Teslim Edecek");
                 $('#sinav').css('display',"none");
                 $('#odev').css('display',"block");
                 $('#sinbaslik').css('visibility',"hidden");
                 $('#sinkut').css('visibility',"hidden");
                 $('#odbas').css('visibility',"visible");
                 $('#obs').css('visibility',"visible");
                 $('#oac').css('visibility',"visible");
             }
             if(sgd=="so")
             {
                 $('#sgdmesaj').html("Öğrenciler Bu Seviyeyi Geçmek İçin Sizin Hazırladığınız Bir Sınava Girecek");
                 $('#odev').css('display',"block");
                 $('#sinav').css('display',"block");
                 $('#sinbaslik').css('visibility',"visible");
                 $('#sinkut').css('visibility',"visible");
                 $('#odbas').css('visibility',"visible");
                 $('#obs').css('visibility',"visible");
                 $('#oac').css('visibility',"visible");
             }
             gsgd=sgd;
         }

         function dokumanYule ()
         {

             $('#tasiyici').css('margin-top',"-1110px");
             uniteGetir(1);
         }

         function dokSeEkSecim (se)
         {
             if(se=="s")
             {
                 $("#edtas").css("display" , "none");
                 $("#doktasiyici").css("display" , "block");
                 $("#dsec").css("color" , "#048CAD");
                 $("#eklen").css("color" , "#e5e5e5");
             }
             if(se=="d")
             {
                 $("#edtas").css("display" , "block");
                 $("#doktasiyici").css("display" , "none");
                 $("#eklen").css("color" , "#048CAD");
                 $("#dsec").css("color" , "#e5e5e5");
             }
         }

        function siSeEkSecim (se)
        {
            if(se=="s")
            {
                $("#estas").css("display" , "none");
                $("#sintasiyici").css("display" , "block");
                $("#ssec").css("color" , "#048CAD");
                $("#seklen").css("color" , "#e5e5e5");
            }
            if(se=="d")
            {
                $("#estas").css("display" , "block");
                $("#sintasiyici").css("display" , "none");
                $("#seklen").css("color" , "#048CAD");
                $("#ssec").css("color" , "#e5e5e5");
            }
        }

        function sinavaGec ()
        {
            if(gsgd=="so" || gsgd=="s") {
                $('#tasiyici').css('margin-top', "-1925px");
                uniteGetir(2);
            }
            if(gsgd=="o")
            {
                odeveGec();
            }
        }

        function odeveGec ()
        {
            if(gsgd=="so" || gsgd=="o") {
                $('#tasiyici').css('margin-top', "-2725px");
            }
            if(gsgd=="s")
            {
                tamamaGit();
            }
        }

        function tamamaGit()
        {
            $('#tasiyici').css('margin-top',"-3525px");
        }

        function seviyeOlustur()
        {
           if (olustumu==0)
           {	
            $.ajax({
               type : 'POST',
               url : "../systemPHP/dersDuzenle.php",
               data : $('#ders').serializeArray(),
               success : function (data)
               {
                   var veri = $.parseJSON(data);
                   if(veri['durum']=="OK")
                   {
                       $('#derse').html('Dersi Görüntüle');
                       olustumu=1; 
                   }
               }
            });
           }
           else
           {
           	 ebsno++;
           	 window.location="http://www.uzakademi.org/systemVISUAL/ogretmen_ders_goruntuleme.php?dersid=" + dersid + "&seviyeno=" + ebsno;
           }
        }

    </script>
</head>
<body style="background-color:#FAFAFA;overflow-y: hidden"  >
  <div class="topbar">
       <form action="arama_sonuclari.php" method="get">
        <input type="search" name="aranacak" placeholder="Arama">
        </form>
        <img src="http://localhost/uzakademi.org/Graphics/images/yenilogo.png" alt="" class="logo">
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

  <div class="newLauncher">

      <div id="notlar" class="newLauncherLink">

          <img alt="Cevaplar" src="../Graphics/images/cevpicon.png" />
          <p>Seviye Türü</p>
      </div>

      <div id="odevler" class="newLauncherLink">


          <img alt="Notlarınız" src="../Graphics/images/noteicon.png" />
          <p>Döküman Seç</p>
      </div>
      <div id="sinav" class="newLauncherLink">

          <img alt="Ödevlriniz" src="../Graphics/images/odevicon.png" />
          <p>Sınav Oluştur</p>
      </div>
      <div id="odev" class="newLauncherLink">

          <img alt="Sonuçlar" src="../Graphics/images/sonucicon.png" />
          <p>Ödev ver</p>
      </div>
      <div id="ss" class="newLauncherLink">

          <img alt="Sonuçlar" src="../Graphics/images/ok.png" />
          <p>Tamamla</p>
      </div>
  </div>

 <div id="tasiyici" style="transition: all 0.2s ease;  width: 90%;left: 9%; height: 550%; margin-top: 70px;position: absolute;" >

     <form id="ders" method="post">

         <input name="dersadi" id="ad" type="text" style=" width: 50%; padding: 10px 10px 10px 10px; margin-left: 15%; margin-top: 100px;" placeholder="Dersinizin Adı">
         <textarea name="dersacik" id="acik" rows="5" style="width: 50%; padding: 10px 10px 10px 10px; margin-left: 15%; margin-top: 100px;" placeholder="Dersinizin Açıklayın" ></textarea>
         <div style="margin-left: 35%; margin-top: 45px; text-align: center; width: 10%;padding: 10px 10px 10px 10px; background:#4B77BE; border-radius: 10px;box-shadow: #000000 0px 0px 1px;color: #ffffff;font-family: 'exo', sans-serif; " onclick="seviyeGecmeDurumu()" >
             Sonraki
         </div>

         <h1 class="baslik" style="margin-top: 250px;width: 90%;left: 9%;text-align: center; font-family: 'Exo', sans-serif; color: #000000;">Yeni Seviye Neye Bağlı Olarek Geçilecek</h1>
         <h2 class="baslik" style="margin-top: 50px;width: 90%;left: 9%;text-align: center; font-family: 'Exo', sans-serif; color: #000000;">
             <input onclick="sgdAyar('s')" style="margin-top: -3px;" type="radio" name="sg" value="s">&nbsp;Sınava Bağlı&nbsp;&nbsp;&nbsp;<input onclick="sgdAyar('o')" style="margin-top: -3px;" type="radio" name="sg" value="o">&nbsp;Ödeve Bağlı&nbsp;&nbsp;&nbsp;<input onclick="sgdAyar('so')" style="margin-top: -3px;" type="radio" name="sg" value="so">&nbsp;Sınava ve Ödeve Bağlı
         </h2>
         <h1 id="sgdmesaj" class="baslik" style="margin-top: 50px;width: 90%;left: 9%;text-align: center; font-family: 'Exo', sans-serif; color: black; padding: 10px 10px 10px 10px;background:#ffffff;border-radius: 10px;box-shadow: #4B77BE 0px 0px 1px;">
          Seviyenin nasıl grçileceğini seçin
         </h1>
         <div style="margin-left: 35%; margin-top: 45px; text-align: center; width: 10%;padding: 10px 10px 10px 10px; background:#4B77BE; border-radius: 10px;box-shadow: #000000 0px 0px 1px;color: #ffffff;font-family: 'exo', sans-serif; " onclick="dokumanYule()" >
             Sonraki
         </div>
         <h1 class="baslik" style="margin-top: 220px;width: 90%;left: 9%;text-align: center; font-family: 'Exo', sans-serif; color: #000000;">Yeni Seviyede Yayınlamak İçin Döküman Seçin</h1>

         <div style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">

             <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                 <p id="dsec" onclick="dokSeEkSecim('s')" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Döküman Seç</p>
                 <p id="eklen" onclick="dokSeEkSecim('d')" style="margin-left:30px;float:left;color: #e5e5e5;font-family: 'Exo', sans-serif;">Eklenenler</p>
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


             <div style=" display: none; margin-top: 30px;width: 100%;left: 9%; height: 410px;" id="edtas">
                 <div id="ekbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;">
                     Ekledikleriniz
                 </div>
                 <div id="eklenendokuman" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;">

                 </div>

         </div>

             <div style="margin-left: 35%; margin-top: 12px; text-align: center; width: 10%;padding: 10px 10px 10px 10px; background:#4B77BE; border-radius: 10px;box-shadow: #000000 0px 0px 1px;color: #ffffff;font-family: 'exo', sans-serif; " onclick="sinavaGec()" >
                 Sonraki
             </div>

         </div>


         <h1 id="sinbaslik" class="baslik" style="margin-top: 220px;width: 90%;left: 9%;text-align: center; font-family: 'Exo', sans-serif; color: #000000;">Yeni Seviye İçin Sınav Oluşturun</h1>

         <div id="sinkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">

             <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                 <p id="ssec" onclick="siSeEkSecim('s')" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Soru Seç</p>
                 <p id="seklen" onclick="siSeEkSecim('d')" style="margin-left:30px;float:left;color: #e5e5e5;font-family: 'Exo', sans-serif;">Eklenenler</p>
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

             <div style="margin-left: 35%; margin-top: 12px; text-align: center; width: 10%;padding: 10px 10px 10px 10px; background:#4B77BE; border-radius: 10px;box-shadow: #000000 0px 0px 1px;color: #ffffff;font-family: 'exo', sans-serif; " onclick="odeveGec()" >
                 Sonraki
             </div>

         </div>

         <h1 id="odbas" class="baslik" style="margin-top: 220px;width: 90%;left: 9%;text-align: center; font-family: 'Exo', sans-serif; color: #000000;">Yeni Seviye İçin Ödev Verin</h1>

         <input name="odevbaslik" id="obs" type="text" style=" width: 50%; padding: 10px 10px 10px 10px; margin-left: 15%; margin-top: 100px;" placeholder="Ödev Başlığı">
         <textarea name="odevaciklamasi" class="ckeditor" id="oac" rows="5" style="width: 50%; padding: 10px 10px 10px 10px; margin-left: 15%; margin-top: 100px;" placeholder="Ödevi Açıklayın" ></textarea>

         <div style="margin-left: 35%; margin-top: 12px; text-align: center; width: 10%;padding: 10px 10px 10px 10px; background:#4B77BE; border-radius: 10px;box-shadow: #000000 0px 0px 1px;color: #ffffff;font-family: 'exo', sans-serif; " onclick="tamamaGit()" >
             Sonraki
         </div>

         <h1 class="baslik" style="margin-top: 466px;width: 90%;left: 9%;text-align: center; font-family: 'Exo', sans-serif; color: #000000;">Butona Tıklayın ve Yeni Seviye Oluşturulsun</h1>

         <div id="derse" style="margin-left: 35%; margin-top: 12px; text-align: center; width: 10%;padding: 10px 10px 10px 10px; background:#4B77BE; border-radius: 10px;box-shadow: #000000 0px 0px 1px;color: #ffffff;font-family: 'exo', sans-serif;font-size: 25px " onclick="seviyeOlustur()" >
             Oluştur
         </div>
         <input type="hidden" name="cmd" value="so" >
         <input type="hidden" name="dersid" value="<?php echo $_GET['dersid']; ?>" >
         <input type="hidden" name="ebsno" value="<?php echo $_GET['ebsno']; ?>" >
     </form>

 </div>

</body>
</html>
