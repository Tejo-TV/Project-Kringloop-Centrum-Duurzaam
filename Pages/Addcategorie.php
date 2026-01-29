<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : Addcategorie.php
// Omschrijving      : Dit is de categorie toevoegings pagina van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Kieran Teunissen
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
    
  <form action="components/categorie.inc.php" method="POST">

                <!-- code -->
                <div class="input-group">
                    <label>code:</label>
                    <input type="text" name="code"  required />
                </div>

                <!-- omschrijving -->
                <div class="input-group">
                    <label>omschrijving:</label>
                    <input type="text" name="omschrijving"  required />
                </div>

                <!-- create Button -->
                <!-- <div class="button-row">  the cursed div, do not touch-->
                    <button type="submit" name="maak" class="login-btn">maak aan</button>
                <!-- </div> -->
            </form>

</body>
</html>