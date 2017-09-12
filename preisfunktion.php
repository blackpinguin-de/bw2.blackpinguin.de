<?php
//include("inhalt/config.php");

function  anz_unter( $artikel_nr ) {
$sql = " SELECT * FROM `struktur` s WHERE `s`.`ober_id` = '$artikel_nr' ";
$res = mysql_query($sql);
return mysql_num_rows($res);
}

//artikel einzelpreis
function  art_preis( $artikel_nr ) {
$sql = " SELECT `artikel_einzelpreis` FROM `artikel` WHERE `artikel_nr` = '$artikel_nr' ";
$res = mysql_query($sql);
while($row = mysql_fetch_object($res))
	{
	$result = $row->artikel_einzelpreis;
	}
return $result;
}


function  preis( $artikel_nr ) {
if( anz_unter($artikel_nr) == 0 )
	{
	//einzelpreis
	return art_preis($artikel_nr);
	}
else
	{
	$preis = art_preis($artikel_nr);
	$sql = " SELECT * FROM `struktur` s WHERE `s`.`ober_id` = '$artikel_nr' ";
	$res = mysql_query($sql);
	while($row = mysql_fetch_object($res))
		{
		$n = $row->menge;
		$id = $row->unter_id;
		$pr = preis($id); //REKURSION
		$preis = $preis + ( $n * $pr );
		}
	return $preis;
	}
}

//dispocheck preis
function dpreis($artikel_nr, $dispo, $artikel_einzelpreis)
{
if($dispo == 0 ) return $artikel_einzelpreis;
if( anz_unter($artikel_nr) == 0 ) return $artikel_einzelpreis;

$preis = $artikel_einzelpreis;
$sql = " SELECT * FROM `struktur` s WHERE `s`.`ober_id` = '$artikel_nr' ";
$res = mysql_query($sql);
while($row = mysql_fetch_object($res))
	{
	$n = $row->menge;
	$id = $row->unter_id;
	$pr = preis($id); //REKURSION
	$preis = $preis + ( $n * $pr );
	}
return $preis;
}


/*
//echo anz_unter("20");
echo preis("20");
echo "<br>";
echo preis("21");
echo "<br>";
echo preis("22");
echo "<br>";
echo preis("23");
echo "<br>";
echo preis("24");
echo "<br>";
echo preis("25");

mysql_close($verbindung);
*/
?>
