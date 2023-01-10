<?php
require_once('../src/class.php');

//start sessie
session_start();
//Maak nieuw gebruikers
$user = new Gebruikers();
//passed post variables
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];
$code = $_POST['code'];



//filter emails naar lowerstring
$email = strtolower($email);
// echo $code. " ". $email. " ". $wachtwoord;

// validatie checker
if (isset($_POST['submit'])) {

    //check email
    if (!empty($email)) {
        $email_subject = $email;
        $email_pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $email_match = preg_match($email_pattern, $email_subject);
        if ($email_match !== 1) {
            $error[] = "Email moet een @ bevatten dus: example@ex.com";
        }
    } else {
        // mag niet leeg zijn
        $error[] = "Email mag niet leeg.";
    }

    // wachtwoord validatie
    if (!empty($wachtwoord)) {
        $uppercase = preg_match('@[A-Z]@', $wachtwoord);
        $lowercase = preg_match('@[a-z]@', $wachtwoord);
        $number    = preg_match('@[0-9]@', $wachtwoord);
        $specialChars = preg_match('@[^\w]@', $wachtwoord);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($wachtwoord) < 8) {
            $error[] = 'Wachtwoord moet ten minste 8 tekens lang zijn en moet ten minste één hoofdletter, één cijfer en één speciaal teken bevatten.';
        }
    } else {
        // mag niet leeg zijn
        $error[] = "Wachtwoord mag niet leeg.";
    }
    // wachtwoord validatie
    if (empty($code)) {
        $error[] = "Authenticatie code mag niet leeg zijn";
    }

    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location: ../login/login.php');
    } else {
        $usertype = "medewerker";
        $loggedin = $user->login($email, $wachtwoord, $code, $usertype);
        if (is_bool($loggedin)) {
            //Zet user values in sessie
            $_SESSION['gebruiker_data'] = serialize($user);
            header('Location: ../urenregistratie/urenregistratie.php');
        } elseif (is_string($loggedin)) {
            $usertype = "admin";
            $adminloggedin = $user->login($email, $wachtwoord, $code, $usertype);
            if (is_bool($adminloggedin)) {
                //Zet user values in sessie
                $_SESSION['gebruiker_data'] = serialize($user);
                header('Location: ../urenregistratie/urenregistratie.php');
            } elseif (is_string($adminloggedin)) {
                $usertype = "non-actief";
                $nonlogin = $user->login($email, $wachtwoord, $code, $usertype);
                if (is_bool($nonlogin)) {
                    //Zet user values in sessie
                    $nietActief = "Jouw account is gedactiveerd neem contact op met de beheerder.";
                    $_SESSION['ERRORS'] = $nietActief;
                    header('Location: ../login/login.php');
                } elseif (is_string($nonlogin)) {
                    $_SESSION['ERRORS'] = $nonlogin;
                    $_SESSION['ERRORS'] = $loggedin;
                    $_SESSION['ERRORS'] = $adminloggedin;
                    header('Location: ../login/login.php');
                }
            }
        }
    }
}
