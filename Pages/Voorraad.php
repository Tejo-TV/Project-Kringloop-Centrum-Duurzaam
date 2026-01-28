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
</head>
<body>
    <h1 class="Voorraad">Voorraad Overzicht</h1>

    <?php if ($voorraad): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Artikel</th>
                    <th>Locatie</th>
                    <th>Aantal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voorraad as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['id']) ?></td>
                        <td><?= htmlspecialchars($item['artikel_naam']) ?></td>
                        <td><?= htmlspecialchars($item['locatie']) ?></td>
                        <td><?= htmlspecialchars($item['aantal']) ?></td>
                        <td><?= htmlspecialchars($item['status_naam']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen artikelen in voorraad.</p>
    <?php endif; ?>