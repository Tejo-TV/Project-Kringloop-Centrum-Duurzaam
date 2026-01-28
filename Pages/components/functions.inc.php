<?php

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
        header("Location: ../login.php?error=wrongLogin");
        exit();
    }

    $db_ww = $gebruikerExists["wachtwoord"];
    $wwHashed = hash('sha256', $ww);

    if ($db_ww !== $wwHashed) {
        header("Location: ../login.php?error=wrongLogin");
        exit();
    }

    session_start();
    $_SESSION["userid"] = $gebruikerExists["id"];
    $_SESSION["role"] = $gebruikerExists["rollen"];

    header("Location: ../dashboard.php?error=none");
    exit();
}


// ----------------------------------------------------
// create category
// ----------------------------------------------------
   function createCategorie($conn, $code, $omschrijving) {
 
    $sql = "INSERT INTO categorie
            (code, omschrijving)
            VALUES
            (:code, :omschrijving)";
 
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":code"             => $code,
        ":omschrijving"     => $omschrijving
    ]);
 
    header("Location: ../login.php?error=none");
    exit();
}