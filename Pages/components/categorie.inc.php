<?php 

if (isset($_POST["maak categorie"])) {

    // alle items die zijn gepost worden in een apparte variable gezed
    $code = $_POST["code"];
    $omschrijving = $_POST["omschrijving"];
    
   // include de database connectie en de functies file.
    require_once '../../Config/DB_connect.php';
    require_once 'functions.inc.php';

    // PDO connectie ophalen
    $db = new Database();
    $conn = $db->getConnection();
    };
 
createCategorie ($conn, $code, $omschrijving);