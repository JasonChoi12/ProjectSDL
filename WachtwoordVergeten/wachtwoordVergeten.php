<?php include("../forms/app_logic.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="watchwoordVergeten.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Wachtwoord Vergeten</title>
      </head>
      
  <body>
     <!--Zijkant-->
    <div class="sidebar">
        <img class="logo" alt="logo" src="../Logo-DEVP.png"/>
    </div>
    <div class="title">
      <h1>Wachtwoord Vergeten</h1>
      <form action="wachtwoordVergeten.php">
        <label>Vul je email in om je wachtwoord te kunnen resetten<br>
        <input
          class="inputgegevens"
          type="text"
          id="email"
          name="email"
          placeholder="Email"
        />
      </label>
        <div class="btn-group">
          <button name="reset-password" class="submit">Reset Wachtwoord</button>
        </div>
      </form>
    </div>
  </body>
</html>