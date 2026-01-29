<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : Voorraad.php
// Omschrijving      : Dit is de voorraad beheer pagina
// Naam ontwikkelaar : Thimo Kamp
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 

// Fouten tonen (development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start sessie
session_start();

// Include DB + helpers
require_once '../Config/DB_connect.php';
require_once 'components/functions.inc.php';
require_once 'components/adminnavbar.inc.php';

// DB connectie
$db = new Database();
$conn = $db->getConnection();

// Foutmelding
$errorMsg = ''; 

// Verwerk POST formulier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artikel_naam'])) {
    // Lees en trim input
    $artikel_naam = trim($_POST['artikel_naam'] ?? '');
    $locatie = trim($_POST['locatie'] ?? '');
    $aantal = (int)($_POST['aantal'] ?? 0); // forceer integer
    $status = trim($_POST['status'] ?? '');

    // Valideer invoer
    if (!empty($artikel_naam) && !empty($locatie) && $aantal > 0 && !empty($status)) {
        try {
            // Zoek artikel op naam
            $stmt = $conn->prepare("SELECT id FROM artikel WHERE naam = :naam");
            $stmt->bindParam(":naam", $artikel_naam);
            $stmt->execute();
            $artikel = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$artikel) {
                // Voeg artikel toe (defaults)
                $stmt = $conn->prepare("INSERT INTO artikel (naam, categorie_id, prijs_ex_btw) VALUES (:naam, 1, 0)");
                $stmt->bindParam(":naam", $artikel_naam);
                $stmt->execute();
                $artikel_id = (int)$conn->lastInsertId();

                // Fallback: zoek opnieuw op naam als id niet komt
                if ($artikel_id <= 0) {
                    $stmt = $conn->prepare("SELECT id FROM artikel WHERE naam = :naam");
                    $stmt->bindParam(":naam", $artikel_naam);
                    $stmt->execute();
                    $artikel2 = $stmt->fetch(PDO::FETCH_ASSOC);
                    $artikel_id = $artikel2 ? (int)$artikel2['id'] : 0;
                }
            } else {
                // Gebruik bestaande id
                $artikel_id = (int)$artikel['id'];
            }

            // Fout: geen artikel id
            if ($artikel_id <= 0) {
                throw new Exception('Kon artikel niet aanmaken of vinden. Controleer of de tabel `artikel` een geldig AUTO_INCREMENT primaire sleutel heeft.');
            }

            // Haal status id (fallback 1)
            $stmt = $conn->prepare("SELECT id FROM status WHERE status = :status");
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            $status_obj = $stmt->fetch(PDO::FETCH_ASSOC);
            $status_id = $status_obj ? (int)$status_obj['id'] : 1; // 1 is default/status fallback

            // Voeg voorraad toe (helper)
            if (voegVoorraadToe($conn, $artikel_id, $locatie, $aantal, $status_id)) {
                // Redirect na succes 
                header("Location: Voorraad.php?success=1");
                exit();
            } else {
                // Fout bij toevoegen voorraad
                throw new Exception('Kon voorraad niet toevoegen.');
            }

        } catch (PDOException $e) {
            // DB fout (alleen tonen in dev)
            $errorMsg = 'Database fout: ' . $e->getMessage();
        } catch (Exception $e) {
            // Algemene fout
            $errorMsg = 'Fout: ' . $e->getMessage();
        }
    } else {
        // Toon validatiefout
        $errorMsg = 'Vul alle verplichte velden correct in.';
    }
}

// Haal voorraad op
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
    <!-- Header -->
    <div class="voorraad-header">
        <h1 class="Voorraad">Voorraad</h1>
        <button class="toggle-btn" onclick="toggleFormulier()">Nieuwe Item</button>
    </div>

    <!-- Foutmelding -->
    <?php if (!empty($errorMsg)): ?>
        <div class="error-msg"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <!-- Formulier -->
    <div id="formulierContainer" class="formulier-container">
        <h2>Nieuw Artikel Toevoegen</h2>
        <!-- Formulier (POST) -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="artikel_naam">Artikel Naam:</label>
                <input type="text" id="artikel_naam" name="artikel_naam" required>
            </div>

            <div class="form-group">
                <label for="locatie">Locatie:</label>
                <input type="text" id="locatie" name="locatie" required>
            </div>

            <div class="form-group">
                <label for="aantal">Aantal:</label>
                <input type="number" id="aantal" name="aantal" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required>
            </div>

            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <textarea id="beschrijving" name="beschrijving"></textarea>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-submit">Opslaan</button>
                <button type="button" class="btn-cancel" onclick="toggleFormulier()">Annuleren</button>
            </div>
        </form>
    </div>

    <script>
        /* Toggle formulier */
        function toggleFormulier() {
            const formulierContainer = document.getElementById('formulierContainer');
            formulierContainer.classList.toggle('active');
        }
    </script>

    <!-- Voorraad tabel -->
    <?php if ($voorraad): ?> 
        <table class="voorraad-table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="select-all"></th>
                    <th>ID</th>
                    <th>Omschrijving</th>
                    <th>Hoeveelheid</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voorraad as $item): ?>
                    <tr>
                        <!-- Checkbox per rij -->
                        <td><input type="checkbox" class="item-checkbox"></td> 
                        <td><?= htmlspecialchars($item['id']) ?></td>
                        <td><?= htmlspecialchars($item['artikel_naam']) ?></td>
                        <td><?= htmlspecialchars($item['aantal']) ?></td>
                        <td class="actions"><button class="menu-btn">⋮</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Footer/paginatie -->
        <div class="table-footer">
            <span><?php echo count($voorraad); ?> Resultaten</span>
            <div class="pagination">
                <button class="paginatie-btn">‹ Vorige</button>
                <span>1</span>
                <button class="paginatie-btn">Volgende ›</button>
            </div>
        </div>
    <?php else: ?>
<<<<<<< Updated upstream
        <p>Geen artikelen in voorraad.</p>
    <?php endif; ?>
=======
        <!-- Geen items -->
        <p class="voorraadpar">Geen artikelen in voorraad.</p>
    <?php endif; ?>

</body>
</html>
>>>>>>> Stashed changes
