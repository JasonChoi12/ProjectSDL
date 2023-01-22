<?php
require_once('../src/class.php');


require_once("../src/sessie.php");
$user = unserialize($_SESSION['gebruiker_data']);

if (!empty($_GET["id_project"])) {
  $id_project = $_GET["id_project"];
  // $id_klant = $_GET["id_klant"];
  setcookie("id_project", $id_project);
} elseif (!empty($_COOKIE["id_project"])) {
  $id_project = $_COOKIE["id_project"];
  setcookie("id_project", "", time() - 3600);
} elseif (empty($id_project)) {

  $error[] = "Kies eerst een project.";
  if (isset($error)) {
    $_SESSION['errors'] = implode('<br> ', $error);
    header('Location: ../projectoverzicht/projectoverzicht.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="urenoverzicht.css" />
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
  </script>

  <div class="title">
    <h1>Uren Overzicht</h1>
    <div class="searchbar">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" class="searchbar-input" id="query" onkeyup="searchBar()" placeholder="Zoeken" />
    </div>
    <form method="get" action="../archiveer/urenoverzichtarchiveer.php">

      <input type="hidden" name="id_project" value="<?php echo $id_project; ?>">
      <button class="archiveerlijst">Bekijk archiveerde</button>
    </form>

    <div class="btn-group">
      <?php if($user->usertype === "admin"){?>
    <button name="submit" type="submit" form="declareren" class="declareren">Declareren</button>
<?php }?>
      <a href="../urenregistratie/urenregistratie.php"><button class="toevoegen">Toevoegen</button></a>
      <button type="submit" form="update" class="bewerk">Bewerken</button>
      <button name="submit" type="submit" form="archiveer" class="verwijderen">Archiveer</button>
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
    <table id="urenoverzicht">
      <tr>
        <th id="table-left-border">
          <input id="selectAll" class="checkbox" type="checkbox" />
        </th>
        <th>Medewerker</th>
        <th>Activiteit</th>
        <th>Decl.</th>
        <th>Bonus mdw</th>
        <th>Uren</th>
        <th>Begonnen om</th>
        <th>Beïndigd om</th>
        <th id="table-right-border">Datum</th>
      </tr>
      <?php
      // print_r($_SESSION);
      // foreach klant om door alle rijen een loop te doen
      $uren = new uren();
      $uren_data = $uren->UrenZien($id_project);
      $medewerker = new Gebruikers;
      // print_r($uren_data);
      foreach ($uren_data as $uur_data) {
        if ($uur_data['archiveer'] === "nee") {


      ?>
          <tr>
            <td class="checkbox">
              <input name="checkbox" type="checkbox" onchange="chkbox(this)" value="<?php echo $uur_data['id_uren']; ?>">
            </td>
            <td><?php echo $uur_data['voornaam'] . " " . $uur_data['tussenvoegsel'] . " " . $uur_data['achternaam']; ?></td>
            <td>
              <?php echo $uur_data['activiteit'] ?>
            </td>
            <td><?php echo $uur_data['declarabel'] ?></td>
            <td> <?php
                  if (!empty($uur_data['id_bonusmedewerker'])) {
                    $medewerker_data = $medewerker->GebruikerZien($uur_data['id_bonusmedewerker']);
                    echo $medewerker_data[0]["voornaam"] . " " . $medewerker_data[0]["tussenvoegsel"] . " " . $medewerker_data[0]["achternaam"];
                  } ?>

            </td>
            <td><?php echo gmdate("H:i", $uur_data['uren']) ?></td>
            <td><?php echo gmdate("H:i", $uur_data['begonnen']) ?></td>
            <td><?php echo gmdate("H:i", $uur_data['beeindigd']) ?></td>
            <td><?php echo $uur_data['datum'] ?></td>
          </tr>
      <?php }
      } ?>
    </table>
    <form id="update" method="get" action="../urenbewerken/urenbewerken.php">
      <input value="" type="hidden" id="update-input" name="id_uren" />
      <input value="<?php echo $id_project; ?>" type="hidden" name="id_project" />
    </form>
    <form id="archiveer" method="post" action="../forms/urenarchiveer-form.php">
      <input value="" type="hidden" id="archiveer-input" name="id_uren" />
      <input type="hidden" id="archiveer" name="archiveer" value="ja" />
      <p id="archiveer"></p>
    </form>
    <form id="declareren" method="post" action="../forms/urendeclareren-form.php">
      <input value="" type="hidden" id="declareren-input" name="id_uren" />
      <input value="<?php echo $id_project; ?>" type="hidden" name="id_project" />
      <p id="declareren"></p>
    </form>
    <p id="sh" hidden></p>
    <p id="sh1" hidden></p>
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
      $('#declareren-input').val(d);

      console.log(d)
      // console.log(typeof d)
      //  document.getElementById("sh").innerHTML = d;
      let text = "";
      d.forEach(archiveer);

      document.getElementById("archiveer").innerHTML = text;

      function archiveer(item, index) {
        // document.write("<input id='archiveer' value= "+ item +" type='hidden' id='archiveer-input'name='id_uren[]'/>");
        text += "<input form='archiveer' id='archiveer' value= " + item + " type='hidden' id='archiveer-input'name='id_uren[]'/>";
        text += '<input type="hidden" id="archiveer" name="archiveer" value="ja" />';
      }
      d.forEach(declareren);

      document.getElementById("declareren").innerHTML = text;

      function declareren(item, index) {
        text += "<input form='declareren' id='declareren' value= " + item + " type='hidden' id='declareren-input'name='id_uren[]'/>";
        // text += '<input type="hidden" id="declareren" name="declarabel" value="verander" />';
        text += '<input type="hidden" id="declareren" name="id_project" value="<?php echo $id_project; ?>" />';

      }

    } else {
      console.log(d)
      a = d[0];
      $('#update-input').val(a);
      $('#archiveer-input').val(a);
      $('#declareren-input').val(a);
      $('#export-input').val(a);

    }

  }
</script>

</html>