<?php
session_start();
require_once('../src/class.php');
$klant = new Klanten();
//filter the excel data
$id_klant = $_POST['id_klant'];
// echo "het werkt ";
if (isset($_POST['submit'])) {
    // check id_klant
    if (empty($id_klant)) {
        $error[] = "Kies een klant.";
    }
    if (isset($error)) {
            
        $_SESSION['errors'] = implode('<br> ', $error);
        header('Location:../klantoverzicht/klantoverzicht.php');
    } else {
        $klant_data = $klant->KlantZien($id_klant);
        $klantnaam = $klant_data[0]["klantnaam"];
        function filterData(&$str)
        {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }
        // excel file name for download
        $fileName = "projectoverzicht_van_" . $klantnaam . "_export_data-" . date('Ymd') . ".xls";

        // column names
        $fields = array('Prj.N.', 'Projectnaam', 'Totale uren', 'Declarabele uren', 'Laatst geupdate', 'Begindatum');

        // display columns names as first row
        $excelData = implode("\t", array_values($fields)) . "\n";

        $projecten = new projecten();
        $projecten_data = $projecten->Projectenzienbydate($id_klant);
        $uren = new uren();
        // echo count($projecten_data);
        if (count($projecten_data) > 0) {

            foreach ($projecten_data as $project_data) {
                $uren_data = $uren->TotaleUrenZien($project_data['id_project']);

                $totaleUren = array_sum(array_column($uren_data, 'uren'));
                $new = array_filter($uren_data, function ($var) {
                    return ($var['declarabel'] == 'ja');
                });
                $declarabel = array_sum(array_column($new, 'uren'));
                $arr1 = array('totale uren' => number_format($totaleUren / 3600, 1));
                $arr2 = array('declarabel' => number_format($declarabel / 3600, 1));
                $project_data = $project_data + $arr1 + $arr2;
                // print_r($project_data);

                // echo "<br>";

                $Projecten_array = array($project_data["id_project"], $project_data["projectnaam"], $project_data["totale uren"], $project_data["declarabel"], $project_data["laatst_gewerkt"], $project_data["begindatum"]);
                array_walk($Projecten_array, 'filterData');
                $excelData .= implode("\t", array_values($Projecten_array)) . "\n";
                // print_r($project_data);
                // echo count($project_data);
            }
        } else {
            $excelData .= 'Geen Data gevonden...' . "\n";
        }
        // header for download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        echo $excelData;
        exit;
    }
}
