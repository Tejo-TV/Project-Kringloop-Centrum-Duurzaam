<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : setting.inc.php
// Omschrijving      : Op deze pagina worden de instellingen van de gebruiker bijgewerkt
// Naam ontwikkelaar : Groep D
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 

if (isset($_POST["update_settings"])) {

    // alle items die zijn gepost worden in een apparte variable gezed
    $gebruiker = $_POST["gebruiker"];
    $ww = $_POST["new_ww"];
    $id = $_POST["userid"];

    // include de database connectie en de functies file.
    require_once '../../Config/DB_connect.php';
    require_once 'functions.inc.php';

    // PDO connectie ophalen
    $db = new Database();
    $conn = $db->getConnection();

    // logt de gebruiker in
    updateGebruiker($conn, $id, $gebruiker, $ww);
} else {
    // als iemand probeert deze pagina te benaderen zonder op de inloggen knop te drukken wordt die terug gestuurd naar de login pagina./
    echo "<script>window.location.href = '../login.php?error=wrongWay';</script>";
    exit();
}
