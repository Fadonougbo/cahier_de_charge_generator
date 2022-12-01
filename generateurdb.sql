-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 01 déc. 2022 à 15:59
-- Version du serveur : 8.0.27
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `generateurdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `containte`
--

DROP TABLE IF EXISTS `containte`;
CREATE TABLE IF NOT EXISTS `containte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `budget` int NOT NULL,
  `devise` varchar(10) NOT NULL DEFAULT 'fcfa',
  `livraison_date` date DEFAULT NULL,
  `maintenance` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `info_plus` text NOT NULL,
  `user_cahier_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_containte_user_cahier1_idx` (`user_cahier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `design`
--

DROP TABLE IF EXISTS `design`;
CREATE TABLE IF NOT EXISTS `design` (
  `id` int NOT NULL AUTO_INCREMENT,
  `design_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `logo_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `police` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `couleur` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `user_cahier_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_design_user_cahier1_idx` (`user_cahier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `hebergement_info`
--

DROP TABLE IF EXISTS `hebergement_info`;
CREATE TABLE IF NOT EXISTS `hebergement_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_de_domaine` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hebergeur_name` varchar(100) NOT NULL,
  `user_cahier_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_hebergement_info_user_cahier1_idx` (`user_cahier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `projet_description`
--

DROP TABLE IF EXISTS `projet_description`;
CREATE TABLE IF NOT EXISTS `projet_description` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `objectif` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_cahier_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_projet_description_user_cahier1_idx` (`user_cahier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `site_info`
--

DROP TABLE IF EXISTS `site_info`;
CREATE TABLE IF NOT EXISTS `site_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_type` varchar(45) NOT NULL,
  `technologie` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nombre_page` int NOT NULL,
  `langue` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `site_contenue` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url_info` varchar(100) DEFAULT NULL,
  `user_cahier_id` int NOT NULL,
  `image_optimisation` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fonctionnalite` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_site_info_user_cahier1_idx` (`user_cahier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `user_cahier`
--

DROP TABLE IF EXISTS `user_cahier`;
CREATE TABLE IF NOT EXISTS `user_cahier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_info_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_cahier_user_info_idx` (`user_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `visibilite`
--

DROP TABLE IF EXISTS `visibilite`;
CREATE TABLE IF NOT EXISTS `visibilite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `current_list` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pub_status` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `reseaux_sociaux_info` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mots_cle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `seo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `suivie_analytique` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_cahier_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_visibilite_user_cahier1_idx` (`user_cahier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `containte`
--
ALTER TABLE `containte`
  ADD CONSTRAINT `containte_ibfk_1` FOREIGN KEY (`user_cahier_id`) REFERENCES `user_cahier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `design`
--
ALTER TABLE `design`
  ADD CONSTRAINT `design_ibfk_1` FOREIGN KEY (`user_cahier_id`) REFERENCES `user_cahier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `hebergement_info`
--
ALTER TABLE `hebergement_info`
  ADD CONSTRAINT `hebergement_info_ibfk_1` FOREIGN KEY (`user_cahier_id`) REFERENCES `user_cahier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `projet_description`
--
ALTER TABLE `projet_description`
  ADD CONSTRAINT `projet_description_ibfk_1` FOREIGN KEY (`user_cahier_id`) REFERENCES `user_cahier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `site_info`
--
ALTER TABLE `site_info`
  ADD CONSTRAINT `site_info_ibfk_1` FOREIGN KEY (`user_cahier_id`) REFERENCES `user_cahier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_cahier`
--
ALTER TABLE `user_cahier`
  ADD CONSTRAINT `user_cahier_ibfk_1` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `visibilite`
--
ALTER TABLE `visibilite`
  ADD CONSTRAINT `visibilite_ibfk_1` FOREIGN KEY (`user_cahier_id`) REFERENCES `user_cahier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
