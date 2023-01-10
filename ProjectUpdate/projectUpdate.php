<?php
require_once("../src/sessie.php");
$id_klant = $_GET['id_klant'];
$id_project = $_GET['id_project'];
if (empty($id_project)) {

  $error[] = "Kies eerst een project.";
  if(isset($error)){
  $_SESSION['errors'] = implode('<br> ', $error);
  header('Location: ../projectoverzicht/projectoverzicht.php');
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="projectupdate.css" />
  <link rel="stylesheet" href="../style.css" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
</head>

<body>
  <!--Navbar Import -->
  <div id="nav-placeholder"></div>
  <?php
  $project = new projecten;
  $project_data = $project->Projectzien($id_project);
  $klant = new projecten;
  $klant_data = $klant->KlantZien($id_klant);?>
  <script>
    $(function() {
      $("#nav-placeholder").load("../navBar.php");
    });
  </script>
  <div class="title">
    <h1>Project Bewerken</h1>

    <form class="project" method="post" action="../forms/projectupdate-form.php">
      <div class="klant">
        <label>Klant *</label><br />
        <input type="hidden" value="<?php echo $project_data[0]["id_project"]; ?>" name="id_project">
        <input type="hidden" value="<?php echo $id_klant; ?>" name="id_klant">
        <input class="klant-input" placeholder="<?php echo $klant_data[0]["klantnaam"]; ?>" disabled />
      </div>
      <br />
      <div class="project-info">
        <div class="projectnaam">
          <label>Projectnaam *<br />
          <input class="projectnaam-input" name="projectnaam" placeholder="<?php echo $project_data[0]["projectnaam"]; ?>" />
          </label>
        </div>
        <div class="begindatum">
          <label>
            Begindatum *<br />
            <input type="text" class="begindatum-input" name="begindatum" placeholder="<?php echo $project_data[0]["begindatum"]; ?>" onfocus="(this.type='date')" />
          </label>
        </div>
        <div class="btn">
          <br>
          <button name="submit" class="submit">Bewerken</button>
        </div>
      </div>
      <br>
    
      <div>
        <?php
        // laat error code Zien
        if (isset($_SESSION['ERRORS'])) {
          echo $_SESSION['ERRORS'];
          unset($_SESSION['ERRORS']);
        }
        ?></div>
  </div>

  </form>
  </div>

</body>

</html>