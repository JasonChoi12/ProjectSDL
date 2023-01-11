<?php
require_once("../src/sessie.php");
// $id_klant = $_GET["id_klant"];
// $_SESSION["id_klant"] = $id_klant;
// $id_klant = $_SESSION["id_klant"];
// if (empty($id_klant)) {
//   $error[] = "Kies eerst een klant.";
//   $_SESSION['errors'] = implode('<br> ', $error);
//   header('Location: ../klantoverzicht/klantoverzicht.php');
// }
// print_r($_COOKIE);
if (!empty($_GET["id_klant"])) {
  $id_klant = $_GET["id_klant"];
setcookie("id_klant", $id_klant);
} elseif(!empty($_COOKIE["id_klant"])) {
  $id_klant = $_COOKIE["id_klant"];
setcookie("id_klant", "", time() - 3600);
}elseif(empty($id_klant)){
  if (!isset($_SESSION['errors'])) {
  $error[] = "Kies eerst een klant.";
  if(isset($error)){
    $_SESSION['errors'] = implode('<br> ', $error);
  header('Location: ../klantoverzicht/klantoverzicht.php');
  }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="klantupdate.css" />
  <link rel="stylesheet" href="../style.css" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <title>Klant Bewerken</title>
</head>

<body>
  <!--Navbar Import -->
  <div id="nav-placeholder"></div>
  <?php

  $klant = new Klanten;
  $klant_data = $klant->KlantZien($id_klant);
  // echo $klant_data[0]["klantnaam"]
  ?>
  <script>
    $(function() {
      $("#nav-placeholder").load("../navBar.php");
    });
  </script>
  <div class="title">
    <h1>Klant bewerken</h1>

    <form class="klant" method="post" action="../forms/klantupdate-form.php">
      <input type="hidden" name="id_klant" value="<?php echo $id_klant ?>">
      <div>
        <label>Klant *</label><br />
        <input class="klantnaam-input" name="klantnaam" placeholder="<?php echo $klant_data[0]["klantnaam"] ?>" />
      </div>
      <div class="middle-line">
      <div class="straat">
        <label>Straat<br />
          <input class="straat-input" name="straatnaam" placeholder="<?php echo $klant_data[0]["straatnaam"] ?>" />
        </label>
      </div>
      <div class="telefoon">
        <label>
          Telefoon<br />
          <input class="telefoon-input" name="telefoon" placeholder="<?php echo $klant_data[0]["telefoonnummer"] ?>" />
        </label>
      </div>
      <div class="woonplaats">
        <label>
          Woonplaats *<br />
          <input class="woonplaats-input" name="woonplaats" placeholder="<?php echo $klant_data[0]["woonplaats"] ?>" />
        </label>
      </div>
      </div>
      <div class="bottom-line">
        <div class="adres">
          <label>Huisnummer
          <input class="adres-input" name="huisnummer" placeholder="<?php echo $klant_data[0]["huisnummer"] ?>" /></label>
        </div>
        <div class="postcode">
          <label>Postcode
          <input class="adres-input" name="postcode" placeholder="<?php echo $klant_data[0]["postcode"] ?>" /></label>
        </div>
      </div>
      <button name="submit" class="submit">Bewerken</button>
      <br>
      <?php
        
        // laat error code Zien
        if (isset($_SESSION['ERRORS'])) {
          echo $_SESSION['ERRORS'];
          unset($_SESSION['ERRORS']);
        }
        ?>
  </div><br><br>
    </form>
  </div>

</body>

</html>