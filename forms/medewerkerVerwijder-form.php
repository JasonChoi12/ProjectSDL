<?php
session_start();
require_once('../src/class.php');
$gebruikers = new gebruikers();
//filter the excel data
$id_gebruiker = $_POST['id_gebruiker'];
if (isset($_POST['submit'])) {
    // check id_gebruiker
    if (empty($id_gebruiker)) {
        $error[] = "Kies een medewerker om te verwijderen.";
    }
    if (isset($error)) {

        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../medewerker/medewerker.php');
    } else {

        if (!is_string($id_gebruiker)) {
            foreach ($id_gebruiker as $id_gebruikers) {

                    $delete = $gebruikers->Verwijdergebruiker($id_gebruikers);
                    $accountaangemaakt[] = 'gebruiker is succesvol verwijderd.';
                    $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
                    header('Location:../medewerker/medewerker.php');
            }
        } elseif(is_string($id_gebruiker)) {


           
            $delete = $gebruikers->Verwijdergebruiker($id_gebruiker);
                
                        // terug naar begin pagina
                        $accountaangemaakt[] = 'gebruiker is succesvol verwijderd.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
             header('Location:../medewerker/medewerker.php');


        }else{
            $_SESSION['errors'] = "oeps er ging iets fout";
            header('Location:../medewerker/medewerker.php');
        }
    }
}
