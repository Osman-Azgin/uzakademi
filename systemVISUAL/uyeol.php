<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<title>Üye Olun</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script type="text/javascript" src="../systemJS/jquery-1.11.1.min.js"></script>

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
    
    function uyeol ()
    {
       $.ajax({
       type:"POST",
       url:"uyelik_islemleri.php",
       data:$.("#frm").selarize(),
       success:function (data) {
       document.getElementById('frm').innerHTML=data;
       }
       
       });
    }
    
    </script>
</head> 
<body>
<div class="fixedmenu">
            <img style="position:absolute; left:0px; top:-6px;" src="logy.png" width="150" height="75" />
            <h2 style="position:absolute; color:#F60; margin-left:75px; top:-9px;"></h2>
            <a class="link" style="margin-left:39%;" href="#"><img src="svg/home.svg"/><p class="lpr">Anasayfa</p></a>
            <a class="link" href="#"><img src="svg/iletisim.svg"  ><p class="lpr">Iletisim</p></a>
            <a class="link" href="#"> <img src="svg/bilgi.svg" > <p class="lpr">Proje Hakkinda</p></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <p id="giris" class="giris">Giris</p>
            
        </div>
    
<form id="frm" onsubmit="uyeol();" method="post"  enctype="multipart/form-data">
<div  class="frm" style="margin-top:150px;width: 50%;height: auto;overflow: hidden;">
	<input type="text" name="uyeadi" placeholder="Adınız" /><br />
	<input type="text" name="uyesoyadi"  placeholder="Soyadınız" /><br />
	<input type="text" name="eposta"cvalue="<?php echo $_POST['eposta'];  ?>"  placeholder="E-posta" /><br />
	<input type="password" name="pass" value="<?php echo $_POST['pass'];  ?>"   placeholder="sifre" /><br />
	<input type="password" name="passi"  placeholder="Sifre Yeniden" /><br />
	<input type="text" name="user"  placeholder="Kullanıcı adı" value="<?php echo $_POST['user'];  ?>" /><br />
	<input type="file" name="foto" /><br />
	<input type="text" name="brans"  placeholder="Branşınız" /><br />
	<input type="radio" name="yetki" value="1" />Öğretmen<br />
	<input type="radio" name="yetki" value="0" />Öğrenci<br />
	<input type="hidden" name="komut" value="uo" />
	<input type="submit" />
</div>
</form>
</body>