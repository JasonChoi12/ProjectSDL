<?php
require_once('../src/class.php');

require_once("../src/sessie.php");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="klantOverzicht.css" />
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
  <!--Navbar Import -->
  <div id="nav-placeholder"></div>

  <script>
    $(function() {
      $("#nav-placeholder").load("../navBar.php");
    });
  </script>
  `
  <div class="title">
    <h1>Klant Overzicht</h1>
    <form id="form">
      <div class="searchbar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="searchbar-input" type="search" id="query" name="q" placeholder="Search..." />
      </div>
      <?php
      // laat error code Zien
      if (isset($_SESSION['ERRORS'])) {
        echo $_SESSION['ERRORS'];
        unset($_SESSION['ERRORS']);
      }
      ?>
    </form>
    <div class="btn-group">
      <button class="exporteer">Exporteer</button>
      <a href="../Klant/klant.php"><button class="toevoegen">Toevoegen</button></a>
      <button class="bewerk">Bewerk</button>
      <button class="verwijderen">Verwijderen</button>
    </div>
    <table>
      <tr>
        <th id="table-left-border"></th>
        <th>Klant</th>
        <th>Woonplaats</th>
        <th>Adres</th>
        <th>Postcode</th>
        <th>Telefoon </th>
        <th>Projecten</th>
        <th id="table-right-border"></th>
      </tr>

      <?php
      // foreach klant om door alle rijen een loop te doen
      $klanten = new Klanten();
      $klanten_data = $klanten->KlantenZien();
      $projecten = new projecten();
      foreach ($klanten_data as $klant_data) {
        $id_klant = $klant_data['id_klant'];
      ?>
        <tr>
          <td class="checkbox">
            <input type="checkbox">
          </td>
          <td><?php echo $klant_data['klantnaam']; ?></td>
          <td><?php echo $klant_data['woonplaats']; ?></td>
          <td><?php echo $klant_data['straatnaam'] . " " . $klant_data['huisnummer']; ?></td>
          <td><?php echo $klant_data['postcode']; ?></td>
          <td><?php echo $klant_data['telefoonnummer']; ?></td>
          <td><?php $projecten_data = $projecten->Projectzien($id_klant);
            echo count($projecten_data);?></td>
          <td>
            <form method="get" action="../ProjectOverzicht/ProjectOverzicht.php">
              <input type="hidden" name="id_klant" value="<?php echo $klant_data['id_klant'] ?>">
              <button class="table-bewerk">Bekijk</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>

</html>