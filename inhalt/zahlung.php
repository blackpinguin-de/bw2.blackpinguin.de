<script type="text/javascript" language="JavaScript">
var a_nr=new Array();
var a_name=new Array();
var a_preis=new Array();
var a_capacity=new Array();

<?php
$kdnr=$headeruserid;


$abfrage  = " SELECT `w`.`artikel_nr` wan,`w`.`menge` menge, `a`.`artikel_name` name, `a`.`artikel_einzelpreis` preis, ";
$abfrage .= " `a`.`artikel_dispositionsstufe` dispo ";
$abfrage .= " FROM `warenkorb` w INNER JOIN `artikel` a ON `w`.`artikel_nr` = `a`.`artikel_nr` ";
$abfrage .= " WHERE `w`.`kunden_nr` = '$kdnr' ORDER BY `a`.`artikel_name` ";

$ergebnis = mysql_query($abfrage, $verbindung);
$i=0;
while($row = mysql_fetch_object($ergebnis))
	{
	echo "a_nr[",$i,"]=\"",$row->wan,"\";\n";
	echo "a_name[",$i,"]=decodeURIComponent(\"",rawurlencode($row->name),"\");\n";
	$preis = dpreis($row->wan, $row->dispo, $row->preis);
	echo "a_preis[",$i,"]=runde(\"$preis\",2);\n";
	echo "a_capacity[",$i,"]=\"",$row->menge,"\";\n";
	
	$i=$i+1;
	}

?>
</script>




<script type="text/javascript" language="JavaScript">
var liefer=new Array(6);
var rechnung=new Array(6);
var tempr=new Array(6);
var tempb=new Array(6);
var temprschalter=0; 
var tempbschalter=0; 

function zur()
{
tempbschalter=0;
temprschalter=0;
f.ed_r_firstname.disabled=false;
f.ed_r_lastname.disabled=false;
f.ed_r_add.disabled=false;
f.ed_r_plz.disabled=false;
f.ed_r_ort.disabled=false;
f.ed_r_land.disabled=false;
f.rwiel.disabled=false;	
}

function rwol()
{

if(f.rwiel.checked)
	{
	if(temprschalter==0)
		{
	tempr[0]=f.ed_r_firstname.value;
	tempr[1]=f.ed_r_lastname.value;
	tempr[2]=f.ed_r_add.value;
	tempr[3]=f.ed_r_plz.value;
	tempr[4]=f.ed_r_ort.value;
	tempr[5]=f.ed_r_land.value;

	f.ed_r_firstname.value=f.ed_l_firstname.value;
	f.ed_r_lastname.value=f.ed_l_lastname.value;
	f.ed_r_add.value=f.ed_l_add.value;
	f.ed_r_plz.value=f.ed_l_plz.value;
	f.ed_r_ort.value=f.ed_l_ort.value;
	f.ed_r_land.value=f.ed_l_land.value;

	f.ed_r_firstname.disabled=true;
	f.ed_r_lastname.disabled=true;
	f.ed_r_add.disabled=true;
	f.ed_r_plz.disabled=true;
	f.ed_r_ort.disabled=true;
	f.ed_r_land.disabled=true;
		temprschalter=1;
		}
	}
else
	{
	if(temprschalter==1)
		{
	f.ed_r_firstname.value=tempr[0];
	f.ed_r_lastname.value=tempr[1];
	f.ed_r_add.value=tempr[2];
	f.ed_r_plz.value=tempr[3];
	f.ed_r_ort.value=tempr[4];
	f.ed_r_land.value=tempr[5];

	f.ed_r_firstname.disabled=false;
	f.ed_r_lastname.disabled=false;
	f.ed_r_add.disabled=false;
	f.ed_r_plz.disabled=false;
	f.ed_r_ort.disabled=false;
	f.ed_r_land.disabled=false;
		temprschalter=0;
		}
	}
}








