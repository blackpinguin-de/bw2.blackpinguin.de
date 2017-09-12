<script type="text/javascript" language="JavaScript">
var a_nr=new Array();
var a_name=new Array();
var a_preis=new Array();
var a_capacity=new Array();

<?php
if($seasonid!="")
{
$kdnr=$headeruserid;
$bestell_nr=mysql_real_escape_string($_GET['id']);

$abfrage1  = " SELECT `bestell_art` ba, `bestell_datum` bd, `bezahlt` bb ";
$abfrage1 .= " FROM `bestellung` ";
$abfrage1 .= " WHERE `bestell_nr` = '$bestell_nr' ";
$abfrage1 .= " AND `kunden_nr` = '$kdnr' ";
$ergebnis1 = mysql_query($abfrage1, $verbindung);
$i=0;
while($row1 = mysql_fetch_object($ergebnis1))
	{
	$bestell_datum=$row1->bd;
	$bestell_art=$row1->ba;
	$bezahlt = $row1->bb;
	echo "var b_nr=\"",$bestell_nr,"\";\n";
	echo "var b_datum=\"",$bestell_datum,"\";\n";
	echo "var b_art=\"",$bestell_art,"\";\n";
	echo "var b_bezahlt=\"",$bezahlt,"\";\n";
	$i=$i+1;
	}





$abfrage3  = "SELECT `b`.`artikel_nr` anr, `b`.`einzelpreis` ap, `b`.`menge` am, `a`.`artikel_name` an ";
$abfrage3 .= "FROM `bestelldetails` b INNER JOIN `artikel` a ON `b`.`artikel_nr` = `a`.`artikel_nr` ";
$abfrage3 .= "WHERE `b`.`bestell_nr` = '$bestell_nr' ORDER BY `a`.`artikel_name`";
$ergebnis3 = mysql_query($abfrage3, $verbindung);
$i=0;
while($row3 = mysql_fetch_object($ergebnis3))
	{
	$anr=$row3->anr;
	$aname=rawurlencode($row3->an);
	$einzelpreis=$row3->ap;
	$menge=$row3->am;

	echo "a_nr[",$i,"]=\"",$anr,"\";\n";	
	echo "a_name[",$i,"]=decodeURIComponent(\"",$aname,"\");\n";	
	echo "a_preis[",$i,"]=\"",$einzelpreis,"\";\n";
	echo "a_capacity[",$i,"]=\"",$menge,"\";\n";
	$i=$i+1;
	}

}
?>
</script>



<script type="text/javascript" language="JavaScript">
if(b_nr!="")
{


document.write("<table width=\"100%\" align=\"center\">");

document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Bestell-Nr.:</th><td style=\"text-align:left;\">"+b_nr+"</td></tr>");
document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Bestell-Zeitpunkt:</th><td style=\"text-align:left;\">"+b_datum+"</td></tr>");
document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Zahlungsart:</th><td style=\"text-align:left;\">");
if(b_art==0){document.write("Vorkasse");} if(b_art==1){document.write("Bar-Nachnahme");}
document.write("<tr><th style=\"text-align:left;\" width=\"30%\">Status:</th><td style=\"text-align:left;\">");
if(b_bezahlt==0){document.write("offen");} if(b_bezahlt==1){document.write("bezahlt");}

var b_endpreis=0;
for(i=0;i<a_nr.length;i++)
	{
	b_endpreis=b_endpreis+(a_preis[i]*a_capacity[i]);
	}
document.write("</td></tr><tr><th style=\"text-align:left;\" width=\"30%\">Gesammtpreis:</th><td style=\"text-align:left;\">"+runde(((b_endpreis*1.19)+5),2)+" €</td></tr>");

document.write("</table><br>");






document.write("<table width=\"100%\" align=\"center\"><tr><th>Nr</th><th>Artikel</th><th>Menge</th><th>ea</th><th>Preis</th></tr>");
var preis=0;
for(i=0;i<a_nr.length;i++)
	{
	document.write("<tr><td style=\"text-align:center;\">"+a_nr[i]+"</td>");
	document.write("<td style=\"text-align:center;\">");
	if(a_name[i].length>42){href("?site=artikel&amp;nr="+a_nr[i],a_name[i].substring(42, 0)+"...");}
	else{href("?site=artikel&amp;nr="+a_nr[i],a_name[i]);}

	document.write("</td><td style=\"text-align:center;\">"+a_capacity[i]+"</td>");
	document.write("<td style=\"text-align:right;\">"+a_preis[i]+" €</td>");
	document.write("<td style=\"text-align:right;\">"+runde(a_preis[i]*a_capacity[i],2)+" €</td></tr>");
	preis=preis+(a_preis[i]*a_capacity[i]);
	}
document.write("</table><br>");

document.write("<div style=\"text-align:right;\">Zwischensumme: "+runde(preis,2)+" €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\">19% Mehrwertsteuer: +"+runde(preis*0.19,2)+" €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\">Versandkosten: +5.00 €&nbsp;&nbsp;</div>");
document.write("<div style=\"text-align:right;\"><b>Endpreis: "+runde(preis+(preis*0.19)+5,2)+" €&nbsp;&nbsp;</b></div>");



}
</script>
