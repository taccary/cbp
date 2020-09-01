-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 01 sep. 2020 à 13:34
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
-- Base de données :  `cbp`
--

-- --------------------------------------------------------

--
-- Structure de la table `bateau`
--

DROP TABLE IF EXISTS `bateau`;
CREATE TABLE IF NOT EXISTS `bateau` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bateau`
--

INSERT INTO `bateau` (`id`, `nom`) VALUES
(1, 'Kor\'Ant'),
(2, 'Ar Solen'),
(3, 'Al\'xi'),
(4, 'Luce isle'),
(5, 'Maëllys');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `lettre` varchar(2) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`lettre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`lettre`, `libelle`) VALUES
('A', 'Passager'),
('B', 'Véhicule < 2m'),
('C', 'Véhicule > 2m');

-- --------------------------------------------------------

--
-- Structure de la table `contenance_bateau`
--

DROP TABLE IF EXISTS `contenance_bateau`;
CREATE TABLE IF NOT EXISTS `contenance_bateau` (
  `idBateau` tinyint(3) UNSIGNED NOT NULL,
  `lettreCategorie` varchar(2) NOT NULL,
  `capaciteMax` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`idBateau`,`lettreCategorie`),
  KEY `lettreCategorie` (`lettreCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contenance_bateau`
--

INSERT INTO `contenance_bateau` (`idBateau`, `lettreCategorie`, `capaciteMax`) VALUES
(1, 'A', 250),
(1, 'B', 20),
(1, 'C', 5),
(2, 'A', 300),
(2, 'B', 15),
(2, 'C', 5),
(3, 'A', 280),
(3, 'B', 10),
(3, 'C', 5),
(4, 'A', 250),
(4, 'B', 10),
(4, 'C', 2),
(5, 'A', 200),
(5, 'B', 0),
(5, 'C', 0);

-- --------------------------------------------------------

--
-- Structure de la table `detail_reservation`
--

DROP TABLE IF EXISTS `detail_reservation`;
CREATE TABLE IF NOT EXISTS `detail_reservation` (
  `numReservation` int(10) UNSIGNED NOT NULL,
  `numType` tinyint(3) UNSIGNED NOT NULL,
  `lettreCategorie` varchar(2) NOT NULL,
  `quantité` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`numReservation`,`numType`,`lettreCategorie`),
  KEY `numType` (`numType`,`lettreCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail_reservation`
--

INSERT INTO `detail_reservation` (`numReservation`, `numType`, `lettreCategorie`, `quantité`) VALUES
(918145, 1, 'A', 2),
(918145, 2, 'A', 1),
(918145, 2, 'B', 1),
(918145, 3, 'A', 2);

-- --------------------------------------------------------

--
-- Structure de la table `liaison`
--

DROP TABLE IF EXISTS `liaison`;
CREATE TABLE IF NOT EXISTS `liaison` (
  `code` tinyint(3) UNSIGNED NOT NULL,
  `codeSecteur` tinyint(3) UNSIGNED NOT NULL,
  `distance` decimal(10,2) NOT NULL,
  `idPortDepart` tinyint(3) UNSIGNED NOT NULL,
  `idPortArrivee` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`code`),
  KEY `idPortArrivee` (`idPortArrivee`),
  KEY `idPortDepart` (`idPortDepart`),
  KEY `codeSecteur` (`codeSecteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `liaison`
--

INSERT INTO `liaison` (`code`, `codeSecteur`, `distance`, `idPortDepart`, `idPortArrivee`) VALUES
(11, 1, '25.10', 2, 4),
(15, 1, '8.30', 1, 2),
(16, 1, '8.00', 1, 3),
(17, 1, '7.90', 3, 1),
(19, 1, '23.70', 4, 2),
(21, 3, '7.70', 6, 7),
(22, 3, '7.40', 7, 6),
(24, 1, '9.00', 2, 1),
(25, 2, '8.80', 1, 5),
(30, 2, '8.80', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

DROP TABLE IF EXISTS `periode`;
CREATE TABLE IF NOT EXISTS `periode` (
  `dateDeb` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`dateDeb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `periode`
--

INSERT INTO `periode` (`dateDeb`, `dateFin`) VALUES
('2019-09-01', '2020-06-15'),
('2020-06-16', '2020-09-15'),
('2020-09-16', '2021-05-31');

-- --------------------------------------------------------

--
-- Structure de la table `port`
--

DROP TABLE IF EXISTS `port`;
CREATE TABLE IF NOT EXISTS `port` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `port`
--

INSERT INTO `port` (`id`, `nom`) VALUES
(1, 'Quiberon'),
(2, 'Le Palais'),
(3, 'Sauzon'),
(4, 'Vannes'),
(5, 'Port St Gildas'),
(6, 'Lorient'),
(7, 'Port-Tudy');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `num` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adr` varchar(300) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `numTraversee` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`num`),
  KEY `numTraversee` (`numTraversee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`num`, `nom`, `adr`, `cp`, `ville`, `numTraversee`) VALUES
(918145, 'TIPREZ', '15 rue de l\'industrie', '19290', 'PEYRELEVADE', 541201);

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

DROP TABLE IF EXISTS `secteur`;
CREATE TABLE IF NOT EXISTS `secteur` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `secteur`
--

INSERT INTO `secteur` (`id`, `nom`) VALUES
(1, 'Belle-Ile-En-Mer'),
(2, 'Houat'),
(3, 'Ile de Groix'),
(4, 'Aix'),
(5, 'Batz'),
(6, 'Bréhat'),
(7, 'Molène'),
(8, 'Ouessant'),
(9, 'Sein'),
(10, 'Yeu');

-- --------------------------------------------------------

--
-- Structure de la table `tarification`
--

DROP TABLE IF EXISTS `tarification`;
CREATE TABLE IF NOT EXISTS `tarification` (
  `codeLiaison` tinyint(3) UNSIGNED NOT NULL,
  `dateDeb` date NOT NULL,
  `numType` tinyint(3) UNSIGNED NOT NULL,
  `lettreCategorie` varchar(2) NOT NULL,
  `tarif` decimal(10,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`codeLiaison`,`dateDeb`,`numType`,`lettreCategorie`),
  KEY `dateDeb` (`dateDeb`),
  KEY `numType` (`numType`,`lettreCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tarification`
--

INSERT INTO `tarification` (`codeLiaison`, `dateDeb`, `numType`, `lettreCategorie`, `tarif`) VALUES
(15, '2019-09-01', 1, 'A', '18.00'),
(15, '2019-09-01', 1, 'B', '86.00'),
(15, '2019-09-01', 1, 'C', '189.00'),
(15, '2019-09-01', 2, 'A', '11.10'),
(15, '2019-09-01', 2, 'B', '129.00'),
(15, '2019-09-01', 2, 'C', '205.00'),
(15, '2019-09-01', 3, 'A', '5.60'),
(15, '2019-09-01', 3, 'C', '268.00'),
(15, '2020-06-16', 1, 'A', '20.00'),
(15, '2020-06-16', 1, 'B', '95.00'),
(15, '2020-06-16', 1, 'C', '208.00'),
(15, '2020-06-16', 2, 'A', '13.10'),
(15, '2020-06-16', 2, 'B', '142.00'),
(15, '2020-06-16', 2, 'C', '226.00'),
(15, '2020-06-16', 3, 'A', '7.00'),
(15, '2020-06-16', 3, 'C', '295.00'),
(15, '2020-09-16', 1, 'A', '19.00'),
(15, '2020-09-16', 1, 'B', '91.00'),
(15, '2020-09-16', 1, 'C', '199.00'),
(15, '2020-09-16', 2, 'A', '12.10'),
(15, '2020-09-16', 2, 'B', '136.00'),
(15, '2020-09-16', 2, 'C', '216.00'),
(15, '2020-09-16', 3, 'A', '6.40'),
(15, '2020-09-16', 3, 'C', '282.00'),
(19, '2019-09-01', 1, 'A', '27.20'),
(19, '2019-09-01', 1, 'B', '129.00'),
(19, '2019-09-01', 1, 'C', '284.00'),
(19, '2019-09-01', 2, 'A', '17.30'),
(19, '2019-09-01', 2, 'B', '194.00'),
(19, '2019-09-01', 2, 'C', '308.00'),
(19, '2019-09-01', 3, 'A', '9.80'),
(19, '2019-09-01', 3, 'C', '402.00'),
(19, '2020-06-16', 1, 'A', '29.30'),
(19, '2020-06-16', 1, 'B', '139.00'),
(19, '2020-06-16', 1, 'C', '306.00'),
(19, '2020-06-16', 2, 'A', '18.60'),
(19, '2020-06-16', 2, 'B', '209.00'),
(19, '2020-06-16', 2, 'C', '332.00'),
(19, '2020-06-16', 3, 'A', '10.60'),
(19, '2020-06-16', 3, 'C', '434.00'),
(19, '2020-09-16', 1, 'A', '28.50'),
(19, '2020-09-16', 1, 'B', '135.00'),
(19, '2020-09-16', 1, 'C', '298.00'),
(19, '2020-09-16', 2, 'A', '18.10'),
(19, '2020-09-16', 2, 'B', '203.00'),
(19, '2020-09-16', 2, 'C', '323.00'),
(19, '2020-09-16', 3, 'A', '10.20'),
(19, '2020-09-16', 3, 'C', '422.00');

-- --------------------------------------------------------

--
-- Structure de la table `traversee`
--

DROP TABLE IF EXISTS `traversee`;
CREATE TABLE IF NOT EXISTS `traversee` (
  `num` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `codeLiaison` tinyint(3) UNSIGNED NOT NULL,
  `idBateau` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`num`),
  KEY `codeLiaison` (`codeLiaison`),
  KEY `idBateau` (`idBateau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `traversee`
--

INSERT INTO `traversee` (`num`, `date`, `heure`, `codeLiaison`, `idBateau`) VALUES
(541197, '2020-07-10', '07:45:00', 15, 1),
(541198, '2020-07-10', '09:15:00', 15, 2),
(541199, '2020-07-10', '10:50:00', 15, 3),
(541200, '2020-07-10', '12:15:00', 15, 4),
(541201, '2020-07-10', '14:30:00', 15, 1),
(541202, '2020-07-10', '16:45:00', 15, 2),
(541203, '2020-07-10', '18:15:00', 15, 3),
(541204, '2020-07-10', '19:45:00', 15, 5);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `num` tinyint(3) UNSIGNED NOT NULL,
  `lettreCategorie` varchar(2) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`num`,`lettreCategorie`),
  KEY `lettreCategorie` (`lettreCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`num`, `lettreCategorie`, `libelle`) VALUES
(1, 'A', 'Adulte'),
(1, 'B', 'Voiture long.inf.4m'),
(1, 'C', 'Fourgon'),
(2, 'A', 'Junior 8 à 18 ans'),
(2, 'B', 'Voiture long.inf.5m'),
(2, 'C', 'Camping Car'),
(3, 'A', 'Enfant 0 à 7 ans'),
(3, 'C', 'camion');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenance_bateau`
--
ALTER TABLE `contenance_bateau`
  ADD CONSTRAINT `contenance_bateau_ibfk_1` FOREIGN KEY (`idBateau`) REFERENCES `bateau` (`id`),
  ADD CONSTRAINT `contenance_bateau_ibfk_2` FOREIGN KEY (`lettreCategorie`) REFERENCES `categorie` (`lettre`);

--
-- Contraintes pour la table `detail_reservation`
--
ALTER TABLE `detail_reservation`
  ADD CONSTRAINT `detail_reservation_ibfk_1` FOREIGN KEY (`numReservation`) REFERENCES `reservation` (`num`),
  ADD CONSTRAINT `detail_reservation_ibfk_2` FOREIGN KEY (`numType`,`lettreCategorie`) REFERENCES `type` (`num`, `lettreCategorie`);

--
-- Contraintes pour la table `liaison`
--
ALTER TABLE `liaison`
  ADD CONSTRAINT `liaison_ibfk_1` FOREIGN KEY (`idPortArrivee`) REFERENCES `port` (`id`),
  ADD CONSTRAINT `liaison_ibfk_2` FOREIGN KEY (`idPortDepart`) REFERENCES `port` (`id`),
  ADD CONSTRAINT `liaison_ibfk_3` FOREIGN KEY (`codeSecteur`) REFERENCES `secteur` (`id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`numTraversee`) REFERENCES `traversee` (`num`);

--
-- Contraintes pour la table `tarification`
--
ALTER TABLE `tarification`
  ADD CONSTRAINT `tarification_ibfk_1` FOREIGN KEY (`codeLiaison`) REFERENCES `liaison` (`code`),
  ADD CONSTRAINT `tarification_ibfk_2` FOREIGN KEY (`dateDeb`) REFERENCES `periode` (`dateDeb`),
  ADD CONSTRAINT `tarification_ibfk_3` FOREIGN KEY (`numType`,`lettreCategorie`) REFERENCES `type` (`num`, `lettreCategorie`);

--
-- Contraintes pour la table `traversee`
--
ALTER TABLE `traversee`
  ADD CONSTRAINT `traversee_ibfk_1` FOREIGN KEY (`codeLiaison`) REFERENCES `liaison` (`code`),
  ADD CONSTRAINT `traversee_ibfk_2` FOREIGN KEY (`idBateau`) REFERENCES `bateau` (`id`);

--
-- Contraintes pour la table `type`
--
ALTER TABLE `type`
  ADD CONSTRAINT `type_ibfk_1` FOREIGN KEY (`lettreCategorie`) REFERENCES `categorie` (`lettre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
