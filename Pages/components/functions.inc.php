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
function Ritten($conn){
    $sql = "SELECT planning.id, planning.artikel_id, planning.klant_id, planning.kenteken, planning.ophalen_of_bezorgen, planning.afspraak_op, 
            artikel.naam as artikel_naam, klant.naam as klant_naam, klant.adres, klant.plaats
            FROM planning
            LEFT JOIN artikel ON planning.artikel_id = artikel.id
            LEFT JOIN klant ON planning.klant_id = klant.id
            ORDER BY planning.afspraak_op DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


