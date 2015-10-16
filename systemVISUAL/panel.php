<?php
session_start();


include("../systemPHP/her_sayfada_olan.php");


//$hso = new her_sayfada_olan();
//$hso->mesaj_getir();
//$hso->bildirim_getir();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Uzak Akademi </title>
        <link rel="stylesheet" href="http://localhost/uzakademi.org/systemTHEME/panel.css">
        <link rel="stylesheet" href="http://localhost/uzakademi.org/styles.css">
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

        $(document).ready(function(){
            $(window).disablescroll();
         });

    </script>
    <script language="javascript" type="text/javascript">

    //var dlist = "<?php //for ($i=1;$i<=count($pnl->dersler)-1;$i++){ echo "<a href='ders_goruntuleme.php?dersid=" . $pnl->dersler[$i] ."&dersadi=" . $pnl->dersadlari[$i] ."'><div class='isbox'>" . $pnl->dersadlari[$i] . "</div></a><br />"; }?>";


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
        $('.share').css('display' , 'block');
        akisiyazdir();
     }

     document.getElementById("notlar").onclick = function ()
     {
        /*genislik = screen.availWidth;
        degisecek = document.getElementById("notlar");
        eskiyedonecek = akildaki;
        akildaki= document.getElementById("notlar");
        degistir ();*/
        sonnotlariyazdir();
     }
     document.getElementById("odevler").onclick = function ()
     {
        $('.share').css('display' , 'none');
        odevleriyazdir ();
     }
      document.getElementById("cevaplar").onclick = function ()
     {
       $('.share').css('display' , 'none');
       $('#at').html('<div id="ogrkut" style="width: 58%; height: auto; margin-top: -110px; overflow: hidden; background: none repeat scroll 0% 0% rgb(255, 255, 255); padding: 10px; box-shadow: 0px 0px 1px rgb(0, 0, 0); margin-left: -5%;"><div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;"><p onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: Exo, sans-serif;">Öğretmenlerinize Sorduğunuz Sorular</p></div><div id="ogrsorulist"></div></div>');
        ogrenciSorusuGetir ();
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
                     yeniakissayisi = (msg);
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


        },10000);
    }


function sonnotlariyazdir ()
{
    $('.share').css('display' , 'none');
    $('#at').html('<div id="ntas"><div id="nkut" style="width: 58%; height: auto; margin-top: -110px; overflow: hidden; background: none repeat scroll 0% 0% rgb(255, 255, 255); padding: 10px; box-shadow: 0px 0px 1px rgb(0, 0, 0); margin-left: -5%;"><div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;"><p onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: Exo, sans-serif;">TÜm Notlarınız</p></div><div id="nlist" style="width: 102%;height: 100px;position: relative;margin-left: -1%;"></div></div></div>');
    notGetir();
}
function odevleriyazdir ()
{
  $.ajax({
    type:'POST',
    url:"../systemPHP/panel_odevler.php",
    data:{ komut:"og" },
    success: function(data) { document.getElementById("at").innerHTML = data; }
  });

}

function ogrenciSorusuGetir ()
{
     $.ajax({
       type : 'POST',
       url : '../systemPHP/sorular.php',
       data :  { komut : 'ocg' , cevap:'1' },
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

				function istek_onayla (iid,kid)
{
   $.ajax({
        type: 'GET',
        url :'istekler.php',
        data : { komut:'ik', istekid:iid },
        success : function (data) { document.getElementById("i"+iid).remove(); }
    });
}



function notGetir ()
{
    var yazilacak="";
    $.ajax({
        type : 'POST',
        url : '../systemPHP/not.php',
        data :  { komut : 'sng'  },
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

function notYaz ()
{
 $.ajax({
 type:'POST',
 url:'../systemPHP/not.php',
 data:{ komut:'ne' , seviye:seviyeid , dersid:drsid , not:document.getElementById('not').value , baslik:ders['dersadi'] + " Dersi " + ders['seviyeno'] + ". Seviye" },
 success:function (data) { notGetir(); }
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


</script>

    </head>
<body>
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
                          foreach ($pnl->istekler as $is)
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
        <p>Notlar</p>
        </div>
        <div id="odevler" class="newLauncherLink">

        <img alt="Ödevlriniz" src="../Graphics/images/odevicon.png" />
         <p>Ödevler
        </div>
        <div id="cevaplar" class="newLauncherLink">

        <img alt="Cevaplar" src="../Graphics/images/cevpicon.png" />
         <p>Cevaplar</p>
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
     <?php for ($i=1;$i<=count($_SESSION['dersler'])-1;$i++){ echo "<li><a href='ders_goruntuleme.php?dersid=" . $_SESSION['dersler'][$i] ."&dersadi=" . $_SESSION['dersadlari'][$i] ."'>" . $_SESSION['dersadlari'][$i] . "</a></li>"; }
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
</div>
</body>
</html>
