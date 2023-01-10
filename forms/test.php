<?php
require_once('../src/class.php');
require_once(__DIR__ . '/vendor/autoload.php');
# Create the 2FA class
$google2fa = new PragmaRX\Google2FA\Google2FA();

$email = "Developer@dev.nl";
$voornaam = "Developer";
$secret_key ="LOF4TVGGlKF7GK3U ";


$text = $google2fa->getqrCodeUrl(
    $email,
    $voornaam,
    $secret_key
);
$image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=' . $text;
$qr[] = '<img class="qrcode" src="' . $image_url . '" />';
$qr[] = 'Kan je de qr niet scannen hier is jouw instelsleutel: ' . $secret_key;

$_SESSION['qr'] = implode('<br> ', $qr);

if (isset($_SESSION['qr'])) {

    echo $_SESSION['qr'];

    unset($_SESSION['qr']);
}