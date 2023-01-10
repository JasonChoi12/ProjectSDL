<?php
session_start();
require_once('../src/class.php');
$uren = new uren();
//filter the excel data
$id_project = $_POST['id_project'];
$id_klant = $_POST['id_klant'];
if (isset($_POST['submit'])) {
  // check id_klant
  if (empty($id_project)) {
      $error[] = "Kies een project.";
  }
  if (isset($error)) {
          
      $_SESSION['errors'] = implode('<br> ', $error);
      header('Location:../projectoverzicht/projectoverzicht.php');
  } else {
$uren_data = $uren->Exportuurzien($id_project);

// print_r($uren_data);
$projectnaam = $uren_data[0]["projectnaam"];
$klantnaam = $uren_data[0]["klantnaam"];
$laatst_gewerkt = $uren_data[0]["laatst_gewerkt"];


$projecten = new projecten();
$projecten_data = $projecten->Projectenzien($id_klant);
$uren = new uren();

  $totaleuren_data = $uren->TotaleUrenZien($id_project);
    
  $totaleUren = array_sum(array_column($totaleuren_data, 'uren'));
  $new = array_filter($totaleuren_data, function ($var) {
    return ($var['declarabel'] == 'ja');
  });
  $declarabel = array_sum(array_column($new, 'uren'));

$declarabel = number_format($declarabel / 3600, 1);
$totaleUren = number_format($totaleUren / 3600, 1);


// echo "<br>". $projectnaam. " ". $klantnaam. " ".$laatst_gewerkt. " ".$declarabel. " ".$totaleUren;
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
// excel file name for download
$fileName = "urenoverzicht_van_".$projectnaam."_export_data-" . date('Ymd') . ".xls";

// column names
$titel = array('Klantnaam: '.$klantnaam, 'Projectnaam: '.$projectnaam, 'Laatst Bijgewerkt: '.$laatst_gewerkt, 'Totale Uren: '.$totaleUren, 'Waarvan Declarabel: '.$declarabel);

// display columns names as first row
$excelData = implode("\t", array_values($titel)) . "\n";


// column names
$fields = array('Uren.N.', 'Activiteit', 'Declarabel', 'Uren', 'Begonnen', 'Beeindigd', 'Datum', 'Door:');

// display columns names as first row
$excelData .= implode("\t", array_values($fields)) . "\n";

// echo "<br>". count($uren_data);
// print_r($uren_data);
if(count($uren_data) > 0){

      foreach ($uren_data as $uur_data) {
        $naam = $uur_data["voornaam"]. " ". $uur_data["tussenvoegsel"]. " ".$uur_data["achternaam"];
    $filteruren_data = array($uur_data["id_uren"], $uur_data["activiteit"], $uur_data["declarabel"],  number_format($uur_data["uren"] / 3600, 1), gmdate("H:i", $uur_data["begonnen"]), gmdate("H:i", $uur_data["beeindigd"]), $uur_data["datum"], $naam);
    array_walk($filteruren_data, 'filterData');
    $excelData .= implode("\t", array_values($filteruren_data)). "\n";


    }
}else{
        $excelData .= 'Geen Data gevonden...'. "\n";
    }
// header for download
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 

echo $excelData;
exit;
  }}