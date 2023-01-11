<?php
require_once('../src/class.php');

// start sessie
session_start();

// maak nieuwe klant aan
$urenbewerken = new Uren();
// Pakt post van de form en zet ze in variable
$id_gebruiker = $_POST['id_gebruiker'];
$id_uren = $_POST['id_uren'];
$id_klant = $_POST['id_klant'];
$id_project = $_POST['id_project'];
$declarabel = $_POST['declarabel'];
$activiteiten = $_POST['activiteiten'];
$datum = $_POST['datum'];
$begonnen = $_POST['begonnen'];
$beëindigd = $_POST['beëindigd'];
$uren = $_POST['uren'];
$buren = $_POST['Buren'];
$bonusmdw = $_POST['id_bonusmdw'];


// echo "declarabel: " . $declarabel . "<br>";
// echo "id_uren: " . $id_uren . "<br>";
// echo "id_gebruiker: " . $id_gebruiker . "<br>";
// echo "id_klant: " . $id_klant . "<br>";
// echo "id_project: " . $id_project . "<br>";
// echo "activiteit: " . $activiteiten . "<br>";
// echo "datum: " . $datum . "<br>";
// echo "begonnen: " . $begonnen . "<br>";
// echo "beëindigd: " . $beëindigd . "<br>";
// echo "uren: " . $uren . "<br>";
// echo "buren: " . $buren . "<br>";
// echo "id_bonusmdw: " . $bonusmdw . "<br>";


$s = (strtotime("00:00"));
// $begonnen = strtotime($begonnen);
// $beëindigd = strtotime($beëindigd);
// $uren = strtotime($uren);
// $buren = strtotime($buren);
// echo "begonnen: " . $begonnen . "<br>";
// echo "beëindigd: " . $beëindigd . "<br>";
// echo "uren: " . $uren . "<br>";
// echo "buren: " . $buren . "<br>";
// echo "s: " . $s . "<br>";
// echo "<br>";
// $begonnen = $begonnen - $s;
// $beëindigd = $beëindigd - $s;
// $uren = $uren - $s;
// $buren = $buren - $s;
// echo "<br><br><br><br>";
// echo "begonnen: " . $begonnen . "<br>";
// echo "beëindigd: " . $beëindigd . "<br>";
// echo "uren: " . $uren . "<br>";
// echo "buren: " . $buren . "<br>";
// echo "doper: " . $doper . "<br>";

// echo "<br><br><br><br>";

// echo "begonnen: " . gmdate("H:i", $begonnen) . "<br>";
// echo "beëindigd: " . gmdate("H:i", $beëindigd) . "<br>";
// echo "uren: " . gmdate("H:i", $uren) . "<br>";
// echo "buren: " . gmdate("H:i", $buren) . "<br>";
// echo "doper: " . gmdate("H:i", $doper) . "<br>";



if (isset($_POST['submit'])) {
    if (empty($declarabel)) {
        $declarabel = NULL;
    }
    // check datum
    if (empty($datum)) {
        $error[] = "Vul de datum van invullen in.";
    }
    if ($bonusmdw === "id_bonusmdw") {
        $bonusmdw = NULL;
    }
    if(!empty($begonnen)){
        $begonnen = strtotime($begonnen);
        $begonnen = $begonnen - $s;
    }else{
        $begonnen = NULL;
    }
    if(!empty($beëindigd)){
        $beëindigd = strtotime($beëindigd);
        $beëindigd = $beëindigd - $s;
    }else{
        $beëindigd = NULL;
    }
    //check uren
    if (!empty($uren)) {
        echo"regex:". $uren;
        $uren_subject = $uren;
        $uren_pattern = '/^([01]?[0-9]|2[0-3])\:+[0-5][0-9]$/';
        $uren_match = preg_match($uren_pattern, $uren_subject);
        if ($uren_match !== 1) {
            $error[] = "Totaal gewerkte tijd moet er zo uitzien 02:59.";
        }else{
$uren = strtotime($uren);
            
$buren = strtotime($buren);
                $uren = $uren - $s;
                
            }
        }
    
    if (isset($error)) {
        $_SESSION['ERRORS'] = implode('<br> ', $error);
        header('Location:../urenbewerken/urenbewerken.php');


    } else {

        $urenbewerken->urenbewerken($id_uren, $bonusmdw, $activiteiten, $declarabel, $uren, $begonnen, $beëindigd, $datum);
        $laatst_gewerkt = $urenbewerken->Laatst_gewerkt($id_klant, $id_project, $datum);
        $accountaangemaakt[] = 'Urenreigstratie is succesvol bijgewerkt.';
        $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
        header('Location:../projectoverzicht/projectoverzicht.php');
    }
}
