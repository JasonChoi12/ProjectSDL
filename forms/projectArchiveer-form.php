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
        $error[] = "Kies een project.";
    }
    if (isset($error)) {
            
        $_SESSION['errors'] = implode('<br> ', $error);
        // header('Location:../ProjectOverzicht/ProjectOverzicht.php');
    } else {

if (!is_string($id_project)) {
foreach($id_project as $id_projecten){
    echo "<br>";
   echo "id_projecten: " .$id_projecten;
   echo "<br>";
   echo "archiveer: " .$archiveer;
   $projecten->projectArchiveer($id_projecten, $archiveer);
//    header('Location:../ProjectOverzicht/ProjectOverzicht.php');

    }
}else{
    echo "<br>";
    echo "id_projecten: " .$id_project;
    echo "<br>";
    echo "archiveer: " .$archiveer;
    $projecten->projectArchiveer($id_project, $archiveer);
//    header('Location:../ProjectOverzicht/ProjectOverzicht.php');

}
    }
}


