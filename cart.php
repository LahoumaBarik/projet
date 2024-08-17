<?php
include 'config.php';


if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

$taxRate = 0.15; 
$deliveryFee = 10.00; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $quantite = $_POST['quantite'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantite;
    } else {
        $_SESSION['cart'][$id] = $quantite;
    }

    header("Location: cart.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $id = $_POST['remove_from_cart'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    foreach ($_POST['quantites'] as $id => $quantite) {
        if ($quantite > 0) {
            $_SESSION['cart'][$id] = $quantite;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php");
    exit();
}

$total = 0;
$tax = 0;
$grandTotal = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantite) {
        $sql = "SELECT * FROM produits WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $subtotal = $row['prix'] * $quantite;
        $total += $subtotal;
    }

    $tax = $total * $taxRate;
    $grandTotal = $total + $tax + $deliveryFee;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template E-Commerce</title>

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

    <div class="row">
        <div class="col-12 mt-3 text-center text-uppercase">
            <h2>Panier</h2>
        </div>
    </div>

    <main class="row">
        <div class="col-12 bg-white py-3 mb-3">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-10 mx-auto table-responsive">
                    <form method="post" action="cart.php">
                        <div class="col-12">
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Montant</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $id => $quantite) {
                                        $sql = "SELECT * FROM produits WHERE id='$id'";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();

                                        $subtotal = $row['prix'] * $quantite;

                                        echo "<tr>";
                                        echo "<td><img src='images/" . $row['image'] . "' class='img-fluid'> " . $row['nom'] . "</td>";
                                        echo "<td>$" . $row['prix'] . "</td>";
                                        echo "<td><input type='number' name='quantites[$id]' value='$quantite' min='1'></td>";
                                        echo "<td>$" . $subtotal . "</td>";
                                        echo "<td><button class='btn btn-link text-danger' type='submit' name='remove_from_cart' value='$id'><i class='fas fa-times'></i></button></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Votre panier est vide.</td></tr>";
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total avant taxes</th>
                                    <th>$<?php echo number_format($total, 2); ?></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Taxes (15%)</th>
                                    <th>$<?php echo number_format($tax, 2); ?></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Frais de livraison</th>
                                    <th>$<?php echo number_format($deliveryFee, 2); ?></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Total général</th>
                                    <th>$<?php echo number_format($grandTotal, 2); ?></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-12 text-right">
                            <button class="btn btn-outline-secondary me-3" type="submit" name="update_cart">Mettre à jour</button>
                            <a href="checkout.php" class="btn btn-outline-success">Passer la commande</a>
                        </div>
                    </form>
                </div>
            </div>
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
