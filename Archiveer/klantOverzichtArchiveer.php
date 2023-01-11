<?php
require_once('../src/class.php');

require_once("../src/sessie.php");
setcookie("id_klant", "", time() - 3600);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="../klantoverzicht/klantoverzicht.css" />
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
    <form method="get" action="../klantoverzicht/klantoverzicht.php">
                <button class="archiveerlijst">Bekijk Non-archiveerde</button>
              </form>
   
    <div class="btn-group">
      <button name="submit" type="submit" form="export" class="exporteer">Exporteren</button>
      <button type="submit" form="update" class="bewerk">Bewerken</button>
      <button name="submit" type="submit" form="archiveer" class="toevoegen">De-archiveer</button>
      <button onclick="return confirm('Weet je het zeker dat je deze klant(en) wilt verwijderen')"name="submit" type="submit" form="verwijder" class="verwijderen">Verwijder</button>
    </div>
    <?php
    // laat error code Zien

        // laat error code Zien
        if (isset($_SESSION['errors'])) {
          echo $_SESSION['errors'];
          unset($_SESSION['errors']);
        }
        // laat qr code Zien

        elseif (isset($_SESSION['succes'])) {
          echo $_SESSION['succes'];
          unset($_SESSION['succes']);
        } 
    // print_r($_COOKIE);
    ?>
    <table id="klantoverzicht">
      <tr>
        <th id="table-left-border"><input id="selectAll" class="checkbox" type="checkbox"></th>
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
        if ($klant_data['archiveer'] === "ja") {
          $id_klant = $klant_data['id_klant'];
      ?>
          <tr>
            <td>
              <input id="checkbox" name="checkbox" class="checkbox" type="checkbox" onchange="chkbox(this)" value="<?php echo $klant_data['id_klant']; ?>">
            </td>
            <td><?php echo $klant_data['klantnaam']; ?></td>
            <td><?php echo $klant_data['woonplaats']; ?></td>
            <td><?php echo $klant_data['straatnaam'] . " " . $klant_data['huisnummer']; ?></td>
            <td><?php echo $klant_data['postcode']; ?></td>
            <td><?php echo $klant_data['telefoonnummer']; ?></td>
            <td><?php $projecten_data = $projecten->projectenzien($id_klant);
                echo count($projecten_data); ?></td>
            <td>
              <form method="get" action="../projectoverzicht/projectoverzicht.php">
                <input type="hidden" name="id_klant" value="<?php echo $klant_data['id_klant'] ?>">
                <button class="table-bewerk">Bekijken</button>
              </form>
            </td>
          </tr>
      <?php }
      } ?>
    </table>
    <form id="update" method="get" action="../klantupdate/klantupdate.php">
      <input value="" type="hidden" id="update-input" name="id_klant" />
    </form>
    <form id="export" method="post" action="../forms/projectexport-form.php">
      <input value="" type="hidden" id="export-input" name="id_klant" />
    </form>
    <form id="archiveer" method="post" action="../forms/klantarchiveer-form.php">
    <input value="" type="hidden" id="archiveer-input" name="id_klant" />
    <input type="hidden" id="archiveer" name="archiveer" value="nee" />
    <p id="archiveer"></p>
    </form>
    <form id="verwijder" method="post" action="../forms/klantverwijder-form.php">
    <input value="" type="hidden" id="verwijder-input" name="id_klant" />
    <p id="verwijder"></p>
    </form>

    <p id="sh"></p>
    <!-- <p id="sh1"></p> -->

  </div>
</body>
<script type="text/javascript">
  document.getElementById('selectAll').onclick = function() {
    var box = document.getElementsByName('checkbox')
    for (var i = 0; i < box.length; i++) {
      box[i].checked = !box[i].checked;

      if ("createEvent" in document) {
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("change", false, true);
        box[i].dispatchEvent(evt);
      } else {
        box[i].fireEvent("onchange");
      }
    }
  };

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
      console.log(d.length)
      $('#archiveer-input').val(d);
      $('#delete-input').val(d);

      console.log(d)
      // console.log(typeof d)
      //  document.getElementById("sh").innerHTML = d;
      let text = "";
      d.forEach(archiveer);

      document.getElementById("archiveer").innerHTML = text;

      function archiveer(item, index) {
        // document.write("<input id='archiveer' value= "+ item +" type='hidden' id='archiveer-input'name='id_klant[]'/>");
        text += "<input form='archiveer' id='archiveer' value= "+ item +" type='hidden' id='archiveer-input'name='id_klant[]'/>";
        text += '<input type="hidden" id="archiveer" name="archiveer" value="nee" />';
      }
      d.forEach(verwijder);

      document.getElementById("verwijder").innerHTML = text;

      function verwijder(item, index) {
        text += "<input form='verwijder' id='verwijder' value= "+ item +" type='hidden' id='verwijder-input'name='id_klant[]'/>";
      }
      
    } else {
      console.log(d)
      a = d[0];
      $('#update-input').val(a);
      $('#archiveer-input').val(a);
      $('#verwijder-input').val(a);
      $('#export-input').val(a);

    }

  }
</script>
