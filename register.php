<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenoms = $_POST["prenoms"];
    $date_naissance = $_POST["date_naissance"];
    $sexe = $_POST["sexe"];
    $contact = $_POST["contact"];
    $matricule = strtoupper(trim($_POST["matricule"]));
    $serie_bac = $_POST["serie_bac"];
    $filiere = $_POST["filiere"];
    $niveau = $_POST["niveau"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenoms, date_naissance, sexe, contact, matricule, serie_bac, filiere, niveau, mot_de_passe) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenoms, $date_naissance, $sexe, $contact, $matricule, $serie_bac, $filiere, $niveau, $password]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - IUA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-image: url('back.png');
            background-size: cover;
            background-position: center;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        .btn-custom {
            background-color:rgb(52, 94, 185);
            color: #fff;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color:rgb(0, 119, 230);
        }

        .alert {
            font-size: 1rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .register-logo {
            width: 150px;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 30px;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <img src="iua.png" alt="Logo IUA" class="register-logo"> 
        <h2>Inscription <i class="bi bi-pencil-square"></i></h2>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger text-center">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="mb-3">
                <input type="text" name="nom" class="form-control" placeholder="Nom" required>
            </div>
            <div class="mb-3">
                <input type="text" name="prenoms" class="form-control" placeholder="Prénoms" required>
            </div>
            <div class="mb-3">
                <input type="date" name="date_naissance" class="form-control" required>
            </div>
            <div class="mb-3">
                <select name="sexe" class="form-control">
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" name="contact" class="form-control" placeholder="Contact" required>
            </div>
            <div class="mb-3">
                <input type="text" name="matricule" class="form-control" placeholder="Matricule" required>
            </div>
            <div class="mb-3">
                <input type="text" name="serie_bac" class="form-control" placeholder="Série du Bac" required>
            </div>
            <div class="mb-3">
                <select name="filiere" class="form-control" required>
                    <option value="Informatique">Informatique</option>
                    <option value="Gestion">Gestion</option>
                    <option value="Finance">Finance</option>
                    <option value="Droit">Droit</option>
                    <option value="Marketing">Marketing</option>
                </select>
            </div>
            <div class="mb-3">
                <select name="niveau" class="form-control" required>
                    <option value="Licence 1">Licence 1</option>
                    <option value="Licence 2">Licence 2</option>
                    <option value="Licence 3">Licence 3</option>
                    <option value="Master 1">Master 1</option>
                    <option value="Master 2">Master 2</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">S'inscrire</button>
        </form>

        <div class="mt-3">
            <a href="index.php">Déjà inscrit ? Se connecter</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
