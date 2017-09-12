<?php
include("../inhalt/config.php");
include("../preisfunktion.php");
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
	if($row->dispo > 0){$rapreis[] = preis($row->nr);}
	else{$rapreis[] = $row->preis;}
	$raanzahl[] = $row->anzahl;
	}

print_r($ranr);
print_r($rapreis);
print_r($raanzahl);
?>
