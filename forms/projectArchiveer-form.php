<?php
session_start();
require_once('../src/class.php');
$projecten = new projecten();
//filter the excel data
$archiveer = $_POST['archiveer'];
$id_project = $_POST['id_project'];
if (isset($_POST['submit'])) {
    // check id_klant
    if (empty($id_project)) {
        $error[] = "Kies een project om te archiveren.";
    }
    if (isset($error)) {
            
        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../projectoverzicht/projectoverzicht.php');
    } else {

if (!is_string($id_project)) {
foreach($id_project as $id_projecten){
    echo "<br>";
   echo "id_projecten: " .$id_projecten;
   echo "<br>";
   echo "archiveer: " .$archiveer;
   $projecten->projectarchiveer($id_projecten, $archiveer);
   $accountaangemaakt[] = 'Project is succesvol gearchiveerd.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
   header('Location:../projectoverzicht/projectoverzicht.php');

    }
}else{
    echo "<br>";
    echo "id_projecten: " .$id_project;
    echo "<br>";
    echo "archiveer: " .$archiveer;
    $projecten->projectarchiveer($id_project, $archiveer);
    $accountaangemaakt[] = 'Project is succesvol gearchiveerd.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
   header('Location:../projectoverzicht/projectoverzicht.php');

}
    }
}


