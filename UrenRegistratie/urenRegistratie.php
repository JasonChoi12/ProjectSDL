<?php
require_once("../src/sessie.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="urenRegistratie.css" />
  <link rel="stylesheet" href="../style.css" />

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
    <h1>Uren Registreren</h1>

    <form>
      <div class="klant">
        <label>Klant</label><br />
        <input class="klant-input" list="klanten" name="klanten" placeholder="Klantnaam" />
        <datalist id="klanten">
          <option value="Klant1"></option>
          <option value="Klant2"></option>
          <option value="Klant3"></option>
        </datalist>
      </div>
      <br />

      <form>
        <div>
          <label>Project</label><br />
          <input class="project-input" list="projecten" name="projecten" placeholder="Projectnaam" />
          <datalist id="projecten">
            <option value="Project1"></option>
            <option value="Project2"></option>
            <option value="Project3"></option>
          </datalist>
        </div>
        <br />

        <div class="activiteit">
          <label>Activiteit<br />
            <input class="activiteit-input" name="activiteiten" placeholder="Activiteit" />
          </label>
        </div>
        <div class="datum">
          <label>Datum
            <br />
            <input type="date" class="datum-input" name="datum" placeholder="Dag-Maand-Jaar" />
          </label>
        </div>

        <div class="tijd">
          <label>Begonnen om
            <input type="time" class="tijd-input" name="tijd" placeholder="00:00" /></label>
          <div class="eindtijd">
            <label>Beïndigd om
              <input type="time" class="tijd-input" name="tijd" placeholder="00:00" /></label>
          </div>
          <div class="toteindtijd">
            <label>Totale gewerkte tijd
              <input class="tijd-input" name="tijd" placeholder="00:00" /></label>
          </div>
          <button class="submit">Toevoegen</button>
        </div>
      </form>
  </div>
</body>

</html>