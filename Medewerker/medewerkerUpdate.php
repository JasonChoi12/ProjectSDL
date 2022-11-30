<?php

require_once("../src/sessie.php");
$id_gebruiker = $_GET["id_gebruiker"];
if(empty($id_gebruiker)){
    $error[] = "Kies eerst een gebruiker.";
    $_SESSION['ERRORS'] = implode('<br> ', $error);
    header('Location: ../Medewerker/Medewerker.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../AccountSettings/accountSettings.css" />
    <link rel="stylesheet" href="../style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <title>Account aanpassen</title>
  </head>
  <body>
    <!--Navbar Import -->
    <div id="nav-placeholder"></div>
    <?php
                                    $gebruikers = new Gebruikers;
                                    $gebruikers_data = $gebruikers->GebruikerZien($id_gebruiker);
                                    print_r($gebruikers_data);
                              ?>
    <script>
      $(function () {
        $("#nav-placeholder").load("../navBar.php");
      });
    </script>
    <div class="registreren">
      <h1>Account aanpassen</h1>
      <form method="post" action="../forms/medewerkerType-form.php">
        <div>
            <input type="hidden" name="id_gebruiker" value="<?php echo $gebruikers_data[0]["id_gebruiker"]?>" >
          <input
            class="inputnaam"
            type="text"
            id="voornaam"
            name="voornaam"
            placeholder="<?php echo $gebruikers_data[0]["voornaam"]?>"
            disabled
          />
          <input
            class="inputnaam"
            type="text"
            id="tussenvoegsel"
            name="tussenvoegsel"
            placeholder="<?php echo $gebruikers_data[0]["tussenvoegsel"]?>"
            disabled
          />
          <input
            class="inputnaam"
            type="text"
            id="achternaam"
            name="achternaam"
            placeholder="<?php echo $gebruikers_data[0]["achternaam"]?>"
            disabled
          />
        </div>
        <br />
        <input
          class="inputgegevens"
          type="text"
          id="email"
          name="email"
          placeholder="<?php echo $gebruikers_data[0]["email"]?>"
          disabled
        /><br />
        <div>
        <div class="usertype">
          <select
            required
            class="usertype-dropdown"
            name="usertype"
            id="usertype"
          >
            <option class="usertype-label" value="" disabled selected hidden>
            <?php echo $gebruikers_data[0]["usertype"]?>
            </option>
            <option value="admin">Admin</option>
            <option value="medewerker">Medewerker</option>
            <option value="non-actief">Non-actief</option>
          </select>
        </div>
        </<br>
        <br>
        <div class="btn-group">
          <button type="submit" name="submit" class="submit">Aanpassen</button>
        </div>
        <div class="text-center center input">
        <?php
        // laat error code Zien
        if (isset($_SESSION['ERRORS'])) {
          echo $_SESSION['ERRORS'];
          unset($_SESSION['ERRORS']);
        }
       if (isset($_SESSION['succes'])) {
          echo $_SESSION['succes'];
          unset($_SESSION['succes']); }?></div>
      </form>
    </div>
  </body>
</html>
