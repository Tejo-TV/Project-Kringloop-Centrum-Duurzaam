<?php 
//---------------------------------------------------------------------------------------------------//
// Naam script       : Ritten.php
// Omschrijving      : Dit is de ritten beheer pagina
// Naam ontwikkelaar : Groep D
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
session_start();

// Als je niet bent ingelogd, stuur je terug naar de login pagina anders popup.
if (!isset($_SESSION["userid"])) {
    echo "<script>window.location.href = 'login.php?error=notLoggedIn';</script>";
    exit();
} elseif ($_SESSION["role"] != 'admin' && $_SESSION["role"] != 'chauffeur') {
    // Niet gemachtigd
    echo "<script>window.location.href = 'dashboard.php?error=notAuthorized';</script>";
    exit();
}

require_once '../Config/DB_connect.php';
require_once 'components/functions.inc.php';
require_once 'components/adminnavbar.inc.php';

$db = new Database();
$conn = $db->getConnection();

// haal opgegeven ritten functies
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create') {
        $artikel_id = $_POST['artikel_id'] ?? '';
        $klant_id = $_POST['klant_id'] ?? '';
        $kenteken = $_POST['kenteken'] ?? '';
        $ophalen_of_bezorgen = $_POST['ophalen_of_bezorgen'] ?? '';
        $afspraak_op = $_POST['afspraak_op'] ?? '';
        
        if (!empty($artikel_id) && !empty($klant_id) && !empty($kenteken) && !empty($ophalen_of_bezorgen) && !empty($afspraak_op)) {
            if (createRit($conn, $artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op)) {
                $message = 'Rit succesvol toegevoegd!';
                $messageType = 'success';
            } else {
                $message = 'Fout bij toevoegen van rit.';
                $messageType = 'error';
            }
        } else {
            $message = 'Alle velden zijn verplicht.';
            $messageType = 'error';
        }
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? '';
        $artikel_id = $_POST['artikel_id'] ?? '';
        $klant_id = $_POST['klant_id'] ?? '';
        $kenteken = $_POST['kenteken'] ?? '';
        $ophalen_of_bezorgen = $_POST['ophalen_of_bezorgen'] ?? '';
        $afspraak_op = $_POST['afspraak_op'] ?? '';
        
        if (!empty($id) && !empty($artikel_id) && !empty($klant_id) && !empty($kenteken) && !empty($ophalen_of_bezorgen) && !empty($afspraak_op)) {
            if (updateRit($conn, $id, $artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op)) {
                $message = 'Rit succesvol bijgewerkt!';
                $messageType = 'success';
            } else {
                $message = 'Fout bij bijwerken van rit.';
                $messageType = 'error';
            }
        } else {
            $message = 'Alle velden zijn verplicht.';
            $messageType = 'error';
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            if (deleteRit($conn, $id)) {
                $message = 'Rit succesvol verwijderd!';
                $messageType = 'success';
            } else {
                $message = 'Fout bij verwijderen van rit.';
                $messageType = 'error';
            }
        }
    }
}

// Get data for form dropdowns
$artikelen = haalAlleArtikelen($conn);
$klanten = haalAlleKlanten($conn);
$ritten = Ritten($conn);

// Check if we're editing
$editingRit = null;
if (isset($_GET['edit'])) {
    $editingRit = getRitById($conn, $_GET['edit']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritten</title>
    <link rel="shortcut icon" type="x-icon" href="../Assets/Images/centrum-duurzaam-icon.png">
    <link rel="stylesheet" href="../Assets/CSS/Style.css">
</head>
<body>
    <?php require_once 'components/adminnavbar.inc.php'; ?>
    <div class="ritten-container">
        <h1>Ritten Planning</h1>
        
        <!-- Message Display -->
        <?php if ($message): ?>
            <div class="message message-<?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <!-- Add/Edit Form -->
        <div class="ritten-form-container">
            <h2><?= $editingRit ? 'Rit Bewerken' : 'Nieuwe Rit Toevoegen' ?></h2>
            <form method="POST" class="ritten-form">
                <input type="hidden" name="action" value="<?= $editingRit ? 'update' : 'create' ?>">
                <?php if ($editingRit): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editingRit['id']) ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="artikel_id">Artikel:</label>
                    <select name="artikel_id" id="artikel_id" required>
                        <option value="">-- Selecteer artikel --</option>
                        <?php foreach ($artikelen as $artikel): ?>
                            <option value="<?= $artikel['id'] ?>" 
                                <?= $editingRit && $editingRit['artikel_id'] == $artikel['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($artikel['naam']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="klant_id">Klant:</label>
                    <select name="klant_id" id="klant_id" required>
                        <option value="">-- Selecteer klant --</option>
                        <?php foreach ($klanten as $klant): ?>
                            <option value="<?= $klant['id'] ?>" 
                                <?= $editingRit && $editingRit['klant_id'] == $klant['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($klant['naam']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="kenteken">Kenteken:</label>
                    <input type="text" name="kenteken" id="kenteken" required 
                        value="<?= $editingRit ? htmlspecialchars($editingRit['kenteken']) : '' ?>">
                </div>
                
                <div class="form-group">
                    <label for="ophalen_of_bezorgen">Type:</label>
                    <select name="ophalen_of_bezorgen" id="ophalen_of_bezorgen" required>
                        <option value="">-- Selecteer type --</option>
                        <option value="ophalen" <?= $editingRit && $editingRit['ophalen_of_bezorgen'] == 'ophalen' ? 'selected' : '' ?>>Ophalen</option>
                        <option value="bezorgen" <?= $editingRit && $editingRit['ophalen_of_bezorgen'] == 'bezorgen' ? 'selected' : '' ?>>Bezorgen</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="afspraak_op">Afspraak op:</label>
                    <input type="datetime-local" name="afspraak_op" id="afspraak_op" required 
                        value="<?= $editingRit ? htmlspecialchars(str_replace(' ', 'T', $editingRit['afspraak_op'])) : '' ?>">
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-primary"><?= $editingRit ? 'Bijwerken' : 'Toevoegen' ?></button>
                    <?php if ($editingRit): ?>
                        <a href="ritten.php" class="btn-secondary">Annuleren</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Ritten Table -->
        <div class="ritten-table-container">
            <h2>Alle Ritten</h2>
            <?php if ($ritten): ?>
            <table class="ritten-table">
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
                        <th>Acties</th>
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
                            <td class="ritten-actions">
                                <a href="ritten.php?edit=<?= $item['id'] ?>" class="btn-edit">Bewerk</a>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Weet je zeker dat je deze rit wilt verwijderen?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn-delete">Verwijder</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Geen ritten beschikbaar.</p>
        <?php endif ?>
        </div>
    </div>
</body>
</html>