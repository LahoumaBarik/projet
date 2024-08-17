<?php
include 'config.php';

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    $utilisateur_id = $_SESSION['utilisateur_id'];
    $total = $_SESSION['total'];

    $sql = "INSERT INTO commandes (utilisateur_id, total, statut, paypal_order_id) VALUES ('$utilisateur_id', '$total', 'En attente', '$orderID')";
    
    if ($conn->query($sql) === TRUE) {
        $commande_id = $conn->insert_id;

        foreach ($_SESSION['cart'] as $id => $quantite) {
            $prix = $conn->query("SELECT prix FROM produits WHERE id='$id'")->fetch_assoc()['prix'];
            $sql = "INSERT INTO articles_commande (commande_id, produit_id, quantite, prix) VALUES ('$commande_id', '$id', '$quantite', '$prix')";
            $conn->query($sql);
        }

        unset($_SESSION['cart']);
        unset($_SESSION['total']); 
        echo "Commande passée avec succès!";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Erreur: Order ID non fourni.";
}
?>
