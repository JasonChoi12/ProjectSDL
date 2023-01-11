<?php
session_start();
require_once('../src/class.php');
$uren = new uren();
//filter the excel data
$id_project = $_POST['id_project'];
$id_uur = $_POST['id_uren'];
// print_r($_POST);

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
   echo "id_uren: " .$id_uren;
   echo "<br>";
   $uren_data = $uren->uurzien($id_uren);
echo $uren_data[0]["declarabel"];
// print_r($uren_data);
if($uren_data[0]["declarabel"] === "ja"){
    $declarabel = "nee";
    $uren->urendeclarabel($id_uren, $declarabel);
}elseif($uren_data[0]["declarabel"] === "nee"){
    $declarabel = "ja";
    $uren->urendeclarabel($id_uren, $declarabel);
}
$accountaangemaakt[] = 'urenregistratie is succesvol gedeclareerd';
$_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
   header('Location:../urenoverzicht/urenoverzicht.php');

    }
}else{
    echo "<br>";
    echo "id_uren: " .$id_uur;
    echo "<br>";
    
    $uren_data = $uren->uurzien($id_uur);
    echo $uren_data[0]["declarabel"];
    // print_r($uren_data);
    if($uren_data[0]["declarabel"] === "ja"){
        $declarabel = "nee";
        $uren->urendeclarabel($id_uur, $declarabel);
    }elseif($uren_data[0]["declarabel"] === "nee"){
        $declarabel = "ja";
        $uren->urendeclarabel($id_uur, $declarabel);
    }
    $accountaangemaakt[] = 'urenregistratie is succesvol gedeclareerd.';
$_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
   header('Location:../urenoverzicht/urenoverzicht.php');

}
    }
}


