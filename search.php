<?php
session_start();
include 'config.php';

$search_results = [];

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $sql = "SELECT * FROM produits WHERE nom LIKE ? OR description LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = '%' . $query . '%';
    $stmt->bind_param('ss', $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        $message = "No products found for your search query.";
    }

    $stmt->close();
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resultats recherches</title>

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
                            <div class="col-12 text-center text-uppercase">
                                <h2>Resultats recherches</h2>
                            </div>
                            <div class="col-12">
                                <?php if (!empty($search_results)): ?>
                                    <div class="row">
                                        <?php foreach ($search_results as $product): ?>
                                            <div class="col-lg-3 col-sm-6 my-3">
                                                <div class="col-12 bg-white text-center h-100 product-item">
                                                    <div class="row h-100">
                                                        <div class="col-12 p-0 mb-3">
                                                            <a href="product.php?id=<?php echo $product['id']; ?>">
                                                                <img src="images/<?php echo $product['image']; ?>" class="img-fluid">
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <a href="product.php?id=<?php echo $product['id']; ?>" class="product-name"><?php echo $product['nom']; ?></a>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <span class="product-price">
                                                                $<?php echo $product['prix']; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="col-12">
                                        <p><?php echo $message; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            <div class="col-12 align-self-end">
                <footer class="row">
                </footer>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>
