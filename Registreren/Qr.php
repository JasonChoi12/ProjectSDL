<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="registreren.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!--Zijkant-->
    <div class="sidebar">
        <img class="logo" src="../Logo DEVP.png" />
    </div>
    <div class="registreren">
        <h1>QR code aanmaken account</h1>
        <?php
        session_start();

        // laat qr code Zien

        if (isset($_SESSION['succes']) && isset($_SESSION['QR'])) {

            echo $_SESSION['succes'];

            unset($_SESSION['succes']); ?><br>
        <?php

            echo $_SESSION['QR'];

            unset($_SESSION['QR']);
        }
        ?>
        <div class="btn-group">
            <a href="../UrenRegistratie/urenRegistratie.php">
                <button class="submit">Terug</button>
            </a>
        </div>
    </div>
    </form>
    </div>
</body>

</html>