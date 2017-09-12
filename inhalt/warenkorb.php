<?php 
$kdnr=$headeruserid;

$artikelnr = [];
$artikelcount = [];
$edartikelnr = [];
$edartikelcount = [];


if($kdnr!="")
{
$artikelnr = ( isset($_POST["artikelnr"]) ? (array) $_POST["artikelnr"] : [] );
$artikelcount = ( isset($_POST["artikelcount"]) ? (array) $_POST["artikelcount"] : [] );

$wkorbcount=0;
for ($i = 0 ; $i < count($artikelnr) ; $i++)
	{
	if ($artikelcount[$i] != 0)
		{
		$abfrage = "REPLACE INTO `warenkorb`";
		$abfrage .= " VALUES('".mysql_real_escape_string($artikelnr[$i])."','$kdnr','".mysql_real_escape_string($artikelcount[$i])."')";
		mysql_query($abfrage, $verbindung);
		$wkorbcount++;
		}
	}
	if($wkorbcount != 0)
	{
	echo "<br>$wkorbcount Artikel hinzugefügt.<br>";
	}





$edartikelnr = ( isset($_POST["edartikelnr"]) ? $_POST["edartikelnr"] : [] );
$edartikelcount = ( isset($_POST["edartikelcount"]) ? $_POST["edartikelcount"] : [] );

if(count($edartikelnr)>0&&count($edartikelcount)>0&&count($edartikelnr)==count($edartikelcount))
	{
	for($i=0;$i<count($edartikelnr);$i++)
		{
		if($edartikelcount[$i]==0)
			{
			$tempatnr=$edartikelnr[$i];
			$abfrage="DELETE FROM `warenkorb` WHERE `artikel_nr`='$tempatnr' AND `kunden_nr`='$kdnr'";
			mysql_query($abfrage, $verbindung);
			}
		else
			{
			$tempatnr=$edartikelnr[$i];
			$tempatcount=$edartikelcount[$i];
			$abfrage = "UPDATE `warenkorb` SET `menge` = '$tempatcount' ";
			$abfrage.= "WHERE `artikel_nr`='$tempatnr' AND `kunden_nr`='$kdnr'";
			mysql_query($abfrage, $verbindung);
			}
		}
	}
}
?>



<script type="text/javascript" language="JavaScript">
var a_nr=new Array();
var a_name=new Array();
var a_preis=new Array();
var a_capacity=new Array();

<?php


$abfrage = " SELECT `w`.`artikel_nr` wan,`w`.`menge` menge, `a`.`artikel_name` name, `a`.`artikel_einzelpreis` preis, ";
$abfrage .= " `a`.`artikel_dispositionsstufe` dispo ";
$abfrage .=" FROM `warenkorb` w INNER JOIN `artikel` a ON `w`.`artikel_nr` = `a`.`artikel_nr` ";
$abfrage .=" WHERE `w`.`kunden_nr` = '$kdnr' ORDER BY `a`.`artikel_name` ";

$ergebnis = mysql_query($abfrage, $verbindung);
$i=0;
while($row = mysql_fetch_object($ergebnis))
	{
	echo "a_nr[",$i,"]=\"",$row->wan,"\";\n";
	echo "a_name[",$i,"]=decodeURIComponent(\"",rawurlencode($row->name),"\");\n";
	$preis = dpreis($row->wan, $row->dispo, $row->preis);
	echo "a_preis[",$i,"]=\"$preis\";\n";
	echo "a_capacity[",$i,"]=\"",$row->menge,"\";\n";

	$i=$i+1;
	}

?>
</script>




<script type="text/javascript" language="JavaScript">

if(a_nr.length!=0)
{
var tempseason="&amp;season="+season+"\" method=\"post\">";

document.write("<br><form action=\"?site=warenkorb"+tempseason);
document.write("<table width=\"100%\">");
document.write("<tr><th>Menge</th><th>Artikel</th><th>ea</th><th>Preis</th></tr>");
var preis=0;
for(i=0; i < a_nr.length;i++)
	{
	document.write("<tr><td><input type=\"hidden\" name=\"edartikelnr[]\" value=\""+a_nr[i]+"\"><input type=\"text\" name=\"edartikelcount[]\" value=\""+a_capacity[i]+"\" size=\"1\" maxlength=\"2\"></td>");
	document.write("<td>");

if(a_name[i].length>45){href("?site=artikel&amp;nr="+a_nr[i],a_name[i].substring(45, 0)+"...");}
else{href("?site=artikel&amp;nr="+a_nr[i],a_name[i]);}

document.write("</td>");
	document.write("<td style=\"text-align:right;\">"+runde(a_preis[i],2)+"¹ €</td>");
	document.write("<td style=\"text-align:right;\">"+runde(runde(a_preis[i],2)*a_capacity[i],2)+"¹ €</td></tr>");
	preis=preis+(runde(a_preis[i],2)*a_capacity[i]);
	}
preis=runde(preis,2)*1;
document.write("</table>");

document.write("<div style=\"text-align:left;\"><input type=\"submit\" value=\"Aktualisieren\"></div>");


document.write("<div style=\"text-align:right;\">Zwischensumme: "+preis+"¹ €&nbsp;&nbsp;</div>");
var mwst = runde(preis*0.19,2)*1;
document.write("<div style=\"text-align:right;\">19% Mehrwertsteuer: +"+mwst+" €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\">Versandkosten: +5.00 €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\"><b>Summe: "+runde(preis+mwst+5,2)+" €&nbsp;&nbsp;</b></div>");
document.write("</form>");

document.write("<form action=\"index.php?site=zahlung"+tempseason);
document.write("<div style=\"text-align:right;\"><input type=\"submit\" value=\"Zur Kasse\"></div>");
document.write("</form><div style=\"text-align:right;\">¹ = ohne mwst.</div>");
}

else
{
document.write("</form>");
document.write("<br>Keine Artikel im Warenkorb.<br><br>");
}

</script>
