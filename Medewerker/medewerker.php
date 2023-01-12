<?php
require_once("../src/sessie.php");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="medewerker.css" />
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

  <div class="title">
    <h1>Medewerker Overzicht</h1>
    <form id="form">
      <div class="searchbar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="searchbar-input" type="search" id="query" name="q" placeholder="Zoeken..." />
      </div>

    </form>

    <div class="btn-group">
      <a href="../registreren/registreren.php"><button class="toevoegen">Toevoegen</button></a>
      <button type="submit" form="update" class="bewerk">Bewerken</button>
      <button onclick="return confirm('Weet je het zeker dat je deze medewerker(s) wilt verwijderen')" name="submit" type="submit" form="verwijder" class="verwijderen">Verwijder</button>

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
    <table>
      <tr>
        <th id="table-left-border"><input id="selectAll" class="checkbox" type="checkbox"></th>
        <th>Medewerker</th>
        <th>Email</th>
        <th>Type medewerker</th>
        <th id="table-right-border"></th>
      </tr>
      <?php
      // foreach klant om door alle rijen een loop te doen
      $gebruikers = new Gebruikers();
      $gebruikers_data = $gebruikers->GebruikersZien();
      foreach ($gebruikers_data as $gebruiker_data) {

      ?>
        <tr>
          <td class="test">
            <input name="checkbox" class="checkbox" type="checkbox" onchange="chkbox(this)" value="<?php echo $gebruiker_data['id_gebruiker']; ?>">

          </td>
          <td><?php echo $gebruiker_data['voornaam'] . " " . $gebruiker_data['tussenvoegsel'] . " " . $gebruiker_data['achternaam']; ?></td>
          <td><?php echo $gebruiker_data['email'] ?></td>
          <td><?php echo $gebruiker_data['usertype'] ?></td>

        </tr>
      <?php } ?>
    </table>
    <form id="verwijder" method="post" action="../forms/medewerkerverwijder-form.php">
      <input value="" type="hidden" id="verwijder-input" name="id_gebruiker" />
      <p id="verwijder"></p>
    </form>
    <form id="update" method="get" action="../medewerker/medewerkerupdate.php">
      <input value="" type="hidden" id="update-input" name="id_gebruiker" />
    </form>

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

      let text = "";


      d.forEach(verwijder);

      document.getElementById("verwijder").innerHTML = text;

      function verwijder(item, index) {
        text += "<input form='verwijder' id='verwijder' value= " + item + " type='hidden' id='verwijder-input'name='id_gebruiker[]'/>";
      }

    } else {
      console.log(d)
      a = d[0];
      $('#update-input').val(a);
      $('#verwijder-input').val(a);


    }

  }
</script>

</html>