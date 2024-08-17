<?php
session_start();
include 'config.php';

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

$total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantite) {
        $sql = "SELECT prix FROM produits WHERE id='$id'";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $total += $row['prix'] * $quantite;
        }
    }
}

$taux_tva = 0.15;
$tva = $total * $taux_tva;
$frais_livraison = 10; 
$total_general = $total + $tva + $frais_livraison;
?>

<!DOCTYPE html>
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

<div class="container mt-5">
    <h2>Passer la commande</h2>
    <form method="POST" action="process_checkout.php">
        <div class="mb-4">
            <h4>Informations de Livraison</h4>
            <div class="row">
                <div class="col-md-6">
                    <label for="nom_complet" class="form-label">Nom Complet</label>
                    <input type="text" class="form-control" id="nom_complet" name="nom_complet" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="telephone" class="form-label">Numéro de Téléphone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone" required>
                </div>
                <div class="col-md-6">
                    <label for="adresse" class="form-label">Adresse de Livraison</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" required>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h4>Résumé de la Commande</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $id => $quantite) {
                            $sql = "SELECT nom, prix FROM produits WHERE id='$id'";
                            $result = $conn->query($sql);
                            if ($result && $row = $result->fetch_assoc()) {
                                $subtotal = $row['prix'] * $quantite;
                                echo "<tr>";
                                echo "<td>{$row['nom']}</td>";
                                echo "<td>{$quantite}</td>";
                                echo "<td>\${$row['prix']}</td>";
                                echo "<td>\${$subtotal}</td>";
                                echo "</tr>";
                            }
                        }
                    }
                    ?>
                    <tr>
                        <th colspan="3" class="text-end">Sous-total:</th>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">TVA (15%):</th>
                        <td>$<?php echo number_format($tva, 2); ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Frais de Livraison:</th>
                        <td>$<?php echo number_format($frais_livraison, 2); ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total Général:</th>
                        <td><strong>$<?php echo number_format($total_general, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h4>Informations de Paiement</h4>
            <div id="paypal-button-container"></div>
        </div>

        <input type="hidden" name="total" value="<?php echo $total_general; ?>">

    </form>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AfRIg7NJ42M1rrEGGE5Un102g7z9c7JBGwFQL_tBFMJfw0NKGfjR8t-wZqHp6WSDpVnlZg0Fjvd_SWht&currency=CAD"></script>
<script>
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '<?php echo sprintf("%.2f", $total_general); ?>' 
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            alert('Transaction complétée par ' + details.payer.name.given_name);
            document.querySelector('form').submit(); 
        });
    },
    onError: function(err) {
        console.error('Erreur PayPal:', err);
        alert('Une erreur est survenue avec PayPal. Veuillez réessayer.');
    }
}).render('#paypal-button-container');

</script>

<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
