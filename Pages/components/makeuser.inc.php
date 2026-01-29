<?php

if (isset($_POST["makeuser"])) { 
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];
    $rollen = $_POST["rollen"];
    $is_geverifieerd = $_POST["is_geverifieerd"];

    require_once '../../Config/DB_connect.php';
    require_once 'functions.inc.php';

    $db = new Database();
    $conn = $db->getConnection();

    maakMedewerker($conn, $gebruikersnaam, $wachtwoord, $rollen, $is_geverifieerd);

} else {
    echo "test";
}
