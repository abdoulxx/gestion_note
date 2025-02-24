<?php
session_start();
require "config.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "etudiant") {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user"];

// Récupération des résultats de l'étudiant
$stmt = $pdo->prepare("SELECT * FROM notes WHERE matricule = ?");
$stmt->execute([$user["matricule"]]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcul dynamique de la moyenne et des crédits
$total_notes = 0;
$total_matieres = 0;
$credits_valides = 0;

foreach ($notes as $note) {
    $total_notes += $note["note"];
    $total_matieres++;

    if ($note["note"] >= 10) {
        $credits_valides += 3; // Chaque matière validée donne 3 crédits
    }
}

// Calcul de la moyenne
$moyenne = ($total_matieres > 0) ? $total_notes / $total_matieres : 0;
$moyenne = number_format($moyenne, 2);

// Attribution de la mention
if ($moyenne >= 18) {
    $mention = "Excellent";
} elseif ($moyenne >= 16) {
    $mention = "Bien";
} elseif ($moyenne >= 13) {
    $mention = "Assez Bien";
} elseif ($moyenne >= 10) {
    $mention = "Passable";
} else {
    $mention = "Insuffisant";
}

// Simulation du rang (à remplacer par une requête SQL réelle si applicable)
$rang = rand(1, 10); // Simulation : génère un rang aléatoire
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats - IUA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #0066cc;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .semestre {
            background: black;
            color: white;
            padding: 10px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .session {
            background: #ffcc00;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .result-header {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }
        .matiere {
            background: orange;
            color: white;
            padding: 8px;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
        }
        .table {
            width: 100%;
            margin-top: 10px;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .table th {
            background: #007bff;
            color: white;
        }
        .note {
            color: green;
            font-weight: bold;
        }
        .note-rouge {
            color: red;
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
    <!-- 🏫 En-tête -->
    <div class="header">
        2023/2024 - LICENCE 3 - MÉTHODES INFORMATIQUES APPLIQUÉES À LA GESTION D’ENTREPRISE - Rang[<?= $rang ?>]
    </div>

    <!-- 📚 Semestre -->
    <div class="semestre">SEMESTRE 5 - SESSION 1</div>

    <!-- 📊 Résumé des résultats (Dynamique) -->
    <div class="session">
        <div class="result-header">
            <span><strong>SESSION 1 :</strong></span>
            <span><strong>Mention:</strong> <?= $mention ?> </span>
            <span><strong>Crédits Validés:</strong> <?= $credits_valides ?> </span>
            <span><strong>Moyenne:</strong> <?= $moyenne ?> </span>
        </div>
    </div>

    <!-- 📖 Liste des matières avec notes -->
    <?php
    // Regrouper les matières dans des catégories simulées
    $categories = [
        "Programmation Mobile Androïde" => ["Programmation Mobile IOS", "Programmation Mobile Android"],
        "Comptabilité Analytique et Financière" => ["Comptabilité Analytique", "Gestion d’Entreprise"],
        "Sécurité des Systèmes d’Informations" => ["Sécurité des Systèmes d’Informations"],
        "Architecture Big Data et Cloud Computing" => ["Architecture Big Data et Cloud Computing"],
        "Machine Learning" => ["Machine Learning"],
        "Cryptographie" => ["Algorithmie de cryptographie"],
        "Analyse UML" => ["Modélisation avec le langage UML"],
        "Anglais Technique II" => ["Anglais"],
        "Gestion de Projet avec MS Project" => ["Gestion de projet (informatique) avec MS Project"]
    ];

    foreach ($categories as $categorie => $cours) {
        echo "<div class='matiere'>$categorie</div>";
        echo "<table class='table'>";
        echo "<tr><th>Matière</th><th>Note /20</th></tr>";

        foreach ($cours as $matiere) {
            // Recherche de la note de la matière
            $note_valeur = "N/A";
            foreach ($notes as $note) {
                if ($note["matiere"] == $matiere) {
                    $note_valeur = number_format($note["note"], 2);
                    break;
                }
            }

            // Définir la couleur de la note
            $class_note = ($note_valeur >= 10) ? "note" : "note-rouge";

            echo "<tr><td>$matiere</td><td class='$class_note'>$note_valeur /20</td></tr>";
        }
        echo "</table>";
    }
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
