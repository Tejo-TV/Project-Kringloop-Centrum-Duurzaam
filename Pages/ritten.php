<?php 
//---------------------------------------------------------------------------------------------------//
// Naam script       : Ritten.php
// Omschrijving      : Dit is de ritten beheer pagina
// Naam ontwikkelaar : Kevin van Lit
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: ../login.php?error=notLoggedIn");
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