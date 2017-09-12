<?php

$host="localhost";
$dbselect="blackpinguin_shop";
$user="bp_shop";
$pswd="ZCs-cf861KZ7-buGmuk8"; //passwort entfernt

$verbindung = @mysql_connect($host, $user, $pswd);

if(!$verbindung)
	{
	die("<h1>MySQL-Error</h1>".mysql_error());
	}

@mysql_select_db($dbselect, $verbindung);
@mysql_query("set names 'utf8';");

$host="";
$dbselect="";
$user="";
$pswd="";
?>
