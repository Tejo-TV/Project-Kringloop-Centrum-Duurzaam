<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : login.php
// Omschrijving      : Dit is de login pagina van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 

if(isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<div class='popup1'> One or more required fields are empty. Please complete all fields to continue. </div>";
    } else if ($_GET["error"] == "wrongLogin") {
        echo "<div class='popup1'> The email address or password is incorrect. Please check your information and try again. </div>";
    } else if ($_GET["error"] == "stmtfailed") {
        echo "<div class='popup1'> Something went wrong, please try again later. </div>";
    } else if ($_GET["error"] == "wrongWay") {
        echo "<div class='popup1'> You have accessed this page incorrectly. Please use the form to proceed. </div>";
    } else if ($_GET["error"] == "uitgelogd") {
        echo "<div class='popup2'> You have successfully logged out. </div>";
    } else if ($_GET["error"] == "none") {
        echo "<div class='popup2'> Account successfully created. Please log in now. </div>";
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
        <nav>
            <a href="pages/login.php">Aanmelden</a>
        </nav>
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

                <p> Wachtwoord vergeten? <a href="reset.php">Reset wachtwoord</a></p>
            </form>
        </div>
    </div>

</body>
</html>

