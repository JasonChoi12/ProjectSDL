<?php
session_start();
require_once('../src/class.php');
$uren = new uren();
//filter the excel data
$id_uur = $_POST['id_uren'];
// print_r($id_uur);
if (isset($_POST['submit'])) {
    // check id_uur
    if (empty($id_uur)) {
        $error[] = "Kies een registratie om te verwijderen.";
    }
    if (isset($error)) {

        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../archiveer/urenoverzichtarchiveer.php');
    } else {

        if (!is_string($id_uur)) {
            foreach ($id_uur as $id_uren) {
                $uren_data = $uren->uurZien($id_uren);
                // print_r($uren_data);
                if ($uren_data[0]['archiveer'] === 'ja') {
                    $delete = $uren->VerwijderUren($id_uren);
                    $accountaangemaakt[] = 'urenregistratie is succesvol verwijderd.';
                    $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
                        header('Location:../archiveer/urenoverzichtarchiveer.php');
                    
             
                       
                    
                }else{
                    header('Location:../urenoverzicht/urenoverzicht.php');
                }
            }
        } else {

            $uren_data = $uren->uurZien($id_uur);
            if ($uren_data[0]['archiveer'] === 'ja') {
            $delete = $uren->VerwijderUren($id_uur);
            $accountaangemaakt[] = 'urenregistratie is succesvol verwijderd.';
            $_SESSION['succes'] = implode('<br> ', $accountaangemaakt);
                        // terug naar begin pagina
                        header('Location:../archiveer/urenoverzichtarchiveer.php');

                    
                }else{
                    header('Location:../urenoverzicht/urenoverzicht.php');
                }

        }
    }
}
