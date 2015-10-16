<?php
session_start();


include("../systemPHP/her_sayfada_olan.php");

//$hso = new her_sayfada_olan();
//$hso->mesaj_getir();
//$hso->bildirim_getir();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uzak Akademi </title>
        <link rel="stylesheet" href="../systemTHEME/panel.css">
        <link rel="stylesheet" href="../styles.css">
    <script src="../systemJS//jquery-1.11.1.min.js"></script>
    <script src="../systemJS//jquery.pKisalt.js"></script>
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


     var server_active_sayac;
     var akishtml;
     var akissayisi;
     var ebaid;
     var yeniakissayisi;


 window.onload=panel;

 function panel ()
{
  /*setInterval(function () {
        $.ajax({
            type:'POST',
            url : 'server_active.php',
            data: { komut : 'm_b' , ms : gercek_mesaj_sayisi},
            success : function (data) { mesajvarmi=data.substr(0,1); bildirimvarmi = data.substr(1,1); }
        });
        if (mesajvarmi == 1)
        {
            if (en_b_m_id == '')
            {
                en_b_m_id=0;
            }
            if (e_b_b_id == '')
            {
                en_b_b_id=0;
            }
            $.ajax({
                type : 'POST',
                url : 'server_active.php',
                data : { komut : 'm_g' , ebmid : en_b_m_id },
                success : function (data) {  document.getElementById("mesajdd").innerHTML += data;  }
            });
            $.ajax({
                type : 'POST',
                url : 'server_active.php',
                data : { komut : 'mid' , ebmid : en_b_m_id },
                success : function (data) { en_b_m_id = data;  }
            });
            $.ajax({
                type: 'POST',
                url : 'server_active.php',
                data : {komut:'mssg'},
                success : function (data) { gercek_mesaj_sayisi = data; }
            });
            mesajvarmi = 0;
        }
      if (bildirimvarmi == 1)
      {
          $.ajax({
              type : 'POST',
              url : 'server_active.php',
              data : { komut : 'b_g' , ebmid : en_b_b_id },
              success : function (data) {  document.getElementById("bildirimdd").innerHTML += data;  }
          });
          $.ajax({
              type : 'POST',
              url : 'server_active.php',
              data : { komut : 'mid' , ebmid : en_b_b_id },
              success : function (data) { en_b_b_id = data;  }
          });
          $.ajax({
              type: 'POST',
              url : 'server_active.php',
              data : {komut:'mssg'},
              success : function (data) { gercek_mesaj_sayisi = data; }
          });
      }
    },1000);*/


   // if (genislik < 1400 && genislik > 1290)
    //{
     // document.getElementById("akis").style.background="#F60";
      //    document.getElementById("akis").style.width="86%";
      //    document.getElementById("akis").style.left="15px";
       //   document.getElementById("akis").style.color="#FFF";
    //}
    //if (genislik < 1290 && genislik > 1030)
    //{
      //   document.getElementById("akis").style.background="#F60";
      //    document.getElementById("akis").style.width="86%";
      //    document.getElementById("akis").style.left="13px";
      //    document.getElementById("akis").style.color="#FFF";
    //}
    //if (genislik < 1030)
    //{
     //   document.getElementById("akis").style.background="#F60";
      //    document.getElementById("akis").style.width="83%";
      //    document.getElementById("akis").style.left="13px";
      //    document.getElementById("akis").style.color="#FFF";
    //}

     //akildaki = document.getElementById("akis");

     akisiyazdir();

    /*document.getElementById("mi").onclick = function ()
    {
       if (mesajdd == 0)
       {
       document.getElementById("mesajdd").style.top="50px";
       document.getElementById("mi").style.borderBottom="none";
       mesajdd = 1;
       }
       else
       {
           document.getElementById("mesajdd").style.top="-100%";
           mesajdd = 0;
       }
    }
    document.getElementById('bi').onclick = function ()
    {
        if (bildirimdd == 0){
        document.getElementById("bildirimdd").style.top="50px";
        document.getElementById("bi").style.borderBottom="none";
        bildirimdd = 1;}
        else
        {
            document.getElementById("bildirimdd").style.top="-100%";
            bildirimdd = 0;
        }
    }*/
     document.getElementById("akis").onclick= function ()
     {
        //genislik = screen.availWidth;
        //degisecek = document.getElementById("akis");
        //eskiyedonecek = akildaki ;
       // akildaki = document.getElementById("akis");
       // degistir ();
         akisiyazdir();
         $('.share').css('display' , 'block');
     }

     document.getElementById("notlar").onclick = function ()
     {
        /*genislik = screen.availWidth;
        degisecek = document.getElementById("notlar");
        eskiyedonecek = akildaki;
        akildaki= document.getElementById("notlar");
        degistir ();*/
        document.getElementById('at').innerHTML='<div style="width: 53%;height: auto;margin-top:-109px;overflow: hidden;background: #ffffff;padding: 20px 20px 20px 20px;margin-left: -33px;box-shadow: #000000 0px 0px 1px;" >    <p id="ssec" onclick="" style="margin-left: 10px; color: #474747;; float: left; font-family: Exo,sans-serif; margin-top: 9px;">Daha Fazlası Envanterinizde</p>  <a href="envanter_duzenleme.php" ><div style="position: static; margin-left: 56%; padding: 0px; margin-top: -1px;" class="soruonay">Envanteriniz</div></a> </div> <div id="dokumantas" style="display:block;margin-bottom: 61px;"> <div style="width: 55%;height: auto;margin-top:45px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: -33px;box-shadow: #000000 0px 0px 1px;"> <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;"> <p id="ssec" onclick="" style=" margin-left: 10px;color: #048CAD; float:left;font-family: Exo, sans-serif;">Envanterinizdeki Dökümanlar</p> </div> <div style="margin-top: 30px;width: 100%;left: 9%; height: 410px;" id="doktasiyici"> <div id="unbtas" style="width: 20%;float:left;height: 300px;"> <div id="unbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;"> Üniteler </div> <div id="duniteler" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;"> </div> </div> <div id="konbtas" style="width: 20%;float:left;height: 300px;"> <div id="konbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;"> Konular </div> <div id="dkonular" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;"> </div> </div> <div id="doktas" style="width: 60%;float:left;height: 300px;"> <div id="dokbas" style="width: 100%;background: #ffffff;padding: 10px 0px 10px 0px;box-shadow: #000000 0px 0px 1px;text-align: center;"> Dökümanlar </div> <div id="dicerik" style="width: 100%;height: 370px;box-shadow: inset 0 0 0.5em #000000; overflow-y: scroll;"> </div> </div></div>';
        uniteGetir(1);
        $('.share').css('display' , 'none');
     }
     document.getElementById("odevler").onclick = function ()
     {
        /*genislik = screen.availWidth;
        degisecek = document.getElementById("odevler");
        eskiyedonecek = akildaki;
        akildaki= document.getElementById("odevler");
        degistir ();*/
        odevleriyazdir ();
     }
      document.getElementById("cevaplar").onclick = function ()
     {
        /*genislik = screen.availWidth;
        degisecek = document.getElementById("cevaplar");
        eskiyedonecek = akildaki;
        akildaki= document.getElementById("cevaplar");
        degistir ();*/
        ogrenciSorusuGetir ("0,30");
        $('.share').css('display' , 'none');
     }



function akisiyazdir ()
    {
        $.ajax({
            type : 'POST',
            url : '../systemPHP/akis.php',
            data : { komut : "ay"  },
            success : function (data) {  if (data != "null") {
                document.getElementById('at').innerHTML=data;
            }  }
        });

        $.ajax({
            type : 'POST',
            url : '../systemPHP/akis.php',
            data : { komut : "ebaid"  },
            success : function (data) {  ebaid = data;
            }
        });

        $.ajax({
            type : 'POST',
            url : '../systemPHP/akis.php',
            data : { komut : "asbul" },
            success : function (data) {  if (data != "null") {  akissayisi = data;

            }  }
        });

        server_active_sayac = setInterval(function  (){

            $.ajax({
                type : 'POST',
                url : '../systemPHP/akis.php',
                data : { komut : "asbul" },
                success : function (msg) {
                     yeniakissayisi = msg;
                }
            });

            if (yeniakissayisi > akissayisi)
            {
                $.ajax({
                    type : 'POST',
                    url : '../systemPHP/akis.php',
                    data : { komut : "ag" , ebakid : ebaid  },
                    success : function (data) {
                        document.getElementById("at").innerHTML = data + document.getElementById('at').innerHTML;
                    }
                });
                $.ajax({
                    type : 'POST',
                    url : '../systemPHP/akis.php',
                    data : { komut : "asbul" },
                    success : function (data) {  if (data != "null") {  akissayisi = data;

                    }  }
                });
                $.ajax({
                    type : 'POST',
                    url : '../systemPHP/akis.php',
                    data : { komut : "ebaid" },
                    success : function (data) {  ebaid = data;
                    }
                });
            }


        },600000);
    }


function sonnotlariyazdir ()
{
    $.ajax({
        type : 'POST',
        url : 'not.php',
        data : { komut : 'sng' },
        success : function (data) {  if (data != "null") {
            document.getElementById("at").innerHTML = data;
        }  }
    });
}
function odevleriyazdir ()
{
  $.ajax({
    type:'POST',
    url:"../systemPHP/panel_odevler.php",
    data:{ komut:"ogrtog" },
    success: function(data) { document.getElementById("at").innerHTML = "<div style='margin-top:-115px;'>" + data + "</div>"; $('.share').css('display' , 'none'); }
  });

}




   function sonucyazdir ()
   {
       document.getElementById("at").innerHTML  = "<div class='panel_akis_tasiyici'>";
       for (var v =1;v <= sss;v++)
       {
       document.getElementById("at").innerHTML += "<div class='panel_akis_kutusu'>" + "<p>" + ssonucadlari[v] + "</p><p>" + ssonuclari[v] + "</p><p>" + gk(sdurumlari[v]) + "</p></div>";
       }
       document.getElementById("at").innerHTML  += "<div class='panel_akis_tasiyici'>";
       document.getElementById("pkutu").style.visibility = "hidden";
       document.getElementById("pkutu").style.marginTop="-200px";
   }


    function gk (a)
    {
        if (a >= 60)
        return "geçti";

        else
        return "kaldı";
    }


function degistir ()
{
    if (genislik < 1290 && genislik > 1030)
    {
       degisecek.style.background="#F60";
       degisecek.style.width="86%";
       degisecek.style.left="13px";
       degisecek.style.color="#FFF";
       eskiyedonecek.style.background="";
       eskiyedonecek.style.width="";
       eskiyedonecek.style.left="";
       eskiyedonecek.style.color="";
    }
    if (genislik < 1400 && genislik > 1290)
    {
       degisecek.style.background="#F60";
       degisecek.style.width="86%";
       degisecek.style.left="15px";
       degisecek.style.color="#FFF";
       eskiyedonecek.style.background="";
       eskiyedonecek.style.width="";
       eskiyedonecek.style.left="";
       eskiyedonecek.style.color="";
    }
    if (genislik < 1030)
    {
       degisecek.style.background="#F60";
       degisecek.style.width="83%";
       degisecek.style.left="13px";
       degisecek.style.color="#FFF";
       eskiyedonecek.style.background="";
       eskiyedonecek.style.width="";
       eskiyedonecek.style.left="";
       eskiyedonecek.style.color="";
    }
}
}

