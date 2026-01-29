<?php 
//---------------------------------------------------------------------------------------------------//
// Naam script       : Ritten.php
// Omschrijving      : Dit is de ritten beheer pagina
// Naam ontwikkelaar : Groep D
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
session_start();

// Als je niet bent ingelogd, stuur je terug naar de login pagina anders popup.
if (!isset($_SESSION["userid"])) {
    echo "<script>window.location.href = 'login.php?error=notLoggedIn';</script>";
    exit();
} elseif ($_SESSION["role"] != 'admin' && $_SESSION["role"] != 'chauffeur') {
    // Niet gemachtigd
    echo "<script>window.location.href = 'dashboard.php?error=notAuthorized';</script>";
    exit();
}

require_once '../Config/DB_connect.php';
require_once 'components/functions.inc.php';
require_once 'components/adminnavbar.inc.php';

$db = new Database();
$conn = $db->getConnection();
require_once 'components/adminnavbar.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritten</title>
    <link rel="shortcut icon" type="x-icon" href="../Assets/Images/centrum-duurzaam-icon.png">
</head>
<body>
    
</body>
</html>