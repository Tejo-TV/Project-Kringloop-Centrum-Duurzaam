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
    echo "<script>window.location.href = 'login.php?error=notLoggedIn';</script>";
    exit();
} 

//als je net bent ingelogd, laat een popup zien dat je succesvol bent ingelogd.
if(isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<div class='popup1'> ❌ Één of meer verplichte velden zijn leeg. Vul alstublieft alle velden in om verder te gaan. </div>";
    } elseif ($_GET["error"] == "none") {
        echo "<div class='popup2'> ✅ Instellingen succesvol aangepast. </div>";
    }
}

// Haal de gebruikersnaam op voor weergave in instellingen
require_once '../Config/DB_connect.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare("SELECT gebruikersnaam FROM gebruiker WHERE id = :id");
$stmt->bindParam(":id", $_SESSION["userid"]);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$username = $row['gebruikersnaam'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instellingen</title>
    <link rel="shortcut icon" type="x-icon" href="../Assets/Images/centrum-duurzaam-icon.png">
    <link rel="stylesheet" href="../Assets/CSS/Style.css" />
</head>
<body>
        <!-- Header -->
    <header>
        <a href="dashboard.php">Kringloop centrum</a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <?php 
            // Toon menu opties op basis van gebruikersrol
            if ($_SESSION["role"] == 'admin') {
                echo '  <a href="#" class="deze_pagina">Instellingen</a>
                        <a href="ritten.php">Ritten</a>
                        <a href="#">Klantgegevens</a>
                        <a href="Voorraad.php">Voorraadbeheer</a>
                        <a href="#">Opbrengst</a>
                        <a href="make_user.php">Medewerkers</a>';
            } else if ($_SESSION["role"] == 'directie') {
                echo '  <a href="#" class="deze_pagina">Instellingen</a>
                        <a href="#">Opbrengst</a>
                        <a href="Voorraad.php">Voorraadbeheer</a>';
            } else if ($_SESSION["role"] == 'medewerker') {
                echo '  <a href="#" class="deze_pagina">Instellingen</a>
                        <a href="Voorraad.php">Voorraadbeheer</a>';
            } else if ($_SESSION["role"] == 'chauffeur') {
                echo '  <a href="#" class="deze_pagina">Instellingen</a>
                        <a href="ritten.php">Ritten</a>';
            } else {
                echo '<a href="#" class="deze_pagina">Instellingen</a>';
            }
            ?>

            <a class="header-button2" href="components/logout.inc.php">Uitloggen</a>
        </nav>
    </header>

        <!-- body -->
        </div class="login-container">
            <div class="login-form">
                <h2>User Form</h2>

                <form action="components/setting.inc.php" method="POST">

                    <!-- Gebruikersnaam -->
                    <div class="input-group">
                        <label>Gebruikersnaam:</label>
                        <input type="text" name="gebruiker" value="<?php echo $username; ?>" placeholder="Enter your gebruikersnaam" />
                    </div>

                    <!-- Wachtwoord -->
                    <div class="input-group">
                        <label>Wachtwoord:</label>
                        <input type="password" name="new_ww" placeholder="Enter your password" minlength="8" />
                    </div>

                    <!-- Geeft de userid mee -->
                    <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>" />

                    <!-- Update settings Button -->
                    <div class="button-row">
                        <button type="submit" name="update_settings" class="login-btn">Update settings</button>
                    </div>
                </form>
            </div>
        </div>

    
</body>
</html>