<?php
require_once("../src/sessie.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="registreren.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>registreren</title>
</head>

<body>
  <!--Zijkant-->
  <div class="sidebar">
    <img class="logo" alt="logo" src="../Logo-DEVP.png" />
  </div>
  <div class="registreren">
    <h1>Registreren</h1>
    <form method="post" action="../forms/registreren-form.php">
      <input class="inputnaam" type="text" id="voornaam" name="voornaam" placeholder="Voornaam *" />
      <input class="inputnaam" type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="Tussenvoegsel" />
      <input class="inputnaam" type="text" id="achternaam" name="achternaam" placeholder="Achternaam *" />

      <input class="inputgegevens" type="text" id="email" name="email" placeholder="Email *" />
      <input class="inputgegevens" type="password" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord *" />
      <div class="btn-group">
        <button name="submit" class="submit">Registreren</button>
        <button name="cancel" class="cancel">Annuleren</button>
      </div>
      <div class="error">
        <?php
        // laat error code Zien
        if (isset($_SESSION['ERRORS'])) {
          echo $_SESSION['ERRORS'];
          unset($_SESSION['ERRORS']);
        }
        // laat qr code Zien

        elseif (isset($_SESSION['succes']) && isset($_SESSION['qr'])) {
          echo $_SESSION['succes'];
          unset($_SESSION['succes']);
        } ?><br>
      </div>
    </form>
  </div>
</body>

</html>