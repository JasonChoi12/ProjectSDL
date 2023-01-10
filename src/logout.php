<?php
require_once('sessie.php');
require_once('class.php');

// zet de gebruiker in user_logout 
$user_logout = new Gebruikers();

// als de gebruiker
if ($user_logout->is_loggedin() != "") {
	header('welkom.php');
}
if (isset($_GET['logout']) && $_GET['logout'] == "true") {
	$user_logout->doLogout();
	header('Location: ../login/login.php');
}
