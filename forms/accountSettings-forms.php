<?php
# Include packages

require_once('../src/class.php');
require_once(__DIR__ . '/vendor/autoload.php');
//start sessie
session_start();
// maak nieuwe gebruiker
$user = new Gebruikers();
// pak de post die in de registreren form is doorgestuurd en bind het aan een variable
$post = $_POST;
$voornaam = $_POST['voornaam'];
$tussenvoegsel = $_POST['tussenvoegsel'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];
$wachtwoordcheck = $_POST['wachtwoordcheck'];
//filter emails naar lowerstring
$email = strtolower($email);
//check invoervelden of hij goed is ingevuld
echo $voornaam . " " . $tussenvoegsel . " " . $achternaam . " " . $email . " " . $wachtwoord . " " . $wachtwoordcheck;

if (isset($_POST['submit'])) {

    //check voornaam
    if (!empty($voornaam)) {
        $voornaam_subject = $voornaam;
        $voornaam_pattern = '/^[a-zA-Z ]*$/';
        $voornaam_match = preg_match($voornaam_pattern, $voornaam_subject);
        if ($voornaam_match !== 1) {
            $error[] = "Voornaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }

    //check achternaam
    if (!empty($achternaam)) {
        $achternaam_subject = $achternaam;
        $achternaam_pattern = '/^[a-zA-Z ]*$/';
        $achternaam_match = preg_match($achternaam_pattern, $achternaam_subject);
        if ($achternaam_match !== 1) {
            $error[] = "Achternaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }

    //check email
    if (!empty($email)) {
        $email_subject = $email;
        $email_pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $email_match = preg_match($email_pattern, $email_subject);
        if ($email_match !== 1) {
            $error[] = "Email moet een @ bevatten dus: example@ex.com";
        }
    }

    // wachtwoord validatie
    if (!empty($wachtwoord)) {
        $uppercase = preg_match('@[A-Z]@', $wachtwoord);
        $lowercase = preg_match('@[a-z]@', $wachtwoord);
        $number    = preg_match('@[0-9]@', $wachtwoord);
        $specialChars = preg_match('@[^\w]@', $wachtwoord);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoord) < 8) {
            $error[] = 'Nieuw wachtwoord moet ten minste 8 tekens lang zijn en moet ten minste één hoofdletter, één cijfer en één speciaal teken bevatten.';
        }
    }

//Zet variablen op NULL voor isset check
if (empty($email)) {
    $email = NULL;
}

if (empty($wachtwoord)) {
    $wachtwoord = NULL;
}
    // wachtwoordcheck validatie
    if (!empty($wachtwoordcheck)) {
        $uppercase = preg_match('@[A-Z]@', $wachtwoordcheck);
        $lowercase = preg_match('@[a-z]@', $wachtwoordcheck);
        $number    = preg_match('@[0-9]@', $wachtwoordcheck);
        $specialChars = preg_match('@[^\w]@', $wachtwoordcheck);
    } else {
        // mag niet leeg zijn 
        $error[] = "Wachtwoord mag niet leeg zijn.";
    }

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoordcheck) < 8) {
        $error[] = 'Wachtwoord moet ten minste 8 tekens lang zijn en moet ten minste één hoofdletter, één cijfer en één speciaal teken bevatten.';
    }


    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../accountsettings/accountsettings.php');
    } else {
        $update = $user->update($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $wachtwoordcheck);
        if (is_bool($update)) {

            if (isset($wachtwoord) || isset($email)) {
                 // succes messasge
                 $accountaangemaakt[] = 'Account is succesvol bijgewerkt.';
                // Update voor nieuw wachtwoord
                $updateUser = $user->update($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $wachtwoordcheck);
                header('Location:../accountsettings/accountsettings.php');

            }
             // succes messasge
             $accountaangemaakt[] = 'Account is succesvol bijgewerkt.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
            //Voer ook uit als geen nieuw wachtwoord of email zijn ingevoerd
            //Volgende locatie
            header('Location:../accountsettings/accountsettings.php');
        } elseif (is_string($update)) {
            $_SESSION['ERRORS'] = $update;
            header('Location:../accountsettings/accountsettings.php');
        }
    }
}
