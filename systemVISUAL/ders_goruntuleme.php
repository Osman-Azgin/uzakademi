<?php
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Uzakademi.org <?php echo $_GET['dersadi']; ?> dersi </title>
   <link rel="stylesheet" type="text/css" href="../systemTHEME/panel.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <script type="text/javascript" src="../systemJS/jquery-1.11.1.min.js"></script>
    <script src="../systemJS/jquery.pKisalt.js"></script>
    <script type='text/javascript' src='../systemAPPS/ckeditor/ckeditor.js'></script>
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
    <script type="text/javascript" language="javascript">

        $(document).ready(function(){


            //Select the first tab and div by default
            $('#tab_nav > ul > li > a').eq(0).addClass( "selected" );
            $('#tab_nav > div').eq(0).addClass( "selected" );


            //EVENT DELEGATION
            //This assigns an onclick event listener to the UL tag.
            //Then it checks what A tag was selected.
            $('#tab_nav > ul').on('click','a',function(){

                var aElement = $('#tab_nav > ul > li > a');
                var divContent = $('#tab_nav > div');

                /*Handle Tab Nav*/
                aElement.removeClass( "selected");
                $(this).addClass( "selected");

                /*Handle Tab Content*/
                var clicked_index = aElement.index(this);
                divContent.css('display','none');
                divContent.eq(clicked_index).css('display','block');

                $(this).blur();
                return false;

            });


        });
        </script>
    <script language="javascript" type="text/javascript">
       var drsid = <?php echo $_GET['dersid'];  ?> ;
       var seviyeid;
       var ders;
       var sdokumanlar;
       var sorular;
       var odev;
       var odevTeslimleri;
       var notlar;

       window.onload = dersBilgileri;

       function dersBilgileri ()
       {
           $('#dblg').css('display' , 'block');
           $('#dokumantas').css('display' , 'none');
           $.ajax({
               type : 'POST',
               url : '../systemPHP/ogrenciDersGoruntuleme.php',
               data : { cmd : 'dersgetir', dersid : drsid },
               success : function (data)
               {
                   if(data == "")
                   {
                       alert("Seviye Hazır Değil!");
                   }
                   if(data != "ga")
                   {
                       ders = $.parseJSON(data);
                       document.getElementById('dad').innerHTML += ders['dersadi'];
                       document.getElementById('sevsay').innerHTML += ders['seviyeno'];
                       document.getElementById('dersh1').innerHTML +="Ders Adı: " + ders['dersadi'] + " Seviyeniz : " + ders['seviyeno'] + " Öğretmen: <img src='" + ders['ogretmenfoto'] + "' style='width:50px;height:50px;' /> " + ders['ogretmenadi'] + " <div style='width: 200px;  margin-top: -28px;position: absolute;margin-left: 89%;' class='progress'><div id='progressboxi' class='bar' style='width: 0px;'><p id='yuzdei' class='percent'></p></div></div>";
                       if(ders['sgd']=='s')
                       {
                       	  document.getElementById('sgd').innerHTML += "Sınava Bağlı";
                       	  document.getElementById('odevler').remove();
                       }
                       if(ders['sgd']=='o')
                       {
                       	  document.getElementById('sgd').innerHTML += "Ödeve Bağlı";
                       	  document.getElementById('sinavs').remove();
                       }
                       if(ders['sgd']=='so')
                       {
                       	  document.getElementById('sgd').innerHTML += "Sınava ve Ödeve Bağlı";
                       }
                       $('#progressbox').css('width' , ders['yuzde'] + '%');
                       $('#progressboxi').css('width' , ders['yuzde'] + '%');
                       $('#yuzde').html(ders['yuzde']);
                       $('#yuzdei').html(ders['yuzde']);
                       seviyeid=ders['seviyeid'];
                   }
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
           $('#odevtas').css('display' , 'none');
           $('#ntas').css('display' , 'none');
           $('#ogrsorutas').css('display' , 'none');
           seviyedekiDokumanlariGetir();
           uniteGetir(1);
       }

       function sinav ()
       {
           $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'none');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#sinavs').css('background' , "white");
           $('#sorutas').css('display' , 'block');
           $('#odevtas').css('display' , 'none');
           $('#ntas').css('display' , 'none');
           $('#ogrsorutas').css('display' , 'none');
           sinavBilgileri();
           uniteGetir(2);
       }

       function odevler ()
       {
           $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'none');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#odevler').css('background' , "white");
           $('#sorutas').css('display' , 'none');
           $('#odevtas').css('display' , 'block');
           $('#ntas').css('display' , 'none');
           $('#ogrsorutas').css('display' , 'none');
           odevGetir();
       }

       function not ()
       {
       	   $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'none');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#notlr').css('background' , "white");
           $('#sorutas').css('display' , 'none');
           $('#odevtas').css('display' , 'none');
           $('#ntas').css('display' , 'block');
           $('#ogrsorutas').css('display' , 'none');
           notGetir();
       }

       function soru ()
       {
       	  $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'none');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#sor').css('background' , "white");
           $('#sorutas').css('display' , 'none');
           $('#odevtas').css('display' , 'none');
           $('#ogrtas').css('display' , 'none');
           $('#ntas').css('display' , 'none');
           $('#ogrsorutas').css('display' , 'block');
           ogrenciSorusuGetir("0,30");
       }


       function seviyedekiDokumanlariGetir ()
       {
           $.ajax({
              type : 'POST',
              url : '../systemPHP/ogretmenDersGoruntuleme.php',
              data :  { cmd : 'dokumangetir' , seviyeid : ders['seviyeid']  },
              success : function (data)
              {
                  if(data=="")
                  {
                      document.getElementById("doklist").innerHTML="<h1 class='baslik'>Döküman Yok</h1>";
                  }
                  else {
                      var yazi = "";
                      sdokumanlar = $.parseJSON(data);
                          for (var i = 0; i<= sdokumanlar.length -1; i++) {
                              yazi += "<div style='float:left;margin-top:10px;margin-left:10px;width:160px;padding:10px 10px 10px 10px;box-shadow:black 0px 0px 1px;border-radius:5px;'><img src='../Graphics/svg/documenticn.png' style='width: 80%;height: 113px;margin-left: 10%;' /> <p style='font-family: Exo, sans-serif;text-align:center;margin-top: 16px;'>" + sdokumanlar[i]['dadi'] + "</p><a href='ogrenci_dokuman_inceleme.php?did=" + sdokumanlar[i]['did'] + "&dersid=" + drsid + "&dersadi=" + ders['dersadi'] + "'><div style='background: #27AE60;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' >Göster</div></a></div>";
                          }
                      document.getElementById("doklist").innerHTML = yazi;
                  }
              }
           });
       }

       function sinavBilgileri ()
       {
           $.ajax({
               type : 'POST',
               url : '../systemPHP/ogrenciDersGoruntuleme.php',
               data :  { cmd : 'sinavbilgileri' , seviyeid : ders['seviyeid']  },
               success : function (data)
               {

                       var yazilacak = "";
                       sBil = $.parseJSON(data);
                       $('#sinad').html('Sınav Adı : ' + ders['dersadi']);
                       $('#sinss').html('Soru Sayısı : ' + sBil['sorusay']);
                       $('#sinssur').html('Süre : ' + sBil['sinavsure']);
                       if (sBil['girdimi']==0)
                       {
                       	$('#girdimi').html('<h1 class="baslik" style="margin-top:20px;margin-bottom:20px;width:100%;text-align:center;">Bu Sınava Daha Önce Girmediniz</h1>');
                       }
                       else {
                         $('#girdimi').html('<h1 class="baslik" style="margin-top:20px;margin-bottom:20px;width:100%;text-align:center;">Puanınız: ' + sBil['sinavnot'] + '</h1>');
                       }
                       if(ders['yuzde'] == 100)
                       {
                            document.getElementById('slinka').href="sinav_giris.php?seviye=" + ders['seviyeid'] + "&sgd=" + ders['sgd'] + "&sevno=" + ders['seviyeno'] + "&dersid=" + "<?php echo $_GET['dersid']; ?>";
                            $('#slink').html('Sınava Gir');
                       }
                       else
                       {
                         $('#slink').html('Sınava Girmek İçin Tüm Dökümanları Görüntülemelisiniz');
                         $('#slink').css('width' , '300px');
                       }
             }
           });
       }

       function odevGetir ()
       {
           $.ajax({
               type : 'POST',
               url : '../systemPHP/ogrenciDersGoruntuleme.php',
               data :  { cmd : 'odevgetir' , seviyeid : ders['seviyeid']  },
               success : function (data)
               {
                   if(data!="")
                   {
                       odev = $.parseJSON(data);
                       $('#obs').html("Ödevin Adı : " + odev['odevadi']);
                       $('#oac').html(odev['odevmetni']);
                       $('#odid').val(odev['odevid']);
                       $('#sevid').val(ders['seviyeid']);
                       $('#oddid').val(drsid);
                       if(odev['odevvarmi'] == 1)
                       {
                       	  $('#oncekiodev').html("<div style='background:#F6F7F8;margin-top:25px;width: 102%;height:auto;padding:10px 0px 15px 0px;border-top:1px solid #e5e5e5;margin-bottom: -10px;margin-left: -1%;'><img src='../Graphics/svg/tedilenicn.png' style='float:left;position:static;width:60px;height:60px;' /><p class='baslik' style='margin-left:1%;margin-top:10px;float:left;'>" + odev['dosad'].substr(0,10) + "</p><a href='" + odev['adres'] + "'><div class='soruonay' style='margin:0;margin-left: 31%;padding:1px 1px 1px 1px;position:static;margin-top: 10px;'>Göster</div></a><p class='baslik' style='margin:0;margin-left: 56%;float:left;margin-top: -43px;' id='puan'></p></div>");
                       	  if(odev['okundumu']==1)
                       	  {
                       	  	  $('#puan').html('Puanınız : ' + odev['odevnotu']);
                       	  }
                       	  else
                       	  {
                       	  	  $('#puan').html('Ödev Kontrol Edilmedi');
                       	  }
                       	  $('#oonay').html('Ödev Güncelle');
                       }
                   }
               }
           });
       }

       function notGetir ()
       {
       	  var yazilacak="";
       	  $.ajax({
               type : 'POST',
               url : '../systemPHP/not.php',
               data :  { komut : 'dsng' , seviyeid : ders['seviyeid'] , seviye : seviyeid  },
               success : function (data)
               {
               	  if (data !== "") {
                    notlar=$.parseJSON(data);
                    for (var i = 0; i <= notlar.length -1 ; i++)
                    {
                    	yazilacak += "<div style='width:100%;height: 176px;padding:10px 0px 10px 0px;border-top: rgb(228, 228, 228) solid 1px;border-bottom: rgb(228, 228, 228) solid 1px;'><h1 class='baslik' style='margin:0;margin-left: 12px;'>" + notlar[i]['notbaslik'] + "</h1><div id='notmet" + i + "'><p style='margin-left: 16px;font-family: sans-serif;margin-top: 15px;margin-bottom: 15px;' id='notp" + i + "'>" + notlar[i]['noticerik'] + "</p></div><div id='ndt" + i + "' class='soruonay' style='display:none;position: static;padding: 1px 5px 1px 5px;float: right;margin-right: 2%;margin-top: 10px;'>Tamam</div><div class='soruonay' style='background: rgb(139, 40, 40);position: static;padding: 1px 5px 1px 5px;float: right;margin-right: 2%;margin-top: 31px;' id='nsa" + i + "' onclick='notuSil(" + notlar[i]['notid'] + ")'>Sil</div><div class='soruonay' style='position: static;padding: 1px 5px 1px 5px;float: right;margin-right: 2%;margin-top: 31px;' id='nda" + i + "' onclick='notDuzAc(" + notlar[i]['notid'] + "," + i + ")'>Düzenle</div></div>";
                    };
                    document.getElementById('nlist').innerHTML = yazilacak;
               	  }
                   else {
                     document.getElementById('nlist').innerHTML = '<h1 class="baslik" style="margin:0;margin-left: 12px;">Hiç Notunuz Yok</h1>';
                   }
               }
           });
       }

        function ogrenciSorusuGetir ()
       {
       	    $.ajax({
               type : 'POST',
               url : '../systemPHP/sorular.php',
               data :  { komut : 'ocg' , seviye:seviyeid },
               success : function (data)
               {
               	   ogrencisorulari = $.parseJSON(data);
                   var yazilacak="";

                       for (var i = 0; i <= ogrencisorulari.length -1; i++)
                       {
                       	if (ogrencisorulari[i]['cevaplandidi']==1)
                       	{
                          yazilacak +="<div style='float:left; margin-top:30px; width:100%;height: 176px;padding:10px 0px 10px 0px;border-top: rgb(228, 228, 228) solid 1px;border-bottom: rgb(228, 228, 228) solid 1px;'><p class='baslik' style='margin:0;margin-left: 12px;text-decoration: none;color: #048CAD; font-size: 17px;'>Soru : </p><p style='margin-left: 16px;font-family: sans-serif;margin-top: 15px;margin-bottom: 15px;'>" + ogrencisorulari[i]['osoruicerik'] + "</p><p class='baslik' style='margin:0;margin-left: 12px;text-decoration: none;color: #048CAD;  font-size: 17px;'>Cevap : </p><p style='margin-left: 16px;font-family: sans-serif;margin-top: 15px;margin-bottom: 15px;'>" + ogrencisorulari[i]['cevap'] + "</p></div>";
                       	}
                       	else
                       	{
                       	  yazilacak +="<div style='float:left; margin-top:30px; width:100%;height: 176px;padding:10px 0px 10px 0px;border-top: rgb(228, 228, 228) solid 1px;border-bottom: rgb(228, 228, 228) solid 1px;'><p class='baslik' style='margin:0;margin-left: 12px;text-decoration: none;color: #048CAD; font-size: 17px;'>Soru : </p><p style='margin-left: 16px;font-family: sans-serif;margin-top: 15px;margin-bottom: 15px;'>" + ogrencisorulari[i]['osoruicerik'] + "</p><p class='baslik' style='margin:0;margin-left: 12px;text-decoration: none;color: #048CAD;  font-size: 17px;'>Cevap : </p><p style='margin-left: 16px;font-family: sans-serif;margin-top: 15px;margin-bottom: 15px;color:red;'>Cevap Bekliyor</p></div>";
                       	}
                       }

                       $('#ogrsorulist').html(yazilacak);
               }
           });
       }

         function notYaz ()
        {
          $.ajax({
          type:'POST',
          url:'../systemPHP/not.php',
          data:{ komut:'ne' , seviye:seviyeid , dersid:drsid , not:document.getElementById('not').value , baslik:ders['dersadi'] + " Dersi " + ders['seviyeno'] + ". Seviye" },
          success:function (data) { notGetir(); }
          });

        }

        function soruSor ()
        {
        	$.ajax({
               type : 'POST',
               url : '../systemPHP/sorular.php',
               data :  { komut : 'oss' , sid:seviyeid , ogrtid : ders['ogretmenid'] , soru : $('#ogsor').val() },
               success : function (data)
               {
               	  ogrenciSorusuGetir();
               }
           });
        }

        function notDuzAc (id,tagid)
        {
          var metin = $('#notp' + tagid).html();
          document.getElementById('notmet' + tagid).innerHTML = "<textarea style='width: 100%;position: static;height: 91px;border: none;' id='yeninot" + tagid + "' cols='45' rows='5'></textarea>";
          $('#nda' + tagid).css('display' , 'none');
          $('#nsa' + tagid).css('display' , 'none');
          $('#ndt' + tagid).css('display' , 'block');
          $('#yeninot' + tagid).html(metin);
          $('#ndt' + tagid).click(
            function () {
            	notDuzenle(id,tagid);
            }
          	);
        }

        function notDuzenle(id,tagid)
        {
            var yn = document.getElementById('yeninot' + tagid).value;
            $.ajax({
            type:'POST',
            url:'../systemPHP/not.php',
            data:{ komut:'ng' , not:yn , notid:id },
            success:function (data) { notGetir(); }
            });
        }

        function notuSil(id)
        {
        	$.ajax({
            type:'POST',
            url:'../systemPHP/not.php',
            data:{ komut:'ns' , notid:id },
            success:function (data) { notGetir(); }
            });
        }

       function odevTeslimEt ()
       {
       	  $("#oy").submit();
       	  odevGetir();
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


    </script>

</head>
<body style="background-color:#FAFAFA;font-family:'Exo' Sans-serif">
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
    <div  class="newLauncher">
        <div id="derb" style="background: #ffffff;" class="newLauncherLink">
            <img style="border-radius:100px;" src="../Graphics/images/drsicn.png" />
            <p>Dersiniz</p>
        </div>

        <div onclick="dokumanlar()" id="doks" class="newLauncherLink">
            <img alt="Notlarınız" src="../Graphics/images/noteicon.png" />
            <p>Dökümanlar</p>
        </div>

        <div id="sinavs" onclick="sinav()" class="newLauncherLink">

            <img alt="Sonuçlar" src="../Graphics/images/sonucicon.png" />
            <p>Sınavlar
        </div>

        <div onclick="odevler()" id="odevler" class="newLauncherLink">

            <img alt="Ödevlriniz" src="../Graphics/images/odevicon.png" />
            <p>Ödevler
        </div>

        <div id="notlr" onclick="not()" class="newLauncherLink">

            <img alt="Akış" src="../Graphics/images/akis.png" />
            <p>Notlarınız</p>
        </div>
        <div onclick="soru()" id="sor" class="newLauncherLink">

            <img alt="sor" src="../Graphics/images/cevpicon.png" />
            <p>Sorular</p>
        </div>

    </div>

    <div style="width: 75%;margin-top: 58px;margin-left:139px;margin-bottom:100px;" class="panel_akis_tasiyici" id="at">



     <div id="dersbilust">
        <h1 id="dersh1" class="baslik" style="margin:0;margin-top:20px;text-align:center;margin-left: -23%;"> <h1>
     </div>



     <div id="dersbilgileri">

         <div id="dblg" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
             <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                 <p id="ssec" onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Ders Bilgileri</p>
             </div>
             <h1 style="margin-top: 10px;" id="dad" class="baslik">Dersadı: </h1>
             <h1 style="margin-top: 10px;" id="sevsay" class="baslik">Bulunduğunuz Seviye: </h1>
             <h1 style="margin-top: 10px;" id="sgd" class="baslik">Seviye Geçme: </h1>
             <div style="width: 864px;margin-top: 10px;margin-left: 0px;" class="progress">
             <div id="progressbox" class="bar"><p id="yuzde" class="percent" ></p></div>
             </div>
             <div style="width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
                 <div style="margin: 0;position: static;padding: 2px 10px 1px 10px;" class="soruonay">Durumu Göster</div>
             </div>
         </div>

     </div>


        <div id="dokumantas">

            <div id="dokkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">

                <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                    <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Seviyedeki Dökümanlar</p>
                </div>

                <div id="doklist">

                </div>

                <div style="float:left;width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;"></div>


        </div>




        <div style="width: 90%;height: auto;margin-top:45px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <form id="ekdata">
                <input type="hidden" name="sid" value="" id="sid">
                <input type="hidden" name="drsid" value="" id="dersid">
                <input type="hidden" name="cmd" value="dokekle" >
                <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">

                    <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Bu Seviyeye Sizde Döküman Yükleyebilirsiniz</p>

                </div>

                  <input type="file" style="position: static;margin-top: 30px;margin-left: 37%;margin-bottom: 30px;width: inherit;" name="dosya" class="soruonay">

                <div style="float:left;width: 100%;padding: 10px 0px 10px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
                   <div class="soruonay" style="position: static;margin-left: 37%;width: 100px;margin:0;padding:5px 5px 5px 5px;float: right;padding: 1px 1px 1px 1px;margin-right:10px;">Dosyayı Yükle</div>
                </div>
            </div>
          </form>
        </div>



    <div style="display: none;" id="sorutas">
    <form id="sordata">
        <div id="sorukut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">

            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Seviyedeki Sınav Soruları</p>
            </div>

            <div id="sorlist">
               <h1 style="margin:0" class="baslik" id="sinad"></h1>
               <h1 style="margin:0" class="baslik" id="sinss"></h1>
               <h1 style="margin:0" class="baslik" id="sinssur"></h1>
               <div id="girdimi"></div>

            </div>

            <div style="float:left;width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
               <a id="slinka" href="#"><div id="slink" class="soruonay" style="position: static;margin-left: 37%;width: 100px;margin:0;padding:5px 5px 5px 5px;"></div></a>
            </div>
           </form>
        </div>
    </div>






<div style="display: none;" id="odevtas">
        <div id="odevkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Seviyedeki Ödev</p>
            </div>

            <div id="odlist">
            	<form  id="oy"  target="yukle" method="post" action="../dosya_yukle.php" enctype="multipart/form-data">
                <h1 class="baslik" style="margin: 0;" id="obs"></h1>
                <div id="oac"></div>
                <input type="hidden" name="odevid" id="odid" />
                <input type="hidden" name="komut" value="odev">
                <input type="hidden" name="seviyeid" id="sevid" />
                <input type="hidden" name="dersid" id="oddid">
                <div id="oncekiodev"></div>
            </div>

            <div style="float:left;width: 100%;padding: 20px 0px 15px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
                <input type="file" style="position: static;width: 300px;float: left;margin-left: 23%;" name="dosya" class="soruonay">
                <div class="soruonay" onclick="odevTeslimEt()" style="margin: 0;margin-left: 3%;position: static;width: 100px;float: left;padding: 1px 5px 1px 5px;" id="oonay">Teslim Et</div>
                <iframe id="yukle" name="yukle" src="" style="display: none;"></iframe>
                </form>
            </div>
        </div>

</div>


<div style="display: none;" id="ntas">
    <div id="nkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Seviyedeki Notlarınız</p>
            </div>
            <div id="nekle">
                 <textarea id="not" style="margin: 0px; /* width: 801px; */ height: 49px;position: relative;margin-top: 10px;width: 100%;border: none;font-family: sans-serif;height: 100px;" placeholder="Yeni Notunuzu Yazın"></textarea>
            </div>
            <div style="float:left;width: 100%;padding: 10px 0px 3px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
                <div class="soruonay" style="position: static;padding: 1px 5px 1px 5px;float: right;margin-right: 2%;" onclick="notYaz()" >Ekle</div>
            </div>
            <div id="nlist" style="width: 102%;height: 100px;position: relative;margin-top: 200px;margin-left: -1%;">

            </div>
        </div>
</div>


<div style="display: none;" id="ogrsorutas">
    <div id="ogrkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Öğretmeninize Sorduğunuz Sorular</p>
            </div>
            <div id="ssor">
                 <textarea id="ogsor" style="margin: 0px; /* width: 801px; */ height: 49px;position: relative;margin-top: 10px;width: 100%;border: none;font-family: sans-serif;height: 100px;" placeholder="Yeni Bir Soru Sorun"></textarea>
            </div>
            <div style="float:left;width: 100%;padding: 10px 0px 3px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
                <div class="soruonay" style="position: static;padding: 1px 5px 1px 5px;float: right;margin-right: 2%;" onclick="soruSor()">Sor</div>
            </div>
            <div id="ogrsorulist">

            </div>
        </div>
</div>

<div style="margin-top:50px;"></div>

</div>

    <div class="kisilerKutusu">
        <div class="sagpanel"><div class="ders-list"><div class="user-h">
                    <p>Dersler</p>
                </div>
                <ul class="derslist">
                    <?php
                    $ar = $_SESSION['dersler'];
                    for ($i=1;$i<=count($ar)-1;$i++){ echo "<li><a href='ders_goruntuleme.php?dersid=" . $_SESSION['dersler'][$i] ."&dersadi=" . $_SESSION['dersadlari'][$i] ."'>" . $_SESSION['dersadlari'][$i] . "</a></li>"; }
                    ?>

                </ul></div></div>
        <div class="user-list">
            <div class="user-h">
                <p>Arkadaşlar</p>
            </div>
            <ul id="arkadaslar">
                <?php
                for ($i=1;$i <= count($_SESSION['arkids'])-1;$i++)
                {
                    echo '<li>';
                    echo '<p><img src="' . $_SESSION['arkfots'][$i] . '" width="22px" class="ava"/> ' . $_SESSION['arkads'][$i] . '</p>';
                    echo '</li>';
                }
                ?>
            </ul>

        </div>


    </div>
</body>
</html>
