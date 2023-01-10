<?php
require_once('../src/class.php');

// start sessie
session_start();

// maak nieuwe klant aan
$klant = new Klanten();
// Pakt post van de form en zet ze in variable
$id_klant = $_POST['id_klant'];
$klantnaam = $_POST['klantnaam'];
$straatnaam = $_POST['straatnaam'];
$telefoonnummer = $_POST['telefoon'];
$woonplaats = $_POST['woonplaats'];
$huisnummer = $_POST['huisnummer'];
$postcode = $_POST['postcode'];

echo $klantnaam . " " . $straatnaam . " " . $telefoonnummer . " " . $woonplaats . " " . $huisnummer . " " . $postcode . " " . $id_klant;
if (isset($_POST['submit'])) {
    //check klantnaam
    if (!empty($klantnaam)) {
        $klantnaam_subject = $klantnaam;
        $klantnaam_pattern = '/^[a-zA-Z ]*$/';
        $klantnaam_match = preg_match($klantnaam_pattern, $klantnaam_subject);
        if ($klantnaam_match !== 1) {
            $error[] = "Klantnaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }
    //check straatnaam
    if (!empty($straatnaam)) {
        $straatnaam_subject = $straatnaam;
        $straatnaam_pattern = '/^[a-zA-Z ]*$/';
        $straatnaam_match = preg_match($straatnaam_pattern, $straatnaam_subject);
        if ($straatnaam_match !== 1) {
            $error[] = "Straatnaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }
    //check telefoon
    if (!empty($telefoonnummer)) {
        $telefoonnummer_subject = $telefoonnummer;
        $telefoonnummer_pattern = '/^[0-9]*$/';
        $telefoonnummer_match = preg_match($telefoonnummer_pattern, $telefoonnummer_subject);
        if ($telefoonnummer_match !== 1) {
            $error[] = "Telefoon nummer mag alleen nummers bevatten";
        }
    }
    //check woonplaats
    if (!empty($woonplaats)) {
        $woonplaats_subject = $woonplaats;
        $woonplaats_pattern = '/^[a-zA-Z ]*$/';
        $woonplaats_match = preg_match($woonplaats_pattern, $woonplaats_subject);
        if ($woonplaats_match !== 1) {
            $error[] = "Woonplaats mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }
    //check huisnummer
    if (!empty($huisnummer)) {
        $huisnummer_subject = $huisnummer;
        $huisnummer_pattern = '/^[0-9]*$/';
        $huisnummer_match = preg_match($huisnummer_pattern, $huisnummer_subject);
        if ($huisnummer_match !== 1) {
            $error[] = "huisnummer mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }
    //check postcode
    if (!empty($postcode)) {
        $postcode_subject = $postcode;
        $postcode_pattern = '/^[0-9A-Za-z]*$/';
        $postcode_match = preg_match($postcode_pattern, $postcode_subject);
        if ($postcode_match !== 1) {
            $error[] = "Postcode mag alleen alfabetische letters en nummers bevatten";
        }
    }
    if (isset($error)) {
        setcookie("id_klant", $id_klant);
        print_r($_COOKIE);
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../klantupdate/klantupdate.php');
        
    } else {
        $klant->KlantUpdate($klantnaam, $straatnaam, $telefoonnummer, $woonplaats, $huisnummer, $postcode, $id_klant);
        $accountaangemaakt[] = 'Klant is succesvol bijgewerkt.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
        header('Location:../klantoverzicht/klantoverzicht.php');
    }
}
