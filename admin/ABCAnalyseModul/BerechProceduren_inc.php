<?php
/* Beinhaltet alle wichtiegen Proceduren 
   für die eigentliche Berechnung, 
   der ABC Analyse.       
*/


//Berechnet den Gesamtverbrauchswert        
//aller verbrauchten Materialarten.        
function BerechnVerbrauchswertGesampt($Materialart,$Jahresverbrauch,$Einstandspreis) {
  $VerbrauchswertGesamt = 0.0;

  $arr_size=count($Materialart);
  for($i=0;$i<$arr_size;$i++){
  
    #Den Gesamtverbrauchswert aller verbrauchten Materialarten berechnen.
	
    $VerbrauchswertGesamt += $Jahresverbrauch[$i] * $Einstandspreis[$i];   
  }    

  return $VerbrauchswertGesamt;
}


//Berechnet die Gesamtmenge aller           
//verbrauchten Materialarten.               
function BerechnJahresverbrauchGesamt($Materialart,$Jahresverbrauch,$Einstandspreis) {
  $JahresverbrauchGesamt = 0.0;

  $arr_size=count($Materialart);
  for($i=0;$i<$arr_size;$i++){
    $JahresverbrauchGesamt = $JahresverbrauchGesamt + $Jahresverbrauch[$i];   
  }

  return $JahresverbrauchGesamt;
}


//Berechnet den Gesamtverbrauchswert, den prozentualen Anteil des   
//Gesamtverbrauchswertes und den prozentualen Anteil an der Gesamtmenge,   
//einer Materialart pro Periode.            
function BerechnGesVGEGesVPROZENTJahreVPROZENT($Materialart,$Jahresverbrauch,$Einstandspreis,$VerbrauchswertGesamt,$JahresverbrauchGesamt) {

  $MaterialListe = array();
  
  $arr_size=count($Materialart);
  for($i=0;$i<$arr_size;$i++){
   
    //Berechnung des Gesamtverbrauchswertes einer Materialart pro Periode (Menge multipliziert mit dem Einstandspreis)
    $GesamtverbrauchswertGE = $Jahresverbrauch[$i] * $Einstandspreis[$i];
    
    //Berechnung des prozentualen Anteils einer Materialart pro Periode am Gesamtverbrauchswert aller verbrauchten Materialarten
    $GesamtverbrauchswertPROZENT = ($GesamtverbrauchswertGE * 100) / $VerbrauchswertGesamt;
	
    //Die Materialien Liste um die zusätzlichen Elemente erweitetern.
	//??? [$i]
    $MaterialZeile = array($Materialart[$i],$Jahresverbrauch[$i],$Einstandspreis[$i],$GesamtverbrauchswertGE,$GesamtverbrauchswertPROZENT);
	$MaterialListe[$i] = $MaterialZeile;
  }

return $MaterialListe;
}

// Vergleichsfunktion zum sortieren von unter-Arrays
function vergleich($wert_a, $wert_b) {
   // Sortierung nach dem zweiten Wert des Array (Index: 1)
   $a = $wert_a[3];
   $b = $wert_b[3];
 
   if ($a == $b) {
       return 0;
   }
   return ($a > $b) ? -1 : +1;
}

//Sortieren der Materialarten in absteigender Reihenfolge nach dem 
//Gesamtverbrauchswert.            
function MaterialListeSortieren($MaterialListe) {
 
// Aufruf von usort() mit dem Array, das sortiert werden soll und dem Namen der Vergleichsfunktion
usort($MaterialListe, 'vergleich');

return $MaterialListe;
}


//Kumulieren des prozentualen Gesamtverbrauchswerte und der   
//prozentualen Gesamtmenge der einzelnen Materialienarten. 
function KumulierteWerteBerechnen($MaterialListe) {

  $GesamtverbrauchswertKUMULIERT = 0.0;
  $JahresverbrauchKUMULIERT = 0.0;

  $MaterialZeile = array();
  $MaterialListeAus = array();
   
  $arr_size=count($MaterialListe);
  
  $GueterPROZENT = (100/$arr_size);
 
  for($i=0;$i<$arr_size;$i++){
    $MaterialZeile = $MaterialListe[$i];  
	
    $Materialart = $MaterialZeile[0];
    $Jahresverbrauch = $MaterialZeile[1];
    $Einstandspreis = $MaterialZeile[2];
    $GesamtverbrauchswertGE = $MaterialZeile[3];	
    $GesamtverbrauchswertPROZENT = $MaterialZeile[4];	
	
    //Kumulieren des prozentualen Anteils eines Materials am Gesamtverbrauchswert aller Materialarten.
    $GesamtverbrauchswertKUMULIERT += $GesamtverbrauchswertPROZENT;
    
	//Kumulieren der Gueter.
    $GueterKUMULIERT += $GueterPROZENT;
		
    //Die Materialliste wieder zusammensetzen
    $MaterialZeileAus = array($Materialart,$Jahresverbrauch,$Einstandspreis,$GesamtverbrauchswertGE,$GesamtverbrauchswertPROZENT,$GesamtverbrauchswertKUMULIERT,$GueterKUMULIERT);
	$MaterialListeAus[$i] = $MaterialZeileAus;
  }

return $MaterialListeAus;
}

