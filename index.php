<?php include 'config.php'; ?>
<!doctype html>
<html lang="fr">
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
                <div id="slider" class="carousel slide w-100" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#slider" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#slider" data-bs-slide-to="1"></li>
        <li data-bs-target="#slider" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <img src="images/iphone.jpg" class="slider-img" alt="iPhone Image">
        </div>
        <div class="carousel-item">
            <img src="images/mac.jpg" class="slider-img" alt="Mac Image">
        </div>
        <div class="carousel-item">
            <img src="images/sa3a.jpg" class="slider-img" alt="Watch Image">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>


                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 py-3">
                                <div class="row">
                                    <div class="col-12 text-center text-uppercase">
                                        <h2>Produits en Vedette</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    $sql = "SELECT * FROM produits ORDER BY id DESC LIMIT 10";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<div class='col-lg-3 col-sm-6 my-3'>";
                                            echo "<div class='col-12 bg-white text-center h-100 product-item'>";
                                            echo "<div class='row h-100'>";
                                            echo "<div class='col-12 p-0 mb-3'>";
                                            echo "<a href='product.php?id=" . $row['id'] . "'>";
                                            echo "<img src='images/" . $row['image'] . "' class='img-fluid'>";
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
                                            echo "<button type='submit' name='add_to_cart' class='btn btn-outline-dark'><i class='fas fa-cart-plus me-2'></i>Ajouter au panier</button>";
                                            echo "</form>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<p class='text-center'>Aucun produit trouvé.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 py-3">
                                <div class="row">
                                    <div class="col-12 text-center text-uppercase">
                                        <h2>Derniers Produits</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    $sql = "SELECT * FROM produits ORDER BY date_added DESC LIMIT 10";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<div class='col-lg-3 col-sm-6 my-3'>";
                                            echo "<div class='col-12 bg-white text-center h-100 product-item'>";
                                            echo "<span class='new'>Nouveau</span>";
                                            echo "<div class='row h-100'>";
                                            echo "<div class='col-12 p-0 mb-3'>";
                                            echo "<a href='product.php?id=" . $row['id'] . "'>";
                                            echo "<img src='images/" . $row['image'] . "' class='img-fluid'>";
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
                                            echo "<button type='submit' name='add_to_cart' class='btn btn-outline-dark'><i class='fas fa-cart-plus me-2'></i>Ajouter au panier</button>";
                                            echo "</form>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<p class='text-center'>Aucun produit trouvé.</p>";
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 py-3">
                                <div class="row">
                                    <div class="col-12 text-center text-uppercase">
                                        <h2>Produits les Plus Vendus</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    $sql = "SELECT produits.*, SUM(sales.quantity) as total_sales FROM produits 
                                            JOIN sales ON produits.id = sales.product_id 
                                            GROUP BY sales.product_id 
                                            ORDER BY total_sales DESC 
                                            LIMIT 10";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<div class='col-lg-3 col-sm-6 my-3'>";
                                            echo "<div class='col-12 bg-white text-center h-100 product-item'>";
                                            echo "<div class='row h-100'>";
                                            echo "<div class='col-12 p-0 mb-3'>";
                                            echo "<a href='product.php?id=" . $row['id'] . "'>";
                                            echo "<img src='images/" . $row['image'] . "' class='img-fluid'>";
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
                                            echo "<button type='submit' name='add_to_cart' class='btn btn-outline-dark'><i class='fas fa-cart-plus me-2'></i>Ajouter au panier</button>";
                                            echo "</form>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<p class='text-center'>Aucun produit trouvé.</p>";
                                    }

                                    $conn->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 py-3 bg-light d-sm-block d-none">
                        <div class="row">
                            <div class="col-lg-3 col ms-auto large-holder">
                                <div class="row">
                                    <div class="col-auto ms-auto large-icon">
                                        <i class="fas fa-money-bill"></i>
                                    </div>
                                    <div class="col-auto me-auto large-text">
                                        Meilleur Prix
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col large-holder">
                                <div class="row">
                                    <div class="col-auto ms-auto large-icon">
                                        <i class="fas fa-truck-moving"></i>
                                    </div>
                                    <div class="col-auto me-auto large-text">
                                        Livraison Rapide
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col me-auto large-holder">
                                <div class="row">
                                    <div class="col-auto ms-auto large-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="col-auto me-auto large-text">
                                        Produits Authentiques
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            <div class="col-12 align-self-end">
            <?php include 'footer.php'; ?>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>
