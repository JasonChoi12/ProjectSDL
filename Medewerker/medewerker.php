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
      <button class="exporteer">Verborgen</button>
      <a href="../Registreren/registreren.php"><button class="toevoegen">Toevoegen</button></a>
      <button type="submit" form="update" class="bewerk">Bewerken</button>
      <button  type="submit" form="delete" class="verwijderen">Verwijderen</button>
    </div>
    <table>
      <tr>
      <th id="table-left-border"><input id="selectAll" class="checkbox" type="checkbox"></th>
        <th>Medewerker</th>
        <th>Email</th>
        <th>Type Medewerker</th>
        <th id="table-right-border"></th>
      </tr>
      <?php
      // foreach klant om door alle rijen een loop te doen
      $gebruikers = new Gebruikers();
      $gebruikers_data = $gebruikers->GebruikersZien();
      foreach ($gebruikers_data as $gebruiker_data) {
      ?>
        <tr>
          <td class="checkbox">
            <input name="checkbox" type="checkbox" onchange="chkbox(this)" value="<?php echo $gebruiker_data['id_gebruiker']; ?>">

          </td>
          <td><?php echo $gebruiker_data['voornaam'] . " " . $gebruiker_data['tussenvoegsel'] . " " . $gebruiker_data['achternaam']; ?></td>
          <td><?php echo $gebruiker_data['email'] ?></td>
          <td><?php echo $gebruiker_data['usertype'] ?></td>
          <td>
            <form method="get" action="">
              <input type="hidden" name="id_gebruiker" value="<?php echo $gebruiker_data['id_gebruiker'] ?>">
              <button class="table-bewerk">Bekijken</button>
            </form>

          </td>
        </tr>
      <?php } ?>
    </table>
    <p id="sh"></p>
    <p id="sh1"></p>
    <form id="update" method="get" action="../Medewerker/medewerkerUpdate.php">
      <input value="" type="hidden" id="update-input" name="id_gebruiker" />
    </form>
    <form id="delete" method="get" action="../Medewerker/medewerkerDelete.php">
      <input value="" type="hidden" id="delete-input" name="id_gebruiker" />
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
      $('delete-input').val(d);
      document.getElementById("delete-input").value = d;
    } else {
      console.log(d)
      a = d[0];
      $('update-input').val(a);

      document.getElementById("update-input").value = a;

    }

  }
</script>

</html>