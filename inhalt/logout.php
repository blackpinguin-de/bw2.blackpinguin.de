<?php

if($seasonid != "")
	{
	$thistime=time();
	$sqlquery = "SELECT * FROM `season` WHERE `key` = '$seasonid'";
	$sqlresult = mysql_query($sqlquery, $verbindung);
	while($row = mysql_fetch_object($sqlresult))
		{
		$sqlkey = $row->key;
		$sqltime = $row->zeit;
		}


	$sqlquery = "DELETE FROM `season` WHERE `key` = '$seasonid' LIMIT 1";
	mysql_query($sqlquery, $verbindung);
        echo "<br>Sie sind nun ausgeloggt.";
        echo "<br><a href=\"/\">Zur Startseite</a><br><br>";
	}

?>
