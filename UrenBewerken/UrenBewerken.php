<?php
require_once("../src/sessie.php");
$user = unserialize($_SESSION['gebruiker_data']);
$id_gebruiker = $user->id;
$id_uren = $_GET["id_uren"];
$id_project = $_GET["id_project"];
setcookie("id_project", $id_project);
if (empty($id_uren)) {
  $error[] = "Kies eerst een project.";
  if (isset($error)) {
    $_SESSION['errors'] = "Er is niks gekozen om te bewerken.";
    header('Location:../urenoverzicht/urenoverzicht.php');
  }
}


setcookie("id_project", "", time() - 3600);
// if (isset($error)) {
//   $_SESSION['ERRORS'] = implode('<br> ', $error);
//   header('Location:../registreren/registreren.php');
// }
$uren = new uren;
$uren_data = $uren->uurzien($id_uren);
$medewerker = new Gebruikers;
$medewerker_data = $medewerker->GebruikerZien($uren_data[0]["id_bonusmedewerker"]);

// $medewerker_data[0]["voornaam"];
// print_r($uren_data);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="urenbewerken.css" />
  <link rel="stylesheet" href="../style.css" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <title>Uren Bewerken</title>
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
    <h1>Uren Bewerken: </h1>
    <h2><?php echo $uren_data[0]["voornaam"] . " " . $uren_data[0]["tussenvoegsel"] . " " . $uren_data[0]["achternaam"] ?></h2>
    <form action="../forms/urenbewerken-form.php" method="post">
      <p class="righter"><?php echo "Begonnen om: " . gmdate("H:i", $uren_data[0]["begonnen"]); ?></p>
      <p class="righter"><?php echo "Beeindigd om: " . gmdate("H:i", $uren_data[0]["beeindigd"]); ?></p>
      <p class="righter"><?php echo "Totale tijd: " . gmdate("H:i", $uren_data[0]["uren"]); ?></p>

      <div class="klant">
        <label>Klant *</label><br>
        <input class="klant-input" id="input" name="klant" placeholder="<?php echo $uren_data[0]["klantnaam"]; ?>" disabled />

        <div class="project-declarabel">

          <label>Project *<br />
            <input class="klant-input" list="projecten" id="project" name="project" placeholder="<?php echo $uren_data[0]["projectnaam"]; ?>" />
          </label>
          <div class="declarabel">
            <?php if ($user->usertype === "admin") { ?>
              <label>Declarabel <br />

                <select  class="klant-input" name="declarabel" id="declarabel">
                  <option value="<?php  echo $uren_data[0]["declarabel"] ?>" selected hidden>Declarabel staat nu op: <?php echo $uren_data[0]["declarabel"]; ?></option>
                  <option value="ja">Ja</option>
                  <option value="nee">Nee</option>
                </select>
              <?php } ?>
              </label>
          </div>
        </div>
        <div class="">
        <label>Bonus medewerker</label><br />
        <?php
      // foreach klant om door alle rijen een loop te doen
      $gebruikers = new Gebruikers();
      $gebruikers_data = $gebruikers->GebruikersZien();
      // foreach ($gebruikers_data as $gebruiker_data) {
      ?>
      <input class="klant-input" list="medewerkers" id="input-medewerker" name="medewerker" placeholder="<?php  if(!empty($uren_data[0]['id_bonusmedewerker'])){ echo $medewerker_data[0]["voornaam"];} else{ echo 'medewerkers';}?>" />
        <datalist id="medewerkers">
          <option data-id="" value=" "></option>
          <?php
           
            foreach ($gebruikers_data as $gebruiker_data) {
              if($gebruiker_data["id_gebruiker"] !== $user->id){
            
              echo '<option data-id="' . "$gebruiker_data[id_gebruiker]" . '" value=' . $gebruiker_data["voornaam"] . '></option>';
            }}

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
          <input name="id_uren" value="<?php echo $uren_data[0]["id_uren"]; ?>" type="hidden" id="id_uren" />
          <input name="id_klant" value="<?php echo $uren_data[0]["id_klant"]; ?>" type="hidden" id="id_klant" />
          <input name="id_project" value="<?php echo $uren_data[0]["id_project"]; ?>" type="hidden" id="id_project" />
          <input name="id_gebruiker" value="<?php echo $uren_data[0]["id_gebruiker"]; ?>" type="hidden" id="id_gebruiker" />
          <div class="activiteit">
            <label>Activiteit<br />
              <input class="activiteit-input" name="activiteiten" placeholder="<?php echo $uren_data[0]["activiteit"]; ?>" />
            </label>
          </div>
          <div class="datum">
            <label>Datum *
              <br>
              Ingevuld: <?php echo $uren_data[0]["datum"]; ?>
              <br />
              <input type="date" class="datum-input" name="datum" required />
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
            <label>Totale gewerkte tijd *<br />
              <input id="diff" class="tijd-input" type="text" name="uren" placeholder="23:59" /></label>
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