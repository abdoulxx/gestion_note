-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 17 fév. 2025 à 23:34
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_notes`
--

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `filiere` varchar(50) NOT NULL DEFAULT 'Informatique',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `filiere`) VALUES
(1, 'Programmation Mobile IOS', 'Informatique'),
(2, 'Programmation Mobile Android', 'Informatique'),
(3, 'Comptabilité Analytique', 'Informatique'),
(4, 'Gestion d’Entreprise', 'Informatique'),
(5, 'Sécurité des Systèmes d’Informations', 'Informatique'),
(6, 'Architecture Big Data et Cloud Computing', 'Informatique'),
(7, 'Machine Learning', 'Informatique'),
(8, 'Algorithmie de cryptographie', 'Informatique'),
(9, 'Modélisation avec le langage UML', 'Informatique'),
(10, 'Anglais', 'Informatique'),
(11, 'Gestion de projet (informatique) avec MS Project', 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(20) DEFAULT NULL,
  `matiere` varchar(50) DEFAULT NULL,
  `note` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matricule` (`matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamations`
--

DROP TABLE IF EXISTS `reclamations`;
CREATE TABLE IF NOT EXISTS `reclamations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(20) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `statut` enum('En cours','Résolue') DEFAULT 'En cours',
  `date_soumission` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `matricule` (`matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reclamations`
--

INSERT INTO `reclamations` (`id`, `matricule`, `sujet`, `message`, `statut`, `date_soumission`) VALUES
(2, '21INF013398', 'bisou', 'ok jbcv jgscvuad kgucv udavci d dg syglsug kylsd ;lsdgiyoyslkbkjgkshjblskdhfsdv', 'Résolue', '2025-02-17 22:44:38');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenoms` varchar(50) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `pays` varchar(3) DEFAULT 'CIV',
  `sexe` enum('M','F') DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `serie_bac` varchar(10) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` enum('etudiant','admin') DEFAULT 'etudiant',
  `filiere` varchar(50) NOT NULL,
  `niveau` enum('Licence 1','Licence 2','Licence 3','Master 1','Master 2') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenoms`, `date_naissance`, `pays`, `sexe`, `contact`, `matricule`, `serie_bac`, `mot_de_passe`, `role`, `filiere`, `niveau`) VALUES
(4, 'herver', 'junior', '2000-04-06', 'CIV', 'M', '0151516084', '21INF013398', 'D', '$2y$10$TX5XVG147YB4.n4vTB.1COXjHrSP4T8fhPB4nTzgeMFbVU./1NOg6', 'etudiant', 'INFORMATIQUE', 'Licence 3'),
(6, 'Admin', 'Super', '1990-01-01', 'CIV', 'M', '0102030405', 'ADMIN12345', 'N/A', '$2y$10$GZ4F35DqlUR5aTESP/1ALOB/TPTZsvsUWtXqx4p/lZClhnI/aDTxG', 'admin', 'Administration', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
