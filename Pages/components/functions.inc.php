<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : functions.inc.php
// Omschrijving      : Functies voor het Kringloop Centrum Duurzaam
// Naam ontwikkelaar : Groep D
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// '

// ----------------------------------------------------
// Check of login input leeg is
// ----------------------------------------------------
function leegInvoerLogin($gebruiker, $ww) {
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
function loginGebruiker($conn, $gebruiker, $ww) {

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
    $_SESSION['username'] = $gebruikerExists['gebruikersnaam'];

    echo "<script>window.location.href = '../dashboard.php?error=none';</script>";
    exit();
}

// ----------------------------------------------------
// Update gebruiker instellingen
// ----------------------------------------------------
function updateGebruiker($conn, $id, $gebruiker, $ww) {
    if (isset($ww)) {
        $wwHashed = hash('sha256', $ww);
        $stmt = $conn->prepare("UPDATE gebruiker SET gebruikersnaam = :gebruiker, wachtwoord = :ww WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":gebruiker", $gebruiker);
        $stmt->bindParam(":ww", $wwHashed);
        $stmt->execute();

        echo "<script>window.location.href = '../instellingen.php?error=none';</script>";
        exit();
    } else {
        $stmt = $conn->prepare("UPDATE gebruiker SET gebruikersnaam = :gebruiker WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":gebruiker", $gebruiker);
        $stmt->execute();

        echo "<script>window.location.href = '../instellingen.php?error=none';</script>";
        exit();
    }
}

// ----------------------------------------------------
// Haal alle ritten op
// ----------------------------------------------------
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

// ----------------------------------------------------
// Voorraad validatie
// ----------------------------------------------------
function emptyInputVoorraadToevoegen($artikel_id, $locatie, $aantal, $status_id) {
    return empty($artikel_id) || empty($locatie) || empty($aantal) || empty($status_id);
}

// ----------------------------------------------------
// Voeg voorraad toe
// ----------------------------------------------------
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

// ----------------------------------------------------
// Haal voorraad op
// ----------------------------------------------------
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

// ----------------------------------------------------
// Verwijder voorraad
// ----------------------------------------------------
function verwijderVoorraad($conn, $voorraadID) {
    $stmt = $conn->prepare("DELETE FROM voorraad WHERE id = :id");
    $stmt->bindParam(":id", $voorraadID);
    return $stmt->execute();
}

// ----------------------------------------------------
// Update voorraad
// ----------------------------------------------------
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

// ----------------------------------------------------
// Haal artikelen op
// ----------------------------------------------------
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

// ----------------------------------------------------
// Haal statuses op
// ----------------------------------------------------
function haalAlleStatuses($conn) {
    $stmt = $conn->prepare("SELECT id, status FROM status ORDER BY status ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// ----------------------------------------------------
// Create category
// ----------------------------------------------------
   function maakCategorie($conn, $code, $omschrijving) {
 
    $sql = "INSERT INTO categorie
            (code, omschrijving)
            VALUES
            (:code, :omschrijving)";
 
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":code"             => $code,
        ":omschrijving"     => $omschrijving
    ]);
 
    echo "<script>window.location.href = '../categorie.php?error=none';</script>";
    exit();
}

// ----------------------------------------------------
// Laad categorien
// ----------------------------------------------------
function haalAlleCategorien($conn) {
    $sql = "SELECT * FROM categorie";
    $stmt = $conn->prepare($sql);
}
// Create Rit
function createRit($conn, $artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op) {
    $stmt = $conn->prepare(
        "INSERT INTO planning (artikel_id, klant_id, kenteken, ophalen_of_bezorgen, afspraak_op) 
         VALUES (:artikel_id, :klant_id, :kenteken, :ophalen_of_bezorgen, :afspraak_op)"
    );
    $stmt->bindParam(":artikel_id", $artikel_id);
    $stmt->bindParam(":klant_id", $klant_id);
    $stmt->bindParam(":kenteken", $kenteken);
    $stmt->bindParam(":ophalen_of_bezorgen", $ophalen_of_bezorgen);
    $stmt->bindParam(":afspraak_op", $afspraak_op);
    return $stmt->execute();
}

// Edit Rit
function updateRit($conn, $id, $artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op) {
    $stmt = $conn->prepare(
        "UPDATE planning SET artikel_id = :artikel_id, klant_id = :klant_id, 
         kenteken = :kenteken, ophalen_of_bezorgen = :ophalen_of_bezorgen, afspraak_op = :afspraak_op 
         WHERE id = :id"
    );
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":artikel_id", $artikel_id);
    $stmt->bindParam(":klant_id", $klant_id);
    $stmt->bindParam(":kenteken", $kenteken);
    $stmt->bindParam(":ophalen_of_bezorgen", $ophalen_of_bezorgen);
    $stmt->bindParam(":afspraak_op", $afspraak_op);
    return $stmt->execute();
}
// Delete Rit
function deleteRit($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM planning WHERE id = :id");
    $stmt->bindParam(":id", $id);
    return $stmt->execute();
}
// Haal Rit op met ID
function getRitById($conn, $id) {
    $stmt = $conn->prepare(
        "SELECT planning.id, planning.artikel_id, planning.klant_id, planning.kenteken, 
         planning.ophalen_of_bezorgen, planning.afspraak_op, 
         artikel.naam as artikel_naam, klant.naam as klant_naam, klant.adres, klant.plaats
         FROM planning
         LEFT JOIN artikel ON planning.artikel_id = artikel.id
         LEFT JOIN klant ON planning.klant_id = klant.id
         WHERE planning.id = :id"
    );
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function haalAlleKlanten($conn) {
    $stmt = $conn->prepare("SELECT id, naam FROM klant ORDER BY naam ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// ----------------------------------------------------
// Create gebruiker
// ----------------------------------------------------

function maakMedewerker($conn, $gebruikersnaam, $wachtwoord, $rollen, $is_geverifieerd) {
 
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
    echo "<script>window.location.href = '../dashboard.php?error=none';</script>";
    exit();
}
?>