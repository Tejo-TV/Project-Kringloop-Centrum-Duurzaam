<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : login.inc.php
// Omschrijving      : Op deze pagina wordt de user ingelogd
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 

if (isset($_POST["login"])) {

    // alle items die zijn gepost worden in een apparte variable gezed
    $gebruiker = $_POST["gebruiker"];
    $ww = $_POST["ww"];

    // include de database connectie en de functies file.
    require_once '../../Config/DB_connect.php';
    require_once 'functions.inc.php';

    // PDO connectie ophalen
    $db = new Database();
    $conn = $db->getConnection();

    // Check of er lege velden zijn
    if (emptyInputLogin($gebruiker, $ww) !== false) {
        echo "<script>window.location.href = '../login.php?error=emptyinput';</script>";
        exit();
    }
    // logt de gebruiker in
    loginUser($conn, $gebruiker, $ww);
} else {
    // als iemand probeert deze pagina te benaderen zonder op de inloggen knop te drukken wordt die terug gestuurd naar de login pagina./
    echo "<script>window.location.href = '../login.php?error=wrongWay';</script>";
    exit();
}

