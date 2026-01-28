<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : login.php
// Omschrijving      : Dit is de login pagina van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
session_start();
if (isset($_SESSION["userid"])) {
    echo "<div class='popup2'> You are logged in. </div>";
} else {
    header("Location: ../login.php?error=notLoggedIn");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>