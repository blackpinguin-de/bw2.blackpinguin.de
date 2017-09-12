<script type="text/javascript" language="JavaScript">
var a_nr=new Array();
var a_name=new Array();
var a_preis=new Array();
var a_capacity=new Array();
var preis=0;

var liefer=new Array(6);
var rechnung=new Array(6);

<?php 
$kdnr=$headeruserid;

if($kdnr!="")
{
$artikelnr = $_POST["artikelnr"];
$artikelname = $_POST["artikelname"];
$artikelpreis = $_POST["artikelpreis"];
$artikelcount = $_POST["artikelcount"];

for($i=0;$i<count($artikelnr);$i++)
	{
	echo "a_nr[",$i,"]=\"",mysql_real_escape_string($artikelnr[$i]),"\";\n";
	echo "a_name[",$i,"]=\"",mysql_real_escape_string($artikelname[$i]),"\";\n";
	echo "a_preis[",$i,"]=\"",mysql_real_escape_string($artikelpreis[$i]),"\";\n";
	echo "a_capacity[",$i,"]=\"",mysql_real_escape_string($artikelcount[$i]),"\";\n";
	}
}

echo "var zahlungsart=\"",mysql_real_escape_string($_POST['artdzahlung']),"\";\n";
echo "var rwielo=\"",mysql_real_escape_string($_POST['rwiel']),"\";\n";

echo "rechnung[0]=\"",mysql_real_escape_string($_POST['ed_r_firstname']),"\";\n";  
echo "rechnung[1]=\"",mysql_real_escape_string($_POST['ed_r_lastname']),"\";\n"; 
echo "rechnung[2]=\"",mysql_real_escape_string($_POST['ed_r_land']),"\";\n";
echo "rechnung[3]=\"",mysql_real_escape_string($_POST['ed_r_ort']),"\";\n"; 
echo "rechnung[4]=\"",mysql_real_escape_string($_POST['ed_r_plz']),"\";\n";
echo "rechnung[5]=\"",mysql_real_escape_string($_POST['ed_r_add']),"\";\n"; 

echo "liefer[0]=\"",mysql_real_escape_string($_POST['ed_l_firstname']),"\";\n"; 
echo "liefer[1]=\"",mysql_real_escape_string($_POST['ed_l_lastname']),"\";\n"; 
echo "liefer[2]=\"",mysql_real_escape_string($_POST['ed_l_land']),"\";\n";
echo "liefer[3]=\"",mysql_real_escape_string($_POST['ed_l_ort']),"\";\n"; 
echo "liefer[4]=\"",mysql_real_escape_string($_POST['ed_l_plz']),"\";\n";
echo "liefer[5]=\"",mysql_real_escape_string($_POST['ed_l_add']),"\";\n";





?>
</script>




<?php

	echo "<form action=\"?site=confirm&amp;season=$seasonid\" method=\"post\">";

?>


<script type="text/javascript" language="JavaScript">

if(zahlungsart=="1")
	{
	for(i=0;i<6;i++)
		{
		rechnung[i]=liefer[i];
		}
	}

if(zahlungsart=="0")
	{
	
	if(rwielo=="1")
		{
		for(i=0;i<6;i++)
			{
			rechnung[i]=liefer[i];
			}
		}
	}


if(season!="")
{
document.write("<table align=\"center\" width=\"100%\">");
document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Zahlungsart:</th><td>");
if(zahlungsart==0){document.write("Vorkasse");}
if(zahlungsart==1){document.write("Bar Nachnahme");}
document.write("</td></tr>")
document.write("</table><br>");


document.write("<table align=\"center\" width=\"100%\">");
document.write("<tr><th></th><th style=\"text-align:left;\">Lieferadresse</th><th style=\"text-align:left;\">Rechnungsadresse</th></tr>");

document.write("<tr>");
document.write("<th style=\"text-align:left;\" width=\"30%\">Vorname:</th>");
document.write("<td >",liefer[0],"</td>");
document.write("<td >",rechnung[0],"</td>");
document.write("</tr>");

document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Nachname:</th>");
document.write("<td>",liefer[1],"</td>");
document.write("<td>",rechnung[1],"</td>");
document.write("</tr>");

document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Straße u. Hausnr.:</th>");
document.write("<td>",liefer[5],"</td>");
document.write("<td>",rechnung[5],"</td>");
document.write("</tr>");

document.write("<tr><th style=\"text-align:left;\" width=\"30%\">PLZ:</th>");
document.write("<td>",liefer[4],"</td>");
document.write("<td>",rechnung[4],"</td>");
document.write("</tr>");

document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Ort:</th>");
document.write("<td>",liefer[3],"</td>");
document.write("<td>",rechnung[3],"</td>");
document.write("</tr>");

document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Land:</th>");
document.write("<td>",liefer[2],"</td>");
document.write("<td>",rechnung[2],"</td>");
document.write("</tr>");
document.write("</table><br>");




document.write("<table align=\"center\" width=\"100%\">");

document.write("<tr><th>Menge</th><th>Artikel</th><th>ea</th><th>Preis</th></tr>");
for(i=0; i < a_nr.length; i++)
	{
	document.write("<tr><td style=\"text-align:center;\">"+a_capacity[i]+"</td>");
	document.write("<td style=\"text-align:center;\">");if(a_name[i].length>45){document.write(a_name[i].substring(45, 0)+"...");}else{document.write(a_name[i]);}document.write("</td>");

	document.write("<td style=\"text-align:right;\">"+runde(a_preis[i],2)+" €</td>");
	document.write("<td style=\"text-align:right;\">"+runde(a_preis[i]*a_capacity[i],2)+" €</td></tr>");
	preis=preis+(a_preis[i]*a_capacity[i]);
	}
document.write("</table><br>");


document.write("<div style=\"text-align:right;\">Zwischensumme: "+runde(preis,2)+" €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\">19% Mehrwertsteuer: +"+runde(preis*0.19,2)+" €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\">Versandkosten: +5.00 €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\"><b>Summe: "+runde(preis+(preis*0.19)+5,2)+" €&nbsp;&nbsp;</b></div>");
document.write("<div style=\"text-align:right;\"><input type=\"submit\" name=\"but1\" value=\"Bestellen\"></div>");




document.write("<input type=\"hidden\" name=\"artdzahlung\" value=\""+zahlungsart+"\">");
for(i=0; i < a_nr.length; i++)
	{
	document.write("<input type=\"hidden\" name=\"artikelnr[]\" value=\""+a_nr[i]+"\">");
	document.write("<input type=\"hidden\" name=\"artikelpreis[]\" value=\""+a_preis[i]+"\">");
	document.write("<input type=\"hidden\" name=\"artikelcount[]\" value=\""+a_capacity[i]+"\">");
	}
for(i=0;i<6;i++)
	{
	document.write("<input type=\"hidden\" name=\"arechnung[]\" value=\""+rechnung[i]+"\">");
	document.write("<input type=\"hidden\" name=\"aliefer[]\" value=\""+liefer[i]+"\">");
	}

}
</script>
</form>
