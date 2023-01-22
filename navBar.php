<?php

require_once("src/sessie.php");

require_once("src/class.php");
$user = unserialize($_SESSION['gebruiker_data']);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <!-- Boxicons CDN Link (Icon link) -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <!-- Nav bar -->
  <div class="sidebar">
    <div class="logo-details">
      <div class="logo_name"><img src="../Logo-DEVP.png" position="absolute" width="90%" height="10%"></div>
      <i class='bx bx-menu' id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="../Klant/klant.php">
          <i class='bx bx-user'></i>
          <span class="links_name">Klant aanmaken</span>
        </a>
        <span class="tooltip">Klant aanmaken</span>
      </li>
      <li>
        <a href="../projectaanmaak/projectaanmaak.php">
          <i class='bx bxs-folder-plus'></i>
          <span class="links_name">Project aanmaken</span>
        </a>
        <span class="tooltip">Project aanmaken</span>
      </li>
      <li>
        <a href="../klantoverzicht/klantoverzicht.php">
          <i class='bx bx-spreadsheet'></i>
          <span class="links_name">Klant overzicht</span>
        </a>
        <span class="tooltip">Klant overzicht</span>
      </li>
      <li>
        <a href="../urenregistratie/urenregistratie.php">
          <i class='bx bx-time'></i>
          <span class="links_name">Uren registratie</span>
        </a>
        <span class="tooltip">Uren registratie</span>
      </li>
      <li>
        <a href="../accountsettings/accountsettings.php">
          <i class='bx bx-cog'></i>
          <span class="links_name">Setting</span>
        </a>
        <span class="tooltip">Setting</span>
      </li>
      <?php if ($user->usertype === "admin") {
        echo '<li>
        <a href="../registreren/registreren.php">
          <i class="bx bx-user-plus"></i>
          <span class="links_name">Nieuwe medewerker</span>
        </a>
        <span class="tooltip">Nieuwe medewerker</span>
      </li>';
      }
      ?>
      <?php if ($user->usertype === "admin") {
        echo '<li>
        <a href="../medewerker/medewerker.php">
        <i class="bx bxs-user-account"></i>
          <span class="links_name">Medewerker Overzicht</span>
        </a>
        <span class="tooltip">Medewerker Overzicht</span>
      </li>';
      }
      ?>


      <li class="profile">
        <div class="profile-details">

          <div class="name_job">
            <div class="name"><?php echo $user->voornaam . " " . $user->tussenvoegsel . " " . $user->achternaam; ?></div>

          </div>
          <a href="../src/logout.php?logout=true"><i class='bx bx-log-out' id="log_out"></i></a>
      </li>
    </ul>
  </div>
  <script>
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
    let searchBtn = document.querySelector(".bx-search");

    closeBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      menuBtnChange(); //calling the function(optional)
    });

    searchBtn.addEventListener("click", () => { // Sidebar open when you click on the search iocn
      sidebar.classList.toggle("open");
      menuBtnChange(); //calling the function(optional)
    });

    // following are the code to change sidebar button(optional)
    function menuBtnChange() {
      if (sidebar.classList.contains("open")) {
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
      } else {
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
      }
    }
  </script>
</body>

</html>