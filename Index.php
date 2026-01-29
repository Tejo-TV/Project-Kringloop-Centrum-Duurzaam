<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : index.php
// Omschrijving      : Dit is de homepage van het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Groep D
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="shortcut icon" type="x-icon" href="assets/Images/centrum-duurzaam-icon.png">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <a href="index.php">Kringloop centrum</a>
        <nav>
            <a class="header-button" href="pages/login.php">Aanmelden</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <section class="homepage">
            <div class="homepage-content">
                <h1>Kringloop Centrum Dashboard</h1>
                <p>Het complete dashboard voor uw duurzame kringloop</p>
                <a href="pages/login.php" class="btn-primary">Aanmelden</a>
            </div>
        </section>
    </main>
</body>
</html>