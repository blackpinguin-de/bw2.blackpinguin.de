<?php





$kdnr=$headeruserid;
$thistime=time();$datum=date("Y-m-d H:i:s",$thistime);
$zahlungsart = post("artdzahlung");

$arechnung = $_POST["arechnung"]; //array
$aliefer   = $_POST["aliefer"]; //array

for($i=0;$i<6;$i++)
	{
	$rechnung[$i] = mysql_real_escape_string($arechnung[$i]);
	$liefer[$i]   = mysql_real_escape_string($aliefer[$i]);
	}

$city    = $rechnung[3];
$state   = $rechnung[4];
$country = $rechnung[5];


$abfr1  = "INSERT INTO `bestellung` ";
$abfr1 .= "VALUES('', '$kdnr', '$datum', '', '$zahlungsart', ";

$abfr1 .= "'$rechnung[0]', '$rechnung[1]', '$rechnung[2]', '$rechnung[3]', '$rechnung[4]', '$rechnung[5]', ";
$abfr1 .= "'$liefer[0]', '$liefer[1]', '$liefer[2]', '$liefer[3]', '$liefer[4]', '$liefer[5]')";
mysql_query($abfr1, $verbindung);

$abfr2 = "SELECT `bestell_nr` FROM `bestellung` WHERE `kunden_nr`='$kdnr' AND `bestell_datum`='$datum'";
$ergb = mysql_query($abfr2, $verbindung);
while($row = mysql_fetch_object($ergb))
	{
	$bestellnr=$row->bestell_nr;
	}



$artikelnr = $_POST["artikelnr"]; //array
$artikelpreis = $_POST["artikelpreis"]; //array
$artikelcount = $_POST["artikelcount"]; //array
$total = 0;
$gaitems = "";

for($i=0;$i<count($artikelnr);$i++)
	{
	$nr = mysql_real_escape_string($artikelnr[$i]);
	$preis = mysql_real_escape_string($artikelpreis[$i]);
	$count = mysql_real_escape_string($artikelcount[$i]);
	$total = $total + $preis;

	$gaitems .= "\n  _gaq.push(['_addItem','$bestellnr','$nr','$nr','','$preis','$count']);";

	$abfr3  = "INSERT INTO `bestelldetails` ";
	$abfr3 .= "VALUES('$bestellnr','$nr','$count','$preis')";
	mysql_query($abfr3, $verbindung);
	}



$abfr4 = "DELETE FROM `warenkorb` WHERE `kunden_nr`='$kdnr'";
mysql_query($abfr4, $verbindung);

echo "<br>Bestellung abgeschickt";


if($zahlungsart=="0")
	{
	echo "<br><br>Sie bezahlen per Vorkasse.<br>Überweisen Sie den Rechnungsbetrag auf unser Konto.";
	echo "<br>Nach Eingang des Geldes erfolgt die Lieferung an Sie.";
	echo "<br><br><b>Unsere Bankdaten:</b>";
	echo "<br><b>Eigentümer:</b> GameZ4you AG";
	echo "<br><b>Kontonr.:</b> 1234567890";
	echo "<br><b>Bank:</b> Hamburger Sparkasse";
	echo "<br><b>Bankleitzahl:</b> 20050550";
	echo "<br><b>Verwendungszweck:</b> AE00",$bestellnr,"HTML<br><br>";

	}

if($zahlungsart=="1")
	{
	echo "<br><br>Sie bezahlen per Bar Nachnahme.<br>Halten Sie bei der Lieferung den entsprechende Rechnungsbetrag bereit,";
	echo "<br> und geben sie ihn dem Lieferanten.<br><br>";
	}

//GOOGLE Analytics
/*
$storename = "GameZ4you";
$tax = $total * 0.19;
$shipping = 5;
$total = $total + $tax + $shipping;


echo "\n<script type=\"text/javascript\">";
echo "\n  _gaq.push(['_addTrans','$bestellnr','$storename',runde($total,2),runde($tax,2),runde($shipping,2),'$city','$state','$country']);";
echo $gaitems;
echo "\n  _gaq.push(['_trackTrans']);";
echo "\n</script>";
*/


?>
