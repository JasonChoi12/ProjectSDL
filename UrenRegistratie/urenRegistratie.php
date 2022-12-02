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
            <input type="date" class="datum-input" name="datum"/>
          </label>
        </div>

        <div class="tijd">
          <label>Begonnen om
            <input id="start" type="time" class="tijd-input" name="tijd"/></label>
          <div class="eindtijd">
            <label>Beïndigd om
              <input id="end" type="time" class="tijd-input" name="tijd"/></label>
          </div>
          <div class="toteindtijd">
            <label>Totale gewerkte tijd
              <input id="diff" class="tijd-input" name="tijd"/></label>
          </div>
          <button class="submit">Toevoegen</button>
        </div>
      </form>
  </div>
</body>
<script>
var start = document.getElementById("start").value;
var end = document.getElementById("end").value;

document.getElementById("start").onchange = function() {diff(start,end)};
document.getElementById("end").onchange = function() {diff(start,end)};


function diff(start, end) {
    start = document.getElementById("start").value; //to update time value in each input bar
    end = document.getElementById("end").value; //to update time value in each input bar
    
    start = start.split(":");
    end = end.split(":");
    var startDate = new Date(0, 0, 0, start[0], start[1], 0);
    var endDate = new Date(0, 0, 0, end[0], end[1], 0);
    var diff = endDate.getTime() - startDate.getTime();
    var hours = Math.floor(diff / 1000 / 60 / 60);
    diff -= hours * 1000 * 60 * 60;
    var minutes = Math.floor(diff / 1000 / 60);

    return (hours < 9 ? "0" : "") + hours + ":" + (minutes < 9 ? "0" : "") + minutes;
}

setInterval(function(){document.getElementById("diff").value = diff(start, end);}, 1000); //to update time every second (1000 is 1 sec interval and function encasing original code you had down here is because setInterval only reads functions) You can change how fast the time updates by lowering the time interval
</script>

</html>