function barvor()
{
if(f.ed_zahlungsart[1].checked)
	{
	if(tempbschalter==0)
		{
		f.rwiel.disabled=true;	
		f.artdzahlung.value="1";

		tempb[0]=f.ed_r_firstname.value;
		tempb[1]=f.ed_r_lastname.value;
		tempb[2]=f.ed_r_add.value;
		tempb[3]=f.ed_r_plz.value;
		tempb[4]=f.ed_r_ort.value;
		tempb[5]=f.ed_r_land.value;

		f.ed_r_firstname.value=f.ed_l_firstname.value;
		f.ed_r_lastname.value=f.ed_l_lastname.value;
		f.ed_r_add.value=f.ed_l_add.value;
		f.ed_r_plz.value=f.ed_l_plz.value;
		f.ed_r_ort.value=f.ed_l_ort.value;
		f.ed_r_land.value=f.ed_l_land.value;

		f.ed_r_firstname.disabled=true;
		f.ed_r_lastname.disabled=true;
		f.ed_r_add.disabled=true;
		f.ed_r_plz.disabled=true;
		f.ed_r_ort.disabled=true;
		f.ed_r_land.disabled=true;
		tempbschalter=1;
		}
	}
else
	{
	if(tempbschalter==1)
		{
		f.rwiel.disabled=false;
		f.artdzahlung.value="0";

		f.ed_r_firstname.value=tempb[0];
		f.ed_r_lastname.value=tempb[1];
		f.ed_r_add.value=tempb[2];
		f.ed_r_plz.value=tempb[3];
		f.ed_r_ort.value=tempb[4];
		f.ed_r_land.value=tempb[5];

		if(f.rwiel.checked == false)
		{f.ed_r_firstname.disabled=false;
		f.ed_r_lastname.disabled=false;
		f.ed_r_add.disabled=false;
		f.ed_r_plz.disabled=false;
		f.ed_r_ort.disabled=false;
		f.ed_r_land.disabled=false;}
		tempbschalter=0;
		}
	}
}









<?php
$kdnr=$headeruserid;

$abfrage2 = "SELECT 
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
$ergebnis = mysql_query($abfrage2);
while($row = mysql_fetch_object($ergebnis))
	{
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

	echo "<form action=\"?site=boverview&amp;season=$seasonid\" method=\"post\" name=\"f\">";

?>




<script type="text/javascript" language="JavaScript">

if(season!="")
{
document.write("<table align=\"center\" width=\"620\">");

document.write("<tr><th>Zahlungsart</th><td colspan=\"2\"><input type=\"radio\" name=\"ed_zahlungsart\" value=\"1\" onclick=\"barvor()\" checked> Vorkasse</td></tr>");
document.write("<tr><th></th><td colspan=\"2\"><input type=\"radio\" name=\"ed_zahlungsart\" value=\"0\" onclick=\"barvor()\"> Bar Nachnahme</td></tr>");



document.write("<tr><td colspan=\"2\"></td><td><input type=\"checkbox\" name=\"rwiel\" onclick=\"rwol()\" value=\"1\"> Rechnungs wie Lieferadresse</td></tr>");


document.write("<tr><th></th><th>Lieferadresse</th><th>Rechnungsadresse</th></tr>");

document.write("<tr>");
document.write("<th>Vorname:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_firstname\" value=\"",liefer[0],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_firstname\" value=\"",rechnung[0],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Nachname:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_lastname\" value=\"",liefer[1],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_lastname\" value=\"",rechnung[1],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Straße u. Hausnr.:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_add\" value=\"",liefer[5],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_add\" value=\"",rechnung[5],"\"></td>");
document.write("</tr>");

document.write("<tr><th>PLZ:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_plz\" value=\"",liefer[4],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_plz\" value=\"",rechnung[4],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Ort:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_ort\" value=\"",liefer[3],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_ort\" value=\"",rechnung[3],"\"></td>");
document.write("</tr>");

document.write("<tr><th>Land:</th>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_l_land\" value=\"",liefer[2],"\"></td>");
document.write("<td class=\"center\"><input type=\"Text\" name=\"ed_r_land\" value=\"",rechnung[2],"\"></td>");
document.write("</tr>");

document.write("<tr><td colspan=\"3\" align=\"center\">");
document.write("<input type=\"reset\" value=\"Reset\" onclick=\"zur();\">&nbsp;<input type=\"submit\" name=\"but1\" value=\"Weiter\">");
document.write("</td></tr></table>");
}


for(i=0; i < a_nr.length; i++)
	{
	document.write("<input type=\"hidden\" name=\"artikelnr[]\" value=\""+a_nr[i]+"\">");
	document.write("<input type=\"hidden\" name=\"artikelname[]\" value=\""+a_name[i]+"\">");
	document.write("<input type=\"hidden\" name=\"artikelpreis[]\" value=\""+a_preis[i]+"\">");
	document.write("<input type=\"hidden\" name=\"artikelcount[]\" value=\""+a_capacity[i]+"\">");
	}


</script>
<input type="hidden" name="artdzahlung" value="0">

</form>
