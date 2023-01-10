<?php
require_once('../src/class.php');

// start sessie
session_start();

// maak nieuwe klant aan
$klant = new Klanten();
// Pakt post van de form en zet ze in variable
$klantnaam = $_POST['klantnaam'];
$straatnaam = $_POST['straatnaam'];
$telefoon = $_POST['telefoon'];
$woonplaats = $_POST['woonplaats'];
$huisnummer = $_POST['huisnummer'];
$postcode = $_POST['postcode'];
$archiveer = "nee";

echo $klantnaam. " ". $straatnaam. " ". $telefoon. " ". $woonplaats. " ".$huisnummer. " ". $postcode;
if(isset($_POST['submit'])){
    //check klantnaam
    if (!empty($klantnaam)) {
        $klantnaam_subject = $klantnaam;
        $klantnaam_pattern = '/^[a-zA-Z ]*$/';
        $klantnaam_match = preg_match($klantnaam_pattern, $klantnaam_subject);
        if ($klantnaam_match !== 1) {
            $error[] = "Klantnaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn
        $error[] = "klantnaam mag niet leeg zijn.";
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
    if (!empty($telefoon)) {
        $telefoon_subject = $telefoon;
        $telefoon_pattern = '/^[0-9]*$/';
        $telefoon_match = preg_match($telefoon_pattern, $telefoon_subject);
        if ($telefoon_match !== 1) {
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
    } else {
        // mag niet leeg zijn
        $error[] = "Woonplaats mag niet leeg zijn.";
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
    if(isset($error)){
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../klant/klant.php');
    }else{
    $klant->KlantCreate($klantnaam, $straatnaam, $telefoon, $woonplaats, $huisnummer, $postcode, $archiveer);
    $accountaangemaakt[] = 'Klant is succesvol aangemaakt.';
    $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
    header('Location:../klantoverzicht/klantoverzicht.php');
    
} 
}
