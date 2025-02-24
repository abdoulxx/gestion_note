<?php
session_start();
require "config.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "etudiant") {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sujet = trim($_POST["sujet"]);
    $message_text = trim($_POST["message"]);

    if (!empty($sujet) && !empty($message_text)) {
        $stmt = $pdo->prepare("INSERT INTO reclamations (matricule, sujet, message) VALUES (?, ?, ?)");
        $stmt->execute([$user["matricule"], $sujet, $message_text]);
        $message = "✅ Votre réclamation a été envoyée avec succès.";
    } else {
        $message = "❌ Veuillez remplir tous les champs.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM reclamations WHERE matricule = ? ORDER BY date_soumission DESC");
$stmt->execute([$user["matricule"]]);
$reclamations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamations - IUA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #0066cc;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table th {
            background: #007bff;
            color: white;
            text-align: center;
        }
        .statut-en-cours {
            color: orange;
            font-weight: bold;
        }
        .statut-resolue {
            color: green;
            font-weight: bold;
        }
    </style>
        <style>
        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: white;
            background: red;
            text-decoration: none;
            border-radius: 5px;
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        .navbar-nav .nav-link {
            font-weight: bold;
            color: #333;
            margin: 0 10px;
            transition: color 0.3s ease-in-out;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .active {
            color: #007bff;
        }
    </style>
</head>
<body>

<nav class=" navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#">IUA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="resultats.php">Résultats</a></li>
                <li class="nav-item"><a class="nav-link" href="a_rattraper.php">A Rattraper</a></li>
                <li class="nav-item"><a class="nav-link" href="reclamation.php">Réclamations</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="header">
        📢 Soumettre une Réclamation
    </div>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-info text-center"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="sujet" class="form-label">Sujet :</label>
            <input type="text" id="sujet" name="sujet" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message :</label>
            <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">📩 Envoyer Réclamation</button>
    </form>

    <h3 class="mt-4 text-center">📄 Historique des Réclamations</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sujet</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reclamations as $reclamation) : ?>
                <tr>
                    <td><?= htmlspecialchars($reclamation["sujet"]) ?></td>
                    <td><?= date("d/m/Y H:i", strtotime($reclamation["date_soumission"])) ?></td>
                    <td class="<?= ($reclamation["statut"] === "Résolue") ? "statut-resolue" : "statut-en-cours" ?>">
                        <?= $reclamation["statut"] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
