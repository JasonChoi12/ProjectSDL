<?php
session_start();
require_once('../src/class.php');
$klanten = new Klanten();
//filter the excel data
$archiveer = $_POST['archiveer'];
$id_klant = $_POST['id_klant'];

if (isset($_POST['submit'])) {
    // check id_klant
    if (empty($id_klant)) {
        $error[] = "Kies een klant.";
    }
    if (isset($error)) {
            
        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../KlantOverzicht/KlantOverzicht.php');
    } else {

if (!is_string($id_klant)) {
foreach($id_klant as $id_klanten){
//     echo "<br>";
//    echo "id_klanten: " .$id_klanten;
//    echo "<br>";
//    echo "archiveer: " .$archiveer;
   $klanten->klantArchiveer($id_klanten, $archiveer);
   header('Location:../KlantOverzicht/klantOverzicht.php');
    }
}else{
    echo "<br>";
    // echo "id_klant: " .$id_klant;
    // echo "<br>";
    // echo "archiveer: " .$archiveer;
   $klanten->klantArchiveer($id_klant, $archiveer);
   header('Location:../KlantOverzicht/klantOverzicht.php');
}
    }
}


