-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 17 fév. 2020 à 08:51
-- Version du serveur :  8.0.18
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `capatools`
--

-- --------------------------------------------------------

--
-- Structure de la table `capaidentity`
--

DROP TABLE IF EXISTS `capaidentity`;
CREATE TABLE IF NOT EXISTS `capaidentity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `Celluleid` int(11) DEFAULT NULL,
  `flagPassword` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-capaidentity_-Cellule` (`Celluleid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `capaidentity`
--

INSERT INTO `capaidentity` (`id`, `username`, `email`, `auth_key`, `password_hash`, `Celluleid`, `flagPassword`) VALUES
(1, 'toto', 'toto@gmail.com', NULL, '$2y$13$DIN4EEnhNkdFqXDSX57dO.64NGKjqPtx1Mi1dRBpPvPL/8zcv.hLe', 8, 0),
(6, 'Viaud Julien', 'julien.viaud@capacites.fr', NULL, '$2y$13$tmb3EMcWa6G9reD4ZVfvw.V97sO8nnVXX6tcGnl/D5EYO0vmeLBju', 8, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cellule`
--

DROP TABLE IF EXISTS `cellule`;
CREATE TABLE IF NOT EXISTS `cellule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cellule`
--

INSERT INTO `cellule` (`id`, `identifiant`, `name`) VALUES
(1, 'AIERA', 'IREALITE'),
(2, 'ACMER', 'MER'),
(3, 'ACAPT', 'CAPTEURS ET COMPOSITES'),
(4, 'AIXEA', 'IXEAD'),
(5, 'AERIM', 'ERIMAT'),
(6, 'AIXPE', 'IXPEL'),
(7, 'ACSUP', 'SUPPORT'),
(8, 'AROBO', 'ROBOTIQUE ET PROCEDES'),
(9, 'ACBSO', 'CBS'),
(10, 'ATHCH', 'THERASSAY CH'),
(11, 'ACPCE', 'CPC ENG'),
(12, 'AINSI', 'INSILICO'),
(13, 'ABIOS', 'BIOSYS'),
(14, 'AKNOW', 'KNOWEDGE'),
(15, 'AGEPR', 'GP'),
(16, 'ALTEN', 'LTN'),
(17, 'AVALI', 'VALINBTP'),
(18, 'ASPEC', 'SPECTROMAITRISE'),
(19, 'APATR', 'PATRIMOINE'),
(20, 'ADZYM', 'DZYME'),
(21, 'ATHCL', 'THERASSAY CLM'),
(22, 'ATHPC', 'THERASSAY PC'),
(23, 'AEREL', 'ERELUEC'),
(24, 'ACECO', 'ECONOMIE CIRCULAIRE'),
(25, 'AEASI', 'EASI'),
(26, 'ATHAL', 'THALASSOMICS'),
(27, 'AEAU0', 'EAU'),
(28, 'AACCE', 'ACCESS MEMORIA'),
(29, 'AOBSL', 'OBSERVATOIRE DU LITTORAL'),
(30, 'AOBS2', 'OBSERVATOIRE DU LITTORAL 2'),
(31, 'AEPUM', 'EPUM'),
(32, 'AENFA', 'ENFANCE');

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `tva` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `company`
--

INSERT INTO `company` (`id`, `name`, `description`, `tva`) VALUES
(13, 'CAPACITES', 'entreprise privée', 'FR 99999999999'),
(14, 'Université de Nantes (labo GeM) ', 'organisme de recherche', 'FR 99999999999'),
(12, 'CAPACITES', 'entreprise privée', 'FR 99999999999'),
(15, NULL, NULL, NULL),
(16, 'tt', NULL, 't'),
(17, 'tt', NULL, 'toooop'),
(18, 'ttoo', NULL, 'toooop');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

DROP TABLE IF EXISTS `devis`;
CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_capa` varchar(250) DEFAULT NULL,
  `internal_name` varchar(250) DEFAULT NULL,
  `service_duration` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `filename_first_upload` datetime DEFAULT NULL,
  `filename_last_upload` datetime DEFAULT NULL,
  `cellule_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `capaidentity_id` int(11) DEFAULT NULL,
  `statut_id` int(11) DEFAULT NULL,
  `id_laboxy` varchar(255) DEFAULT NULL,
  `prix` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_devis_cellule` (`cellule_id`),
  KEY `FK_devis_company` (`company_id`),
  KEY `FK_devis_capaidentity` (`capaidentity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`id`, `id_capa`, `internal_name`, `service_duration`, `version`, `filename`, `filename_first_upload`, `filename_last_upload`, `cellule_id`, `company_id`, `capaidentity_id`, `statut_id`, `id_laboxy`, `prix`) VALUES
