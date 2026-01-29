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

// Als je niet bent ingelogd, stuur je terug naar de login pagina anders popup.
if (!isset($_SESSION["userid"])) {
    echo "<script>window.location.href = 'login.php?error=notLoggedIn';</script>";
    exit();
}

require_once '../Config/DB_connect.php';
require_once 'components/functions.inc.php';
require_once 'components/adminnavbar.inc.php';

$db = new Database();
$conn = $db->getConnection();

$categorien = haalAlleCategorien($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/CSS/Style.css" />
</head>


   <!-- categorien tabel -->
    <?php if ($categorien): ?>
        <table class="voorraad-table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="select-all"></th>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Omschrijving</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorien as $item): ?>
                    <tr>
                         <!-- Checkbox per rij -->
                        <td><input type="checkbox" class="item-checkbox"></td> 
                        <td><?= htmlspecialchars($item['id']) ?></td>
                        <td><?= htmlspecialchars($item['code']) ?></td>
                        <td><?= htmlspecialchars($item['omschrijving']) ?></td>
                          <td class="actions"><button class="menu-btn">⋮</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


   <!-- Footer/paginatie -->
        <div class="table-footer">
            <span><?php echo count($categorien); ?> Resultaten</span>
            <div class="pagination">
                <button class="paginatie-btn">‹ Vorige</button>
                <span>1</span>
                <button class="paginatie-btn">Volgende ›</button>
            </div>
        </div>
    <?php else: ?>
        <!-- Geen items -->
        <p class="voorraadpar">Geen artikelen in voorraad.</p>
    <?php endif; ?>

</body>
</html>