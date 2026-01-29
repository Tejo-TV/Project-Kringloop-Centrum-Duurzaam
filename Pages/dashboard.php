
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
if (!isset($_SESSION["userid"])) {
    header("Location: login.php?error=notLoggedIn");
    exit();
}

//als je net bent ingelogd, laat een popup zien dat je succesvol bent ingelogd.
if(isset($_GET["error"])) {
    if ($_GET["error"] == "none") {
        echo "<div class='popup2'> ✅ U bent succesvol ingelogd. </div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="../Assets/Images/centrum-duurzaam-icon.png">
    <link rel="stylesheet" href="../Assets/CSS/Style.css" />
</head>
<body>
        <!-- Header -->
    <header>
        <a href="index.php">Kringloop centrum</a>
        <nav>
            <a href="#" class="deze_pagina">Dashboard</a>
            <?php 
            // Toon menu opties op basis van gebruikersrol
            if ($_SESSION["role"] == 'admin') {
                echo '  <a href="#">Instellingen</a>
                        <a href="ritten.php">Ritten</a>
                        <a href="#">Klantgegevens</a>
                        <a href="Voorraad.php">Voorraadbeheer</a>
                        <a href="#">Opbrengst</a>
                        <a href="make_user.php">Medewerkers</a>';
            } else if ($_SESSION["role"] == 'directie') {
                echo '  <a href="#">Instellingen</a>
                        <a href="#">Opbrengst</a>
                        <a href="Voorraad.php">Voorraadbeheer</a>';
            } else if ($_SESSION["role"] == 'medewerker') {
                echo '  <a href="#">Instellingen</a>
                        <a href="Voorraad.php">Voorraadbeheer</a>';
            } else if ($_SESSION["role"] == 'chauffeur') {
                echo '  <a href="#">Instellingen</a>
                        <a href="ritten.php">Ritten</a>';
            } else {
                echo '<a href="#">Instellingen</a>';
            }
            ?>

            <a class="header-button2" href="components/logout.inc.php">Uitloggen</a>
        </nav>
    </header>

    <!-- Body -->
    <div class="dashboard">
            <?php 
            // Toon dashboard opties op basis van gebruikersrol
            if ($_SESSION["role"] == 'admin') {
                echo '  <div class="dashboard-content">
                            <h1>Instellingen</h1>
                            <p>Beheer de jou gegevens.</p>
                            <a href="#">Ga naar Instellingen</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Ritten</h1>
                            <p>Beheer en volg alle transportritten en leveringen.</p>
                            <a href="ritten.php">Ga naar Ritten</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Klantgegevens</h1>
                            <p>Bekijk en beheer informatie van alle klanten en contacten.</p>
                            <a href="#">Ga naar Klantgegevens</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Voorraadbeheer</h1>
                            <p>Beheer de voorraad en track beschikbare items.</p>
                            <a href="Voorraad.php">Ga naar Voorraadbeheer</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Opbrengst</h1>
                            <p>Analyseer financiële resultaten en opbrengsten.</p>
                            <a href="#">Ga naar Opbrengst</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Medewerkers</h1>
                            <p>Beheer medewerkers en hun toewijzingen.</p>
                            <a href="make_user.php">Ga naar Medewerkers</a>
                        </div>';
            } else if ($_SESSION["role"] == 'directie') {
                echo '  <div class="dashboard-content">
                            <h1>Instellingen</h1>
                            <p>Beheer de jou gegevens.</p>
                            <a href="#">Ga naar Instellingen</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Voorraadbeheer</h1>
                            <p>Beheer de voorraad en track beschikbare items.</p>
                            <a href="#">Ga naar Voorraadbeheer</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Opbrengst</h1>
                            <p>Analyseer financiële resultaten en opbrengsten.</p>
                            <a href="Voorraad.php">Ga naar Opbrengst</a>
                        </div>';
            } else if ($_SESSION["role"] == 'medewerker') {
                echo '  <div class="dashboard-content">
                            <h1>Instellingen</h1>
                            <p>Beheer de jou gegevens.</p>
                            <a href="#">Ga naar Instellingen</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Voorraadbeheer</h1>
                            <p>Beheer de voorraad en track beschikbare items.</p>
                            <a href="Voorraad.php">Ga naar Voorraadbeheer</a>
                        </div>';
            } else if ($_SESSION["role"] == 'chauffeur') {
                echo '  <div class="dashboard-content">
                            <h1>Instellingen</h1>
                            <p>Beheer de jou gegevens.</p>
                            <a href="#">Ga naar Instellingen</a>
                        </div>
                        <div class="dashboard-content">
                            <h1>Ritten</h1>
                            <p>Beheer en volg alle transportritten en leveringen.</p>
                            <a href="ritten.php">Ga naar Ritten</a>
                        </div>';
            } else {
                echo '  <div class="dashboard-content">
                            <h1>Instellingen</h1>
                            <p>Beheer de jou gegevens.</p>
                            <a href="">Ga naar Instellingen</a>
                        </div>';
            }
            ?>
    </div>


    
</body>
</html>
