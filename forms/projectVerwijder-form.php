<?php
session_start();
require_once('../src/class.php');
$projecten = new projecten();
//filter the excel data
$id_project = $_POST['id_project'];
if (isset($_POST['submit'])) {
    // check id_project
    if (empty($id_project)) {
        $error[] = "Kies een project om te verwijderen.";
    }
    if (isset($error)) {

        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../Archiveer/projectOverzichtArchiveer.php');
    } else {

        if (!is_string($id_project)) {
            foreach ($id_project as $id_projecten) {
                $projecten_data = $projecten->projectZien($id_projecten);
                if ($projecten_data[0]['archiveer'] === 'ja') {
                    $delete = $projecten->Verwijderproject($id_projecten);
                  
                        header('Location:../Archiveer/projectOverzichtArchiveer.php');
                    
             
                       
                    
                }else{
                    header('Location:../projectOverzicht/projectOverzicht.php');
                }
            }
        } else {

            $projecten_data = $projecten->projectZien($id_project);
            if ($projecten_data[0]['archiveer'] === 'ja') {
            $delete = $projecten->Verwijderproject($id_project);
                
                        // terug naar begin pagina
                        header('Location:../Archiveer/projectOverzichtArchiveer.php');

                    
                }else{
                    header('Location:../projectOverzicht/projectOverzicht.php');
                }

        }
    }
}
