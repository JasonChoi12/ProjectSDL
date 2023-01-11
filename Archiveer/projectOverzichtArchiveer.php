<?php
require_once('../src/class.php');

require_once("../src/sessie.php");
if (!empty($_GET["id_klant"])) {
  $id_klant = $_GET["id_klant"];
setcookie("id_klant", $id_klant);
} elseif(!empty($_COOKIE["id_klant"])) {
  $id_klant = $_COOKIE["id_klant"];
setcookie("id_klant", "", time() - 3600);
}elseif(empty($id_klant)){
  $error[] = "Kies eerst een klant.";
  if(isset($error)){
    $_SESSION['errors'] = implode('<br> ', $error);
//   header('Location: ../klantoverzicht/klantoverzicht.php');
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="../projectoverzicht/projectoverzicht.css" />
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
    <h1>Project Overzicht</h1>

    <div class="searchbar">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input class="searchbar-input" type="search" id="query" name="q" placeholder="Zoeken..." />
    </div>
    <form method="get" action="../projectoverzicht/projectoverzicht.php">
    
              <input type="hidden" name="id_klant" value="<?php echo $id_klant; ?>">
              <button class="archiveerlijst">Bekijk Non-archiveerde</button>
            </form>
 

<div class="btn-group">
      <button name="submit" type="submit" form="export" class="exporteer">Exporteren</button>
      <button type="submit" form="update" class="bewerk">Bewerken</button>
      <button name="submit" type="submit" form="archiveer" class="toevoegen">De-archiveer</button>
      <button onclick="return confirm('Weet je het zeker dat je deze project(en) wilt verwijderen')" name="submit" type="submit" form="verwijder" class="verwijderen">Verwijder</button>
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
        <th>Projectnaam</th>
        <th>Totale uren</th>
        <th>Declarabele uren</th>
        <th>Actief?</th>
        <th>Laatst geupdate </th>
        <th>Begindatum</th>
        <th id="table-right-border"></th>
      </tr>

      <?php
      // print_r($_COOKIE);
      $projecten = new projecten();
      $projecten_data = $projecten->Projectenzien($id_klant);
      $uren = new uren();
      foreach ($projecten_data as $project_data) {
        if($project_data['archiveer'] === "ja"){
        $uren_data = $uren->TotaleUrenZien($project_data['id_project']);

        $totaleUren = array_sum(array_column($uren_data, 'uren'));
        $new = array_filter($uren_data, function ($var) {
          return ($var['declarabel'] == 'ja');
        });
        $declarabel = array_sum(array_column($new, 'uren'));

      ?>
        <tr>
          <td class="checkbox">
            <input name="checkbox" type="checkbox" onchange="chkbox(this)" value="<?php echo $project_data['id_project']; ?>">
          </td>
          <td><?php echo $project_data['projectnaam']; ?></td>
          <td><?php echo number_format($totaleUren / 3600, 1); ?></td>
          <td><?php echo number_format($declarabel / 3600, 1); ?></td>
          <td></td>
          <td><?php echo $project_data['laatst_gewerkt']; ?></td>
          <td><?php echo $project_data['begindatum']; ?></td>
          <td>
            <form method="get" action="../urenoverzicht/urenoverzicht.php">
              <input type="hidden" name="id_project" value="<?php echo $project_data['id_project']; ?>">
              <input type="hidden" name="id_klant" value="<?php echo $id_klant; ?>">
              <button class="table-bewerk">Bekijken</button>
            </form>
          </td>
        </tr>
      <?php }} ?>
    </table>
    <form id="update" method="get" action="../projectupdate/projectupdate.php">
      <input value="" type="hidden" id="update-input" name="id_project" />
      <input value="<?php echo $id_klant; ?>" type="hidden" name="id_klant" />
    </form>
    <form id="export" method="post" action="../forms/urenexport-form.php">
    <input value="" type="hidden" id="export-input" name="id_project" />
      <input value="<?php echo $id_klant; ?>" type="hidden" name="id_klant" />
    </form>
    <form id="archiveer" method="post" action="../forms/projectarchiveer-form.php">
    <input value="" type="hidden" id="archiveer-input" name="id_project" />
    <input type="hidden" id="archiveer" name="archiveer" value="nee" />
    <p id="archiveer"></p>
    </form>
    <form id="verwijder" method="post" action="../forms/projectverwijder-form.php">
    <input value="" type="hidden" id="verwijder-input" name="id_project" />
    <p id="verwijder"></p>
    </form>
    <!-- <p id="sh" hidden></p>
    <p id="sh1" hidden></p> -->
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
        // document.write("<input id='archiveer' value= "+ item +" type='hidden' id='archiveer-input'name='id_project[]'/>");
        text += "<input form='archiveer' id='archiveer' value= "+ item +" type='hidden' id='archiveer-input'name='id_project[]'/>";
        text += '<input type="hidden" id="archiveer" name="archiveer" value="nee" />';
      }
      d.forEach(verwijder);

      document.getElementById("verwijder").innerHTML = text;

      function verwijder(item, index) {
        text += "<input form='verwijder' id='verwijder' value= "+ item +" type='hidden' id='verwijder-input'name='id_project[]'/>";
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

</html>