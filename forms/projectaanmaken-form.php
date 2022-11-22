<?php
require_once('../src/class.php');

// start sessie
session_start();

// maak nieuwe projet aanmaken
$project = new projecten();
// Pakt post van de form en zet ze in variable
$id_klant = $_POST['id_klant'];
$projectnaam = $_POST['projectnaam'];
$begindatum = $_POST['begindatum'];


echo $projectnaam. " ". $begindatum. " ". $einddatum;
if(isset($_POST['submit'])){
    //check projectnaam
    if (!empty($projectnaam)) {
        $projectnaam_subject = $projectnaam;
        $projectnaam_pattern = '/^[a-zA-Z ]*$/';
        $projectnaam_match = preg_match($projectnaam_pattern, $projectnaam_subject);
        if ($projectnaam_match !== 1) {
            $error[] = "projectnaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn
        $error[] = "projectnaam mag niet leeg zijn.";
    }
    //check begindatum
    if (!empty($begindatum)) {
        $begindatum_subject = $begindatum;
        $begindatum_pattern = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
        $begindatum_match = preg_match($begindatum_pattern, $begindatum_subject);
        if ($begindatum_match !== 1) {
            $error[] = "begindatum mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } else {
        // mag niet leeg zijn
        $error[] = "begindatum mag niet leeg zijn.";
    }
    if(isset($error)){
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        // header('Location:../klant/klant.php');
    }else{
    $klant->KlantCreate($projectnaam, $begindatum, $einddatum, $woonplaats, $huisnummer, $postcode);
    // header('Location:../KlantOverzicht/klantOverzicht.php');
} 
}
