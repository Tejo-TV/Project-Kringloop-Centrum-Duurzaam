<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : make_user.php
// Omschrijving      : Dit is de make user pagina van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Suzanne Boon
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
session_start();

// Als je niet bent ingelogd, stuur je terug naar de login pagina anders popup.
if (isset($_SESSION["userid"])) {
    echo "<div class='popup2'> You are logged in. </div>";
} else {
    header("Location: login.php?error=notLoggedIn");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Assets/CSS/Style.css">
</head>
<body>
    
    <!-- Header -->
    <header>
        <a href="index.php">Kringloop centrum</a>
        <nav>
            <a href="pages/login.php">Aanmelden</a>
        </nav>
    </header>

    <div class="makeuser-container">
        <div class="makeuser-form">
            
        </div>
    </div>

</body>
</html>