(12, 'AROBO00248', 'ROBO268CAPA02', 6, 6, 'AROBO-GeM IXEAD-CAPACITES_4500363078.pdf', '2019-03-12 16:33:59', '2019-04-05 15:58:40', 8, 14, 6, 0, 'AROBO00248 - Université de Nantes (labo GeM) ', NULL),
(11, 'AROBO00215', 'ROBO268CAPA01', 36, 6, 'AROBO-CAPACITES-ROBO268CAPA01.pdf', '2019-03-07 15:32:30', '2019-09-09 15:29:28', 8, 13, 6, 1, NULL, NULL),
(13, 'AROBO00248', 'ROBO268CAPA02', 6, 6, 'AROBO-GeM IXEAD-CAPACITES_4500363078.pdf', '2019-03-12 16:33:59', '2019-04-05 15:58:40', 8, 14, 6, 2, NULL, NULL),
(14, 'AROBO00215', 'ROBO268CAPA01', 36, 6, 'AROBO-CAPACITES-ROBO268CAPA01.pdf', '2019-03-07 15:32:30', '2019-09-09 15:29:28', 8, 13, 6, 3, NULL, NULL),
(15, 'AROBO00215', 'ROBO268CAPA01', 36, 6, 'AROBO-CAPACITES-ROBO268CAPA01.pdf', '2019-03-07 15:32:30', '2019-09-09 15:29:28', 8, 13, 6, 4, NULL, NULL),
(16, 'AROBO00215', 'ROBO268CAPA01', 36, 6, 'AROBO-CAPACITES-ROBO268CAPA01.pdf', '2019-03-07 15:32:30', '2019-09-09 15:29:28', 8, 13, 6, 5, NULL, NULL),
(18, 'ROBOTIQUE ET PROCEDES4', 'jjj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'ROBOTIQUE ET PROCEDES4', 'tt', NULL, NULL, NULL, NULL, NULL, 8, 16, 1, NULL, 'ROBOTIQUE ET PROCEDES4 - tt', NULL),
(20, 'AROBO4', 'ttt', 6, NULL, '2017Datacenter-1.pdf', NULL, NULL, 8, 18, 1, 0, 'AROBO4 - tt', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `devisstatut`
--

DROP TABLE IF EXISTS `devisstatut`;
CREATE TABLE IF NOT EXISTS `devisstatut` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `devisstatut`
--

INSERT INTO `devisstatut` (`id`, `label`) VALUES
(0, 'Avant contrat'),
(1, 'Projet en cours'),
(2, 'Projet annulé'),
(3, 'Projet terminé'),
(4, 'Attente validation Opérationel'),
(5, 'Attente validation client');

-- --------------------------------------------------------

--
-- Structure de la table `jalon`
--

DROP TABLE IF EXISTS `jalon`;
CREATE TABLE IF NOT EXISTS `jalon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devis_id` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `prix_jalon` double DEFAULT NULL,
  `date_jalon` datetime DEFAULT NULL,
  `commentaires` text,
  `statut_jalon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jalonstatut`
--

DROP TABLE IF EXISTS `jalonstatut`;
CREATE TABLE IF NOT EXISTS `jalonstatut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `jalonstatut`
--

INSERT INTO `jalonstatut` (`id`, `label`) VALUES
(1, 'En cours'),
(2, 'Facturation en cours'),
(3, 'Facturé');

-- --------------------------------------------------------

--
-- Structure de la table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1579796925),
('m200123_162424_create_capaidentity_table', 1580746032),
('m200124_154824_create_UserRightApplication_table', 1580746032),
('m200129_123257_create_Cellule_table', 1580746032),
('m200129_133516_alter_Capaidentity_flag_recuperationmdp', 1580746032),
('m200203_132918_ajoutNomCellule', 1580808549),
('m200206_100741_create_devis_table', 1580989844),
('m200206_110151_create_company_table', 1580989844),
('m200213_125952_create_devisstatut_table', 1581602782),
('m200213_170357_alter_devis_table_id_laboxy', 1581613566),
('m200217_083859_create_jalon_table', 1581929470);

-- --------------------------------------------------------

--
-- Structure de la table `userrightapplication`
--

DROP TABLE IF EXISTS `userrightapplication`;
CREATE TABLE IF NOT EXISTS `userrightapplication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Userid` int(11) NOT NULL,
  `Application` varchar(255) DEFAULT NULL,
  `Credential` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-capaidentity_UserRightApplication` (`Userid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `userrightapplication`
--

INSERT INTO `userrightapplication` (`id`, `Userid`, `Application`, `Credential`) VALUES
(1, 1, 'RH', 'Aucun'),
(2, 1, 'Administration', 'Responsable');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
