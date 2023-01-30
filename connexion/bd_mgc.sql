-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 30 jan. 2023 à 10:51
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_mgc`
--

-- --------------------------------------------------------

--
-- Structure de la table `table_district`
--

DROP TABLE IF EXISTS `table_district`;
CREATE TABLE IF NOT EXISTS `table_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desig_district` varchar(60) DEFAULT NULL,
  `nomp` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `emaild` varchar(60) DEFAULT NULL,
  `siege` varchar(30) DEFAULT NULL,
  `nbrec` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_federal`
--

DROP TABLE IF EXISTS `table_federal`;
CREATE TABLE IF NOT EXISTS `table_federal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desig_fed` varchar(60) DEFAULT NULL,
  `nomp` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `emaild` varchar(60) DEFAULT NULL,
  `siege` varchar(30) DEFAULT NULL,
  `nbrec` int(11) DEFAULT NULL,
  `idcr` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_gab`
--

DROP TABLE IF EXISTS `table_gab`;
CREATE TABLE IF NOT EXISTS `table_gab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desig_sec` varchar(60) DEFAULT NULL,
  `nomp` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `emaild` varchar(60) DEFAULT NULL,
  `siege` varchar(30) DEFAULT NULL,
  `nbrec` int(11) DEFAULT NULL,
  `idsec` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_gpe_users`
--

DROP TABLE IF EXISTS `table_gpe_users`;
CREATE TABLE IF NOT EXISTS `table_gpe_users` (
  `idgpe` int(11) NOT NULL AUTO_INCREMENT,
  `coden` varchar(15) DEFAULT NULL,
  `descn` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`idgpe`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_gpe_users`
--

INSERT INTO `table_gpe_users` (`idgpe`, `coden`, `descn`) VALUES
(5, 'admin', 'administrateur'),
(6, 'gab', 'Gpe animation de base'),
(7, 'cordod', 'Cordonateur district'),
(8, 'cordof', 'cordonateur féderal'),
(9, 'cordor', 'cordonateur regional'),
(10, 'cordos', 'cordonateur sectoriel');

-- --------------------------------------------------------

--
-- Structure de la table `table_militant`
--

DROP TABLE IF EXISTS `table_militant`;
CREATE TABLE IF NOT EXISTS `table_militant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codemilitant` varchar(60) DEFAULT NULL,
  `civ` varchar(3) DEFAULT NULL,
  `nom` varchar(80) DEFAULT NULL,
  `pnom` varchar(100) DEFAULT NULL,
  `daten` varchar(60) DEFAULT NULL,
  `lieun` varchar(60) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `numwhat` varchar(30) DEFAULT NULL,
  `autrenumero` varchar(60) DEFAULT NULL,
  `inscrit_liste` int(11) DEFAULT '0' COMMENT '1 oui 0 non',
  `cartembre` int(11) DEFAULT '0' COMMENT '0 non 1 oui',
  `lieuenr` varchar(60) DEFAULT NULL,
  `iddistrict` int(11) DEFAULT NULL,
  `idregion` int(11) DEFAULT NULL,
  `idsect` int(11) DEFAULT NULL,
  `idgab` int(11) DEFAULT NULL,
  `idfed` int(11) DEFAULT NULL,
  `dateenr` varchar(30) DEFAULT NULL,
  `idenr` int(11) DEFAULT NULL,
  `supp` int(11) DEFAULT '0',
  `idmodif` int(11) DEFAULT '0',
  `datesupp` varchar(30) DEFAULT NULL,
  `datemodif` varchar(30) DEFAULT NULL,
  `photom` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_region`
--

DROP TABLE IF EXISTS `table_region`;
CREATE TABLE IF NOT EXISTS `table_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desig_region` varchar(60) DEFAULT NULL,
  `nomp` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `emaild` varchar(60) DEFAULT NULL,
  `siege` varchar(30) DEFAULT NULL,
  `nbrec` int(11) DEFAULT NULL,
  `iddistrict` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_secteur`
--

DROP TABLE IF EXISTS `table_secteur`;
CREATE TABLE IF NOT EXISTS `table_secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desig_sec` varchar(60) DEFAULT NULL,
  `nomp` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `emaild` varchar(60) DEFAULT NULL,
  `siege` varchar(30) DEFAULT NULL,
  `nbrec` int(11) DEFAULT NULL,
  `idfed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tab_connexion`
--

DROP TABLE IF EXISTS `tab_connexion`;
CREATE TABLE IF NOT EXISTS `tab_connexion` (
  `idconn` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `statconn` int(11) DEFAULT NULL,
  `dateconn` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idconn`),
  UNIQUE KEY `idconn` (`idconn`)
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tab_depot`
--

DROP TABLE IF EXISTS `tab_depot`;
CREATE TABLE IF NOT EXISTS `tab_depot` (
  `id_depot` int(11) NOT NULL AUTO_INCREMENT,
  `id_projet` int(11) NOT NULL,
  `id_fournisseurs` int(11) NOT NULL,
  `date_soumss` date NOT NULL,
  `idmarche` int(11) DEFAULT NULL,
  `datemodif` datetime DEFAULT NULL,
  `id_ajout` int(11) NOT NULL,
  `datenr` datetime DEFAULT NULL,
  `contact` varchar(60) DEFAULT NULL,
  `nom_deposant` varchar(100) DEFAULT NULL,
  `coutoffre` bigint(20) DEFAULT NULL,
  `id_modif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_depot`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tab_histoconnexion`
--

DROP TABLE IF EXISTS `tab_histoconnexion`;
CREATE TABLE IF NOT EXISTS `tab_histoconnexion` (
  `idhisto` int(11) NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `dateconn` datetime DEFAULT NULL,
  `statconn` int(11) DEFAULT NULL,
  PRIMARY KEY (`idhisto`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tab_prospect`
--

DROP TABLE IF EXISTS `tab_prospect`;
CREATE TABLE IF NOT EXISTS `tab_prospect` (
  `id_prospect` int(11) NOT NULL AUTO_INCREMENT,
  `nameprospect` text NOT NULL,
  `phoneprospect` varchar(200) NOT NULL,
  `mailprospect` varchar(200) NOT NULL,
  PRIMARY KEY (`id_prospect`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idqag` int(11) NOT NULL AUTO_INCREMENT,
  `nomag` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `emailag` varchar(255) DEFAULT NULL,
  `telag` varchar(30) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `gpe` int(11) DEFAULT NULL,
  `dateenr` datetime DEFAULT NULL,
  `datemodify` datetime DEFAULT NULL,
  `user_status` int(11) DEFAULT '0',
  `author_modify` int(11) DEFAULT NULL,
  `numag` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idqag`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
