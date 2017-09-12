<html>
<head>
</head>
<body>


<?php
include_once("../inhalt/config.php");
include_once("../preisfunktion.php");

function stueckliste($artnr, $artname, $menge, $dispo)
{
echo "<tr>";
echo "<td>$artnr</td>";
echo "<td>$artname</td>";
echo "<td>$menge</td>";
echo "<td>$dispo</td>";
echo "</tr>";

$sql = "SELECT * FROM `struktur` s CROSS JOIN `artikel` a WHERE `a`.`artikel_nr` = `s`.`unter_id` AND `ober_id` = '$artnr' ";
$res = mysql_query($sql);
while($row = mysql_fetch_object($res))
	{
	$tartnr = $row->artikel_nr;
	$tartname = $row->artikel_name;
	$tmenge = $row->menge;
	$tdispo = $dispo+1;
	stueckliste($tartnr, $tartname, $tmenge, $tdispo);
	}
}

echo "<table border=\"1\">";
echo "<tr>";
echo "<th>Teile-Nr</th>";
echo "<th>Bezeichnung</th>";
echo "<th>Menge</th>";
echo "<th>Dispositionsstufe</th>";
echo "</tr>";

$abfrage  = " SELECT * FROM `artikel` WHERE `artikel_dispositionsstufe` <= '1' ";
$ergebnis = mysql_query($abfrage, $verbindung);
while($row = mysql_fetch_object($ergebnis))
	{
	stueckliste($row->artikel_nr, $row->artikel_name, "", 0);
	}

echo "</table>";

/*
$abfrage  = " SELECT `a`.`artikel_nr`, `a`.`artikel_name`, `a`.`artikel_einzelpreis`, `a`.`artikel_dispositionsstufe`, ";
$abfrage .= " SUM(`bd`.`menge`) menge, SUM(`bd`.`menge` * `bd`.`einzelpreis`) umsatz ";
$abfrage .= " FROM `artikel` a";
$abfrage .= " RIGHT JOIN `bestelldetails` bd ON `a`.`artikel_nr` = `bd`.`artikel_nr` ";
$abfrage .= " GROUP BY `a`.`artikel_nr` ";
$ergebnis = mysql_query($abfrage, $verbindung);
$i=0;
while($row = mysql_fetch_object($ergebnis))
	{
	echo "a_nr[",$i,"]=\"",$row->artikel_nr,"\";\n";
	echo "a_name[",$i,"]=decodeURIComponent(\"",rawurlencode($row->artikel_name),"\");\n";
	echo "a_preis[",$i,"]=\"";
	echo dpreis($row->artikel_nr, $row->artikel_dispositionsstufe, $row->artikel_einzelpreis);
	echo "\";\n";
	//echo "a_dispo[",$i,"]=\"",$row->artikel_dispositionsstufe,"\";\n";
	echo "a_menge[",$i,"]=\"",$row->menge,"\";\n";
	echo "a_umsatz[",$i,"]=\"",$row->umsatz,"\";\n";
	$i=$i+1;
	}
*/
mysql_close($verbindung);
?>






<script type="text/javascript" language="JavaScript">

//document.write("<table>");
//document.write("<tr> <th>Nr</th> <th>Name</th> <th>Preis</th> <th>Menge</th> <th>Umsatz</th> </tr>");

//for(i=0; i < a_nr.length;i++)
//{
//document.write("<tr> <td>"+(a_nr[i])+"</td> <td>"+(a_name[i])+"</td> <td>"+(runde(a_preis[i],2))+"</td> <td>"+(a_menge[i])+"</td> <td>"+(a_umsatz[i])+"</td> </tr>");
//}
//document.write("</table>");


</script>

</body>
</html>
