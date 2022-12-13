<?php
require_once('../src/class.php');

// start sessie
session_start();

// maak nieuwe klant aan
$klant = new Klanten();
// Pakt post van de form en zet ze in variable
$id_klant = $_POST['id_klant'];
$id_project = $_POST['id_project'];
$activiteiten = $_POST['activiteiten'];
$datum = $_POST['datum'];
$begonnen = $_POST['begonnen'];
$beëindigd = $_POST['beëindigd'];
$uren = $_POST['uren'];
echo"id_klant: ". $id_klant ."<br>";
echo"id_project: ". $id_project."<br>";
echo"activiteit: ". $activiteiten."<br>";
echo"datum: ". $datum."<br>";
echo"begonnen: ". $begonnen."<br>";
echo"beëindigd: ". $beëindigd."<br>";
echo"uren: ". $uren;
