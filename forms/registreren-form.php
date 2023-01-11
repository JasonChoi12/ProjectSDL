<?php
session_start();
# Include packages

require_once('../src/class.php');
require_once(__DIR__ . '/vendor/autoload.php');
# Create the 2FA class
$google2fa = new PragmaRX\Google2FA\Google2FA();

// maak nieuwe gebruiker
$user = new Gebruikers();
// pak de post die in de registreren form is doorgestuurd en bind het aan een variable
$post = $_POST;
$voornaam = $_POST['voornaam'];
$tussenvoegsel = $_POST['tussenvoegsel'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];
$usertype = "medewerker";


//filter emails naar lowerstring
$email = strtolower($email);
//check invoervelden of hij goed is ingevuld
// echo $voornaam . " " . $tussenvoegsel . " " . $achternaam . " " . $email . " " . $wachtwoord;

if (isset($_POST['cancel'])) {
    header('Location:../urenregistratie/urenregistratie.php');
}

if (isset($_POST['submit'])) {

    //check voornaam
    if (!empty($voornaam)) {
        $voornaam_subject = $voornaam;
        $voornaam_pattern = '/^[a-zA-Z ]*$/';
        $voornaam_match = preg_match($voornaam_pattern, $voornaam_subject);
        if ($voornaam_match !== 1) {
            $error[] = "Voornaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn 
        $error[] = "Voornaam mag niet leeg zijn.";
    }

    //check achternaam
    if (!empty($achternaam)) {
        $achternaam_subject = $achternaam;
        $achternaam_pattern = '/^[a-zA-Z ]*$/';
        $achternaam_match = preg_match($achternaam_pattern, $achternaam_subject);
        if ($achternaam_match !== 1) {
            $error[] = "Achternaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn 
        $error[] = "Achternaam mag niet leeg zijn.";
    }

    //check email
    if (!empty($email)) {
        $email_subject = $email;
        $email_pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $email_match = preg_match($email_pattern, $email_subject);
        if ($email_match !== 1) {
            $error[] = "Email moet een @ bevatten dus: example@ex.com";
        }
    } else {
        // mag niet leeg zijn zijn
        $error[] = "Email mag niet leeg zijn.";
    }

    // wachtwoord validatie
    if (!empty($wachtwoord)) {
        $uppercase = preg_match('@[A-Z]@', $wachtwoord);
        $lowercase = preg_match('@[a-z]@', $wachtwoord);
        $number    = preg_match('@[0-9]@', $wachtwoord);
        $specialChars = preg_match('@[^\w]@', $wachtwoord);
    } else {
        // mag niet leeg zijn 
        $error[] = "Wachtwoord mag niet leeg zijn.";
    }

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoord) < 8) {
        $error[] = 'Wachtwoord moet ten minste 8 tekens lang zijn en moet ten minste één hoofdletter, één cijfer en één speciaal teken bevatten.';
    }
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../registreren/registreren.php');
    } else {

        $secret_key = $google2fa->generateSecretKey();
        $text = $google2fa->getqrCodeUrl(
            $email,
            $voornaam,
            $secret_key
        );

        $image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=' . $text;
        $qr[] = '<img class="qrcode" src="' . $image_url . '" />';
        $qr[] = 'Kan je de qr niet scannen hier is jouw instelsleutel: ' . $secret_key;

        $accountaangemaakt[] = 'Account is succesvol aangemaakt.';
        $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
        $_SESSION['QR'] = implode('<br> ', $qr);
        // echo $voornaam . " " . $tussenvoegsel . " " . $achternaam . " " . $email . " " . $wachtwoord  . " " . $usertype  . " " . $secret_key;

        $user->create($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $usertype, $secret_key);
        header('Location:../registreren/qr.php');
    }
}
