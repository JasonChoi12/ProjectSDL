<?php

session_start();

require_once 'class.php';
$session = new Gebruikers();

// als user sessie niet aan is of klopt worrd je van alle andere pagina's geredirect naar login.php

if (!$session->is_loggedin()) {
	// als er geen sessie aan is dan redirect naar login.php 
	header('Location: ../login/login.php');
}
