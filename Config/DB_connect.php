<?php 
//---------------------------------------------------------------------------------------------------//
// Naam script       : DB_connect.php
// Omschrijving      : Dit is de connectie naar de database
// Naam ontwikkelaar : Tejo Veldman
// Project           : NETFISH
// Datum             : OefenExamen 12-1-2026
//---------------------------------------------------------------------------------------------------// 

    class Database {
    private $db_server = "localhost"; // server naam
    private $db_user = "root"; // usernaam (default is de naam root)
    private $db_pass = ""; // wachtwoord (default is er geen wachtwoord)
    private $db_name = "duurzaam"; // naam database
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->db_server . ";dbname=" . $this->db_name,
                $this->db_user,
                $this->db_pass
            );

            // Zorgt dat errors netjes worden gegooid (je weet wat er mis gaat)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Database connection failed");
        }
    }

    public function getConnection() {
                return $this->conn;
    }
}
?>