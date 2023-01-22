<?php
require_once("../src/sessie.php");
$user = unserialize($_SESSION['gebruiker_data']);
$id_gebruiker = $user->id;
setcookie("id_project", "", time() - 3600);
// setcookie("id_klant", "", time() - 3600);

if (isset($error)) {
  $_SESSION['ERRORS'] = implode('<br> ', $error);
  header('Location:../urenregistratie/urenregistratie.php');
}
// print_r($_COOKIE);
// test
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="urenregistratie.css" />
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
          if ($_COOKIE["id_klant"] === "undefined") {
            $error = "Klik op een klant i.p.v. typen.";
          }
          $id_klant = $_COOKIE["id_klant"];


          $projecten_data = $projecten->Projectenzien($id_klant);
        } else {
          $id_klant = "";
        }



        if (empty($id_klant) || $id_klant === "undefined") {

          $klanten_data = $klanten->KlantenZien();
          echo '<input onkeydown="return /[a-z]/i.test(event.key)" onchange="this.form.submit()" class="klant-input" list="klanten" id="input" name="klant" placeholder="Klantnaam" />
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
          $klanten = new Klanten;
          $klanten_data = $klanten->KlantenZien();
          $id = array_search($id_klant, array_column($klanten_data, 'id_klant'));


          echo '<input onkeydown="return /[a-z]/i.test(event.key)" onchange="this.form.submit()" class="klant-input" list="klanten" id="input" name="klant" placeholder=' . $klanten_data[$id]["klantnaam"] . '>
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
          if ($_COOKIE["id_project"] === "undefined") {
            $error = '<br>' . "Klik op een project i.p.v. typen.";
          }
          $id_project = $_COOKIE["id_project"];
        } else {
          $id_project = "";
        }
        if (empty($id_project) || $id_project === "undefined") {

          echo '<input onkeydown="return /[a-z]/i.test(event.key)" onchange="this.form.submit()" class="klant-input" list="projecten" id="project" name="project" placeholder="Projectnaam"/>
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

          $projecten_data = $projecten->Projectzien($id_project);
          $id = array_search($id_project, array_column($projecten_data, 'id_project'));

          echo '<input onkeydown="return /[a-z]/i.test(event.key)" onchange="this.form.submit()" class="klant-input" list="projecten" id="project" name="project" placeholder=' . $projecten_data[$id]["projectnaam"] . ' />
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

    <div>
      <form action="../forms/urenregistreren-form.php" method="post">
        <?php //echo $id_klant. " " . $id_project;
        ?>
        <input name="id_klant" value="<?php echo $id_klant; ?>" type="hidden" id="id_klant" />
        <input name="id_project" value="<?php echo $id_project; ?>" type="hidden" id="id_project" />
        <input name="id_gebruiker" value="<?php echo $id_gebruiker; ?>" type="hidden" id="id_gebruiker" />
        <label>Bonus medewerker</label><br />
        <?php
        // foreach klant om door alle rijen een loop te doen
        $gebruikers = new Gebruikers();
        $gebruikers_data = $gebruikers->GebruikersZien();
        // foreach ($gebruikers_data as $gebruiker_data) {
        ?>
        <input class="klant-input" list="medewerkers" id="input-medewerker" name="medewerker" placeholder="Medewerkers" />
        <datalist id="medewerkers">
          <?php

          foreach ($gebruikers_data as $gebruiker_data) {
            if ($gebruiker_data["id_gebruiker"] !== $user->id) {

              echo '<option data-id="' . "$gebruiker_data[id_gebruiker]" . '" value=' . $gebruiker_data["voornaam"] . '></option>';
            }
          }

          ?>
        </datalist>
        <input name="id_bonusmdw" value="id_bonusmdw" type="hidden" id="id_bonusmdw" />
        <script type="text/javascript">
          $(function() {
            $('#input-medewerker').change(function() {
              var id_bonusmdw = $("#medewerkers option[value='" + $('#input-medewerker').val() + "']").attr('data-id');
              $('#id_bonusmdw').val(id_bonusmdw)
            });
          });
        </script>
        <div class="middle-line">
          <div class="activiteit">
            <label>Activiteit *<br />
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
        <label>Totale gewerkte tijd *<br />
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
      // print_r($_COOKIE);

      // print_r($klanten_data);
      // laat error code Zien
      if (isset($_SESSION['ERRORS'])) {
        echo $_SESSION['ERRORS'];
        unset($_SESSION['ERRORS']);
      }
      if (empty($projecten_data) && $id_klant !== "undefined") {
        echo  "Er moeten nog projecten worden aangemaakt voor deze klant. <br>";
      }
      if (empty($klanten_data)) {
        echo  "Er moeten nog klanten worden aangemaakt.<br>";
      }
      if (!empty($error)) {
        echo $error;
        unset($error);
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