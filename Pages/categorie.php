<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : Voorraad.php
// Omschrijving      : Dit is de voorraad beheer pagina
// Naam ontwikkelaar : Groep D
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
<body>

    <!-- Header -->
    <div class="voorraad-header">
        <h1 class="Voorraad">categorie</h1>
        <button class="toggle-btn" onclick="toggleFormulier()">Nieuwe Item</button>
    </div>
 <!-- Formulier -->
    <div id="formulierContainer" class="formulier-container">
        <h2>Nieuw Categorie Toevoegen</h2>
        <!-- Formulier (POST) -->
        <form method="POST" action="components/categorie.inc.php">
            
                  <!-- code -->
                <div class="form-group">
                    <label>code:</label>
                    <input type="text" name="code"  required />
                </div>

                <!-- omschrijving -->
                <div class="form-group">
                    <label>omschrijving:</label>
                    <input type="text" name="omschrijving"  required />
                </div>

                 <p class="form-buttons">
                    <button type="submit" name="maak" class="btn-submit">Opslaan</button>
                    <button type="button" class="btn-cancel" onclick="toggleFormulier()">Annuleren</button>
                 </p>
        </form>
    </div>




   <script>
        /* Toggle formulier */
        function toggleFormulier() {
            const formulierContainer = document.getElementById('formulierContainer');
            formulierContainer.classList.toggle('active');
        }
    </script>

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
                <?php foreach ($categorien as $item): 
                    // if (array_key_exists('delete', $_POST)) {  verwijdercategorie($conn, $categorieID);    }   
                ?>
                    <tr>
                         <!-- Checkbox per rij -->
                        <td><input type="checkbox" class="item-checkbox"></td> 
                        <td><?= htmlspecialchars($item['id'])?></td>
                        <td><?= htmlspecialchars($item['code']) ?></td>
                        <td><?= htmlspecialchars($item['omschrijving']) ?></td>
                        <form method="post">
                             <td class="actions">
                            <input type="hidden" name="id" value="<?= $item['id']; ?>">
                            <input type="submit" name="delete" value="Delete" class="menu-btn"> 
                            <button  class="menu-btn">⋮</button>
                        </form>
                        </td>
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