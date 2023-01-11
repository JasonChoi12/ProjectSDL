<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="registreren.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QR</title>
</head>

<body>
    <!--Zijkant-->
    <div class="sidebar">
        <img class="logo" alt="logo" src="../Logo-DEVP.png" />
    </div>
    <div class="registreren">
        <h1>QR code aanmaken account</h1>
        <div>
        <?php
        session_start();

        // laat qr code Zien

        if (isset($_SESSION['succes']) && isset($_SESSION['QR'])) {

            echo $_SESSION['succes'];

            unset($_SESSION['succes']); ?><br>
        
        <?php

            echo "<div class='qrcode'>" . $_SESSION['QR']. "</div>";

            unset($_SESSION['QR']);
        }
        ?>
        </div>
        <div class="btn-group">
            <a href="../UrenRegistratie/urenRegistratie.php">
                <button class="submit">Terug</button>
            </a>
        </div>
    </div>
    
</body>

</html>