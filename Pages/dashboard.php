
<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : dashboard.php
// Omschrijving      : Dit is de dashboard pagina van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Tejo Veldman
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/CSS/Style.css" />
</head>
<body>
        <!-- Header -->
    <header>
        <a href="index.php">Kringloop centrum</a>
        <nav>
            <a href="#">Dashboard</a>
            <a href="#">Ritten</a>
            <a href="#">Klantgegevens</a>
            <a href="#">Voorraadbeheer</a>
            <a href="#">Opbrengst</a>
            <a href="#">Medewerkers</a>
            <a class="header-button" href="components/logout.inc.php">Logout</a>
        </nav>
    </header>

    <!-- Body -->
    <div class="dashboard">
        <div class="dashboard-content">
            <h1>Ritten</h1>
            <p>Beschrijving</p>
            <a href="ritten.php">Ga naar Ritten</a>
        </div>
        <div class="dashboard-content">
            <h1>Klantgegevens</h1>
            <p>Beschrijving</p>
            <a href="#">Ga naar Klantgegevens</a>
        </div>
        <div class="dashboard-content">
            <h1>Voorraadbeheer</h1>
            <p>Beschrijving</p>
            <a href="voorraad.php">Ga naar Voorraadbeheer</a>
        </div>
        <div class="dashboard-content">
            <h1>Opbrengst</h1>
            <p>Beschrijving</p>
            <a href="#">Ga naar Opbrengst</a>
        </div>
        <div class="dashboard-content">
            <h1>Medewerkers</h1>
            <p>Beschrijving</p>
            <a href="#">Ga naar Medewerkers</a>
        </div>
    </div>


    
</body>
</html>
