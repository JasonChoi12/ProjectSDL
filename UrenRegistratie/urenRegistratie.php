<?php
require_once("../src/sessie.php");
$user = unserialize($_SESSION['gebruiker_data']);
$id_gebruiker = $user->id;
setcookie("id_project", "", time() - 3600);
if (isset($error)) {
  $_SESSION['ERRORS'] = implode('<br> ', $error);
  header('Location:../registreren/registreren.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="urenRegistratie.css" />
  <link rel="stylesheet" href="../style.css" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <title>Uren registratie</title>
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
    <h1>Uren registreren</h1>

    <form method="POST">
      <div class="klant">
        <label>Klant *</label><br />
        <?php
        $klanten = new Klanten;
        $klanten_data = $klanten->KlantenZien();
        $projecten = new projecten;
        if (!empty($_COOKIE["id_klant"])) {
          $id_klant = $_COOKIE["id_klant"];


          $projecten_data = $projecten->Projectenzien($id_klant);
        } else {
          $id_klant = "";
        }




        if (empty($id_klant)) {

          echo '<input onchange="this.form.submit()" class="klant-input" list="klanten" id="input" name="klant" placeholder="Klantnaam" />
        <datalist id="klanten">';
          foreach ($klanten_data as $klant_data) {
            echo '<option data-id="' . "$klant_data[id_klant]" . '" value=' . "$klant_data[klantnaam]" . '></option>
                >';
            echo  '<input name="klantid" value="' . $klant_data["id_klant"] . '" type="hidden" id="klantid" />';
          }
          '
        </datalist>'; ?><input name="id_klant" value="id_klant" type="" id="id_klant" />
          <script type="text/javascript">
            $(function() {
              $('#input').change(function() {
                let abc = $("#klanten option[value='" + $('#input').val() + "']").attr('data-id');
                $('#id_klant').val(abc)
                console.log(abc);
                document.cookie = "id_klant=  " + abc;
                console.log(document.cookie);

              });
            });
          </script>

        <?php
        } else {
          $klant_data = $klanten->KlantZien($id_klant);
          echo '<input onchange="this.form.submit()" class="klant-input" list="klanten" id="input" name="klant" placeholder=' . $klant_data[0]["klantnaam"] . '>
        <datalist id="klanten">';
          foreach ($klanten_data as $klant_data) {
            echo '<option data-id="' . "$klant_data[id_klant]" . '" value=' . "$klant_data[klantnaam]" . '></option>
                >';
            echo  '<input name="klantid" value="' . $klant_data["id_klant"] . '" type="hidden" id="klantid" />';
          }
          '
        </datalist>'; ?><input name="id_klant" value="id_klant" type="" id="id_klant" />
          <script type="text/javascript">
            $(function() {
              $('#input').change(function() {
                let abc = $("#klanten option[value='" + $('#input').val() + "']").attr('data-id');
                $('#id_klant').val(abc)
                console.log(abc);
                document.cookie = "id_klant=  " + abc;
                console.log(document.cookie);

              });
            });
          </script>

        <?php
        } ?>
      </div>
      <br />
      <div>
        <label>Project *</label><br />
        <?php
        if (!empty($_COOKIE["id_project"])) {
          $id_project = $_COOKIE["id_project"];
        } else {
          $id_project = "";
        }
        if (empty($id_project)) {

          echo '<input onchange="this.form.submit()" class="klant-input" list="projecten" id="project" name="project" placeholder="Projectnaam"/>
<datalist id="projecten">';
          foreach ($projecten_data as $project_data) {
            echo '<option data-id="' . "$project_data[id_project]" . '" value=' . "$project_data[projectnaam]" . '></option>
      >';
            echo  '<input name="projectid" value="' . $$project_data["id_project"] . '" type="hidden" id="projectid" />';
          }
          '
</datalist>'; ?><input name="id_project" value="id_project" type="" id="id_project" />
          <script type="text/javascript">
            $(function() {
              $('#project').change(function() {
                let def = $("#projecten option[value='" + $('#project').val() + "']").attr('data-id');
                $('#id_project').val(def)
                console.log(def);
                document.cookie = "id_project=  " + def;
                console.log(document.cookie);

              });
            });
          </script>

        <?php
        } else {

          $projecten = new projecten;
          $project_data = $projecten->Projectzien($id_klant, $id_project);
          echo '<input onchange="this.form.submit()" class="klant-input" list="projecten" id="project" name="project" placeholder=' . $project_data[0]["projectnaam"] . ' />
<datalist id="projecten">';
          foreach ($projecten_data as $project_data) {
            echo '<option data-id="' . "$project_data[id_project]" . '" value=' . "$project_data[projectnaam]" . '></option>
      >';
            echo  '<input name="projectid" value="' . $$project_data["id_project"] . '" type="hidden" id="projectid" />';
          }
          '
</datalist>'; ?><input name="id_project" value="id_project" type="" id="id_project" />
          <script type="text/javascript">
            $(function() {
              $('#project').change(function() {
                let def = $("#projecten option[value='" + $('#project').val() + "']").attr('data-id');
                $('#id_project').val(def)
                console.log(def);
                document.cookie = "id_project=  " + def;
                console.log(document.cookie);

              });
            });
          </script>

        <?php
        } ?>
      </div>
      <br />
    </form>
    <div class="middle-line">
        <form action="../forms/UrenRegistreren-form.php" method="post">
    <?php //echo $id_klant. " " . $id_project;?>
    <input name="id_klant" value="<?php echo $id_klant;?>" type="hidden" id="id_klant" />
    <input name="id_project" value="<?php echo $id_project;?>" type="hidden" id="id_project" />
    <input name="id_gebruiker" value="<?php echo $id_gebruiker;?>" type="hidden" id="id_gebruiker" />
    <div class="activiteit">
          <label>Activiteit<br />
            <input class="activiteit-input" name="activiteiten" placeholder="Activiteit" />
          </label>
        </div>
        <div class="datum">
          <label>Datum *
            <br />
            <input type="date" class="datum-input" name="datum" />
          </label>
        </div>
    </div>
    <div class="tijd-line">
      <div class="tijd">
        <label>Begonnen om<br />
          <input id="start" type="time" class="tijd-input" name="begonnen" /></label>
      </div>
      <div class="eindtijd">
        <label>Beïndigd om<br />
          <input oninput="bereken()" id="end" type="time" class="tijd-input" name="beëindigd" /></label>
      </div>
      <div class="toteindtijd">
        <label>Totale gewerkte tijd<br />
          <input id="diff" class="tijd-input" type="text" name="uren" placeholder="23:59" required /></label>
        <input id="diff-hidden" class="tijd-input" type="hidden" name="Buren" placeholder="" /></label>
      </div>

      <div class="btn">
        <button name="submit" class="submit">Toevoegen</button>
      </div>
    </div>

    </form><br>
    <div class="error">
      <?php
      // print_r($klanten_data);
      // laat error code Zien
      if (isset($_SESSION['ERRORS'])) {
        echo $_SESSION['ERRORS'];
        unset($_SESSION['ERRORS']);
      }
      if (empty($projecten_data)) {
        echo  "Er moeten nog projecten worden aangemaakt";
      }
      if (empty($klanten_data)) {
        $error[] = "er moeten nog klanten worden gemaakt";
      }
      ?>
    </div>
  </div>
</body>
<script>
  let start = document.getElementById("start").value;
  let end = document.getElementById("end").value;

  document.getElementById("start").onchange = function() {
    diff(start, end)
  };
  document.getElementById("end").onchange = function() {
    diff(start, end)
  };


  function diff(start, end) {
    start = document.getElementById("start").value; //to update time value in each input bar
    end = document.getElementById("end").value; //to update time value in each input bar

    start = start.split(":");
    end = end.split(":");
    let startDate = new Date(0, 0, 0, start[0], start[1], 0);
    let endDate = new Date(0, 0, 0, end[0], end[1], 0);
    let diff = endDate.getTime() - startDate.getTime();
    let hours = Math.floor(diff / 1000 / 60 / 60);
    diff -= hours * 1000 * 60 * 60;
    let minutes = Math.floor(diff / 1000 / 60);

    return (hours < 9 ? "0" : "") + hours + ":" + (minutes < 9 ? "0" : "") + minutes;
  }

  function bereken() {

    setInterval(function() {
      document.getElementById("diff").placeholder = diff(start, end);
      document.getElementById("diff-hidden").value = diff(start, end);
    }, 1000); //to update time every second (1000 is 1 sec interval and function encasing original code you had down here is because setInterval only reads functions) You can change how fast the time updates by lowering the time interval
  }
</script>

</html>