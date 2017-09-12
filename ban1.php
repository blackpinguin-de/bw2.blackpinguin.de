<?php
include_once("/rcl/www/funktionen.php");
include_once("inhalt/config.php");

$id = "16";
$s = get("season");

$str = "Location: ./?site=artikel&nr=$id";
if($s != "") $str .= "&season=$s";

header($str);

mysql_close($verbindung);
?>
