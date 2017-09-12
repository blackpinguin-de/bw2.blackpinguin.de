<?php
include_once("WarehouseInfo_inc.php");
include_once("HTMLFunctionen_inc.php");
include_once("BerechProceduren_inc.php");

//Grenzen der Einzelnen Gütter
$ConstRangGrenzen = array(20, 50); //muss < 100 sein den rest sind immer C- Waren
$ConstWertGrenzen = array(80,90); // Bsp Güter: A=20% B=30% C=50%

//http://www.abc-analyse.info/abc/ziel_der_abc-analyse/
//http://www.controllingportal.de/Fachinfo/Grundlagen/ABC-Analyse.html

//Test Daten
/*
$Materialart = array(produkt1,produkt2,produkt3,produkt4,produkt5,produkt6,produkt7,produkt8,produkt9,produkt10);
$Einstandspreis = array(2.5,6.00,0.55,25.50,6.90,5.00,69.50,6.90,0.20,0.70);
$Jahresverbrauch = array(500,250,1223,88,600,2500,30,900,5000,12000);  //Menge
*/

echo HTMLHEAD("ABC-Analyse");

if (count($Materialart) > 0 ) {

    //Gesamtverbrauchswert aller verbrauchten Materialarten berechnen
	$VerbrauchswertGesamt = BerechnVerbrauchswertGesampt($Materialart,$Jahresverbrauch,$Einstandspreis);
	
    //Gesamtmenge aller verbrauchten Materialarten berechnen
	$JahresverbrauchGesamt = BerechnJahresverbrauchGesamt($Materialart,$Jahresverbrauch,$Einstandspreis);

	
    //Gesamtverbrauchswert, prozentualen Anteils des Gesamtverbrauchswertes
    //und den prozentualen Anteil der Gesamtmenge, von allen Materialien berechen.
    $MaterialListe = BerechnGesVGEGesVPROZENTJahreVPROZENT($Materialart,$Jahresverbrauch,$Einstandspreis,$VerbrauchswertGesamt,$JahresverbrauchGesamt);

	
    //Sortieren der Materialarten nach dem Gesamtverbrauchswert
	$MaterialListe = MaterialListeSortieren($MaterialListe);

	
	//Kumulieren des prozentualen Gesamtverbrauchswerte und der prozentualen Gesamtmenge
    //mit der Sortierten Materialien Liste
    $MaterialListe = KumulierteWerteBerechnen($MaterialListe);
   
 	//Einteilung der Materialarten in A-, B- und C-Güter 
	$MaterialListe = GueterKlassezuordnen($MaterialListe,$ConstRangGrenzen,$ConstWertGrenzen);
  
	//Material Liste für die Ausgabe sortieren und die Werte aufrunden
    $MaterialListe = MaterialListeZurAusgabeOrdnen($MaterialListe);
	
    //Durchgefürte ABC-Analyse der Materialien in der MaterialListe als HTML-Tabele ausgeben
	echo HTMLABCAnalyseTabele($MaterialListe,$VerbrauchswertGesamt,$JahresverbrauchGesamt);

	//Maximal Werte für die bestimmung der A-, B- und C-Güter ausgeben.
    echo HTMLABCGueterGrenzenAusgeben($ConstRangGrenzen, $ConstWertGrenzen); 
	
	//Datenbank Inhalt ausgeben
	echo HTMLMaterialTabele($Materialart,$Jahresverbrauch,$Einstandspreis);
	
} else {
  echo HTMLFehler("Keine Materialien in der Datenbank!");
}

echo HTMLFOOT();
	
?>
