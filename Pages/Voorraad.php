<?php
//---------------------------------------------------------------------------------------------------//
// Naam script       : Voorraad.php
// Omschrijving      : Dit is de voorraad beheer pagina
// Naam ontwikkelaar : Tejo Veldman
// Project           : Kringloop Centrum Duurzaam
// Datum             : 28-01-2026
//---------------------------------------------------------------------------------------------------// 
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: ../login.php?error=notLoggedIn");
    exit();
}

require_once '../../Config/database.php';
require_once 'components/functions.inc.php';

$db = new Database();
$conn = $db->getConnection();

// Verwerk formulieren
if (isset($_POST["voorraadToevoegen"])) {
    $artikel_id = $_POST["artikel_id"];
    $locatie = $_POST["locatie"];
    $aantal = $_POST["aantal"];
    $status_id = $_POST["status_id"];

    if (emptyInputVoorraadToevoegen($artikel_id, $locatie, $aantal, $status_id) === false) {
        voegVoorraadToe($conn, $artikel_id, $locatie, $aantal, $status_id);
        header("Location: Voorraad.php?success=added");
    } else {
        header("Location: Voorraad.php?error=emptyinput");
    }
    exit();
}

if (isset($_POST["voorraadVerwijderen"])) {
    verwijderVoorraad($conn, $_POST["voorraadID"]);
    header("Location: Voorraad.php?success=deleted");
    exit();
}

if (isset($_POST["voorraadBijwerken"])) {
    $artikel_id = $_POST["artikel_id"];
    $locatie = $_POST["locatie"];
    $aantal = $_POST["aantal"];
    $status_id = $_POST["status_id"];

    if (emptyInputVoorraadToevoegen($artikel_id, $locatie, $aantal, $status_id) === false) {
        updateVoorraad($conn, $_POST["voorraadID"], $artikel_id, $locatie, $aantal, $status_id);
        header("Location: Voorraad.php?success=updated");
    } else {
        header("Location: Voorraad.php?error=emptyinput");
    }
    exit();
}

$voorraad = haalAlleVoorraad($conn);
$artikelen = haalAlleArtikelen($conn);
$statuses = haalAlleStatuses($conn);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Voorraad</title>
    <link rel="stylesheet" href="../Assets/CSS/Style.css">
    <style>
        body { font-family: Arial; margin: 20px; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        form { background: #f5f5f5; padding: 15px; margin: 20px 0; border-radius: 4px; }
        input, select { width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; }
        button { padding: 8px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Voorraad Beheer</h1>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?= $_GET['error'] === 'emptyinput' ? 'Alle velden invullen!' : 'Fout opgetreden' ?>
        </div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php 
                $msgs = ['added' => 'Toegevoegd!', 'updated' => 'Bijgewerkt!', 'deleted' => 'Verwijderd!'];
                echo $msgs[$_GET['success']] ?? 'Succes!';
            ?>
        </div>
    <?php endif; ?>

    <h2>Artikel Toevoegen</h2>
    <form method="POST">
        <input type="hidden" name="voorraadToevoegen">
        <select name="artikel_id" required>
            <option value="">Selecteer artikel</option>
            <?php foreach ($artikelen as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['naam']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="aantal" placeholder="Aantal" required>
        <input type="text" name="locatie" placeholder="Locatie" required>
        <select name="status_id" required>
            <option value="">Selecteer status</option>
            <?php foreach ($statuses as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['status']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Toevoegen</button>
    </form>

    <h2>Voorraad Overzicht</h2>
    <?php if ($voorraad): ?>
        <table>
            <thead>
                <tr>
                    <th>Artikel</th>
                    <th>Aantal</th>
                    <th>Locatie</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voorraad as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['artikel_naam']) ?></td>
                        <td><?= $item['aantal'] ?></td>
                        <td><?= htmlspecialchars($item['locatie']) ?></td>
                        <td><?= htmlspecialchars($item['status_naam']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="voorraadID" value="<?= $item['id'] ?>">
                                <button type="submit" name="voorraadVerwijderen" class="btn-delete" onclick="return confirm('Verwijderen?')">Del</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen artikelen in voorraad.</p>
    <?php endif; ?>
</body>
</html>