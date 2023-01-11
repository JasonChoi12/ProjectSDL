<?php
session_start();
require_once('../src/class.php');
$uren = new uren();
//filter the excel data
$archiveer = $_POST['archiveer'];
$id_uur = $_POST['id_uren'];
if (isset($_POST['submit'])) {
    // check id_klant
    if (empty($id_uur)) {
        $error[] = "Kies een registratie om te archiveren.";
    }
    if (isset($error)) {
            
        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../urenoverzicht/urenoverzicht.php');
    } else {

if (!is_string($id_uur)) {
foreach($id_uur as $id_uren){
    echo "<br>";
   echo "id_projecten: " .$id_uren;
   echo "<br>";
   echo "archiveer: " .$archiveer;
   $uren->urenarchiveer($id_uren, $archiveer);
   header('Location:../urenoverzicht/urenoverzicht.php');

    }
}else{
    echo "<br>";
    echo "id_projecten: " .$id_uur;
    echo "<br>";
    echo "archiveer: " .$archiveer;
    $uren->urenarchiveer($id_uur, $archiveer);
    $accountaangemaakt[] = 'urenregistratie is succesvol gearchiveerd.';
                    $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
   header('Location:../urenoverzicht/urenoverzicht.php');

}
    }
}


