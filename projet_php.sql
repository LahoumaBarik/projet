-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 08:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles_commande`
--

CREATE TABLE `articles_commande` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles_commande`
--

INSERT INTO `articles_commande` (`id`, `commande_id`, `produit_id`, `quantite`, `prix`) VALUES
(1, 3, 5, 4, 1200.00),
(2, 3, 4, 2, 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `parent_id`) VALUES
(1, 'iPhones', NULL),
(2, 'Macs', NULL),
(3, 'Accessories', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `utilisateur_id`, `total`, `statut`, `cree_le`) VALUES
(3, 3, 0.00, 'En attente', '2024-08-01 22:17:52'),
(4, 3, 0.00, 'En attente', '2024-08-01 22:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `image`, `categorie_id`, `date_added`, `details`) VALUES
(4, 'Iphone 15 Pro Max', 'Ce téléphone est déverrouillé et compatible avec n\'importe quel opérateur de choix sur les réseaux GSM et CDMA (par ex. AT&T, T-Mobile, Sprint, Verizon, US Cellular, Cricket, Metro, Tracfone, Mint Mobile, etc. ).\r\nVeuillez vérifier la compatibilité avec votre transporteur.\r\nLorsque vous recevez le téléphone, insérez une carte SIM d\'un opérateur compatible. Ensuite, allumez-le, connectez-vous au Wi-Fi et suivez les instructions à l\'écran pour activer le service.\r\nL\'appareil n\'est pas livré avec un casque ou une carte SIM. Il comprend un chargeur générique (certifié MFI) et un câble de charge.\r\nTesté pour l\'état de la batterie et garantie pour avoir une capacité de batterie minimale de 80 %.', 1800.00, 'OIP.jpg', 1, '2024-07-26 13:04:03', 'Marque	Apple\r\nSystèmes d’exploitation	iOS 16\r\nModèle de CPU	A13\r\nCapacité de stockage de la mémoire	256 Go\r\nTaille de l’écran	6,7 Pouces\r\nNom du modèle	iPhone 15 Pro Max\r\nOpérateur de réseau mobile sans fil	Tous les transporteurs\r\nTechnologie cellulaire	5G\r\nTechnologie de connectivité	Wi-Fi\r\nCouleur	Blanc'),
(5, 'Iphone 14', 'hhhh', 1200.00, 'OIP (1).jpg', 1, '2024-07-27 01:01:17', 'wa3r');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `produit_id`, `utilisateur_id`, `rating`, `commentaire`, `date`) VALUES
(1, 5, 3, 5, 'nice', '2024-08-15 01:34:22'),
(2, 5, 3, 5, 'nice', '2024-08-15 01:34:28'),
(3, 5, 3, 5, 'nice', '2024-08-15 01:34:31'),
(4, 5, 3, 5, 'nice', '2024-08-15 01:35:36'),
(5, 5, 3, 4, 'dvvd', '2024-08-15 01:43:36'),
(6, 4, 3, 1, 'cc', '2024-08-16 00:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom_utilisateur` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom_utilisateur`, `email`, `mot_de_passe`, `role`) VALUES
(1, 'LahoumaBarik', 'aliatmani669@gmail.com', '$2y$10$06Ox3C41ZIXGqSFMjq.Lm.p4GWuN8BKuY9cEhj3YFKVMHXi9AyuFm', 'user'),
(2, 'lolo', 'aliatmani195@gmail.com', '$2y$10$OTGLTZHp16rkG8XjApZ4TOz1.JAVAHFkIwyqRc7qqcVm0cual3hNi', 'user'),
(3, 'ali', 'aliali@gmail.com', '$2y$10$O557D2VGgMTzNy2nZtFCJee7vbebunVOGGbzsg.jKjbwIGid8h.2K', 'admin'),
(4, 'sss', 'yoyo@gmail.com', '$2y$10$XBEd1zTr1niCetS3hnmfBOSjKGLXdrp5L76yWww6mY5twl39iHgUe', 'user'),
(5, 'anas', 'anas@gmail.com', '$2y$10$.Q.GNAsskXsKAFZuuvV3q./YLYaYW/Q/1MK8xw12xg/nOVV6PuYoC', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles_commande`
--
ALTER TABLE `articles_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_id` (`produit_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles_commande`
--
ALTER TABLE `articles_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles_commande`
--
ALTER TABLE `articles_commande`
  ADD CONSTRAINT `articles_commande_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `articles_commande_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `produits` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
