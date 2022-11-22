<?php
require_once('../src/class.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="klantOverzicht.css" />
    <link rel="stylesheet" href="../style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  </head>
  <body>
    <!--Navbar Import -->
    <div id="nav-placeholder"></div>

    <script>
      $(function () {
        $("#nav-placeholder").load("../navBar.php");
      });
    </script>
    `
    <div class="title">
      <h1>Klant Overzicht</h1>
      <form id="form">
        <div class="searchbar">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input
            class="searchbar-input"
            type="search"
            id="query"
            name="q"
            placeholder="Search..."
          />
        </div>
      </form>
      <div class="btn-group">
        <button class="exporteer">Exporteer</button>
        <button class="toevoegen">Toevoegen</button>
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
          <th>Project</th>
          <th>Medewerkers</th>
          <th>Uren</th>
          <th>Aantal Declarabel</th>
          <th>Opmerking</th>
          <th >Datum</th>
          <th id="table-right-border"></th>
        </tr>
        <!-- <tr>
          <td class="checkbox">
            <input type="checkbox">
          </td>
          <td>John Doe</td>
          <td>Amsterdam</td>
          <td>Remiaplein 12</td>
          <td>1234AB</td>
          <td>W&S</td>
          <td>Johny Vos & Rob van Puffellen</td>
          <td>6</td>
          <td>3</td>
          <td>Lorem Ipsum</td>
          <td>01-05-2022/15-05-2022</td>
          <td><button class="table-bewerk">Bekijk</button></td>
        </tr> -->
        <?php
        // foreach klant om door alle rijen een loop te doen
        $klanten = new Klanten();
        $klanten_data = $klanten->KlantZien();
        foreach($klanten_data as $klant_data){

        

        ?>
        <tr>
          <td class="checkbox">
            <input type="checkbox">
          </td>
          <td><?php echo $klant_data['klantnaam'];?></td>
          <td><?php echo $klant_data['woonplaats'];?></td>
          <td><?php echo $klant_data['straatnaam']. " " .$klant_data['huisnummer']; ?></td>
          <td><?php echo $klant_data['postcode'];?></td>
          <td>W&S</td>
          <td>Johny Vos & Rob van Puffellen</td>
          <td>6</td>
          <td>3</td>
          <td>Lorem Ipsum</td>
          <td >01-05-2022/15-05-2022</td>
          <td><button class="table-bewerk">Bekijk</button></td>
        </tr>
        <?php }?>
      </table>
    </div>
  </body>
</html>
