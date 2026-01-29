<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : functions.inc.php
// Omschrijving      : Functies voor het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// '

// Check of login input leeg is

function emptyInputLogin($gebruiker, $ww) {
    if (empty($gebruiker) || empty($ww)) {
        return true;
    }
    return false;
}

// Check of gebruiker al bestaat

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

// Inloggen

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

// Voorraad validatie
function emptyInputVoorraadToevoegen($artikel_id, $locatie, $aantal, $status_id) {
    return empty($artikel_id) || empty($locatie) || empty($aantal) || empty($status_id);
}

// Voeg voorraad toe
function voegVoorraadToe($conn, $artikel_id, $locatie, $aantal, $status_id) {
    $stmt = $conn->prepare(
        "INSERT INTO voorraad (artikel_id, locatie, aantal, status_id, ingeboekt_op) 
         VALUES (:artikel_id, :locatie, :aantal, :status_id, NOW())"
    );
    $stmt->bindParam(":artikel_id", $artikel_id);
    $stmt->bindParam(":locatie", $locatie);
    $stmt->bindParam(":aantal", $aantal);
    $stmt->bindParam(":status_id", $status_id);
    return $stmt->execute();
}

// Haal voorraad op
function haalAlleVoorraad($conn) {
    $stmt = $conn->prepare(
        "SELECT v.id, v.artikel_id, v.locatie, v.aantal, v.status_id, v.ingeboekt_op,
                a.naam as artikel_naam, s.status as status_naam
         FROM voorraad v
         JOIN artikel a ON v.artikel_id = a.id
         JOIN status s ON v.status_id = s.id
         ORDER BY v.ingeboekt_op DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Verwijder voorraad
function verwijderVoorraad($conn, $voorraadID) {
    $stmt = $conn->prepare("DELETE FROM voorraad WHERE id = :id");
    $stmt->bindParam(":id", $voorraadID);
    return $stmt->execute();
}

// Update voorraad
function updateVoorraad($conn, $voorraadID, $artikel_id, $locatie, $aantal, $status_id) {
    $stmt = $conn->prepare(
        "UPDATE voorraad SET artikel_id = :artikel_id, locatie = :locatie, 
         aantal = :aantal, status_id = :status_id WHERE id = :id"
    );
    $stmt->bindParam(":id", $voorraadID);
    $stmt->bindParam(":artikel_id", $artikel_id);
    $stmt->bindParam(":locatie", $locatie);
    $stmt->bindParam(":aantal", $aantal);
    $stmt->bindParam(":status_id", $status_id);
    return $stmt->execute();
}

// Haal artikelen op
function haalAlleArtikelen($conn) {
    $stmt = $conn->prepare(
        "SELECT a.id, a.naam, a.prijs_ex_btw, c.categorie 
         FROM artikel a
         LEFT JOIN categorie c ON a.categorie_id = c.id
         ORDER BY a.naam ASC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Haal statuses op
function haalAlleStatuses($conn) {
    $stmt = $conn->prepare("SELECT id, status FROM status ORDER BY status ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
 
    header("Location: ../categorie.php?error=none");
    exit();
}

// ----------------------------------------------------
// laad categorien
// ----------------------------------------------------
function loadCategorie($conn, $code, $omschrijving) {
    $sql = "SELECT * FROM categorie WHERE code = :code";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":code", $gebruiker);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    
}



// ----------------------------------------------------
// Create gebruiker
// ----------------------------------------------------

function createMedewerker($conn, $gebruikersnaam, $wachtwoord, $rollen, $is_geverifieerd) {
 
    $sql = "INSERT INTO gebruiker (gebruikersnaam, wachtwoord, rollen, is_geverifieerd) VALUES (:gebruikersnaam, :wachtwoord, :rollen, :is_geverifieerd)";
 
    $stmt = $conn->prepare($sql);
 
    // Wachtwoord hashen
    $wwHashed = hash('sha256', $wachtwoord);
 
    $stmt->execute([
        ':gebruikersnaam' => $gebruikersnaam,
            ':wachtwoord' => $wwHashed,
            ':rollen' => $rollen,
            ':is_geverifieerd' => $is_geverifieerd
    ]);
        header("Location: ../user_edit.php?error=none");
    exit();
}

?>