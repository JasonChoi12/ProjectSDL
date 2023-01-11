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
        $error[] = "Kies een klant om te archiveren.";
    }
    if (isset($error)) {
            
        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../klantoverzicht/klantoverzicht.php');
    } else {

if (!is_string($id_klant)) {
foreach($id_klant as $id_klanten){
//     echo "<br>";
//    echo "id_klanten: " .$id_klanten;
//    echo "<br>";
//    echo "archiveer: " .$archiveer;
   $klanten->klantarchiveer($id_klanten, $archiveer);
   $accountaangemaakt[] = 'Klant is succesvol gearchiveerd.';
   $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
   header('Location:../klantoverzicht/klantoverzicht.php');
    }
}else{
    echo "<br>";
    // echo "id_klant: " .$id_klant;
    // echo "<br>";
    // echo "archiveer: " .$archiveer;
   $klanten->klantarchiveer($id_klant, $archiveer);
   $accountaangemaakt[] = 'Klant is succesvol gearchiveerd.';
   $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
   header('Location:../klantoverzicht/klantoverzicht.php');
}
    }
}


