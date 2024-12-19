-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 01:27 AM
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
-- Database: `projet`
--

-- --------------------------------------------------------

--
-- Table structure for table `animaux`
--



-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `codeF` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `date_f` date NOT NULL,
  `heure_f` datetime NOT NULL,
  `nom_utilisateur` varchar(20) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`codeF`, `question`, `date_f`, `heure_f`, `nom_utilisateur`, `categorie`, `photo_path`, `likes`, `dislikes`) VALUES
(71, 'Comment la gestion de l\'eau et des ressources naturelles est-elle essentielle à une agriculture réussie ??', '2024-12-11', '2024-12-11 06:54:27', 'ahmed arbi', 'Fertilisation', NULL, 0, 0),
(75, 'how to save the plant from sun?', '2024-12-14', '2024-12-14 03:53:21', 'yassine', 'Irrigation et gestion de leau', 'uploads/f.jfif', 0, 0),
(83, 'quels sont les defis de l\'elevage?', '2024-12-14', '2024-12-14 12:14:52', 'amal', 'Élevage et production animale', 'uploads/ff.jfif', 0, 0),
(85, 'Quel rôle les petites exploitations agricoles jouent-elles dans la production alimentaire mondiale ?', '2024-12-14', '2024-12-14 12:45:07', 'kenza', 'Agriculture biologique', 'uploads/fff.jfif', 0, 0),
(86, 'Quels sont les types d’irrigation les plus efficaces ?', '2024-12-14', '2024-12-14 13:42:53', 'ibtihel', 'Irrigation et gestion de leau', 'uploads/ffff.jfif', 0, 0),
(89, 'Comment améliorer la fertilité des sols ??', '2024-12-14', '2024-12-14 13:51:35', 'amira', 'Agriculture biologique', 'uploads/fffff.jfif', 0, 0),
(93, 'where should i put the plants???', '2024-12-14', '2024-12-14 14:59:05', 'asma', 'Fertilisation', 'uploads/fi.jfif', 7, 2),
(101, '', '0000-00-00', '0000-00-00 00:00:00', '', 'Culture', NULL, 0, 0),
(104, 'a quel age je nourris ma vache les legumes ?', '2024-12-15', '2024-12-15 05:45:54', 'mortadha', 'Élevage et production animale', 'uploads/vache.jfif', 0, 0),
(106, 'my cat is sick', '2024-12-15', '2024-12-15 06:53:44', 'amira bensaid', 'Agriculture biologique', 'uploads/cat.jfif', 0, 0),
(107, 'quand', '2024-12-15', '2024-12-15 07:22:12', 'amira', 'Fertilisation', NULL, 0, 0),
(108, 'quelle est la quantite necessaire pour 1000 m²?', '2024-12-16', '2024-12-16 00:50:47', 'ezzedine', 'Irrigation et gestion de leau', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `irrigation`
--

CREATE TABLE `irrigation` (
  `id_irrigation` int(11) NOT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `type_de_sol` varchar(100) DEFAULT NULL,
  `type_de_culture` varchar(100) DEFAULT NULL,
  `superficie` decimal(10,0) DEFAULT NULL,
  `quantite_eau` decimal(10,0) DEFAULT NULL,
  `id_meteo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `irrigation`
--

INSERT INTO `irrigation` (`id_irrigation`, `lieu`, `type_de_sol`, `type_de_culture`, `superficie`, `quantite_eau`, `id_meteo`) VALUES
(1, 'Ariana', 'Argileux', 'Maïs', 2000, 6400, 1),
(2, 'Nabeul', 'Argileux', 'Olives', 2000, 8000, 2),
(3, 'Tunis', 'Limoneux', 'Blé Dur', 7890, 31560, 3),
(4, 'Sousse', 'Loameux', 'Pommes de Terre', 10000, 40000, 4),
(5, 'Bizerte', 'Sablonneux', 'Tomates', 625, 4500, 5),
(6, 'Kairouan', 'Calcaire', 'Maïs', 4700, 18800, 6),
(8, 'Sousse', 'Sablonneux', 'Orge', 9999, 47995, 8),
(9, 'Nabeul', 'Calcaire', 'Blé Dur', 12345, 49380, 9),
(10, 'sousse', 'Sablonneux', 'Orge', 1920, 11520, 10),
(11, 'Sfax', 'Calcaire', 'Blé Tendre', 1222, 4888, 11),
(12, 'Ariana', 'Limoneux', 'Blé Tendre', 12345, 49380, 12);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `ID_rep` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure` datetime NOT NULL,
  `nom_expert` varchar(20) NOT NULL,
  `codeF` int(11) NOT NULL,
  `reponse` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`ID_rep`, `date`, `heure`, `nom_expert`, `codeF`, `reponse`) VALUES
(33, '2024-12-15', '2024-12-15 01:43:16', 'israa', 93, 'in a safe place');

-- --------------------------------------------------------

--
-- Table structure for table `meteo`
--

CREATE TABLE `meteo` (
  `id_meteo` int(11) NOT NULL,
  `temperature` decimal(5,2) DEFAULT NULL,
  `vent` decimal(5,2) DEFAULT NULL,
  `humidite` decimal(5,2) DEFAULT NULL,
  `precipitation` decimal(5,2) DEFAULT NULL,
  `date_meteo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meteo`
--

INSERT INTO `meteo` (`id_meteo`, `temperature`, `vent`, `humidite`, `precipitation`, `date_meteo`) VALUES
(1, 13.01, 1.54, 88.00, 0.00, '2024-11-27 00:47:34'),
(2, 16.51, 0.99, 63.00, 0.00, '2024-11-27 00:48:31'),
(3, 13.89, 3.08, 56.00, 0.00, '2024-11-27 00:49:18'),
(4, 13.88, 1.54, 77.00, 0.00, '2024-11-27 00:49:38'),
(5, 11.00, 0.00, 100.00, 0.00, '2024-11-27 00:50:46'),
(6, 13.01, 0.51, 76.00, 0.00, '2024-11-27 00:54:06'),
(8, 11.88, 1.54, 82.00, 0.00, '2024-11-27 09:20:09'),
(9, 14.53, 6.37, 62.00, 0.00, '2024-12-01 01:56:14'),
(10, 16.01, 2.57, 82.00, 0.00, '2024-12-03 23:42:01'),
(11, 12.08, 1.54, 54.00, 0.00, '2024-12-10 20:42:39'),
(12, 10.01, 1.54, 81.00, 0.00, '2024-12-10 21:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `reference` varchar(50) NOT NULL,
  `type_prod` varchar(50) NOT NULL,
  `nom_prod` varchar(100) NOT NULL,
  `fabricant` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`reference`, `type_prod`, `nom_prod`, `fabricant`, `prix`, `image_name`, `image_path`, `created_at`, `likes`, `dislikes`) VALUES
('AL001', 'alimentation', 'Croquettes pour chiens', 'Greengrow', 120.00, 'dog-food.jpg', 'images/dog-food.jpg', '2024-12-10 17:59:31', 1, 0),
('AL004', ' alimentation', 'Bâtonnets pour oiseaux', 'Greengrow', 60.00, 'bird-sticks.jpeg', 'images/bird-sticks.jpeg', '2024-12-10 22:20:44', 7, 1),
('AL005', 'alimentation', 'Engrais bio liquide', 'Greengrow', 75.00, 'plant-fertilizer.jpeg', 'images/plant-fertilizer.jpeg', '2024-12-10 18:00:32', 3, 1),
('SA001', 'sante', 'Médicament pour chat', 'Greengrow', 100.00, 'cat-med.jpeg', 'images/cat-med.jpeg', '2024-12-10 18:02:22', 2, 1),
('SA002', 'sante', 'Vitamines pour chiens', 'Greengrow', 80.00, 'dog-vitamins.jpeg', 'images/dog-vitamins.jpeg', '2024-12-10 18:03:28', 3, 2),
('SA004', 'sante', 'Pesticide naturel', 'Greengrow', 50.00, 'plant-nutrients.jpeg', 'images/plant-nutrients.jpeg', '2024-12-10 18:04:21', 5, 1),
('SO001', 'soins', 'Shampoing pour chiens', 'Greengrow', 75.00, 'dog-shampoo.jpeg', 'images/dog-shampoo.jpeg', '2024-12-10 18:01:07', 3, 1),
('SO002', 'soins', 'Peigne pour chien', 'Greengrow', 45.00, 'dog-comb.jpeg', 'images/dog-comb.jpeg', '2024-12-10 22:22:55', 2, 1),
('SO004', ' soins', 'Spray anti-puces pour chats', 'Greengrow', 65.00, 'cat-flea-spray.jpeg', 'images/cat-flea-spray.jpeg', '2024-12-10 18:05:09', 3, 2),
('SO005', 'soins', 'Anti-insectes naturel', 'Greengrow', 55.00, 'fungicide.jpeg', 'images/fungicide.jpeg', '2024-12-10 18:01:46', 4, 0),
('SO006', 'soins', 'Engrais pour plantes fleuries', 'Greengrow', 50.00, 'plant-fertilizer.jpeg', 'images/plant-fertilizer.jpeg', '2024-12-10 22:25:54', 3, 1),
('SO008', 'soins', 'Aérateur pour plantes', 'Greengrow', 85.00, 'plant-aerator.jpg', 'images/plant-aerator.jpg', '2024-12-10 22:27:46', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `reference_zone` varchar(10) NOT NULL,
  `nom` varchar(10) NOT NULL,
  `type_zone` varchar(10) NOT NULL,
  `superficie_zone` float NOT NULL,
  `culture` varchar(10) NOT NULL,
  `reference_f` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`reference_zone`, `nom`, `type_zone`, `superficie_zone`, `culture`, `reference_f`) VALUES
('r12131', 'animal', 'B', 2121, '32121', 'r100'),
('r121312', 'E', 'A', 800, 'sheep', 'r100'),
('r121313', 'grain', 'B', 2121, '232', 'r100'),
('r12132', 'Zone B	', 'agricultur', 300, 'wheat', 'r100'),
('r12133', 'Zone C	', 'livestock', 200, 'sheep', 'r100'),
('r21001', 'animal', 'B', 1100, '232', 'r100'),
('r210011', 'animal', 'B', 2121, '232', 'r100'),
('r21002', 'Zone E	', 'agricultur', 250, 'corn', 'r100'),
('r210021', 'animal', 'B', 2121, '232', 'r100'),
('r2100211', 'E', 'animal', 12300, 'sheep', 'r100'),
('r21003', 'Zone F	', 'irrigation', 400, 'rice', 'r100'),
('r41002', 'Zone A	', 'animal', 350, 'goats', 'r100'),
('R5676', 'animal', 'dd', 765, 'sheep', 'r555');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animaux`
--
ALTER TABLE `animaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`num_c`),
  ADD KEY `reference` (`reference`);

--
-- Indexes for table `fermes`
--
ALTER TABLE `fermes`
  ADD PRIMARY KEY (`reference_f`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`codeF`);

--
-- Indexes for table `irrigation`
--
ALTER TABLE `irrigation`
  ADD PRIMARY KEY (`id_irrigation`),
  ADD KEY `id_meteo` (`id_meteo`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`ID_rep`),
  ADD KEY `message_ibfk_1` (`codeF`);

--
-- Indexes for table `meteo`
--
ALTER TABLE `meteo`
  ADD PRIMARY KEY (`id_meteo`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`reference`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`reference_zone`),
  ADD KEY `reference_f` (`reference_f`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animaux`
--
ALTER TABLE `animaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `num_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `codeF` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `irrigation`
--
ALTER TABLE `irrigation`
  MODIFY `id_irrigation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `ID_rep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `meteo`
--
ALTER TABLE `meteo`
  MODIFY `id_meteo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animaux`
--
ALTER TABLE `animaux`
  ADD CONSTRAINT `animaux_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`reference`) REFERENCES `produits` (`reference`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `irrigation`
--
ALTER TABLE `irrigation`
  ADD CONSTRAINT `irrigation_ibfk_1` FOREIGN KEY (`id_meteo`) REFERENCES `meteo` (`id_meteo`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`codeF`) REFERENCES `forum` (`codeF`) ON DELETE CASCADE;

--
-- Constraints for table `zone`
--
ALTER TABLE `zone`
  ADD CONSTRAINT `zone_ibfk_1` FOREIGN KEY (`reference_f`) REFERENCES `fermes` (`reference_f`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
