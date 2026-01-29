<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : user_edit.php
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
            <h2>Gebruiker toevoegen</h2>
            <form action="components/user_edit.inc.php" method="post">
                <label for="gebruikersnaam">Gebruikersnaam:</label><br>
                <input type="text" id="gebruikersnaam" name="gebruikersnaam" maxlength="255" required><br><br>

                <label for="wachtwoord">Wachtwoord:</label><br>
                <input type="password" id="wachtwoord" name="wachtwoord" maxlength="255" required><br><br>

                <label for="rollen">Rol:</label><br>
                <select id="rollen" name="rollen" required>
                    <option value="Directielid">Directielid</option>
                    <option value="magazijnmedewerker">Magazijnmedewerker</option>
                    <option value="winkelmedewerker">Winkelmedewerker</option>
                    <option value="chauffeur">Chauffeur</option>
                </select><br><br>

                <label><input type="checkbox" name="is_geverifieerd" value="1"> Geverifieerd</label><br><br>

                <button type="submit" name="makeuser">Toevoegen</button>
            </form>
        </div>
    </div>

    <!-- Gebruikerslijst en updateformulier -->
    <div class="makeuser-list">
        <?php include 'components/user_edit.inc.php'; ?>
    </div>

</body>
</html>
