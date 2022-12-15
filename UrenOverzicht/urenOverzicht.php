<?php
require_once('../src/class.php');

require_once("../src/sessie.php");
$id_project = $_GET["id_project"];
$id_klant = $_GET["id_klant"];
$_SESSION["id_klant"] = $id_klant;
$_SESSION["id_project"] = $id_project;
unset($_SESSION["id_project"]);
unset($_SESSION["id_klant"]);
if (empty($id_project)) {
  $error[] = "Kies eerst een project.";
  $_SESSION['ERRORS'] = implode('<br> ', $error);
  header('Location: ../ProjectOverzicht/ProjectOverzicht.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="urenOverzicht.css" />
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <title>Uren Overzicht</title>
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
      table = document.getElementById("urenoverzicht");
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

    function toggle(source) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source) checkboxes[i].checked = source.checked;
      }
    }
  </script>

  <div class="title">
    <h1>Uren Overzicht Persoonlijk</h1>
    <div class="searchbar">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" class="searchbar-input" id="query" onkeyup="searchBar()" placeholder="Zoeken" />
    </div>

    <button class="overzicht">Terug naar overzicht</button>
    <div class="btn-group">
      <button class="exporteer">Exporteren</button>
      <a href="../uren/ProjectAanmaak.php"><button class="toevoegen">Toevoegen</button></a>
      <button type="submit" form="update" class="bewerk">Bewerken</button>
      <button class="verwijderen">Verwijderen</button>
    </div>
    <table id="urenoverzicht">
      <tr>
        <th id="table-left-border">
          <input class="checkbox" type="checkbox" onClick="toggle(this)" />
        </th>
        <th>Medewerker</th>
        <th>Activiteit</th>
        <th>Decl.</th>
        <th>Uren</th>
        <th>Begonnen om</th>
        <th>Beïndigd om</th>
        <th id="table-right-border">Datum</th>
      </tr>
      <?php
      // foreach klant om door alle rijen een loop te doen
      $uren = new uren();
      $uren_data = $uren->UrenZien($id_project);
      // print_r($uren_data);
      foreach ($uren_data as $uur_data) {

      ?>
        <tr>
          <td class="checkbox">
            <input type="checkbox" onchange="chkbox(this)" value="<?php echo $uur_data['id_uren']; ?>">
          </td>
          <td><?php echo $uur_data['voornaam'] . " " . $uur_data['tussenvoegsel'] . " " . $uur_data['achternaam']; ?></td>
          <td>
            <?php echo $uur_data['activiteit'] ?>
          </td>
          <td><?php echo $uur_data['declarabel'] ?></td>
          <td><?php echo gmdate("H:i", $uur_data['uren']) ?></td>
          <td><?php echo gmdate("H:i", $uur_data['begonnen']) ?></td>
          <td><?php echo gmdate("H:i", $uur_data['beeindigd']) ?></td>
          <td><?php echo $uur_data['datum'] ?></td>
        </tr>
      <?php } ?>
    </table>
    <form id="update" method="get" action="../urenUpdate/urenUpdate.php">
      <input value="" type="hidden" id="update-input" name="id_uren" />
      <input value="<?php echo $id_klant; ?>" type="hidden" name="id_klant" />
    </form>
    <p id="sh"></p>
    <p id="sh1"></p>
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
      $('sh').val(d);
      document.getElementById("sh").innerHTML = d;
    } else {
      console.log(d)
      a = d[0];
      $('update-input').val(a);

      document.getElementById("update-input").value = a;

    }

  }
</script>

</html>