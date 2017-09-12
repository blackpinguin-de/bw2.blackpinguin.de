<?php
//mysql-verbindung und loginscript includen
include_once("/rcl/www/funktionen.php");
include_once("inhalt/config.php");
include_once("login.php");

//include script Teil 1
$getsite = get("site");
$go = "";
if ($getsite != "")
	{
	$go  = "inhalt/";
	$go .= $getsite;
	$go .= ".php";
	if (! file_exists($go))
		{
		if ($seasonid == "")
			{
			header("Location: index.php?site=404");
			}
		else
			{
			header("Location: index.php?site=404&amp;season=$seasonid");
			}
		exit();
		}
	}
else
	{
	$getsite="home";
	}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="layout.css">
<title>GameZ4you</title>
<script src="extern.js" type="text/javascript"></script>
<script type="text/javascript" language="JavaScript">
var season=<?php echo "\"",$seasonid,"\""; ?>;
var go=<?php echo "\"",$go,"\""; ?>;
</script>

<!-- Google Analytics -->
<script type="text/javascript">
/*
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20756060-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    //ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    ga.src = 'https://bw2.blackpinguin.de/ga.php';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
*/
</script>
<!-- GA end -->


</head>
<body>

<div style="width:765;text-align:left;position:absolute;left:50%;margin-left:-385px;">

<div style="height:120;width:150;position:absolute;background-image:url(img/gz4y.jpg);" class="rahmen"></div>
<div style="height:120;width:605;position:absolute;left:160;background-image:url(img/banner.jpg);" class="rahmen"></div>

<div style="top:130;width:150;position:absolute;" class="rahmen">
	<br>
	<!-- Navigation-->
	<script type="text/javascript">href("?site=home","Home");</script><br>
	<br>
	<script type="text/javascript">href("?site=shop","Shop");</script><br>
	<br>
	<br>
	<br>
	<script type="text/javascript">
		if(season=="")
			{href("?site=register","Registrieren");document.write("<br><br>");href("?site=login","Login");}
		else
			{if(go!="inhalt/logout.php"){href("?site=warenkorb","Warenkorb");document.write("<br><br>");
			href("?site=bestellungen","Bestellungen");document.write("<br><br>");href("?site=profil","Profil");
			document.write("<br><br>");href("?site=logout","Logout");}else{href("?site=reg","Registrieren");
			document.write("<br><br>");href("?site=login","Login");}}
	</script>
	<br><br><br><br>
	<script type="text/javascript">href("?site=agb","AGB");</script><br>
	<br>
	<script type="text/javascript">href("?site=impressum","Impressum");</script>
	<br><br>
</div>

<div style="left:160;top:130;width:605;position:absolute;text-align:left;" class="rahmen">
<!-- Include Script Teil 2--> <?php include_once("include.php"); ?>
</div>
</div>


<div style="font-size:7pt;position:absolute;top:10px;left:10px;width:235px;height:35px;background-color:#000000;color:#FFFFFF;">
Alle Angebote und Angaben auf dieser Seite sind fiktiv.
<br>Angebotene Artikel dienen der illustration der Seite.
<br><a style="color:#00ff00;" href="https://rcl.blackpinguin.de/imprint">Echtes Impressum</a>
</div>



<?php
mysql_close($verbindung);
if($loginerror!=0){
	echo "<script type=\"text/javascript\">";
	if($loginerror==1){echo "alert(\"Fehler $loginerror: season expired\");";} //season abgelaufen
	if($loginerror==2){echo "alert(\"Fehler $loginerror: wrong passwd\");";} //passwort falsch abgelaufen
	if($loginerror==3){echo "alert(\"Fehler $loginerror: user doesn't exist\");";} //user nicht gefunden
	echo "</script>";
	}
?>
</body>
</html>

