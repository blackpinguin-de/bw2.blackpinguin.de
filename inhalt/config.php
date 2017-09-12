<?php

include_once("/rcl/www/funktionen.php");

if ($err = mysql_init("localhost", "aehtml_shop", "ZCs-cf861KZ7-buGmuk8", "aehtml_shop")) {
    die("<h1>MySQL-Error</h1>" . $err);
}

$verbindung = $rcl->mysqli();

?>
