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
