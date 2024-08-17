<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_review'])) {
    $commentaire = $_POST['commentaire'];
    $rating = $_POST['rating'];
    $utilisateur_id = $_SESSION['utilisateur_id']; 
    $produit_id = $_POST['produit_id'];

    if (!isset($_SESSION['last_review_time']) || (time() - $_SESSION['last_review_time']) > 5) {
        $sql_add_review = "INSERT INTO reviews (commentaire, rating, utilisateur_id, produit_id, date) VALUES ('$commentaire', '$rating', '$utilisateur_id', '$produit_id', NOW())";

        if ($conn->query($sql_add_review) === TRUE) {
            $_SESSION['last_review_time'] = time();
            
            header("Location: product.php?id=$produit_id");
            exit();
        } else {
            echo "Erreur : " . $sql_add_review . "<br>" . $conn->error;
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM produits WHERE id='$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Produit non trouvé.");
    }


    $sql_reviews = "SELECT r.*, u.nom_utilisateur FROM reviews r JOIN utilisateurs u ON r.utilisateur_id = u.id WHERE r.produit_id='$id'";
    $reviews_result = $conn->query($sql_reviews);


    $categorie_id = $product['categorie_id'];
    $sql_similar = "SELECT * FROM produits WHERE categorie_id='$categorie_id' AND id != '$id' LIMIT 4";
    $similar_result = $conn->query($sql_similar);

    $conn->close();
} else {
    die("Produit non spécifié.");
}

?>

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
                    <div class="col-12 bg-white py-3 my-3">
                        <div class="row">
                            <div class="col-lg-5 col-md-12 mb-3">
                                <div class="col-12 mb-3">
                                    <div class="img-large border" style="background-image: url('images/<?php echo $product['image']; ?>')"></div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-9">
                                <div class="col-12 product-name large">
                                    <?php echo $product['nom']; ?>
                                </div>

                                <div class="col-12 px-0">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <ul>
                                        <li><?php echo $product['details']; ?></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 text-center">
                                <div class="col-12 sidebar h-100">
                                    <div class="row">
                                        <div class="col-12">
                                        <span class="detail-price">
                                            $<?php echo $product['prix']; ?>
                                        </span>
                                        </div>
                                        <div class="col-xl-5 col-md-9 col-sm-3 col-5 mx-auto mt-3">
                                            <div class="mb-3">
                                                <label for="qty">Quantité</label>
                                                <input type="number" id="qty" min="1" value="1" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <form action="cart.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="quantite" value="1">
                                                <button class="btn btn-outline-dark" type="submit" name="add_to_cart"><i class="fas fa-cart-plus me-2"></i>Ajouter au panier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3 py-3 bg-white text-justify">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 text-uppercase">
                                            <h2><u>Description</u></h2>
                                        </div>
                                        <div class="col-12" id="details">
                                        <?php echo nl2br($product['description']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="col-12 px-md-4 sidebar h-100">
                                    <div class="row">
                                        <div class="col-12 mt-md-0 mt-3 text-uppercase">
                                            <h2><u>Évaluations & Avis</u></h2>
                                        </div>

                                        <?php if ($reviews_result->num_rows > 0): ?>
                                            <?php while ($review = $reviews_result->fetch_assoc()): ?>
                                                <div class="col-12 text-justify py-2 px-3 mb-3 bg-gray">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong class="me-2"><?php echo $review['nom_utilisateur']; ?></strong>
                                                            <small>
                                                                <?php for ($i = 0; $i < 5; $i++): ?>
                                                                    <i class="fas fa-star <?php echo ($i < $review['rating']) ? '' : 'far'; ?>"></i>
                                                                <?php endfor; ?>
                                                            </small>
                                                        </div>
                                                        <div class="col-12">
                                                            <?php echo $review['commentaire']; ?>
                                                        </div>
                                                        <div class="col-12">
                                                            <small>
                                                                <i class="fas fa-clock me-2"></i><?php echo $review['date']; ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <p>Pas encore d'avis.</p>
                                        <?php endif; ?>

                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Ajouter un avis</h4>
                                            </div>
                                            <div class="col-12">
                                                <form method="post" action="product.php?id=<?php echo $product['id']; ?>">
                                                    <div class="mb-3">
                                                        <textarea name="commentaire" class="form-control" placeholder="Donnez votre avis" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="d-flex ratings justify-content-end flex-row-reverse">
                                                            <input type="radio" value="5" name="rating" id="rating-5"><label for="rating-5"></label>
                                                            <input type="radio" value="4" name="rating" id="rating-4"><label for="rating-4"></label>
                                                            <input type="radio" value="3" name="rating" id="rating-3"><label for="rating-3"></label>
                                                            <input type="radio" value="2" name="rating" id="rating-2"><label for="rating-2"></label>
                                                            <input type="radio" value="1" name="rating" id="rating-1" checked><label for="rating-1"></label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="hidden" name="produit_id" value="<?php echo $product['id']; ?>">
                                                        <button class="btn btn-outline-dark" type="submit" name="add_review">Ajouter un avis</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 py-3">
                                <div class="row">
                                    <div class="col-12 text-center text-uppercase">
                                        <h2>Produits Similaires</h2>
                                    </div>
                                </div>
                                <div class="row">

                                    <?php if ($similar_result->num_rows > 0): ?>
                                        <?php while ($similar = $similar_result->fetch_assoc()): ?>
                                            <div class="col-lg-3 col-sm-6 my-3">
                                                <div class="col-12 bg-white text-center h-100 product-item">
                                                    <div class="row h-100">
                                                        <div class="col-12 p-0 mb-3">
                                                            <a href="product.php?id=<?php echo $similar['id']; ?>">
                                                                <img src="images/<?php echo $similar['image']; ?>" class="img-fluid">
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <a href="product.php?id=<?php echo $similar['id']; ?>" class="product-name"><?php echo $similar['nom']; ?></a>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <span class="product-price">
                                                                $<?php echo $similar['prix']; ?>
                                                            </span>
                                                        </div>
                                                        <div class="col-12 mb-3 align-self-end">
                                                            <button class="btn btn-outline-dark" type="button"><i class="fas fa-cart-plus me-2"></i>Ajouter au panier</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <div class="col-12">
                                            <p>Aucun produit similaire trouvé.</p>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </main>
            </div>

            <div class="col-12 align-self-end">
                <?php include 'footer.php'; ?>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>
