<?php
session_start();
include 'config.php';


$is_logged_in = isset($_SESSION['utilisateur_nom']);

if (isset($_GET['categorie_id'])) {
    $categorie_id = $_GET['categorie_id'];

    
    $sql = "SELECT nom FROM categories WHERE id='$categorie_id'";
    $result = $conn->query($sql);
    $category_name = $result->fetch_assoc()['nom'];
} else {
    echo "Category not specified.";
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LahoumaBarik</title>

    <link href="//fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="col-12">

    <main class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 py-3">
                    <div class="row">
                        <div class="col-12 text-center text-uppercase">
                            <h2><?php echo $category_name; ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM produits WHERE categorie_id='$categorie_id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='col-xl-2 col-lg-3 col-sm-6 my-3'>";
                                echo "<div class='col-12 bg-white text-center h-100 product-item'>";
                                echo "<div class='row h-100'>";
                                echo "<div class='col-12 p-0 mb-3'>";
                                echo "<a href='product.php?id=" . $row['id'] . "'>";
                                echo "<img src='images/" . $row['image'] . "' class='img-fluid' alt='" . $row['nom'] . "'>";
                                echo "</a>";
                                echo "</div>";
                                echo "<div class='col-12 mb-3'>";
                                echo "<a href='product.php?id=" . $row['id'] . "' class='product-name'>" . $row['nom'] . "</a>";
                                echo "</div>";
                                echo "<div class='col-12 mb-3'>";
                                echo "<span class='product-price'>$" . $row['prix'] . "</span>";
                                echo "</div>";
                                echo "<div class='col-12 mb-3 align-self-end'>";
                                echo "<form method='post' action='cart.php'>";
                                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                echo "<input type='hidden' name='quantite' value='1'>";  
                                echo "<button class='btn btn-outline-dark' type='submit' name='add_to_cart'><i class='fas fa-cart-plus me-2'></i>Add to cart</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div class='col-12 text-center'>";
                            echo "<p>aucun produit trouve.</p>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-long-arrow-alt-left"></i></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-long-arrow-alt-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </main>
</div>

<div class="col-12 align-self-end">
    <?php include 'footer.php'; ?>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
