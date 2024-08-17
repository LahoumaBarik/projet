<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $conn->real_escape_string($_POST['nom']);
    $description = $conn->real_escape_string($_POST['description']);
    $details = $conn->real_escape_string($_POST['details']);
    $prix = $conn->real_escape_string($_POST['prix']);
    $categorie_id = $conn->real_escape_string($_POST['categorie_id']);
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "INSERT INTO produits (nom, description, details, prix, image, categorie_id) VALUES ('$nom', '$description', '$details', '$prix', '$image', '$categorie_id')";
    } else {
        $sql = "INSERT INTO produits (nom, description, details, prix, categorie_id) VALUES ('$nom', '$description', '$details', '$prix', '$categorie_id')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Produit ajouté avec succès!";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
$sql = "SELECT id, nom FROM categories";
$categories = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Ajouter Produit</title>
    <style>
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #343a40;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .category-select {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter Produit</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="details" class="form-label">Détails:</label>
                <textarea class="form-control" id="details" name="details" required></textarea>
            </div>

            <div class="form-group">
                <label for="prix" class="form-label">Prix:</label>
                <input type="text" class="form-control" id="prix" name="prix" required>
            </div>

            <div class="form-group">
                <label for="categorie_id" class="form-label">Catégorie:</label>
                <select class="form-control category-select" id="categorie_id" name="categorie_id" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <?php
                    if ($categories->num_rows > 0) {
                        while ($cat = $categories->fetch_assoc()) {
                            echo "<option value='" . $cat['id'] . "'>" . $cat['nom'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Aucune catégorie disponible</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter Produit</button>
        </form>
    </div>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
</body>
</html>
