<?php
# Include packages

require_once('../src/class.php');
require_once(__DIR__ . '/vendor/autoload.php');
//start sessie
session_start();
// maak nieuwe gebruiker
$user = new Gebruikers();
// pak de post die in de registreren form is doorgestuurd en bind het aan een variable
$usertype = $_POST["usertype"];
$id_gebruiker = $_POST["id_gebruiker"]; 
$wachtwoord = $_POST["wachtwoord"];
setcookie("id_gebruiker", $id_gebruiker);

print_r($_POST);
//check invoervelden of hij goed is ingevuld

if (isset($_POST['submit'])) {
// wachtwoord validatie
if (!empty($wachtwoord)) {
    $uppercase = preg_match('@[A-Z]@', $wachtwoord);
    $lowercase = preg_match('@[a-z]@', $wachtwoord);
    $number    = preg_match('@[0-9]@', $wachtwoord);
    $specialChars = preg_match('@[^\w]@', $wachtwoord);
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoord) < 8) {
        $error[] = 'Wachtwoord moet ten minste 8 tekens lang zijn en moet ten minste één hoofdletter, één cijfer en één speciaal teken bevatten.';
    }}
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location: ../login/login.php');
    } else {
 
        $update = $user->UserTypeUpdate($usertype, $id_gebruiker, $wachtwoord);
        if (is_bool($update)) {
             // succes messasge
             $accountaangemaakt[] = 'Account is succesvol bijgewerkt.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
            //Voer ook uit als geen nieuw wachtwoord of email zijn ingevoerd
            //Volgende locatie
            
            header('Location: ../medewerker/Medewerker.php');
        } elseif (is_string($update)) {
            $_SESSION['ERRORS'] = $update;
            header('Location: ../medewerker/medewerkerupdate.php');
        }
    }
}
