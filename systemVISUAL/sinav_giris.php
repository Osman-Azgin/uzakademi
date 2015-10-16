<?php
session_start();
?>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script type="text/javascript" src="../systemJS/jquery-1.11.1.min.js"></script>

    <script language="javascript" type="text/javascript">

        window.onload=sgetir;

        function sgetir ()
        {
            $.ajax({
                type : 'POST',
                url : '../systemPHP/ogrenciDersGoruntuleme.php',
                data :{ cmd:'osg' , seviyeid: "<?php echo $_GET['seviye'] ?>" },
                success : function (data) {
                 var sorular = $.parseJSON(data);
                 var sform=" ";
                 for (var i=0 ; i<= sorular['sorular'].length-1 ; i++)
                 {
                    sform += "<h2>" + sorular['sorular'][i]['sorumet'] + "</h2><br />" + "<p><input type='radio' name ='c" + sorular['sorular'][i]['soruid'] + "' value='a' />" + sorular['sorular'][i]['a'] + "</p><br />";
                    sform += "<p><input type='radio' name ='c" + sorular['sorular'][i]['soruid'] + "' value='b' />" + sorular['sorular'][i]['b'] + "</p><br />";
                    sform += "<p><input type='radio' name ='c" + sorular['sorular'][i]['soruid'] + "' value='c' />" + sorular['sorular'][i]['c'] + "</p><br />"
                    sform += "<p><input type='radio' name ='c" + sorular['sorular'][i]['soruid'] + "' value='d' />" + sorular['sorular'][i]['d'] + "</p><br />"
                 }
                 sform += "<input type='hidden' name='sinavid' value='" + sorular['sinavid'] + "' />";
                 $('#sk').html(sform);
                }
            });

        }
       
		
	function sinav_bitir ()
	{
     $.ajax(
     {
        url : "../systemPHP/ogrenciSinavKontrol.php",
        type: "POST",
        data : $("#osinav").serializeArray(),
        success:function(data)
        {
           document.getElementById('sk').innerHTML=data;
			document.getElementById('sk').innerHTML+="<br /> <a href='ders_goruntuleme.php?dersid=<?php echo $_GET['dersid'] ?>'>Derse git</a>";
			document.getElementById('bitir').remove();
        }
     });
	}


    </script>

</head>


<body>

<form id="osinav" action="dersl_olustur.php" method="POST" >
    <input type="hidden" name="seviyeid" value="<?php echo $_GET['seviye'] ?>" />
    <input type="hidden" name="sevno" value="<?php echo $_GET['sevno'] ?>" />
    <input type="hidden" name="dersid" value="<?php echo $_GET['dersid'] ?>" />
    <input type="hidden" name="sgd" value="<?php echo $_GET['sgd'] ?>" />

  <div id="sk">



  </div>
<a id="bitir" href="javascript: sinav_bitir();">Tamam</a>
</form>

</body>

</html>