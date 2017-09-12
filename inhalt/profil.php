<script type="text/javascript" language="JavaScript">
var liefer=new Array(6);
var rechnung=new Array(6);

<?php
$kdnr=$headeruserid;



$profilseite = mysql_real_escape_string($_POST['profilseite']);
if($profilseite!="")
{

$email = mysql_real_escape_string($_POST['ed_email']);
$r_firstname = mysql_real_escape_string($_POST['ed_r_firstname']);
$l_firstname = mysql_real_escape_string($_POST['ed_l_firstname']);
$r_lastname = mysql_real_escape_string($_POST['ed_r_lastname']);
$l_lastname = mysql_real_escape_string($_POST['ed_l_lastname']);
$r_add = mysql_real_escape_string($_POST['ed_r_add']);
$l_add = mysql_real_escape_string($_POST['ed_l_add']);
$r_plz = mysql_real_escape_string($_POST['ed_r_plz']);
$l_plz = mysql_real_escape_string($_POST['ed_l_plz']);
$r_ort = mysql_real_escape_string($_POST['ed_r_ort']);
$l_ort = mysql_real_escape_string($_POST['ed_l_ort']);
$r_land = mysql_real_escape_string($_POST['ed_r_land']);
$l_land = mysql_real_escape_string($_POST['ed_l_land']);


$abfrage = "UPDATE `kunden` SET 
`kunden_email` = '$email', 
`kunden_rechnung_vorname` = '$r_firstname', 
`kunden_lieferung_vorname` = '$l_firstname', 
`kunden_rechnung_nachname` = '$r_lastname', 
`kunden_lieferung_nachname` = '$l_lastname', 
`kunden_rechnung_strasse` = '$r_add', 
`kunden_lieferung_strasse` = '$l_add', 
`kunden_rechnung_plz` = '$r_plz', 
`kunden_lieferung_plz` = '$l_plz', 
`kunden_rechnung_ort` = '$r_ort', 
`kunden_lieferung_ort` = '$l_ort', 
`kunden_rechnung_land` = '$r_land', 
`kunden_lieferung_land` = '$l_land' 
";
$abfrage .= "WHERE `id`='$kdnr'";
mysql_query($abfrage, $verbindung);		
}


$abfrage2 = "SELECT 
name, 
kunden_email, 
kunden_rechnung_vorname,  
kunden_rechnung_nachname, 
kunden_rechnung_land, 
kunden_rechnung_ort, 
kunden_rechnung_plz, 
kunden_rechnung_strasse, 
kunden_lieferung_vorname, 
kunden_lieferung_nachname, 
kunden_lieferung_land, 
kunden_lieferung_ort, 
kunden_lieferung_plz, 
kunden_lieferung_strasse ";
$abfrage2 .="FROM `kunden` ";
$abfrage2 .="WHERE `id` = '$kdnr'";
$ergebnis = mysql_query($abfrage2, $verbindung);
while($row = mysql_fetch_object($ergebnis))
	{
	echo "username=decodeURIComponent(\"",rawurlencode($row->name),"\");\n";
	echo "email=decodeURIComponent(\"",rawurlencode($row->kunden_email),"\");\n";
	echo "rechnung[0]=decodeURIComponent(\"",rawurlencode($row->kunden_rechnung_vorname),"\");\n";  
	echo "rechnung[1]=decodeURIComponent(\"",rawurlencode($row->kunden_rechnung_nachname),"\");\n"; 
	echo "rechnung[2]=decodeURIComponent(\"",rawurlencode($row->kunden_rechnung_land),"\");\n";
	echo "rechnung[3]=decodeURIComponent(\"",rawurlencode($row->kunden_rechnung_ort),"\");\n"; 
	echo "rechnung[4]=decodeURIComponent(\"",rawurlencode($row->kunden_rechnung_plz),"\");\n";
	echo "rechnung[5]=decodeURIComponent(\"",rawurlencode($row->kunden_rechnung_strasse),"\");\n"; 

	echo "liefer[0]=decodeURIComponent(\"",rawurlencode($row->kunden_lieferung_vorname),"\");\n"; 
	echo "liefer[1]=decodeURIComponent(\"",rawurlencode($row->kunden_lieferung_nachname),"\");\n"; 
	echo "liefer[2]=decodeURIComponent(\"",rawurlencode($row->kunden_lieferung_land),"\");\n";
	echo "liefer[3]=decodeURIComponent(\"",rawurlencode($row->kunden_lieferung_ort),"\");\n"; 
	echo "liefer[4]=decodeURIComponent(\"",rawurlencode($row->kunden_lieferung_plz),"\");\n";
	echo "liefer[5]=decodeURIComponent(\"",rawurlencode($row->kunden_lieferung_strasse),"\");\n";
	}

?>
</script>



<?php

	echo "<br><form action=\"?site=profil&amp;season=$seasonid\" method=\"post\">";

?>

<script type="text/javascript" language="JavaScript">


if(season!="")
{
document.write("<table align=\"center\" width=\"620\">");


document.write("<tr><th>Benutzername:</th><td class=\"center\" colspan=\"2\">");
document.write("<input type=\"Text\" name=\"ed_user\" value=\"",username,"\" readonly>");
document.write("</td></tr>");

document.write("<tr><th>E-Mail:</th><td class=\"center\" colspan=\"2\">");
document.write("<input type=\"Text\" name=\"ed_email\" value=\"",email,"\">");
document.write("</td></tr>");

document.write("<tr><td>&nbsp;</td></tr>");

document.write("<tr><th></th><th>Rechnungsadresse</th><th>Lieferadresse</th></tr>");

document.write("<tr>");
document.write("<th>Vorname:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_firstname\" value=\"",rechnung[0],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_firstname\" value=\"",liefer[0],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Nachname:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_lastname\" value=\"",rechnung[1],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_lastname\" value=\"",liefer[1],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Straße u. Hausnr.:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_add\" value=\"",rechnung[5],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_add\" value=\"",liefer[5],"\"></td>");
document.write("</tr>");

document.write("<tr><th>PLZ:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_plz\" value=\"",rechnung[4],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_plz\" value=\"",liefer[4],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Ort:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_ort\" value=\"",rechnung[3],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_ort\" value=\"",liefer[3],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Land:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_land\" value=\"",rechnung[2],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_land\" value=\"",liefer[2],"\"></td>");
document.write("</tr>");

document.write("<tr><td colspan=\"3\" align=\"center\">");
document.write("<input type=\"reset\" value=\"Reset\">&nbsp;<input type=\"submit\" name=\"but1\" value=\"Bestätigen\">");
document.write("</td></tr></table>");
}

</script>
<input type="hidden" name="profilseite" value="1">
</form>