function akisekle ()
{
    $.ajax({
        type: 'POST',
        url :'../systemPHP/akis.php',
        data : { komut:'ae', icerik:document.getElementById("paykut").value },
        success : function (data) { if (data=="1") { icerik:document.getElementById("paykut").value = "ok"; } }
    });
    akisiyazdir();
}

function cevapla (id)
{
  $.ajax({
        type: 'POST',
        url :'../systemPHP/sorular.php',
        data :$("#soru" + id).serializeArray(),
        success : function (data) { if(data==1){cevapyazdir();} }
        });
}

/*function dosyalarigetir(konu) {
            $.ajax({
                type: 'post',
                url: '../systemPHP/envanter.php',
                data: {
                    komut: 'dg',
                    konuid: konu,
                    dk: 'on'
                },
                success: function (data) {
                    document.getElementById('dosyalar').innerHTML = data;
                }
            });
        }

 function unite_getir(tur) {
            $.ajax({
                type: 'post',
                url: '../systemPHP/envanter.php',
                data: {
                    komut: 'ug',
                    turr: tur
                },
                success: function (data) {
                    if (tur == '1') {
                        document.getElementById('uniteler').innerHTML = data;
                    }
                    if (tur == '3') {
                        document.getElementById('kun').innerHTML = "<Select name='unite'>" + data + "</Select>";
                    }
                    if (tur == '2') {
                        document.getElementById('suniteler').innerHTML = data;
                    }
                }
            });
        }

        function konu_getir(unite, tur) {
            $.ajax({
                type: 'post',
                url: '../systemPHP/envanter.php',
                data: {
                    komut: 'kg',
                    turr: tur,
                    uniteid: unite
                },
                success: function (data) {
                    if (tur == '1') {
                        document.getElementById('konular').innerHTML = data;
                    } else {
                        document.getElementById('skonular').innerHTML = data;
                    }
                }
            });
        }
*/

		function istek_onayla (iid,kid)
{
   $.ajax({
        type: 'GET',
        url :'../systemPHP/istekler.php',
        data : { komut:'ik', istekid:iid },
        success : function (data) { document.getElementById("i"+iid).remove(); }
    });
}


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
                         yazilacak += "<div id='dok" + i + "' style='width:100%;padding: 20px 0px 20px 0px;box-shadow:black 0px 0px 1px;'> <img src='../Graphics/svg/koleksiyon.fw.png' width='50' height='50' style='float: left;margin-top: -12px;' /> <p id='dis" + i +"' style='margin-left:20px;float:left;'>" + uniteler[i]['dadi'].substring(0,20) + "</p> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href=javascript:wiewFile('" + uniteler[i]['dosya'] + "') >Göster</a>  <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href='javascript:envanterdenDokumanSil(" + uniteler[i]['did'] + "," + i + ");'> Sil </a> </div>";
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


    </script>
    <script type="text/javascript" language="javascript">
    function ogrenciSorusuGetir (lim)
    {
          $.ajax({
            type : 'POST',
            url : '../systemPHP/sorular.php',
            data :  { komut : 'orsg' , limit : lim },
            success : function (data)
            {
                 ogrencisorulari = $.parseJSON(data);
                var yazilacak="";
                $('#at').html('<div id="ogrkut" style="width: 58%; height: auto; margin-top: -110px; overflow: hidden; background: none repeat scroll 0% 0% rgb(255, 255, 255); padding: 10px; box-shadow: 0px 0px 1px rgb(0, 0, 0); margin-left: -5%;"><div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;"><p onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: Exo, sans-serif;">Derslerinizdeki Öğrencilerin Size Soruları</p></div><div id="ogrsorulist"></div></div>');
                if (data !="[]")
               {
                    for (var i = 0; i <= ogrencisorulari.length -1; i++)
                    {
                        yazilacak +="<div style='margin-left:-1%;width:102%;height: 400px;padding:10px 0px 10px 0px;border-bottom: rgb(228, 228, 228) solid 1px;'><h1 class='baslik' style='margin:0;margin-left: 12px;'><img src='" + ogrencisorulari[i]['res'] + "' style='width:50px;height:50px;border-radius:200px;float:left;' /><p style='margin-top:12px;'>" + ogrencisorulari[i]['user'] + "</p></h1><div style='margin-top:30px;font-family: sans-serif;margin-left:22px;' id='osmet" + i + "'>" + ogrencisorulari[i]['osoruicerik'] + "</div><textarea style='font-family: sans-serif;margin-top:158px;width: 98%;margin-left:1%;position: static;height: 91px;border-left: none;border-right:none;border-top:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;' id='cevap" + i + "' cols='45' rows='5' placeholder='Bu Soruyu Cevaplayın'></textarea><div class='soruonay' onclick='soruCevapla(" + ogrencisorulari[i]['osoruid'] + "," + i + ")' style='position: static;padding: 1px 5px 1px 5px;float: right;margin-right: 2%;margin-top:10px;'>Cevapla</div></div>";
                    }
               }
               else
               {
                  yazilacak+="<h1 class='baslik' style='margin:0;'>Cevap Bekleyen Soru Yok</h1>"
               }
               $('#ogrsorulist').html(yazilacak);
            }
        });
    }


    function soruCevapla (id,tid)
    {
         $.ajax({
            type : 'POST',
            url : '../systemPHP/sorular.php',
            data :  { komut : 'sc' , osid : id , cevap : document.getElementById('cevap' + tid).value },
            success : function (data)
            {
                ogrenciSorusuGetir("0,30");
            }
        });
    }
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

    
</head>
<body>
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
       <p><?php echo $_SESSION['isim']; ?></p>
      </div>
      <div id="akis" class="newLauncherLink">

        <img alt="Akış" src="../Graphics/images/akis.png" />
        <p>Akış</p>
        </div>

        <div id="notlar" class="newLauncherLink">
        <img alt="Notlarınız" src="../Graphics/images/noteicon.png" />
        <p>Dökümanlar</p>
        </div>

        <div id="odevler" class="newLauncherLink">

        <img alt="Ödevlriniz" src="../Graphics/images/odevicon.png" />
         <p>Ödevler
        </div>
        <div id="cevaplar" class="newLauncherLink">

        <img alt="Cevaplar" src="../Graphics/images/cevpicon.png" />
         <p>Sorular</p>
        </div>

