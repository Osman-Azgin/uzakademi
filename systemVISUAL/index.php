<?php
 session_start();

 session_destroy();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Uzak Akademi</title>
    <link rel="stylesheet" href="../systemTHEM/homepage.css">
    <script src="../systemJS/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#signup_form").hide();
            $("#forgot_form").hide(); 
            $("#minilogo").hide();
            $("#kayit").click(function() {
                $("#login_form").slideToggle();
                $("#signup_form").delay(250).fadeIn();
                $("#login_form").hide();
            });
            $("#giris").click(function() {
                $("#signup_form").slideToggle();
                $("#login_form").delay(250).fadeIn();
                $("#signup_form").hide();
            });
            $("#unuttum").click(function() {
                $("#login_form").slideToggle();
                $("#forgot_form").delay(250).fadeIn();
                $("#login_form").hide();
            });
            $("#geri").click(function() {
                $("#forgot_form").slideToggle();
                $("#login_form").delay(250).fadeIn();
                $("#forgot_form").hide();
            });
            $('#uc, #iki').click(function() {
                $("#minilogo").delay(500).fadeIn();
            });

        });
    </script>

</head>

<body>
    <div class="wrap">

        <div class="header">
       <a href="#one"> <img src="../Graphics/images/yenilogo.png" alt=""  id="minilogo" class="minilogo"></a>
        <ul><li><a id="uc" href="#two">Hakkımızda</a></li><li><a id="iki" href="#three">Nasıl çalışır?</a></li></ul>


         <section>
  <div class="carousel">
    <a id="one"></a>
    <a id="two"></a>
    <a id="three"></a>
    <div class="carousel-container">
      <div class="carousel-inner">
        <figure>
          <img src="../Graphics/images/yenilogo.png" alt="" class="logo">
          <p style="color:white;font-family:'Exo' sans-serif;text-shsdow:black 0px 0px 1px;margin-top: -11px;font-size: 17px;margin-left: 80px;">Eğitimin Eğlenceli Olduğu Bir Yer Hayal Edin</p>
        </figure>
        <figure>
         <h2 style="color:white;font-family:'Exo' sans-serif;text-shsdow:black 0px 0px 1px;">Hakkımızda</h2>
         <p style="color:white;font-family:'Exo' sans-serif;text-shsdow:black 0px 0px 1px;">Uzakademi.org Karma Eğitim Projesi kapsamında geliştirilen bir web sitesidir.Sistemi amacı bilişim tenolojilerini eğitim adına etkin şekilde kullanmak ve böylece öğrencilerin ders çalışma miktarını arttırmaktır.Aynı şekilde okula gidemeyecek yetişkin isnanlara eğitim verilebilir. <br /> <br />Mehmet Akif Ersoy Mesleki Teknik Anadolu Lisesi (c) <br />Geliştiriler : Osman Azgın - Uğur Yaşar Koçal <br />Rehber Öğretmen : Ümit Demir</p>
        </figure>
        <figure>
          <h2 style="color:white;font-family:'Exo' sans-serif;text-shsdow:black 0px 0px 1px;">Nasıl Çalışır?</h2>
          <p style="color:white;font-family:'Exo' sans-serif;text-shsdow:black 0px 0px 1px;">->Kayıt Olun <br /> <br />->Ders Oluşturun/Derse Kaydolun<br /> <br />->Seviyeler Oluşturun/Seviye Geçin<br /> <br />->Ödev Verin-Ödev Teslim Edin<br /> <br />->Yeni ve Etkili Bir Yöntemle Eğitim Verin/Alın</p>
        </figure>
      </div>
    </div>

  </div>

</section>

        </div>
        <div class="circle">

            <div class="login">

                <form action="../systemPHP/redirect.php" method="post" id="login_form">
                    <p class="baslik">Giriş Yap</p>
                    <input type="text" placeholder="Kullanıcı Adı" name="kullaniciadi">
                    <br>
                    <input type="password" placeholder="Şifre" name="sifre">
                    <br>
                    <input type="submit" value="Giriş">
                    <a href="#unuttum" id="unuttum">Şifrenizi Mi Unuttunuz?</a>
                    <br>
                    <a href="#kayit" id="kayit">Kayıt Olun</a>
                </form>
                <form method="post" action="uyeol.php" id="signup_form">
                    <p class="baslik">Kayıt Ol</p>
                    <input type="text" placeholder="E-posta" name="email">
                    <br>
                    <input type="text" placeholder="Kullanıcı Adı" name="user">
                    <br>
                    <input type="password" placeholder="Şifre" name="password">
                    <br>
                    <input type="submit" value="Kayıt Ol">
                    <a href="#giris" id="giris">Zaten Üye Misiniz?</a>
                </form>
                <form method="post" id="forgot_form">
                    <p class="baslik">Şifre İsteyin</p>
                    <input type="text" placeholder="E-Posta Adresiniz" name="user">
                    <br>
                    <input type="button" value="Gönder">
                    <br>
                    <a href="#giris" id="geri">Geri Dön</a>
                </form>
            </div>

        </div>
    </div>
</body>

</html>






