<?php

if (isset($_POST["makeuser"])) { 
    $gebruikersnaam = $_POST["gebruikersnaam"] ?? '';
    $wachtwoord = $_POST["wachtwoord"] ?? '';
    $rollen = $_POST["rollen"] ?? '';
    $is_geverifieerd = isset($_POST["is_geverifieerd"]) ? 1 : 0;

    require_once '../../Config/DB_connect.php';
    require_once 'functions.inc.php';

    $db = new Database();
    $conn = $db->getConnection();

    $wwHashed = hash('sha256', $wachtwoord);
    $sql = "INSERT INTO gebruiker (gebruikersnaam, wachtwoord, rollen, is_geverifieerd) VALUES (:gebruikersnaam, :wachtwoord, :rollen, :is_geverifieerd)";
    $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':gebruikersnaam' => $gebruikersnaam,
            ':wachtwoord' => $wwHashed,
            ':rollen' => $rollen,
            ':is_geverifieerd' => $is_geverifieerd
        ]);
} else {
    echo "test";
    exit();
}
