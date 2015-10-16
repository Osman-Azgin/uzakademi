<?php
session_start();

class panel
 {

 	public $siniflari;
	private $vtb;
	

     function panel ()
 	{
       $this->siniflari=array("siniflar");
	   $this->dersler=array("dersler");
	   $this->dersadlari=array("dersler");
       $this->vtb = new PDO('mysql:host=localhost;dbname=neduzaka_uzakakademi17', 'neduzaka_root17','Uzakademi2014');

        $cev = $this->sorgula("select * from sinif_secimleri where uyeid =".$_SESSION['id']);
        if ($cev != null )
        {
        foreach ($cev as $c) {
       	 array_push($this->siniflari, $c['sinifid']);
       }
        }
        else
        { $this->siniflari=null;}



        $cev = $this->sorgula("select * from dersler where ogretmenid = " .$_SESSION['id']);
       if ($cev != null )
       {
       foreach ($cev as $c) {
       	 array_push($this->dersler, $c['dersid']);
		 array_push($this->dersadlari, $c['dersadi']);  
       }
        //$_SESSION['dersler']['id']=$this->dersler;
		//$_SESSION['dersler']['ad']=$this->dersadlari;
       }
        else
        { $this->dersler=null; }

   }


     function sorgula ($sorgu)
     {
       if (
       $sorgula=$this->vtb->query($sorgu)
       )
       {
         $donecek = $sorgula->fetchAll();
           return $donecek;
       }
         else { return null; }

     }




     function sorgubul ($secilecektablo,$sinanacakalan,$operator,$liste,$limit,$baglac)
     {

         if (count($liste) > 1){
         $sorgu = $secilecektablo . " where " . $sinanacakalan ." ". $operator ." ". $liste[1];
         $deger = count($liste) - 1;
         for ($i=2; $i <= $deger ; $i++) {
             $sorgu = $sorgu . " " . $baglac . " " . $sinanacakalan. " " . $operator . " " . $liste[$i];
         }
         $sorgu = $sorgu . " limit " . $limit;
         return $sorgu;
         }
         else
         { return null; }
     }


   

 }





$pnl=new panel();

