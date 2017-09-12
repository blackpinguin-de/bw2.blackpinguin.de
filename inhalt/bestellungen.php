<script type="text/javascript" language="JavaScript">
var b_nr=new Array();
var b_datum=new Array();
var b_preis=new Array();
var b_bezahlt=new Array();

<?php
$kdnr=$headeruserid;

$abfrage1 = "SELECT `bestell_nr` bnr, `bestell_datum` bd, `bezahlt` ";
$abfrage1 .="FROM `bestellung` ";
$abfrage1 .="WHERE `kunden_nr` = '$kdnr' ORDER BY `bestell_datum`";
$ergebnis1 = mysql_query($abfrage1, $verbindung);
$i=0;
while($row1 = mysql_fetch_object($ergebnis1))
	{
	$bestell_nr=$row1->bnr;
	$bestell_datum=$row1->bd;
	$bezahlt = $row1->bezahlt;

	$artikelpreis=0;
	$abfrage2  = "SELECT `einzelpreis` ap, `menge` am ";
	$abfrage2 .= "FROM `bestelldetails` WHERE `bestell_nr` = '$bestell_nr'";
	$ergebnis2 = mysql_query($abfrage2, $verbindung);
	while($row2 = mysql_fetch_object($ergebnis2))
		{
		$einzelpreis=$row2->ap;
		$menge=$row2->am;
		$artikelpreis=$artikelpreis+($menge*$einzelpreis);
		}

	echo "b_nr[",$i,"]=\"",$bestell_nr,"\";\n";
	echo "b_datum[",$i,"]=\"",$bestell_datum,"\";\n";
	echo "b_preis[",$i,"]=\"",$artikelpreis,"\";\n";
	echo "b_bezahlt[",$i,"]=\"",$bezahlt,"\";\n";
	$i=$i+1;
	}
?>
</script>



<script type="text/javascript" language="JavaScript">

if(b_nr.length!=0)
{
document.write("<table width=\"100%\" align=\"center\"><tr><th>Bestellnr</th><th>Bestell Zeitpunkt</th><th>Status</th><th>Preis</th></tr>");
for(i=0;i<b_nr.length;i++)
	{
	document.write("<tr><td style=\"text-align:center;\">");
	href("?site=bestelldetails&amp;id="+b_nr[i],(b_nr[i]));
	document.write("</td>");
	document.write("<td style=\"text-align:center;\">");
	href("?site=bestelldetails&amp;id="+b_nr[i],(b_datum[i]));
	document.write("</td>");
	document.write("<td style=\"text-align:center;\">");
	if(b_bezahlt[i] == 0) document.write("offen");
	else document.write("bezahlt");
	document.write("</td>");
	document.write("<td style=\"text-align:center;\">"+(runde(((b_preis[i]*1.19)+5),2))+"</td></tr>");
	}
document.write("</table>");
}
else
{
document.write("<br>keine Bestellungen<br><br>");
}


</script>