//Einteilung der Materialarten in A-, B- und C-Güter.                     
function GueterKlassezuordnen($MaterialListe,$ConstRangGrenzen,$ConstWertGrenzen) {
  
  //Materialliste zerlegen
  $MaterialZeile = array();
  $MaterialListeAus = array();
   
  $arr_size=count($MaterialListe);
  for($i=0;$i<$arr_size;$i++){
    $MaterialZeile = $MaterialListe[$i];  
	
    $Materialart = $MaterialZeile[0];
    $Jahresverbrauch = $MaterialZeile[1];
    $Einstandspreis = $MaterialZeile[2];
    $GesamtverbrauchswertGE = $MaterialZeile[3];	
    $GesamtverbrauchswertPROZENT = $MaterialZeile[4];	
    $GesamtverbrauchswertKUMULIERT = $MaterialZeile[5];
    $GueterKUMULIERT = $MaterialZeile[6];
	
    $Klasse = "C";
	
	if($GesamtverbrauchswertKUMULIERT <= $ConstWertGrenzen[1] && $GueterKUMULIERT <= $ConstRangGrenzen[1])
		{
		$Klasse = "B";
		}
	
	if($GesamtverbrauchswertKUMULIERT <= $ConstWertGrenzen[1] && $GueterKUMULIERT <= $ConstRangGrenzen[0])
		{
		$Klasse = "A";
		}	
	
    //Die Materialliste wieder zusammensetzen und die Güterklasse mithinzufügen
	$MaterialZeileAus = array($Materialart,$Jahresverbrauch,$Einstandspreis,$GesamtverbrauchswertGE,$GesamtverbrauchswertPROZENT,$GesamtverbrauchswertKUMULIERT,$GueterKUMULIERT,$Klasse);
	$MaterialListeAus[$i] = $MaterialZeileAus;
  }

return $MaterialListeAus;
}

//Einteilung der Materialarten in A-, B- und C-Güter.                     
function GueterKlassezuordnenV2($MaterialListe,$ConstRangGrenzen,$ConstWertGrenzen) {
  
  //Materialliste zerlegen
  $MaterialZeile = array();
  $MaterialListeAus = array();
   
  $arr_size=count($MaterialListe);
  for($i=0;$i<$arr_size;$i++){
    $MaterialZeile = $MaterialListe[$i];  
	
    $Materialart = $MaterialZeile[0];
    $Jahresverbrauch = $MaterialZeile[1];
    $Einstandspreis = $MaterialZeile[2];
    $GesamtverbrauchswertGE = $MaterialZeile[3];	
    $GesamtverbrauchswertPROZENT = $MaterialZeile[4];	
    $JahresverbrauchPROZENT = $MaterialZeile[5];	
    $GesamtverbrauchswertKUMULIERT = $MaterialZeile[6];
    $JahresverbrauchKUMULIERT = $MaterialZeile[7];
	
    $Klasse = "C";
	
	if($GesamtverbrauchswertKUMULIERT <= $wb && $JahresverbrauchKUMULIERT <= $mb)
		{
		$Klasse = "B";
		}
	
	if($GesamtverbrauchswertKUMULIERT <= $wa && $JahresverbrauchKUMULIERT <= $ma)
		{
		$Klasse = "A";
		}	
	
    //Die Materialliste wieder zusammensetzen und die Güterklasse mithinzufügen
	$MaterialZeileAus = array($Materialart,$Jahresverbrauch,$Einstandspreis,$GesamtverbrauchswertGE,$GesamtverbrauchswertPROZENT,$JahresverbrauchPROZENT,$GesamtverbrauchswertKUMULIERT,$JahresverbrauchKUMULIERT,$Klasse);
	$MaterialListeAus[$i] = $MaterialZeileAus;
  }
  return $MaterialListeAus;
}


//Ordnen der Materialien Liste und die
//Materialien Werte aufrunden die Spätere Ausgabe.                        
function MaterialListeZurAusgabeOrdnen($MaterialListe) {
 
  $MaterialZeile = array();
  $MaterialListeAus = array();
   
  $arr_size=count($MaterialListe);
  for($i=0;$i<$arr_size;$i++){
    $MaterialZeile = $MaterialListe[$i];  
		    
    $Materialart = $MaterialZeile[0];
    $Jahresverbrauch = $MaterialZeile[1]." ME";
    $Einstandspreis = number_format($MaterialZeile[2], 2, '.', ' ')." &euro;";
    $GesamtverbrauchswertGE = number_format($MaterialZeile[3], 2, '.', ' ')." &euro;";
    $GesamtverbrauchswertPROZENT = number_format($MaterialZeile[4], 2, ',', '')." %";
    $GesamtverbrauchswertKUMULIERT = number_format($MaterialZeile[5], 2, ',', '')." %";
    $GueterKUMULIERT = number_format($MaterialZeile[6], 2, ',', '')." %";
	$Klasse = $MaterialZeile[7];
		    
    //Die Materialliste wieder zusammensetzen
    $MaterialZeileAus = array($Materialart,$GueterKUMULIERT,$Einstandspreis,$Jahresverbrauch,$GesamtverbrauchswertGE,$GesamtverbrauchswertPROZENT,$GesamtverbrauchswertKUMULIERT,$Klasse);
	$MaterialListeAus[$i] = $MaterialZeileAus;
  }

return $MaterialListeAus;
}

?>