<?php



require_once("../src/sessie.php");

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="registreren.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registreren</title>
</head>

<body>
  <!--Zijkant-->
  <div class="sidebar">
    <img class="logo" alt="logo" src="../Logo-DEVP.png" />
  </div>
  <div class="registreren">
    <h1>Registreren</h1>
    <form method="post" action="../forms/registreren-form.php">
      <div>
        <input class="inputnaam" type="text" id="voornaam" name="voornaam" placeholder="Voornaam" />
        <input class="inputnaam" type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="tussenvoegsel" />
        <input class="inputnaam" type="text" id="achternaam" name="achternaam" placeholder="Achternaam" />
      </div>
      <br />
      <input class="inputgegevens" type="text" id="email" name="email" placeholder="Email" /><br />
      <input class="inputgegevens" type="password" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord" />
      <div class="btn-group">
        <button name="submit" class="submit">Registreren</button>
        <button name="cancel" class="cancel">Annuleren</button>
      </div>
      <div class="text-center center input">
        <?php
        // laat error code Zien
        if (isset($_SESSION['ERRORS'])) {
          echo $_SESSION['ERRORS'];
          unset($_SESSION['ERRORS']);
        }
        // laat qr code Zien

        elseif (isset($_SESSION['succes']) && isset($_SESSION['QR'])) {
          echo $_SESSION['succes'];
          unset($_SESSION['succes']); ?><br>
        <?php
          echo $_SESSION['QR'];
          unset($_SESSION['QR']);
        }
        ?></div>
    </form>
  </div>
</body>

</html>