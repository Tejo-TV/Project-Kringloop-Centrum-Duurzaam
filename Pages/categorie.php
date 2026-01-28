<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : dashboard.php
// Omschrijving      : Dit is de dashboard pagina van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
session_start();




    // echo "<div> $code $omschrijving Something went wrong, please try again. </div>"; 
// Als je niet bent ingelogd, stuur je terug naar de login pagina anders popup.

// if (isset($_SESSION["userid"])) {
//     echo "<div class='popup2'> You are logged in. </div>";
// } else {
//     header("Location: login.php?error=notLoggedIn");
//     exit();
// }



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

                <!-- Register Button -->
                <div class="button-row">
                    <button type="submit" name="maak categorie" class="login-btn">maak aan</button>
                </div>
            </form>

</body>
</html>