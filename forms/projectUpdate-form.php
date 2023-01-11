<?php
require_once('../src/class.php');

// start sessie
session_start();

// maak nieuwe projet aanmaken
$project = new projecten();
// Pakt post van de form en zet ze in variable
$id_project = $_POST['id_project'];
$id_klant = $_POST['id_klant'];
$projectnaam = $_POST['projectnaam'];
$begindatum = $_POST['begindatum'];


// echo $projectnaam. " ". $begindatum. " ". $id_klant. " ". $id_project ;
if(isset($_POST['submit'])){
    //check projectnaam
    if (!empty($projectnaam)) {
        $projectnaam_subject = $projectnaam;
        $projectnaam_pattern = '/^[a-zA-Z ]*$/';
        $projectnaam_match = preg_match($projectnaam_pattern, $projectnaam_subject);
        if ($projectnaam_match !== 1) {
            $error[] = "projectnaam mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    }
    //check begindatum
    if (!empty($begindatum)) {
        $begindatum_subject = $begindatum;
        $begindatum_pattern = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
        $begindatum_match = preg_match($begindatum_pattern, $begindatum_subject);
        if ($begindatum_match !== 1) {
            $error[] = "begindatum mag alleen alfabetisch, steepjes en spaties bevatten";
        }
    } 
    if(isset($error)){
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../projectupdate/projectupdate.php');
    }else{
    $project->projectupdate($id_klant, $projectnaam, $begindatum, $id_project);
    $accountaangemaakt[] = 'Project is succesvol bijgewerkt.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
    header('Location:../projectoverzicht/projectoverzicht.php');
} 
}
