<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : functions.inc.php
// Omschrijving      : Functies voor het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// '

// ----------------------------------------------------
// Check of login input leeg is
// ----------------------------------------------------
function emptyInputLogin($gebruiker, $ww) {
    if (empty($gebruiker) || empty($ww)) {
        return true;
    }
    return false;
}


// ----------------------------------------------------
// Check of gebruiker al bestaat
// ----------------------------------------------------
function gebruikerExists($conn, $gebruiker) {
    $sql = "SELECT * FROM gebruiker WHERE gebruikersnaam = :gebruiker";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":gebruiker", $gebruiker);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return $row;
    }
    return false;
}

// ----------------------------------------------------
// Inloggen
// ----------------------------------------------------
function loginUser($conn, $gebruiker, $ww) {

    $gebruikerExists = gebruikerExists($conn, $gebruiker);

    if ($gebruikerExists === false) {
        echo "<script>window.location.href = '../login.php?error=wrongLogin';</script>";
        
        exit();
    }

    $db_ww = $gebruikerExists["wachtwoord"];
    $wwHashed = hash('sha256', $ww);

    if ($db_ww !== $wwHashed) {
        echo "<script>window.location.href = '../login.php?error=wrongLogin';</script>";
        exit();
    }

    session_start();
    $_SESSION["userid"] = $gebruikerExists["id"];
    $_SESSION["role"] = $gebruikerExists["rollen"];

    echo "<script>window.location.href = '../dashboard.php?error=none';</script>";
    exit();
}
