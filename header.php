<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'config.php'; 
?>


<header class="row">

    <div class="col-12 bg-dark py-2 d-md-block d-none">
        <div class="row">
            <div class="col-auto me-auto">
                <ul class="top-nav">
                    <li>
                        <a href="tel:+123-456-7890"><i class="fa fa-phone-square me-2"></i>+438-927-4395</a>
                    </li>
                    <li>
                        <a href="mailto:mail@ecom.com"><i class="fa fa-envelope me-2"></i>LahoumaBarik@gmail.com</a>
                    </li>
                </ul>
            </div>
            <div class="col-auto">
    <ul class="top-nav">
        <?php if (isset($_SESSION['utilisateur_nom'])): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user me-2"></i><?php echo $_SESSION['utilisateur_nom']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="userMenu">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a class="dropdown-item" href="admin/admin_dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a>
                </div>
            </li>
        <?php else: ?>
            <li>
                <a href="register.php" class="header-item"><i class="fas fa-user-edit me-2"></i>S'inscrire</a>
            </li>
            <li>
                <a href="login.php" class="header-item"><i class="fas fa-sign-in-alt me-2"></i>Connexion</a>
            </li>
        <?php endif; ?>
    </ul>
</div>


        </div>
    </div>

    <div class="col-12 bg-white pt-4">
        <div class="row">
            <div class="col-lg-auto">
                <div class="site-logo text-center text-lg-left">
                    <a href="index.php">LahoumaBarik</a>
                </div>
            </div>
            <div class="col-lg-5 mx-auto mt-4 mt-lg-0">
                <form action="search.php" method="GET">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="search" name="query" class="form-control border-dark" placeholder="Rechercher..." required>
                            <button class="btn btn-outline-dark"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-auto text-center text-lg-left header-item-holder">
                <a href="cart.php" class="header-item">
                    <i class="fas fa-shopping-bag me-2"></i><span id="header-qty" class="me-3"><?php echo $total_items; ?></span>
                    <i class="fas fa-money-bill-wave me-2"></i><span id="header-price">$<?php echo number_format($total_price, 2); ?></span>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategories" aria-controls="navbarCategories" aria-expanded="false" aria-label="Basculer la navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCategories">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Accueil <span class="sr-only">(actuel)</span></a>
                        </li>
                        <?php
                        if ($conn->ping()) { 
                            $sql = "SELECT * FROM categories WHERE nom IN ('iPhones', 'Macs', 'Accessories')";
                            $result = $conn->query($sql);

                            if ($result === false) {
                                echo "Erreur dans la requête : " . $conn->error;
                            }

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<li class="nav-item">';
                                    echo '<a class="nav-link" href="category.php?categorie_id=' . $row['id'] . '">' . $row['nom'] . '</a>';
                                    echo '</li>';
                                }
                            } else {
                                echo '<li class="nav-item"><a class="nav-link" href="#">Aucune catégorie trouvée</a></li>';
                            }
                        } else {
                            echo "La connexion est fermée ou perdue.";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
