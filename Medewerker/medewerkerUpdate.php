<?php

require_once("../src/sessie.php");
  if (!empty($_GET["id_gebruiker"])) {
    $id_gebruiker = $_GET["id_gebruiker"];
  setcookie("id_gebruiker", $id_gebruiker);
  } elseif(!empty($_COOKIE["id_gebruiker"])) {
    $id_gebruiker = $_COOKIE["id_gebruiker"];
  setcookie("id_gebruiker", "", time() - 3600);
  }elseif(empty($id_gebruiker)){
    if (!isset($_SESSION['ERRORS'])) {
    $error[] = "Kies eerst een medewerker.";
    if(isset($error)){
      $_SESSION['errors'] = implode('<br> ', $error);
      header('Location: ../medewerker/medewerker.php');
    }
    }
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="update.css" />
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
                                 
                              ?>
    <script>
      $(function () {
        $("#nav-placeholder").load("../navBar.php");
      });
    </script>
    <div class="registreren">
      <h1>Account aanpassen</h1>
      <form method="post" action="../forms/medewerkertype-form.php">
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
        /><br>
        <label>Doe dit alleen als er is aangegeven dat de medewerker zijn wachtwoord is vergeten.</label>
        <input class="inputgegevens" type="password" id="wachtwoord" name="wachtwoord" placeholder="Nieuw Wachtwoord" />
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
            <option value="medewerker">medewerker</option>
            <option value="non-actief">Non-actief</option>
          </select>
        </div>
        
      
        <br>
        <div class="btn-group">
          <button type="submit" name="submit" class="submit">Aanpassen</button>
        </div>
        <br>
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
