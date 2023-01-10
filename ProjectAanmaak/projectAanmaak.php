<?php
require_once("../src/sessie.php");
if (!empty($_SESSION["id_klant"])) {
  $id_klant = $_SESSION["id_klant"];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="projectaanmaak.css" />
  <link rel="stylesheet" href="../style.css" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
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
    <h1>Project aanmaken</h1>

    <form class="project" method="post" action="../forms/projectaanmaken-form.php">
      <div class="klant">
        <label>Klant *</label><br /> <?php
                                      $klanten = new Klanten;
                                      $klanten_data = $klanten->KlantenZien();
                                      unset($_SESSION["id_klant"]);
                                      if (empty($id_klant)) {

                                        echo '<input class="klant-input" list="klanten" id="input" name="klant" placeholder="Klantnaam" />
        <datalist id="klanten">';
                                        foreach ($klanten_data as $klant_data) {
                                          echo '<option data-id="' . "$klant_data[id_klant]" . '" value=' . "$klant_data[klantnaam]" . '></option>
                >';
                                        }
                                        '
        </datalist>'; ?><input name="id_klant" value="id_klant" type="hidden" id="id_klant" />
          <script type="text/javascript">
            $(function() {
              $('#input').change(function() {
                var abc = $("#klanten option[value='" + $('#input').val() + "']").attr('data-id');
                $('#id_klant').val(abc)
              });
            });
          </script><?php
                                      } else {
                                        $klanten = new Klanten;
                                        // $id_klant = $_GET['id_klant'];
                                        $klant_data = $klanten->KlantZien($id_klant);
                                        echo '<input  class="klant-input" value="' . $klant_data[0]["klantnaam"] . '" disabled />
                                      <input name="klant" value="' . $klant_data[0]["klantnaam"] . '" type="hidden" id="id_klant" />
                                      <input name="id_klant" value="' . $id_klant . '" type="hidden" id="id_klant" />';
                                      }
                    ?>

      </div>
      <div class="project-info">
        <div class="projectnaam">
          <label>Projectnaam *<br />
            <input class="projectnaam-input" name="projectnaam" placeholder="Projectnaam" />
          </label>
        </div>
        <div class="begindatum">
          <label>
            Begindatum *<br />
            <input type="date" class="begindatum-input" name="begindatum" placeholder="01-01-01" />
          </label>
        </div>
        <div class="btn">
          <br>
          <button name="submit" class="submit">Toevoegen</button>
        </div>
      </div>
      <br>
      <div class="error">
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