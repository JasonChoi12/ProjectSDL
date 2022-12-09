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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
  <!--Navbar Import -->
  <div id="nav-placeholder"></div>

  <script>
    $(function() {
      $("#nav-placeholder").load("../navBar.php");
    });

    function searchBar() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("query");
      filter = input.value.toUpperCase();
      table = document.getElementById("klantoverzicht");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>

  <div class="title">
    <h1>Klant Overzicht</h1>
    <div class="searchbar">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" class="searchbar-input" id="query" onkeyup="searchBar()" placeholder="Zoeken">
    </div>
    <?php
    // laat error code Zien
    if (isset($_SESSION['ERRORS'])) {
      echo $_SESSION['ERRORS'];
      unset($_SESSION['ERRORS']);
    }
    ?>
    <div class="btn-group">
      <button class="exporteer">Exporteren</button>
      <a href="../Klant/klant.php"><button class="toevoegen">Toevoegen</button></a>
      <button type="submit" form="update" class="bewerk">Bewerken</button>
      <button class="verwijderen">Verwijderen</button>
    </div>
    <table id="klantoverzicht">
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
          <input type="checkbox" onchange="chkbox(this)" value="<?php echo $klant_data['id_klant']; ?>">
        </td>
        <td><?php echo $klant_data['klantnaam']; ?></td>
        <td><?php echo $klant_data['woonplaats']; ?></td>
        <td><?php echo $klant_data['straatnaam'] . " " . $klant_data['huisnummer']; ?></td>
        <td><?php echo $klant_data['postcode']; ?></td>
        <td><?php echo $klant_data['telefoonnummer']; ?></td>
        <td><?php $projecten_data = $projecten->Projectenzien($id_klant);
            echo count($projecten_data); ?></td>
        <td>
          <form method="get" action="../ProjectOverzicht/ProjectOverzicht.php">
            <input type="hidden" name="id_klant" value="<?php echo $klant_data['id_klant'] ?>">
            <button class="table-bewerk">Bekijken</button>
          </form>
        </td>
      </tr>
    <?php } ?>
    </table>
    <form id="update" method="get" action="../klantUpdate/klantUpdate.php">
      <input value="" type="hidden" id="update-input" name="id_klant" />
    </form>
    <!-- <p id="sh"></p>
    <p id="sh1"></p> -->

  </div>
</body>
<script type="text/javascript">
  var d = new Array();

  function chkbox(this1) {
    var s = this1.value;
    if (this1.checked) {
      d.push(s);
    } else {
      var index = d.indexOf(s);
      if (index > -1) {
        d.splice(index, 1);
      }
    }
    // console.log(d);
    if (d && d.length > 1) {
      $('#delete').val(d);
      //  document.getElementById("sh").innerHTML = d;
    } else {
      console.log(d)
      a = d[0];
      $('#update-input').val(a);

      document.getElementById("update-input").value = a;

    }

  }
</script>

</html>