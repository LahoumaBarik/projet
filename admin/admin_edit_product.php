<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nom = $conn->real_escape_string($_POST['nom']);
    $description = $conn->real_escape_string($_POST['description']);
    $details = $conn->real_escape_string($_POST['details']);
    $prix = $conn->real_escape_string($_POST['prix']);
    $categorie_id = $conn->real_escape_string($_POST['categorie_id']);
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "UPDATE produits SET nom='$nom', description='$description', details='$details', prix='$prix', image='$image', categorie_id='$categorie_id' WHERE id='$id'";
    } else {
        $sql = "UPDATE produits SET nom='$nom', description='$description', details='$details', prix='$prix', categorie_id='$categorie_id' WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Produit mis à jour avec succès!";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM produits WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produit non trouvé";
        exit();
    }
} else {
    $sql = "SELECT id, nom FROM produits";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<form method="GET" action="admin_edit_product.php">';
        echo '<label for="id">Sélectionnez un produit:</label>';
        echo '<select name="id" id="id">';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['nom'] . '</option>';
        }
        echo '</select>';
        echo '<button type="submit">Modifier</button>';
        echo '</form>';
    } else {
        echo "Aucun produit disponible.";
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
    <title>Modifier Produit</title>
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
        <h2>Modifier Produit</h2>
        <form method="POST" action="admin_edit_product.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">

            <div class="form-group">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo isset($row['nom']) ? $row['nom'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="details" class="form-label">Détails:</label>
                <textarea class="form-control" id="details" name="details" required><?php echo isset($row['details']) ? $row['details'] : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="prix" class="form-label">Prix:</label>
                <input type="text" class="form-control" id="prix" name="prix" value="<?php echo isset($row['prix']) ? $row['prix'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="categorie_id" class="form-label">Catégorie:</label>
                <select class="form-control category-select" id="categorie_id" name="categorie_id" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <?php
                    if ($categories->num_rows > 0) {
                        while ($cat = $categories->fetch_assoc()) {
                            $selected = ($row['categorie_id'] == $cat['id']) ? 'selected' : '';
                            echo "<option value='" . $cat['id'] . "' $selected>" . $cat['nom'] . "</option>";
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

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
</body>
</html>
