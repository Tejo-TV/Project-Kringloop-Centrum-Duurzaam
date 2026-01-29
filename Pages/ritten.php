<?php 
//---------------------------------------------------------------------------------------------------//
// Naam script       : Voorraad.php
// Omschrijving      : Dit is de voorraad beheer pagina
// Naam ontwikkelaar : Kevin van Lit
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
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
$ritten = Ritten($conn);
require_once 'components/adminnavbar.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <?php if ($ritten): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Artikel</th>
                    <th>Klant</th>
                    <th>Adres</th>
                    <th>Plaats</th>
                    <th>Kenteken</th>
                    <th>Type</th>
                    <th>Afspraak</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ritten as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['id']) ?></td>
                        <td><?= htmlspecialchars($item['artikel_naam']) ?></td>
                        <td><?= htmlspecialchars($item['klant_naam']) ?></td>
                        <td><?= htmlspecialchars($item['adres']) ?></td>
                        <td><?= htmlspecialchars($item['plaats']) ?></td>
                        <td><?= htmlspecialchars($item['kenteken']) ?></td>
                        <td><?= htmlspecialchars($item['ophalen_of_bezorgen']) ?></td>
                        <td><?= htmlspecialchars($item['afspraak_op']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen ritten beschikbaar.</p>
        <?php endif ?>
    
</body>
</html>