</div>
<div class="share">
     <img class="panel_profil_resmi" style="margin-left:10px;" src="<?php echo $_SESSION['resim']; ?>" />
                    <p class="panel_kisi_adi" style="color:black;"><?php echo $_SESSION['isim'] ?>
                    </p>
     <ul class="tabs">
                <li>
                    <input type="radio" checked name="tabs" id="tab1">
                    <label for="tab1" ><img src="../Graphics/images/status.png" width="18px" height="18px" /></label>
                    <div id="tab-content1" class="tab-content animated fadeIn">
                        <textarea id="paykut" class="durumbox" type="text" name="paylasım" placeholder="Bir şeyler yaz.."></textarea>
                        <a href="javascript: akisekle();" class="action-button animate blue">Paylaş</a>
                    </div>
                </li>
                <li>
                    <input type="radio" name="tabs" id="tab2">
                    <label for="tab2"><img src="../Graphics/images/foto.png" width="18px" height="18px" /></label>
                    <div id="tab-content2" class="tab-content animated fadeIn">
                        <input style="margin-left:50px;" type="file"  multiple />
                    </div>
                </li>
                <li>
                    <input type="radio" name="tabs" id="tab3">
                    <label for="tab3"><img src="../Graphics/images/video.png" width="18px" height="18px" /></label>
                    <div id="tab-content3" class="tab-content animated fadeIn">
                        <input style="margin-left:50px;" type="file"  multiple  />
                    </div>
                </li>
            </ul>

</div>
<div class="panel_akis_tasiyici" id="at"></div>
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
