<?php
require_once("../src/sessie.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="klant.css" />
  <link rel="stylesheet" href="../style.css" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <title>Klant aanmaken</title>
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
    <h1>Klant aanmaken</h1>
    <form class="klant" method="post" action="../forms/klantaanmaken-form.php">
      <div>
        <label>Klant *</label><br />
        <input class="klantnaam-input" name="klantnaam" placeholder="Klantnaam" />
      </div>
      <div class="middle-line">
        <div class="straat">
          <label>Straat<br />
            <input class="straat-input" name="straatnaam" placeholder="Straatnaam" />
          </label>
        </div>
        <div class="telefoon">
          <label>
            Telefoon<br />
            <input class="telefoon-input" name="telefoon" placeholder="06-123456789" />
          </label>
        </div>
        <div class="woonplaats">
          <label>
            Woonplaats *<br />
            <input class="woonplaats-input" name="woonplaats" placeholder="Stad,Provincie" />
          </label>
        </div>
      </div>
      <div class="bottom-line">
        <div class="adres">
          <label>Huisnummer
            <input class="adres-input" name="huisnummer" placeholder="391" /></label>
        </div>
        <div class="postcode">
          <label>Postcode
            <input class="adres-input" name="postcode" placeholder="1234AB" /></label>
        </div>
      </div>
      <button name="submit" class="submit">Toevoegen</button>

  </div><br>
  <div class="error">
    <?php
    // laat error code Zien
    if (isset($_SESSION['ERRORS'])) {
      echo $_SESSION['ERRORS'];
      unset($_SESSION['ERRORS']);
    }
    ?></div>
  </form>
  </div>

</body>

</html>