?>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Dersinizi Düzenleyin</title>
    
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
                            yazilacak += "<div id='dok" + i + "' style='width:100%;padding: 20px 0px 20px 0px;box-shadow:black 0px 0px 1px;'> <img src='http://localhost/uzakademi.org/Graphics/svg/koleksiyon.fw.png' width='50' height='50' style='float: left;margin-top: -12px;' /> <p id='dis" + i +"' style='margin-left:20px;float:left;'>" + uniteler[i]['dadi'] + "</p> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href=javascript:wiewFile('" + uniteler[i]['dosya'] + "') >Göster</a> <a style='padding: 4px 10px 4px 10px;border: solid #e5e5e5 1px;border-radius: 15px;margin-left: 12%;color: black;text-decoration: none;' href='javascript:dokumanEkle(" + uniteler[i]['did'] + "," + i + ");'> Ekle </a> </div>";
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


        }); </script>
    <script language="javascript" type="text/javascript">
       var drsid = <?php echo $_GET['dersid']  ?> ;
       var seviye = <?php echo $_GET['seviyeno']  ?> ;
       var seviyeid;
       var ders;
       var sdokumanlar;
       var sorular;
       var odev;
       var odevTeslimleri;
       var ogrenciler;
       var ogrencisorulari;

       window.onload = dersBilgileri;

       function dersBilgileri ()
       {
           $('#dblg').css('display' , 'block');
           $('#dokumantas').css('display' , 'none');
           $.ajax({
               type : 'POST',
               url : '../systemPHP/ogretmenDersGoruntuleme.php',
               data : { cmd : 'dersgetir', dersid : drsid, seviyeno : seviye},
               success : function (data)
               {
                   if(data != "ga")
                   {
                       ders = $.parseJSON(data);
                       document.getElementById('dad').innerHTML += ders['dersadi'];
                       document.getElementById('sevsay').innerHTML += ders['ebsno'];
                       if(ders['sgd']=='s')
                       {
                       	  document.getElementById('sgd').innerHTML += "Sınava Bağlı";
                       	  document.getElementById('odevler').remove();
                       }
                       if(ders['sgd']=='o')
                       {
                       	  document.getElementById('sgd').innerHTML += "Ödeve Bağlı"
                       	  document.getElementById('sinavs').remove();
                       }
                       if(ders['sgd']=='so')
                       {
                       	  document.getElementById('sgd').innerHTML += "Sınava ve Ödeve Bağlı"
                       }
                       for (var i=1;i<=ders['ebsno'];i++)
                       {
                       	  document.getElementById('sevnav').innerHTML += "<a href='ogretmen_ders_goruntuleme.php?dersid=<?php echo $_GET['dersid']; ?>&dersadi=<?php echo $_GET['dersadi']; ?>&seviyeno=" + i + "' style='margin-left: 1%;padding: 10px 10px 10px 10px;box-shadow: black 0px 0px 1px;position: relative;margin-top: 7px;font-family:sans-serif;'>" + i + ".Seviye</a>";
                       }
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
           $('#ogrtas').css('display' , 'none');
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
           $('#ogrtas').css('display' , 'none');
           $('#ogrsorutas').css('display' , 'none');
           seviyedekiSorulariGetir();
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
           $('#ogrtas').css('display' , 'none');
           $('#ogrsorutas').css('display' , 'none');
           odevGetir();
       }

       function ogrenci ()
       {
       	  $('#dblg').css('display' , 'none');
           $('#dokumantas').css('display' , 'none');
           $('.newLauncherLink').css('background' , "#e9eaed");
           $('#akis').css('background' , "white");
           $('#sorutas').css('display' , 'none');
           $('#odevtas').css('display' , 'none');
           $('#ogrsorutas').css('display' , 'none');
           $('#ogrtas').css('display' , 'block');
           ogrenciGetir("0,30");
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
           $('#ogrsorutas').css('display' , 'block');
           ogrenciSorusuGetir("0,30")
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
                      //if (sdokumanlar.length > 1) {
                          for (var i = 0; i<= sdokumanlar.length -1; i++) {
                              yazi += "<div style='float:left;margin-top:10px;margin-left:10px;width:160px;padding:10px 10px 10px 10px;box-shadow:black 0px 0px 1px;border-radius:5px;'><img src='http://localhost/uzakademi.org/Graphics/svg/koleksiyon.fw.png' style='width: 100%;height: 100px;' /> <p style='font-family: Exo, sans-serif;text-align:center;'>" + sdokumanlar[i]['dadi'] + "</p><div style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' onclick='seviyedenDokumanKaldir(" + sdokumanlar[i]['did'] + ")' >Kaldır</div><div onclick=wiewFile('" + sdokumanlar[i]['dosya'] + "') style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' >Göster</div></div>";
                          }
                      //}
                    //  else {
                      //    yazi += "<div style='float:left;margin-top:10px;margin-left:10px;width:160px;padding:10px 10px 10px 10px;box-shadow:black 0px 0px 1px;border-radius:5px;'><img src='http://localhost/uzakademi.org/Graphics/svg/koleksiyon.fw.png' style='width: 100%;height: 100px;' /> <p style='font-family: Exo, sans-serif;text-align:center;'>" + sdokumanlar[0]['dadi'] + "</p><div style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' onclick='seviyedenDokumanKaldir(" + sdokumanlar[0]['did'] + ")' >Kaldır</div><div style='background: #3680b8;width: 100%;text-align: center;padding: 10px 0px 10px 0px;margin-top: 20px;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;box-shadow: #000000 0px 0px 1px;' >Göster</div></div>";
                      //}
                      document.getElementById("doklist").innerHTML = yazi;
                  }
              }
           });
       }


       function seviyedekiSorulariGetir ()
       {
           $.ajax({
               type : 'POST',
               url : '../systemPHP/ogretmenDersGoruntuleme.php',
               data :  { cmd : 'sinavgetir' , seviyeid : ders['seviyeid']  },
               success : function (data)
               {
                   if (data == "soru yok")
                   {

                   }
                   else
                   {
                       var yazilacak = "";
                       sorular = $.parseJSON(data);
                       for (var i =0 ; i <= sorular['sorular'].length - 1;i++)
                       {
                           yazilacak += "<div style='width:90%;margin-left:5%;border-radius:5px;background:white;padding:10px 0px 10px 0px;box-shadow:black 0px 0px 1px;'>" + sorular['sorular'][i]['sorumet'] + "<input type='checkbox' name='ksor" + sorular['sorular'][i]['soruid'] + "' />Bu Soruyu Sorma </div>";

                       }
                       document.getElementById('sorlist').innerHTML=yazilacak;
                       document.getElementById('sinid').value=sorular['sinavid'];
                   }
               }
           });
       }

       function odevGetir ()
       {
           $.ajax({
               type : 'POST',
               url : '../systemPHP/ogretmenDersGoruntuleme.php',
               data :  { cmd : 'odevgetir' , seviyeid : ders['seviyeid']  },
               success : function (data)
               {
                   odev = $.parseJSON(data);
                   document.getElementById('ad').value = odev['odevadi'];
                   CKEDITOR.instances.oac.setData(odev['odevmetni']);
                   document.getElementById('oid').value=odev['odevid'];
                   odevTeslimleriniGetir();
               }
           });
       }

       function odevTeslimleriniGetir ()
       {
       	   $.ajax({
               type : 'POST',
               url : '../systemPHP/ogretmenDersGoruntuleme.php',
               data :  { cmd : 'otgetir' , soid :  odev['odevid'] },
               success : function (data)
               {
               	   if(data=="")
               	   {
                       $('#otkut').html('<h1 class="baslik" style="margin:0;">Puan Bekleyen Ödev Yok</h1>');
               	   }
               	   else
               	   {
                      odevTeslimleri = $.parseJSON(data);
                      for (var i=0;i<=odevTeslimleri.length - 1 ; i++)
                      {
                      	  $('#otkut').html('<form id="not' + i + '" method="get"> <input type="hidden" name="seviyeid" value="' + ders['seviyeid'] + '" /> <input type="hidden" name="dersid" value="' + drsid + '" /> <input type="hidden" name="sevno" value="' + seviye + '" /> <input type="hidden" name="uyeid" value="' + odevTeslimleri[i]['uyeid'] + '" /> <input type="hidden" name="sgd" value="' + ders['sgd'] + '" /> <input type="hidden" name="odevtid" value="' + odevTeslimleri[i]['oid'] + '" /> <div style="padding: 20px 0px 19px 0px;background: #F6F7F8;"><h1 class="baslik" style="margin:0;float:left;text-decoration:none;"><img src="' + odevTeslimleri[i]['foto'] + '" style="margin-top:-12px;float:left;width:50px;height:50px;border-radius:100px;box-shadow:black 0px 0px 1px;" /> &nbsp;' + odevTeslimleri[i]['user'] + '</h1><a class="soruonay" style="margin:0;margin-top: -5px;margin-left: 107px;float:left;padding:1px 1px 1px 1px;position:static;" onclick=wiewFile("' + odevTeslimleri[i]['adres'] + '")>İncele</a><input type="text" name="not" style="height: 40px;margin-top: -11px;margin-left: 158px;" placeholder="Puanı Buraya Yazın" /><input type="hidden" name="cmd" value="odevnot" /><input type="button" onclick="notVer(' + i + ')" value="Not Ver" style="width: 129px;height: 41px; background: none repeat scroll 0% 0% #3680B8;border: 1px solid #A6A6A6; cursor: pointer; border-radius: 2px; color: #FFF; font-family: &quot;Open Sans&quot;,sans-serif; letter-spacing: 1px; font-size: 16px; font-weight: 400; padding: 6px;margin-left: 17px;"></div></form>');
                      }
                   }
               }
           });
       }

       function notVer(form)
		{
            $.ajax({
                type:'POST',
                url:'../systemPHP/dersDuzenle.php',
                data :  $('#not' + form).serializeArray() ,
                success : function (data) { document.getElementById('not' + form).remove(); }
            });
		}

       function ogrenciGetir (lim)
       {
       	   $.ajax({
               type : 'POST',
               url : '../systemPHP/ogretmenDersGoruntuleme.php',
               data :  { cmd : 'oglist' , dersid : drsid , limit : lim },
               success : function (data)
               {
               	   var yazilacak="";
               	   if(data=="")
               	   {
                       $('#ogrsorlist').html('<h1 class="baslik" style="margin:0;">Dersizie Katılmış hiç öğrenci yok</h1>');
               	   }
               	   else
               	   {
                      ogrenciler = $.parseJSON(data);
                      for (var i =0; i <= ogrenciler.length - 1; i++) 
                      {	
                        yazilacak += "<div style='margin-top:25px;width:100%;height:auto;padding:10px 0px 15px 0px;border-bottom:1px solid #e5e5e5;'><a href='kisiProfil.php?usr=" + ogrenciler[i]['user'] + "'><img src='" + ogrenciler[i]['foto'] + "' style='float:left;position:static;width:60px;height:60px;' /><p class='baslik' style='margin-left:1%;margin-top:10px;float:left;'>" + ogrenciler[i]['user'] + "</p></a><a href='ogremenIlerleme.php?usr=" + ogrenciler[i]['user'] + "'><div class='soruonay' style='margin:0;margin-left: 31%;padding:1px 1px 1px 1px;position:static;margin-top: 10px;'>Durum</div></a><p class='baslik' style='font-size:17px;margin:0;margin-left: 56%;float:left;margin-top: -43px;'>" + ogrenciler[i]['starih'] + " Tarihinde Deresinize Katıldı</p></div>";
                      }
                   }
                   $('#ogrsorlist').html(yazilacak);
               }
           });
       }


       function ogrenciSorusuGetir (lim)
       {
       	    $.ajax({
               type : 'POST',
               url : '../systemPHP/sorular.php',
               data :  { komut : 'orsg' , limit : lim , seviye:ders['seviyeid'] },
               success : function (data)
               {
               	   ogrencisorulari = $.parseJSON(data);
                   var yazilacak="";
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



       function seviyedenDokumanKaldir (did)
       {
           $.ajax({
               type : 'POST',
               url : '../systemPHP/dersDuzenle.php',
               data :  { cmd : 'doksil' , seviyeid : ders['seviyeid'] , dosyaid : did },
               success : function (data)
               {
                   if(data != null)
                   {
                       seviyedekiDokumanlariGetir();
                   }
               }
           });
       }


       function seviyeyeDokumanEkle ()
       {
           document.getElementById('sid').value = ders['seviyeid'];
           document.getElementById('dersid').value = drsid;
           $.ajax({
               type : 'POST',
               url : '../systemPHP/dersDuzenle.php',
               data :  $('#ekdata').serializeArray(),
               success : function (data)
               {
                   if(data == "")
                   {
                       seviyedekiDokumanlariGetir();
                   }
               }
           });
       }

       function seviyedekiSinaviDuzenle ()
       {
           //document.getElementById('sinid').value = sorular['sorular'];
           $.ajax({
               type : 'POST',
               url : '../systemPHP/dersDuzenle.php',
               data :  $('#sordata').serializeArray(),
               success : function (data)
               {

                       seviyedekiSorulariGetir();
               }
           });
       }

       function odevGuncelle ()
       {
           $.ajax({
               type : 'POST',
               url : '../systemPHP/dersDuzenle.php',
               data : { obas: document.getElementById('ad').value , oacik : CKEDITOR.instances.oac.getData() , oid : odev['odevid'] , cmd : 'odevduzenle'} ,
               success : function (data)
               {

                   odevGetir();
               }
           });
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
<body style="background-color:#FAFAFA;font-family:'Exo' Sans-serif">
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
        
        <div onclick="ogrenci()" id="akis" class="newLauncherLink">

            <img alt="Akış" src="../Graphics/images/ogricn.png" />
            <p>Öğrenciler</p>
        </div>
        <div onclick="soru()" id="sor" class="newLauncherLink">

            <img alt="sor" src="../Graphics/images/cevpicon.png" />
            <p>Sorular</p>
        </div>
        <div onclick="window.location='ogretmen_seviye_olustur.php?dersid=' + drsid + '&ebsno=' + ders['ebsno'];" id="sekle" style="background: #1E3B6B;width: 40%;height: auto;padding: 10px 30% 10px 30%;margin-top: 10px;" >

            <img style="width: 35px;height: 35px;" alt="sor" src="../Graphics/svg/seicn.png">
            <p style="color: white; width: 250%;text-align: center;font-size: 15px;margin-left: -80%;margin-top: 8px;">Seviye Ekle</p>
        </div>

    </div>

    <div style="width: 75%;margin-top: 58px;margin-left: 135px;margin-bottom:30px;" class="panel_akis_tasiyici" id="at">


     <div id="dersbilgileri">

         <div id="dblg" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
             <div style="width: 100%;padding: 8px 0px 30px 0px;border-bottom: 1px solid #e5e5e5;">
                 <p id="ssec" onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Ders Bilgileri</p>
             </div>
             <h1 style="margin-top: 10px;" id="dad" class="baslik">Dersadı: </h1>
             <h1 style="margin-top: 10px;" id="sevsay" class="baslik">Seviye Sayısı: </h1>
             <h1 style="margin-top: 10px;" id="sgd" class="baslik">Seviye Geçme: </h1>
             <h1 style="margin-top: 10px;"  class="baslik">Şu An Düzenlediğiniz Seviye: <?php echo $_GET['seviyeno']; ?></h1>
             <div style="width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;">
                 <div onclick="ogrenci()" style="margin: 0;position: static;padding: 2px 10px 1px 10px;width:134px" class="soruonay">Öğrencileri Göster</div>
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

            </div
        </div>




        <div style="width: 90%;height: auto;margin-top:45px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <form id="ekdata">
                <input type="hidden" name="sid" value="" id="sid">
                <input type="hidden" name="drsid" value="" id="dersid">
                <input type="hidden" name="cmd" value="dokekle" >
            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p id="dsec" onclick="dokSeEkSecim('s')" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Döküman Seç</p>
                <p id="eklen" onclick="dokSeEkSecim('d')" style="margin-left:30px;float:left;color: #e5e5e5;font-family: 'Exo', sans-serif;">Eklenenler</p>
                <div style='background: #3680b8;width: 200px;text-align: center;padding: 10px 0px 10px 0px;margin-top: -8px;margin-left:50%;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;float:left;box-shadow: #000000 0px 0px 1px;' onclick='seviyeyeDokumanEkle()' >Ekle</div>
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
          </form>
        </div>





    </div>


    <div style="display: none;" id="sorutas">
    <form id="sordata">
        <div id="sorukut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">

            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Seviyedeki Sınav Soruları</p>
                <div style='background: #3680b8;width: 200px;text-align: center;padding: 10px 0px 10px 0px;margin-top: -8px;margin-left:50%;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;float:left;box-shadow: #000000 0px 0px 1px;' onclick='seviyedekiSinaviDuzenle()' >Tamam</div>
            </div>

            <div id="sorlist">

            </div>

            <div style="float:left;width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;"></div>

        </div
    </div>



    <div id="sinkut" style="width: 90%;height: auto;margin-top:45px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
        <input type="hidden" name="sinavid" value="" id="sinid">
        <input type="hidden" name="cmd" value="sinavduzenle" >
        <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
            <p id="ssec" onclick="siSeEkSecim('s')" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Soru Seç</p>
            <p id="seklen" onclick="siSeEkSecim('d')" style="margin-left:30px;float:left;color: #e5e5e5;font-family: 'Exo', sans-serif;">Eklenenler</p>
            <div style='background: #3680b8;width: 200px;text-align: center;padding: 10px 0px 10px 0px;margin-top: -8px;margin-left:50%;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;float:left;box-shadow: #000000 0px 0px 1px;' onclick='seviyedekiSinaviDuzenle()' >Tamam</div>
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
         </form>
            </div>

        </div>


    </div>



<div style="display: none;" id="odevtas">
        <div id="odevkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Seviyedeki Ödevi Düzenleyin</p>
                <div style='background: #3680b8;width: 200px;text-align: center;padding: 10px 0px 10px 0px;margin-top: -8px;margin-left:50%;border-radius: 2px;font-family: Open Sans, sans-serif;color: #ffffff;float:left;box-shadow: #000000 0px 0px 1px;' onclick="odevGuncelle()">Tamam</div>
            </div>

            <div id="odlist">

                <input name="obas" id="ad" type="text" style=" width: 50%; padding: 10px 10px 10px 10px; margin-left: 15%; margin-top: 100px;" placeholder="">
                <textarea name="oacik" style="width: 50%; padding: 10px 10px 10px 10px; margin-left: 0%; margin-top: 200px;" class="ckeditor" id="oac"></textarea>
                <input type="hidden" name="oid" id="oid" />
                <input type="hidden" name="cmd" value="odevduzenle">
            </div>

            <div style="float:left;width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;margin-top: 10px;"></div>
        </div>

    <div id="" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
        <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
            <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Seviyedeki Teslim Edilen Ödevleri Kontrol Edin</p>
        </div>
        <div id="otkut">
         
        </div>
        <div style="float:left;width: 100%;padding: 20px 0px 20px 0px;border-top: 1px solid #e5e5e5;"></div>
    </div>
</div>


<div style="display: none;" id="ogrtas">
    <div id="ogrkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 30px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Dersinizdeki Öğrenciler</p>
            </div>
            <div id="ogrsorlist">
                 
            </div>
        </div>
</div>


<div style="display: none;" id="ogrsorutas">
    <div id="ogrkut" style="width: 90%;height: auto;margin-top:10px;overflow: hidden;background: #ffffff;padding: 10px 10px 10px 10px;margin-left: 20px;box-shadow: #000000 0px 0px 1px;">
            <div style="width: 100%;padding: 8px 0px 41px 0px;border-bottom: 1px solid #e5e5e5;">
                <p onclick="" style=" margin-left: 0px;color: #048CAD; float:left;font-family: 'Exo', sans-serif;">Dersinizdeki Öğrencilerin Size Soruları</p>
            </div>
            <div id="ogrsorulist">
                 
            </div>
        </div>
</div>

<div id="sevnav" style="width: 92%;padding: 20px 0px 20px 0px;background: white;box-shadow: black 0px 0px 1px;margin-top: 30px;margin-left: 2%;margin-bottom:10px;overflow-x:scroll;"></div>


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
