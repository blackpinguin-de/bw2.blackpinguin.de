<script type="text/javascript" language="JavaScript">
var a_artikel=new Array(4);
var a_zusammen=new Array();
<?php
$artikelnr=mysql_real_escape_string($_GET['nr']);

$abfrage1 = "SELECT * FROM `artikel` WHERE `artikel_nr` = '$artikelnr' ";
$ergebnis1 = mysql_query($abfrage1, $verbindung);

$abfrage2  = " SELECT ";
$abfrage2 .=     " `b`.`artikel_nr`, ";
$abfrage2 .=     " `c`.`artikel_name`, ";
$abfrage2 .=     " `c`.`artikel_einzelpreis`, ";
$abfrage2 .=     " COUNT(*) anzahl ";
$abfrage2 .= " FROM ";
$abfrage2 .=     " `bestelldetails` a ";
$abfrage2 .=     " CROSS JOIN `bestelldetails` b ";
$abfrage2 .=     " NATURAL JOIN `artikel` c ";
$abfrage2 .= " WHERE ";
$abfrage2 .=     " `a`.`artikel_nr` != `b`.`artikel_nr` ";
$abfrage2 .=     " AND `a`.`artikel_nr` = '$artikelnr' ";
$abfrage2 .=     " AND `a`.`bestell_nr` = `b`.`bestell_nr` ";
$abfrage2 .=     " AND `c`.`artikel_dispositionsstufe` <= '1' ";
$abfrage2 .= " GROUP BY `b`.`artikel_nr` ";
$abfrage2 .= " ORDER BY anzahl DESC ";
$abfrage2 .= " LIMIT 0, 13 ";
$ergebnis2 = mysql_query($abfrage2, $verbindung);


while($row = mysql_fetch_object($ergebnis1))
	{
	$nr = $row->artikel_nr;
	$name = rawurlencode($row->artikel_name);
	$desc = rawurlencode($row->artikel_beschreibung);
	$dispo = $row->artikel_dispositionsstufe;
	$preis = $row->artikel_einzelpreis;
	$preis = dpreis($nr, $dispo, $preis);
	echo "a_artikel[0]=\"$nr\";\n";
	echo "a_artikel[1]=decodeURIComponent(\"$name\");\n";
	echo "a_artikel[2]=decodeURIComponent(\"$desc\");\n";
	echo "a_artikel[3]=\"$preis\";\n";
	}

$i=0;
while($row = mysql_fetch_object($ergebnis2))
	{
	echo "a_zusammen[$i]=new Array(4);\n";
	echo "a_zusammen[$i][0]=\"",$row->artikel_nr,"\";\n";
	echo "a_zusammen[$i][1]=decodeURIComponent(\"",rawurlencode($row->artikel_name),"\");\n";
	echo "a_zusammen[$i][2]=\"",$row->artikel_einzelpreis,"\";\n";
	echo "a_zusammen[$i][3]=\"",$row->anzahl,"\";\n";
	$i++;
	}

?>
</script>



<!-- Beispiel implementation -->



<?php
echo "<form action=\"?site=warenkorb";
if($seasonid != ""){echo "&amp;season=",$seasonid;}
echo "\" method=\"post\">";
?>

<script type="text/javascript" language="JavaScript">
var clientheigh=200;
document.write("<div id=\"overadiv\" style=\"height:"+clientheigh+";width:605;position:relative;text-align:center;left:50%;margin-left:-303px;\"><br>");

document.write("<div class=\"shop\" style=\"width:590;top:5;left:5;position:absolute;\">"+a_artikel[1]+"</div>");
document.write("<div class=\"shop\" style=\"width:91;height:120;top:32;left:5;position:absolute;\"><img src=\"artikel/"+a_artikel[0]+".jpg\" alt=\"bild\"></div>");

document.write("<div id=\"artikelb\" class=\"shop\" style=\"width:489;top:32;left:105;position:absolute;text-align:left;\">"+a_artikel[2]+"</div>");

tempoh = document.getElementById("artikelb").offsetHeight;
if(tempoh <= 120) tempoh = 120;

tempwkh=35+tempoh;
tempwkhe=17;

if(season!="")
	{
	document.write("<div id=\"zumwk\" style=\"text-align:left;width:200;top:"+(tempwkh+2)+";left:410;position:absolute;\">");
	document.write("<input type=\"hidden\" name=\"artikelnr[]\" value=\""+a_artikel[0]+"\">");
	document.write("<input type=\"text\" name=\"artikelcount[]\" value=\"1\" size=\"1\" maxlength=\"2\">");
	document.write("<input type=\"submit\" name=\"submitti\" value=\"In den Warenkorb\">");
	document.write("</div>");
	tempwkh=tempwkh+33;
	tempwkhe=tempwkhe+6;
	}



document.write("<div class=\"shop\" style=\"height:"+tempwkhe+";width:100;top:"+(35+document.getElementById("artikelb").offsetHeight)+";left:105;position:absolute;\">");
document.write("Artikel-Preis: </div>");

document.write("<div class=\"shop\" style=\"height:"+tempwkhe+";width:185;top:"+(35+document.getElementById("artikelb").offsetHeight)+";left:215;position:absolute;\">");
document.write(runde(a_artikel[3],2)+"¹ €</div>");

var tempo3=0;
if(season!="")
	{
	tempo3=28;
	}
else
	{
	tempo3=8;
	}

if( a_zusammen.length > 0 )
	{
	tempo3=tempo3+90;
	document.write("<div style=\"top:"+(tempwkhe+48+tempoh)+";left:5;position:absolute;\">Oft zusammen gekauft mit:</div>");
	document.write("<div class=\"shop\" style=\"width:"+(a_zusammen.length*(45.5)+1)+";top:"+(tempwkhe+65+tempoh)+";height:64;left:5;position:absolute;\">");

	var tmpk = 0;
	for (var i = 0; i < a_zusammen.length; ++i)
		{
		tmpk = ((tmpk*1)+(a_zusammen[i][3]*1))*1;
		}
	for (var i = 0; i < a_zusammen.length; ++i)
		{
		var tmpid    = a_zusammen[i][0];
		var tmpname  = a_zusammen[i][1];
		if(tmpname.length>47) { tmpname = tmpname.substring(47,0) + "..."; }
		var tmpcount = a_zusammen[i][3];
		var tmpproz = 100/tmpk*tmpcount;
		tmpname = tmpname + " - " + runde(tmpproz,2) + " %";

		var tmpbild = "<img src=\"artikel/small/"+(tmpid)+".jpg\" alt=\""+(tmpname)+"\" style=\"margin-left:1px;\" >";
		hreft("?site=artikel&amp;nr="+tmpid, tmpname, tmpbild);
		//document.write("<a href=\"?site=artikel&nr="+(tmpid)+"\" title=\""+(tmpname)+"\">");
		//document.write("<img src=\"artikel/small/"+(tmpid)+".jpg\" alt=\""+(tmpname)+"\" style=\"margin-left:1px;\" >");
		//document.write("</a>");
		}
	document.write("</div>");
	}


document.getElementById("overadiv").style.height =tempwkhe+25+tempo3+(tempoh);

document.write("<div style=\"text-align:right;top:"+(tempwkh)+";left:496;position:absolute;\">¹ = ohne mwst.</div>");


document.write("</div>");




</script>
</form>

