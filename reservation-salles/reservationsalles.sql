-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 16 juin 2020 à 13:57
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `reservationsalles`
--

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES
(31, 'Salle de f&ecirc;te', 'Anniversaire de Mathilde', '2020-06-22 18:00:00', '2020-06-22 19:00:00', 1),
(30, 'Salle de f&ecirc;te', 'Anniversaire de Mathilde', '2020-06-22 17:00:00', '2020-06-22 18:00:00', 1),
(29, 'Salle de f&ecirc;te', 'Anniversaire de Mathilde', '2020-06-22 16:00:00', '2020-06-22 17:00:00', 1),
(28, 'Salle de mariage', 'Mariage d&#039;Adam et Eve', '2020-06-22 13:00:00', '2020-06-22 14:00:00', 1),
(27, 'Salle de mariage', 'Mariage d&#039;Adam et Eve', '2020-06-22 12:00:00', '2020-06-22 13:00:00', 1),
(26, 'Salle de mariage', 'Mariage d&#039;Adam et Eve', '2020-06-22 11:00:00', '2020-06-22 12:00:00', 1),
(25, 'Salle de mariage', 'Mariage d&#039;Adam et Eve', '2020-06-22 10:00:00', '2020-06-22 11:00:00', 1),
(24, 'Salle de mariage', 'Mariage d&#039;Adam et Eve', '2020-06-22 09:00:00', '2020-06-22 10:00:00', 1),
(23, 'Salle de mariage', 'Mariage d&#039;Adam et Eve', '2020-06-22 08:00:00', '2020-06-22 09:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(1, 'New_user', '$2y$10$L0MGMku06cCyZp83pE9To.hr6eF5eq/Ao5nxHdfemOuSbpVgbWV4C');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
