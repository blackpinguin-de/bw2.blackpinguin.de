<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Prim&auml;rbedarfsanalyse</title>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">

<style type="text/css">

td,th {
font-size:10pt;
text-align:center;
border-width:2px;
border-style:outset;
border-color:grey;
-moz-border-radius:6px; //rund
padding: 2px 10px 2px 10px ;
}

th {
font-size:14pt;
color:white;
background-color:black;
}

sub {
font-size:8pt;
}


td.a
{
background-color:#888;
}

td.b
{
font-size:12pt;
font-weight:bold;
background-color:#5f5;
}

td.h
{
visibility:hidden;
}


</style>
<script type="text/javascript" src="../extern.js"></script>
</head>
<body>
<h1>Prim&auml;rbedarfsanalyse</h1>
<?php
include_once("../inhalt/config.php");
include_once("/rcl/www/funktionen.php");

$interval_perioden = (int) get("n");
$interval_length = (int) get("m");
$interval_type = get("t");
$alpha = get("a");

//DEFAULTS
if($interval_perioden == 0) $interval_perioden = 4; //so und so viele perioden betrachten
if($interval_length == 0) $interval_length = 1;    //wieviele von type
if($interval_type == "") $interval_type = "MONTH"; //periodentyp
if($alpha == ""){$alpha = (double) 0.5;} //smoothing faktor
else{$alpha = (double) $alpha; }
if($alpha <= (double)0.0) $alpha = (double) 0.0;
if($alpha >= (double)1.0) $alpha = (double) 1.0;
switch ($interval_type)
	{
	case "HOUR"   : break;
	case "MINUTE" : break;
	case "SECOND" : break;
	case "DAY"    : break;
	case "WEEK"   : break;
	case "MONTH"  : break;
	case "YEAR"   ; break;
	default: $interval_type = "MONTH";
	}


echo "\n<h4> n = Anzahl Perioden = $interval_perioden </h4>";
echo "\n<h4> m = Anzahl Zeiteinheiten pro Periode = $interval_length </h4>";
echo "\n<h4> t = Zeit Typ (DAY, MONTH, YEAR, ...) = $interval_type </h4>";
echo "\n<h4> a = &alpha; = $alpha </h4>\n";


$sql0  = " SELECT `a`.`artikel_nr` nr, ";
$sql0 .=     " `a`.`artikel_dispositionsstufe` dispo, ";
$sql0 .=     " SUM(`bd`.`menge`) anzahl ";
$sql0 .= " FROM artikel a ";
$sql0 .=     " NATURAL JOIN bestelldetails bd ";
$sql0 .=     " NATURAL JOIN bestellung b ";
$sql0 .= " WHERE ";
//$sql0 .=     " `b`.`bestell_datum` BETWEEN SUBDATE(CURDATE()+1, INTERVAL ";
$sql0 .=     " `b`.`bestell_datum` BETWEEN SUBDATE(NOW(), INTERVAL ";
// 2 MONTH
//$sql1 = ") AND SUBDATE(CURDATE()+1, INTERVAL "; //CURRDATE()+1 damit Heute auch mit drin.
$sql1 = ") AND SUBDATE(NOW(), INTERVAL ";
// 1 MONTH
$sql2= " ) ";
//$sql2 =     " ) AND `a`.`artikel_dispositionsstufe` < 2 ";
$sql2 .= " GROUP BY `a`.`artikel_nr` ";

$ranr = array();
$raanz = array($interval_perioden);
$ranr[0] = 0;

for( $i = 0; $i < $interval_perioden; $i++)
	{
	$raanz[$i] = array();
	$raanz[$i][0] = 0;
	}

$erg0 = mysql_query( " SELECT `artikel_nr` nr FROM `artikel` ", $verbindung );
while($row = mysql_fetch_object($erg0))
	{
	$ranr[$row->nr] = (int) $row->nr;
	for( $i = 0; $i < $interval_perioden; $i++)
		{
		$raanz[$i][(int)$row->nr] = 0;
		}
	}

for( $i = 0; $i < $interval_perioden; $i++)
	{
	$sql = $sql0.(($i+1)*$interval_length)." ".$interval_type.$sql1.($i*$interval_length)." ".$interval_type.$sql2;
	$erg = mysql_query( $sql, $verbindung );
	while($row = mysql_fetch_object($erg)) { $raanz[$i][(int)$row->nr] = (int)$row->anzahl;}
	}





//print_r($ranr);
//echo "<br><br>";
//print_r($raanz);
$gew = 0; //fuer gewichtung
echo "Periodendauer: ".$interval_length." ".$interval_type;
echo "<table>\n<tr>\n  <th>Nr</th>";
for( $i = $interval_perioden-1; $i >= 0; $i--)
	{
	$gew = $gew + $i+1;
	if($i==0) echo " <th>p<sub>n</sub></th>";
	else echo " <th>p<sub>n-$i</sub></th>";
	}
echo " <th>&Sigma;p<sub>i</sub></th>"; //Summe
echo " <th>&Sigma;(p<sub>i</sub>/n)</th>"; //simple moving average
echo " <th>&Sigma;(p<sub>i</sub>(i/&Sigma;i))</th>"; //weighted moving average
echo " <th>&alpha;p<sub>i</sub>+(1-&alpha;)p<sub>i-1</sub></th>"; //exponential moving average
echo "\n</tr>";
for( $i=1; $i < count($ranr); $i++ )
	{
	$sum1 = 0;
	$sum2 = 0;
	$sum3 = 0;
	$sum4 = 0;
	$tmp2 = 0;
	echo "<tr>\n  <td class='a'>".$ranr[$i]."</td>";
	//schleife begin
	for( $j = $interval_perioden-1; $j >= 0; $j--)
		{
		$tmp = $raanz[$j][$i];
		$tmp2++;
		$sum1 = $sum1 + $tmp;
		$sum3 = $sum3 + $tmp * ($tmp2 / $gew) ;
		$sum4 = $sum4*(1-$alpha) + $alpha*$tmp;
		if($tmp==0){echo " <td class='h'>";}else{echo " <td>";}
		echo $tmp."</td>";
		}
	//schleife end
	echo " <td class='a'>$sum1</td>";
	$sum2 = (((int)$sum1)/((int)$interval_perioden));
	echo " <td class='b'><script type='text/javascript'>document.write(runde($sum2,3));</script></td>";
	echo " <td class='b'><script type='text/javascript'>document.write(runde($sum3,3));</script></td>";
	echo " <td class='b'><script type='text/javascript'>document.write(runde($sum4,3));</script></td>";
	echo "\n</tr>";
	}
echo "</table>";
mysql_close($verbindung);
?>

</body>
</html>
