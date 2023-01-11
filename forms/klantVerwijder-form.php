<?php
session_start();
require_once('../src/class.php');
$klanten = new Klanten();
//filter the excel data
$id_klant = $_POST['id_klant'];
if (isset($_POST['submit'])) {
    // check id_klant
    if (empty($id_klant)) {
        $error[] = "Kies een klant om te verwijderen.";
    }
    if (isset($error)) {

        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../archiveer/klantoverzichtarchiveer.php');
    } else {

        if (!is_string($id_klant)) {
            foreach ($id_klant as $id_klanten) {
                $klanten_data = $klanten->KlantZien($id_klanten);
                if ($klanten_data[0]['archiveer'] === 'ja') {
                    $delete = $klanten->VerwijderKlant($id_klanten);
                    $accountaangemaakt[] = 'Klant is succesvol verwijderd.';
                    $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
                        header('Location:../archiveer/klantoverzichtarchiveer.php');
                    
             
                       
                    
                }else{
                    header('Location:../klantoverzicht/klantoverzicht.php');
                }
            }
        } else {

            $klanten_data = $klanten->KlantZien($id_klant);
            if ($klanten_data[0]['archiveer'] === 'ja') {
            $delete = $klanten->VerwijderKlant($id_klant);
                
                        // terug naar begin pagina
                        $accountaangemaakt[] = 'Klant is succesvol verwijderd.';
             $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
                        header('Location:../archiveer/klantoverzichtarchiveer.php');

                    
                }else{
                    header('Location:../klantoverzicht/klantoverzicht.php');
                }

        }
    }
}
