<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : Voorraad.php
// Omschrijving      : Dit is de voorraad beheer pagina
// Naam ontwikkelaar : Thimo Kamp
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: ../login.php?error=notLoggedIn");
    exit();
}

require_once '../Config/DB_connect.php';
require_once 'components/functions.inc.php';
require_once 'components/adminnavbar.inc.php';

$db = new Database();
$conn = $db->getConnection();

$voorraad = haalAlleVoorraad($conn);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Voorraad</title>
    <link rel="stylesheet" href="../Assets/CSS/Style.css">
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Voorraad Overzicht</h1>

    <?php if ($voorraad): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Omschrijving</th>
                    <th>Hoeveelheid</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voorraad as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ID']) ?></td>
                        <td><?= $item['Omschrijving'] ?></td>
                        <td><?= htmlspecialchars($item['Hoeveelheid']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen artikelen in voorraad.</p>
    <?php endif; ?>