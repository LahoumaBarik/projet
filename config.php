<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$conn = new mysqli("localhost", "root", "", "projet_php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$total_items = 0;
$total_price = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantite) {
        $sql = "SELECT prix FROM produits WHERE id='$id'";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $total_price += $row['prix'] * $quantite;
            $total_items += $quantite;
        }
    }
}
?>
