<?php
include("../funktionen.php");
include("preisfunktion.php");
$fakedseason=mysql_real_escape_string($_GET["season"]);

// wenn season übergeben wird, gucken ob existiert, gucken ob nicht abgelaufen, evtl löschen, zeit aktualisieren
if($fakedseason != "")
        {
        $thistime=time();
        $seasonid=$fakedseason;
        $sqlquery = "SELECT * FROM `season`";
        $sqlresult = mysql_query($sqlquery, $verbindung);
        while($row = mysql_fetch_object($sqlresult))
                {
                if($seasonid==$row->key)
                        {
                        $sqltime=$row->zeit;
                        $sqlseasonuserid=$row->userid;
                        }
                }
        if((strtotime($sqltime))<$thistime)
                {
                $sqlquery = "DELETE FROM `season` WHERE `key` = '$seasonid' LIMIT 1";
                mysql_query($sqlquery, $verbindung);
                $seasonid="";
                $loginerror=1; //season abgelaufen
                }
        else
                {
                $thistime=time();
                $datum=date("Y-m-d H:i:s",($thistime+900));
                $sqlquery = "UPDATE `season` SET `zeit` = '$datum' WHERE `key` = '$seasonid'";
                mysql_query($sqlquery, $verbindung);
                }
        }

//wenn nicht übergeben aber login informationen -> usergucken, passwort gucken, vergleichen, fehlermeldungen etc.
if($fakedseason == "")
        {
        $fakeuser=mysql_real_escape_string($_POST["p_user"]);
        $fakepass=mysql_real_escape_string($_POST["p_pass"]);
        if($fakeuser != "" || $fakepass != "")
                {
                $user = $fakeuser;
                $passwd = $fakepass;
                $sqlquery = "SELECT * FROM `kunden`";
                $sqlresult = mysql_query($sqlquery, $verbindung);
                while($row = mysql_fetch_object($sqlresult))
                        {
                        if(strtoup($row->name) == strtoup($user))
                                {
                                $resultid=$row->id;
                                $sqlseasonuserid=$resultid;
                                $resultpasswd=$row->passwd;
                                }
                        }
                if($resultid!=0)
                        {
						//User existiert
                        if($passwd==$resultpasswd)
                                {
                                $sqlquery = "DELETE FROM `season` WHERE userid='$resultid'";
                                mysql_query($sqlquery, $verbindung);
								srand();
                                //$seasonid=md5(rand(1,pow(rand(2,5),rand(128,256))));
								$seasonid = md5(mt_rand());
                                $sqlquery = "SELECT * FROM `season`";
                                $sqlresult = mysql_query($sqlquery, $verbindung);
                                $fehler=1;
                                while($fehler == 1)
                                        {
										$fehler=0;
                                        while($row = mysql_fetch_object($sqlresult))
                                                {
                                                if($seasonid == $row->key)
                                                        {
														$fehler=1;
													//$seasonid=md5(rand(1,pow(rand(2,5),rand(128,256))));
														$seasonid = md5(mt_rand());
                                                        }
                                                }
                                        }
                                $thistime=time();
                                $datum=date("Y-m-d H:i:s",($thistime+900));
                                $sqlquery = "INSERT INTO `season` ( `userid` , `key` , `zeit` )";
                                $sqlquery .= "VALUES ( '$resultid', '$seasonid', '$datum')";
                                mysql_query($sqlquery, $verbindung);
                                }
                        else
                                {
                                $seasonid="";
                                $loginerror=2; //passwort falsch abgelaufen
                                }
                        }
                else
                        {
                        $seasonid="";
                        $loginerror=3; //user nicht gefunden
                        }
                }
        }


//Ablaufdatum der season updaten, variablen für späteren gebrauch
if($seasonid != "")
        {
        $thistime=time();
        $datum=date("Y-m-d H:i:s",($thistime+900));
        $sqlquery = "UPDATE `season` SET `zeit` = '$datum' WHERE `key` = '$seasonid'";
        mysql_query($sqlquery, $verbindung);

        $headeruserid=$sqlseasonuserid;

        $sqlquery = "SELECT * FROM `kunden` WHERE id=$headeruserid";
        $sqlresult = mysql_query($sqlquery, $verbindung);
        while($row = mysql_fetch_object($sqlresult))
                {
                $headerusername=$row->name;
                }
        // $headeruserid
        // $headerusername
        // $headeruserrang
        }
?>
