<?php
    require_once '../Config/DB_connect.php';
    require_once 'functions.inc.php';

    $db = new Database();
    $conn = $db->getConnection();

// Maak medewerker aan
if (isset($_POST["makeuser"])) { 
     $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];
    $rollen = $_POST["rollen"];
    $is_geverifieerd = $_POST["is_geverifieerd"];
    maakMedewerker($conn, $gebruikersnaam, $wachtwoord, $rollen, $is_geverifieerd);
}

// Update medewerker
if (isset($_POST["updateuser"])) {
    $id = $_POST["id"];
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];
    $rollen = $_POST["rollen"];
    $is_geverifieerd = isset($_POST["is_geverifieerd"]) ? $_POST["is_geverifieerd"] : 0;
    if (!empty($wachtwoord)) {
        $wwHashed = hash('sha256', $wachtwoord);
        $sql = "UPDATE gebruiker SET gebruikersnaam = :gebruikersnaam, wachtwoord = :wachtwoord, rollen = :rollen, is_geverifieerd = :is_geverifieerd WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':gebruikersnaam' => $gebruikersnaam,
            ':wachtwoord' => $wwHashed,
            ':rollen' => $rollen,
            ':is_geverifieerd' => $is_geverifieerd,
            ':id' => $id
        ]);
    } else {
        $sql = "UPDATE gebruiker SET gebruikersnaam = :gebruikersnaam, rollen = :rollen, is_geverifieerd = :is_geverifieerd WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':gebruikersnaam' => $gebruikersnaam,
            ':rollen' => $rollen,
            ':is_geverifieerd' => $is_geverifieerd,
            ':id' => $id
        ]);
    }
    echo "<div style='color: green;'>Gebruiker bijgewerkt!</div>";
}

// Haal alle gebruikers op
$sql = "SELECT * FROM gebruiker";
$stmt = $conn->prepare($sql);
$stmt->execute();
$gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gebruikerslijst tonen
echo "<h2>Gebruikerslijst</h2>";
echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Gebruikersnaam</th><th>Rollen</th><th>Geverifieerd</th><th>Actie</th></tr>";
foreach ($gebruikers as $gebruiker) {
    echo "<tr>";
    echo "<td>" . $gebruiker['id'] . "</td>";
    echo "<td>" . $gebruiker['gebruikersnaam'] . "</td>";
    echo "<td>" . $gebruiker['rollen'] . "</td>";
    echo "<td>" . $gebruiker['is_geverifieerd'] . "</td>";
    echo "<td>";
    // Update form per gebruiker
    echo "<form method='post' style='display:inline;'>";
    echo "<input type='hidden' name='id' value='" . $gebruiker['id'] . "'>";
    echo "<input type='text' name='gebruikersnaam' value='" . $gebruiker['gebruikersnaam'] . "' required> ";
    echo "<input type='password' name='wachtwoord' placeholder='Nieuw wachtwoord'> ";
    echo "<input type='text' name='rollen' value='" . $gebruiker['rollen'] . "' required> ";
    echo "<input type='number' name='is_geverifieerd' value='" . $gebruiker['is_geverifieerd'] . "' min='0' max='2' required> ";
    echo "<button type='submit' name='updateuser'>Update</button>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
