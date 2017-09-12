<?php
include_once("../../inhalt/config.php");
include_once("../../preisfunktion.php");
$sql  = " SELECT `a`.`artikel_nr` nr, ";
$sql .=     " `a`.`artikel_einzelpreis` preis, ";
$sql .=     " `a`.`artikel_dispositionsstufe` dispo, ";
$sql .=     " SUM(`bd`.`menge`) anzahl ";
$sql .= " FROM artikel a ";
$sql .=     " NATURAL JOIN bestelldetails bd ";
$sql .=     " NATURAL JOIN bestellung b ";
$sql .= " WHERE YEAR(`b`.`bestell_datum`) = YEAR(CURDATE()) ";
$sql .=     " AND `a`.`artikel_dispositionsstufe` < 2 ";
$sql .= " GROUP BY `a`.`artikel_nr` ";

$ranr = array();
$rapreis = array();
$raanzahl = array();

$ergebnis = mysql_query($sql, $verbindung);
while($row = mysql_fetch_object($ergebnis))
	{
	$ranr[] = $row->nr;
	$rapreis[] = dpreis($row->nr, $row->dispo, $row->preis);
	$raanzahl[] = $row->anzahl;
	}
	
$Materialart = $ranr;
$Einstandspreis = $rapreis;
$Jahresverbrauch = $raanzahl;
	
mysql_close($verbindung);	

/*
print_r($Materialart);
print_r($Einstandspreis);
print_r($Jahresverbrauch);
*/
?>
