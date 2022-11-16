<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="login.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!--Zijkant-->
    <div class="sidebar">
        <img class="logo" src="../Logo DEVP.png" />
    </div>
    <div class="login">
        <h1>Login</h1>
        <form method="post" action="../forms/login-form.php">
            
            <br />
            <input class="inputgegevens" type="text" id="email" name="email" placeholder="Email" /><br />
            <input class="inputgegevens" type="password" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord" />
            <input class="inputgegevens" type="password" id="wachtwoord" name="code" placeholder="Code" />
            
            <div class="btn-group">
                <button name="submit" class="submit">login</button>
            </div>
            <div class="text-center center input">
                <?php
                session_start();
                // laat error code Zien
                if (isset($_SESSION['ERRORS'])) {
                    echo $_SESSION['ERRORS'];
                    unset($_SESSION['ERRORS']);
                }
                ?></div>
        </form>
    </div>
</body>

</html>