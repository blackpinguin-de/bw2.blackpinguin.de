<?php 
$search = post("search");
if($search==""){$search = get("search");}
?>
<br>

<script type="text/javascript">
function searchClick(){
    document.forms.search.action = document.forms.search.action + "&search=" + document.forms.search.search.value;
    if(season!="") document.forms.search.action = document.forms.search.action + "&season=" + season;
    return true;
}
</script>

<div style="text-align:center;">
<form name="search" action="?site=shop" method="post">
<input type="text" name="search" value="<?php echo $search; ?>" size="50" maxlength="40">
<input type="submit" name="submitti" value="Suche" onclick="searchClick();">
<br>


<?php

		//Seitenanzahl zaehlen
		$pageacount=8;
		$abb  = " SELECT * ";
		$abb .= " FROM `artikel` ";
		$abb .= " WHERE `artikel_dispositionsstufe` <= '1' ";
		$abb .= " AND ( `artikel_name` LIKE '%$search%' ";
		$abb .= " OR `artikel_beschreibung` LIKE '%$search%' ) ";
		$erb = mysql_query($abb, $verbindung);
		$postcount = 0;
		while($row = mysql_fetch_object($erb))
			{
			$postcount++;
			}
        $maxpages = ceil($postcount/$pageacount);

		//welche Seite anzeigen?
		//keine Seite -> Seite 1
        $page = ((int) get("page")) ?: 1;
        $pageb = $page;

		//Seitennummerierung
		if($maxpages>1)
			{
			$vor    = "<a href=\"?site=shop";
			if($search!=""){$vor .= "&amp;search=$search";}
			$vor   .= "&amp;page=";
			$mitte  = "";
			if($seasonid!=""){$mitte = "&amp;season=$seasonid";}
			$mitte .= "\">";
			$nach   = "</a> ";
			$rcl->page($maxpages,4,$pageb,$vor,$mitte,$nach);
			}
        $page--;
        $page=$page*$pageacount;
?>

</form>
</div>




<script type="text/javascript" language="JavaScript">
var a_nr=new Array();
var a_name=new Array();
var a_preis=new Array();
<?php
//Artikel abfrage (JavaScript-Array)
$abfrage  = " SELECT `artikel_nr`,`artikel_name`,`artikel_einzelpreis`, `artikel_dispositionsstufe` ";
$abfrage .= " FROM `artikel` ";
$abfrage .= " WHERE `artikel_dispositionsstufe` <= '1' ";
$abfrage .= " AND ( `artikel_name` LIKE '%$search%' ";
$abfrage .= " OR `artikel_beschreibung` LIKE '%$search%' ) ";
$abfrage .= " ORDER BY `artikel_name` ";
$abfrage .= " LIMIT $page , $pageacount ";
$ergebnis = mysql_query($abfrage, $verbindung);
$i=0;
while($row = mysql_fetch_object($ergebnis))
	{
	$art_id    = $row->artikel_nr;
	$art_name  = $row->artikel_name;
	$art_preis = $row->artikel_einzelpreis;
	$art_dispo = $row->artikel_dispositionsstufe;
	echo "a_nr[",$i,"]=\"",$art_id,"\";\n";
	echo "a_name[",$i,"]=decodeURIComponent(\"",rawurlencode($art_name),"\");\n";
	echo "a_preis[",$i,"]=\"",dpreis($art_id, $art_dispo, $art_preis),"\";\n";
	//echo "a_preis[",$i,"]=\"",$row->artikel_einzelpreis,"\";\n";

	$i=$i+1;
	}

?>
</script>






<?php
$siteheight=($i*75)+70;
if($i==0){$siteheight=$siteheight+30;}
if($seasonid!=""){$siteheight=$siteheight+30;}

echo "<div style=\"width:605;height:",$siteheight,";position:relative;text-align:center;left:50%;margin-left:-303px;\"><br>"; 


echo "<form action=\"?site=warenkorb";
if($seasonid != ""){echo "&amp;season=$seasonid";}
echo "\" method=\"post\">";
?>

<!-- Beispiel implementation -->
<script type="text/javascript" language="JavaScript">

var aw=440;
var leftb=455;
var abw=387;

if(season=="")
	{
	aw=aw+55;
	leftb=leftb+55;
	abw=abw+55;
	}


document.write("<div class=\"shop\" style=\"width:"+aw+";top:15;left:5;position:absolute;\">Artikel</div>");
document.write("<div class=\"shop\"  style=\"width:80;top:15;left:"+leftb+";position:absolute;\">Preis</div>");
if(season!=""){document.write("<div class=\"shop\"  style=\"width:50;top:15;left:545;position:absolute;\">Menge</div>");}


var hoehe=45;
for(i=0; i < a_nr.length;i++)
{

document.write("<div class=\"shop\" style=\"height:62;width:43;top:"+hoehe+";left:5;position:absolute;\">");
href("?site=artikel&amp;nr="+a_nr[i],"<img align=\"left\" src=\"artikel/small/"+a_nr[i]+".jpg\" alt=\"bild\">");
document.write("</div>");

document.write("<div class=\"shop\" style=\"height:62;width:"+abw+";top:"+hoehe+";left:57;position:absolute;\"><br>");
if(a_name[i].length>47){href("?site=artikel&amp;nr="+a_nr[i],a_name[i].substring(47, 0)+"...");}
else{href("?site=artikel&amp;nr="+a_nr[i],a_name[i]);}
document.write("</div>");

document.write("<div class=\"shop\" style=\"height:62;width:80;top:"+hoehe+";left:"+leftb+";position:absolute;text-align:right;\"><br><nobr>"+runde(a_preis[i],2)+"¹ €</nobr></div>");



if(season!="")
	{
	document.write("<div class=\"shop\" style=\"height:62;width:50;top:"+hoehe+";left:545;position:absolute;\">");
	document.write("<br><input type=\"hidden\" name=\"artikelnr[]\" value=\""+a_nr[i]+"\">");
	document.write("<input type=\"text\" name=\"artikelcount[]\" value=\"0\" size=\"1\" maxlength=\"2\">");
	document.write("</div>");
	}


hoehe=hoehe+75;
}

if(a_nr.length==0)
	{
	document.write("<div style=\"text-align:center;top:"+(hoehe)+";left:5;width:590;position:absolute;\">Keine Artikel gefunden.</div>");
	hoehe=hoehe+30;
	}

if(season!="")
	{
	document.write("<div style=\"text-align:right;top:"+(hoehe)+";left:465;position:absolute;\"><input type=\"submit\" name=\"submitti\" value=\"In den Warenkorb\"></div>");
	hoehe=hoehe+30;
	}

document.write("<div style=\"text-align:right;top:"+(hoehe)+";left:500;position:absolute;\">¹ = ohne mwst.</div>");

</script>
</form>


</div>
