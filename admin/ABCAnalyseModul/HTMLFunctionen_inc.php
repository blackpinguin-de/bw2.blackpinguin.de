<?php
//Beinhaltet alle Proceduren die zur
//darstellung von HTML code dienen.

function HTMLHEAD($Titel) {
return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html lang=\"de\">
<html>
<head>
  <title>$Titel</title>
</head>
<body alink=\"#000000\" bgcolor=\"#8BA6C7\" link=\"#FFFFFF\" text=\"#000000\" vlink=\"#5F5F5F\">
  <center><h2>$Titel</h2></center>
  <hr width=\"800\" size=\"2\">
  <br>\n\n";
}

function HTMLFOOT(){
return "\n</body>
</html>";
}


// Erstelt HTML-Tabelenzellen mit          
// den übergebenen Werten als Inhalt.     
function HTMLTabelenElemente($Materialart,$Jahresverbrauch,$Einstandspreis) {
  $TableBody == "";
   
  $arr_size=count($Materialart);
  for($i=0;$i<$arr_size;$i++)
  {
    $TableBody = $TableBody."\n    <tr>\n";
    #Für jedes Element/Wert in Materialart eine Tabelenzelle in der späteren HTML-Tabelle erzeugen
	$TableBody = $TableBody."      <td>$Materialart[$i]</td>\n      <td>$Jahresverbrauch[$i]</td>\n      <td>".number_format($Einstandspreis[$i], 2, '.', '')." &euro;</td>\n";
    $TableBody = $TableBody."     </tr>";
  }    
  return $TableBody;
}

// Erstelt eine HTML-Tabele zur ausgabe der vorhandenen Materialien.
//(Materialart;Jahresverbrauch;Einstandspreis) 
function HTMLMaterialTabele($Materialart,$Jahresverbrauch,$Einstandspreis) {

$Elemente = HTMLTabelenElemente($Materialart,$Jahresverbrauch,$Einstandspreis); 

return "  <center><h2>Materialien in der Datenbank: </h2></center>
    <table border=\"1\" align=\"center\" style=\"text-align:right\">
    <thead bgcolor=\"\#F0F8FF\">
      <tr>
        <th>Materialart </th>
        <th>Jahresverbrauch in ME </th>
        <th>Einstandspreis je ME </th>
      </tr>
    </thead>
    <tbody>$Elemente 
    </tbody>
    </table>
	<br>
	<br>\n";
}


//Erzeugt HTML-code zur ausgabe, der momentan
// gültiegen Wertegrenzen für die ABC Güter
// Parameter: VarGutMaxWert:                          
//            Ein Array mit dem Inhalt des            
//             prozentualen Maximal Wert für ein A, B 
//             und C Gut.                             
//            VarGutMaxMenge:                         
//             Ein Array mit dem Inhalt der           
//             prozentualen Maximal Menge für ein A, B
//             und C Gut.                             
function HTMLABCGueterGrenzenAusgeben($ConstRangGrenzen, $ConstWertGrenzen) {
return "  <br>
  <hr width=\"1000\" size=\"2\">
  <div align=\"center\">
  <h4>Prozent Werte die f&#252r die Berechnung der ABC-Analyse bunutzt wurden:</h4>
  <b>(<i>A</i> - G&#252ter)</b> $ConstWertGrenzen[0]% des Wertanteils und $ConstRangGrenzen[0]% der G&#252ter
  <br>
  <b>(<i>B</i> - G&#252ter)</b>".($ConstWertGrenzen[1] - $ConstWertGrenzen[0])."% des Wertanteils und ".($ConstRangGrenzen[1] - $ConstRangGrenzen[0]) ."% der G&#252ter 
  <br>
  <b>(<i>C</i> - G&#252ter)</b>".(100 - $ConstWertGrenzen[1])."% des Wertanteils und ".(100 - $ConstRangGrenzen[1]) ."% der G&#252ter
  <br>
  </div>
  <br>
  <hr width=\"1000\" size=\"2\">
  <br>";
}

//Fehlerseite ausgeben
function HTMLFehler($FehlerText){
return "  <br>
   <div align=\"center\"><b>$FehlerText</b></div>
   <br>\n";
}


// Erstelt HTML-Tabelenzellen mit          
// den übergebenen Werten als Inhalt.     
function HTMLTabelenElementeABC($MaterialListe) {
  $TableBody == "";
    
  $MaterialZeile = array();
   
  //Für jedes Element/Wert in Materialart eine Tabelenzelle in der späteren HTML-Tabelle erzeugen
  $arr_size=count($MaterialListe);
  for($i=0;$i<$arr_size;$i++){
	$MaterialZeile = $MaterialListe[$i];  
		    
    $TableBody = $TableBody."\n    <tr>\n";

	for($j=0;$j<count($MaterialZeile);$j++)
	{	
		$TableBody = $TableBody."      <td>$MaterialZeile[$j]</td>\n";
	}    
  
	$TableBody = $TableBody."     </tr>";
  }

  return $TableBody;
}

//Erstelt eine HTML-Tabele zur ausgabe der  
//in der ABC-Analyse berechneten Werte.     
function HTMLABCAnalyseTabele($MaterialListe,$VerbrauchswertGesamt,$JahresverbrauchGesamt) {

return "  <table border=\"1\" align=\"center\" style=\"text-align:right\">
  <thead bgcolor=\"\#F0F8FF\">
    <tr align=\"center\">     
      <th>Materialart</th>
      <th>G&#252ter kumuliert</th>
	  <th>Eistandspreis</th>    
	  <th>Jahresverbrauch</th>
      <th>Gesamtverbrauchswert</th>
      <th>Gesamtverbrauchswert</th>
	  <th>Gesamtverbrauchswert kumuliert</th>      
      <th>Klasse</th>
    </tr>
  </thead>
   <tbody>".HTMLTabelenElementeABC($MaterialListe).
   "</tbody>
     <tfoot bgcolor=\"\#F0F8FF\">
    <tr>
      <td>-</td>
	  <td>-</td>
	  <td>-</td>
	  <td><b>".number_format($JahresverbrauchGesamt, 2, '.', '')."</b></td>  	  
      <td><b>".number_format($VerbrauchswertGesamt, 2, '.', '')."</b></td>
      <td><b>100,00</b></td>    
      <td>-</td>
	  <td>-</td>
   </tr>
   </tfoot>
   </table>
   <br>";
}

?>