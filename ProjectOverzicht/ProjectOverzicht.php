<?php
require_once('../src/class.php');

require_once("../src/sessie.php");
$id_klant = $_GET["id_klant"];
$_SESSION["id_klant"]= $id_klant;
// unset($_SESSION["id_klant"]);
if(empty($id_klant)){
  $error[] = "Kies eerst een klant.";
  $_SESSION['ERRORS'] = implode('<br> ', $error);
  header('Location: ../KlantOverzicht/klantOverzicht.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="ProjectOverzicht.css" />
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
      <h1>Project Overzicht</h1>
      <form id="form">
        <div class="searchbar">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input
            class="searchbar-input"
            type="search"
            id="query"
            name="q"
            placeholder="Zoeken..."
          />
        </div>
      </form>
      <div class="btn-group">
        <button class="exporteer">Exporteren</button>
        <a href="../Projectaanmaak/ProjectAanmaak.php"><button class="toevoegen">Toevoegen</button></a>
        <button type="submit" form="update" class="bewerk">Bewerken</button>
        <button class="verwijderen">Verwijderen</button>
      </div>
      <table>
        <tr>
          <th id="table-left-border"></th>
          <th>Projectnaam</th>
          <th>Totale uren</th>
          <th>Declarabele uren</th>
          <th>Actief?</th>
          <th>Laatst geupdate </th>
          <th>Begindatum</th>
          <th id="table-right-border"></th>
        </tr>

        <?php
        // foreach klant om door alle rijen een loop te doen
        $projecten = new projecten();
        $projecten_data = $projecten->Projectzien($id_klant);
        foreach($projecten_data as $project_data){
        ?>
        <tr>
        <td class="checkbox">
            <input  type="checkbox" onchange="chkbox(this)" value="<?php echo $project_data['id_project'];?>">
          </td>
          <td><?php echo $project_data['projectnaam'];?></td>
          <td></td>
          <td></td>
          <td></td>
          <td><?php echo $project_data['laatst_gewerkt']; ?></td>
          <td><?php echo $project_data['begindatum'];?></td>
          <td><button class="table-bewerk">Bekijken</button></td>
        </tr>
        <?php }?>
      </table>
      <form id="update" method="get" action="../projectUpdate/projectUpdate.php">
    <input value="" type="hidden" id="update-input" name="id_project" />
    <input value="<?php echo $id_klant; ?>" type="hidden"  name="id_klant" />
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
        if(d && d.length > 1){
          $('sh').val(d);
           document.getElementById("sh").innerHTML = d;
        }else{
          console.log(d)
          a = d[0]; 
          $('update-input').val(a);
        
        document.getElementById("update-input").value = a;

        }
        
    }
    </script>
</html>
