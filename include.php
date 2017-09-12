<?php

$content = "";

if( $seasonid != "" ) //Wenn eingeloggt
	{
	switch ($getsite)
		{
		case "bestelldetails":
		$content = "inhalt/bestelldetails.php";
		break;

		case "bestellungen":
		$content = "inhalt/bestellungen.php";
		break;

		case "boverview":
		$content = "inhalt/boverview.php";
		break;

		case "confirm":
		$content = "inhalt/confirm.php";
		break;

		case "logout":
		$content = "inhalt/logout.php";
		break;

		case "profil":
		$content = "inhalt/profil.php";
		break;

		case "warenkorb":
		$content = "inhalt/warenkorb.php";
		break;

		case "zahlung":
		$content = "inhalt/zahlung.php";
		break;

		default:
		$content = "";
		break;
		}
	}


if( $content == "" ) //Wenn keine der login-exklusiven Seiten
	{
	switch ($getsite)
		{
		case "404":
		$content = "inhalt/404.php";
		break;

		case "artikel":
		$content = "inhalt/artikel.php";
		break;

		case "home":
		$content = "inhalt/home.php";
		break;

		case "impressum":
		$content = "inhalt/impressum.php";
		break;

		case "login":
		$content = "inhalt/login.php";
		break;

		case "register":
		$content = "inhalt/register.php";
		break;

		case "shop":
		$content = "inhalt/shop.php";
		break;

		case "agb":
		$content = "inhalt/agb.php";
		break;

		default:
		$content = "inhalt/404.php";
		break;
		}
	}

include_once($content);
?>
