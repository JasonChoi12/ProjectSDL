<?php

require_once("../src/sessie.php");
require_once('../forms/vendor/autoload.php');


# Create the 2FA class
$google2fa = new PragmaRX\Google2FA\Google2FA();

$user = unserialize($_SESSION['gebruiker_data']);
$email = $user->email;
$voornaam = $user->voornaam;
$secret_key = $user->secret_key;
$text = $google2fa->getQRCodeUrl(
  $email,
  $voornaam,
  $secret_key
);
$image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=' . $text;
$qr[] = '<img class="qrcode" src="' . $image_url . '" />';
$qr[] = 'Kan je de qr niet scannen hier is jouw instelsleutel: ' . $secret_key;

$_SESSION['QR'] = implode('<br> ', $qr);

// if (isset($_SESSION['QR'])) {

//   echo $_SESSION['QR'];

//   unset($_SESSION['QR']);
// }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="accountSettings.css" />
  <link rel="stylesheet" href="../style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <title>Account aanpassen</title>
</head>

<body>
  <!--Navbar Import -->
  <div id="nav-placeholder"></div>

  <script>
    $(function() {
      $("#nav-placeholder").load("../navBar.php");
    });
  </script>
  <div class="registreren">
    <h1>Account aanpassen</h1>
    <form method="post" action="../forms/accountSettings-forms.php">

      <input class="inputnaam" type="text" id="voornaam" name="voornaam" placeholder="Voornaam" />
      <input class="inputnaam" type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="tussenvoegsel" />
      <input class="inputnaam" type="text" id="achternaam" name="achternaam" placeholder="Achternaam" />
      <input class="inputgegevens" type="text" id="email" name="email" placeholder="Email" />
      <input class="inputgegevens" type="password" id="wachtwoord" name="wachtwoordcheck" placeholder="Wachtwoord *" />
      <input class="inputgegevens" type="password" id="wachtwoord" name="wachtwoord" placeholder="Nieuw Wachtwoord" /><br>
      <!-- <div class="usertype">
          <select
            required
            class="usertype-dropdown"
            name="usertype"
            id="usertype"
          >
            <option class="usertype-label" value="" disabled selected hidden>
              Type Gebruiker
            </option>
            <option value="admin">Admin</option>
            <option value="medewerker">Medewerker</option>
            <option value="non-actief">Non-actief</option>
          </select>
        </div> -->
      <label>Profielfoto</label><br />
      <input class="profielfoto" type="file" id="myfile" name="myfile" accept="image/png, image/jpeg" />
      <div class="btn-group">
        <button name="submit" class="submit">Aanpassen</button>
      </div>
      <div class="error">
        <?php
        // laat error code Zien
        if (isset($_SESSION['ERRORS'])) {
          echo $_SESSION['ERRORS'];
          unset($_SESSION['ERRORS']);
        }
        if (isset($_SESSION['succes'])) {
          echo $_SESSION['succes'];
          unset($_SESSION['succes']);
        }

        if (isset($_SESSION['QR'])) {

          echo $_SESSION['QR'];

          unset($_SESSION['QR']);
        } ?></div>
    </form>
  </div>
</body>

</html>