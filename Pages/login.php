<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : login.php
// Omschrijving      : Dit is de login pagina van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 

session_start();
// Als je bent ingelogd, stuur je naar het dashboard.
if (isset($_SESSION["userid"])) {
    echo "<script>window.location.href = 'dashboard.php';</script>";
    exit();
}

// Foutmeldingen weergeven op de login pagina
if(isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<div class='popup1'> ❌ Één of meer verplichte velden zijn leeg. Vul alstublieft alle velden in om verder te gaan. </div>";
    } else if ($_GET["error"] == "wrongLogin") {
        echo "<div class='popup1'> ❌ Het e-mailadres of wachtwoord is onjuist. Controleer uw informatie en probeer het opnieuw. </div>";
    } else if ($_GET["error"] == "stmtfailed") {
        echo "<div class='popup1'> ⚠️ Er is iets misgegaan. Probeer het later alstublieft opnieuw. </div>";
    } else if ($_GET["error"] == "wrongWay") {
        echo "<div class='popup1'> ⚠️ U hebt deze pagina op onjuiste wijze bereikt. Gebruik het formulier om verder te gaan. </div>";
    } else if ($_GET["error"] == "uitgelogd") {
        echo "<div class='popup2'> ✅ U bent succesvol uitgelogd. </div>";
    } else if ($_GET["error"] == "none") {
        echo "<div class='popup2'> ✅ Account succesvol aangemaakt. Log nu in. </div>";
    } else if ($_GET["error"] == "notLoggedIn") {
        echo "<div class='popup1'> 🔐 U moet ingelogd zijn om het dashboard te openen. Log alstublieft eerst in. </div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="shortcut icon" type="x-icon" href="assets/Images/centrum-duurzaam-icon.png">
    <link rel="stylesheet" href="../assets/CSS/Style.css" />
</head>
<body>
    
    <!-- Header -->
    <header>
        <a href="index.php">Kringloop centrum</a>
    </header>


</div class="login-container">
    <div class="login-form">
        <h2>Login Form</h2>

        <form action="components/login.inc.php" method="POST">

                <!-- gebruikersnaam -->
                <div class="input-group">
                    <label>Gebruikersnaam:</label>
                    <input type="text" name="gebruiker" placeholder="Enter your gebruikersnaam" required />
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label>Password:</label>
                    <input type="password" name="ww" placeholder="Enter your password" required />
                </div>

                <!-- Register Button -->
                <div class="button-row">
                    <button type="submit" name="login" class="login-btn">Login</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

