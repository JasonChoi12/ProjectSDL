<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="registreren.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>qr</title>
</head>

<body>
    <!--Zijkant-->
    <div class="sidebar">
        <img class="logo" alt="logo" src="../Logo-DEVP.png" />
    </div>
    <div class="registreren">
        <h1>qr code aanmaken account</h1>
        <div>
        <?php
        session_start();

        // laat qr code Zien

        if (isset($_SESSION['succes']) && isset($_SESSION['qr'])) {

            echo $_SESSION['succes'];

            unset($_SESSION['succes']); ?><br>
        
        <?php

            echo "<div class='qrcode'>" . $_SESSION['qr']. "</div>";

            unset($_SESSION['qr']);
        }
        ?>
        </div>
        <div class="btn-group">
            <a href="../urenregistratie/urenregistratie.php">
                <button class="submit">Terug</button>
            </a>
        </div>
    </div>
    
</body>

</html>