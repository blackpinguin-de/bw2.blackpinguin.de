<script language="JavaScript">
function checkreg()
{
if(f.ed_user.value!=""&&f.ed_passwd.value!=""&&f.ed_passwdw.value!=""&&f.ed_firstname.value!=""&&f.ed_lastname.value!=""&&f.ed_add.value!=""&&f.ed_plz.value!=""&&f.ed_ort.value!=""&&f.ed_land.value!="")
	{
	if(f.ed_passwd.value==f.ed_passwdw.value)
		{
		return true;
		}
	else
		{
		alert("Passwörter nicht identisch");
		return false;
		}
	}

else
	{
	alert("Bitte alle Felder Ausfüllen");
	return false;
	}

}
</script>




<?php

if(mysql_real_escape_string($_POST['ed_user'])=="")
{
echo "<form name=\"f\" action=\"?site=register\" method=\"post\" onsubmit=\"return checkreg()\">";
echo "<table align=\"center\" width=\"620\">";
echo "<tr><td colspan=\"2\"><h2 class=\"anmeld\">Hier kostenlos Anmelden!<h2></td></tr>";
echo "<tr><td>Benutzername:</td><td class=\"center\"><input type=\"Text\" name=\"ed_user\"></td></tr>";
echo "<tr><td>Passwort:</td><td class=\"center\"><input type=\"Password\" name=\"ed_passwd\"></td></tr>";
echo "<tr><td>Passwort wiederholen:</td><td class=\"center\"><input type=\"Password\" name=\"ed_passwdw\"></td></tr>";
echo "<tr><td>E-Mail:</td><td class=\"center\"><input type=\"Text\" name=\"ed_email\"></td></tr>";
echo "<tr><td>Vorname:</td><td class=\"center\"><input type=\"Text\" name=\"ed_firstname\"></td></tr>";
echo "<tr><td>Nachname:</td><td class=\"center\"><input type=\"Text\" name=\"ed_lastname\"></td></tr>";
echo "<tr><td>Straße und Nummer:</td><td class=\"center\"><input type=\"Text\" name=\"ed_add\"></td></tr>";
echo "<tr><td>PLZ:</td><td class=\"center\"><input type=\"Text\" name=\"ed_plz\"></td></tr>";
echo "<tr><td>Ort:</td><td class=\"center\"><input type=\"Text\" name=\"ed_ort\"></td></tr>";
echo "<tr><td>Land:</td><td class=\"center\"><input type=\"Text\" name=\"ed_land\" value=\"Deutschland\"></td></tr>";
echo "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"but1\" value=\"Bestätigen\">&nbsp;<input type=\"reset\" value=\"Zurücksetzen\"></td></tr></table></form>";
}

else
{
$ch_user=mysql_real_escape_string($_POST['ed_user']);
$ch_pass=mysql_real_escape_string($_POST['ed_passwd']);
$ch_email=mysql_real_escape_string($_POST['ed_email']);
$ch_vorname=mysql_real_escape_string($_POST['ed_firstname']);
$ch_nachname=mysql_real_escape_string($_POST['ed_lastname']);
$ch_add=mysql_real_escape_string($_POST['ed_add']);
$ch_plz=mysql_real_escape_string($_POST['ed_plz']);
$ch_ort=mysql_real_escape_string($_POST['ed_ort']);
$ch_land=mysql_real_escape_string($_POST['ed_land']);

$fehler=false;
$sqlquery = "SELECT `name` FROM `kunden`";
$sqlresult = mysql_query($sqlquery, $verbindung);
while($row = mysql_fetch_object($sqlresult))
	{
	if(strtoup($ch_user)==strtoup($row->name))
		{
		$fehler=true;
		}
	}

if(!$fehler)
	{
	$sqlquery2 = "INSERT INTO `kunden` ";
	$sqlquery2.= "VALUES (NULL , '$ch_user', '$ch_pass', '$ch_email', '$ch_vorname', '$ch_nachname', '$ch_land', '$ch_ort', ";
	$sqlquery2.= "'$ch_plz', '$ch_add', '$ch_vorname', '$ch_nachname', '$ch_land', '$ch_ort', '$ch_plz', '$ch_add')";
	mysql_query($sqlquery2, $verbindung);
	
	echo "<br>Registriert<br><br>";

	}
else
	{
	echo "<br>Benutzer schon vorhanden<br><br>";
	}

}

?>
