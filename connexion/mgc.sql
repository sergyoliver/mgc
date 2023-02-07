-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 06 fév. 2023 à 10:29
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mgc`
--

-- --------------------------------------------------------

--
-- Structure de la table `table_adherent`
--

CREATE TABLE `table_adherent` (
  `id_adhr` int(11) NOT NULL,
  `nom_adh` varchar(100) NOT NULL,
  `penom_adh` text NOT NULL,
  `fonction _adh` varchar(50) NOT NULL,
  `mail_adh` varchar(50) NOT NULL,
  `datenaiss_adh` date NOT NULL,
  `tel_adh` varchar(50) NOT NULL,
  `adresse_adh` varchar(50) NOT NULL,
  `idsec` int(11) NOT NULL,
  `iddist` int(11) NOT NULL,
  `idreg` int(11) NOT NULL,
  `id_fed` int(11) NOT NULL,
  `id_bdv` int(11) NOT NULL,
  `id_ajout` int(11) NOT NULL,
  `id_modif` int(11) NOT NULL,
  `darenr` datetime NOT NULL,
  `datenrf` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `table_district`
--

CREATE TABLE `table_district` (
  `id` int(11) NOT NULL,
  `desig_district` varchar(60) DEFAULT NULL,
  `nomp` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `emaild` varchar(60) DEFAULT NULL,
  `siege` varchar(30) DEFAULT NULL,
  `nbrec` int(11) DEFAULT NULL,
  `datenr` date NOT NULL,
  `datenrf` date DEFAULT NULL,
  `id_ajout` int(11) NOT NULL,
  `id_modif` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_district`
--

INSERT INTO `table_district` (`id`, `desig_district`, `nomp`, `contact`, `emaild`, `siege`, `nbrec`, `datenr`, `datenrf`, `id_ajout`, `id_modif`) VALUES
(1, 'Capture-d’écran-2022-10-30-230925_wpb2.png', NULL, NULL, NULL, NULL, NULL, '2023-02-02', '2023-02-02', 3000, 3000),
(2, 'Capture-d’écran-2022-10-30-230925_bkil.png', 'testé', '03098656890', 'zertyuio', '§oui', 2, '2023-02-02', '2023-02-02', 3000, 3000);

-- --------------------------------------------------------

--
-- Structure de la table `table_federal`
--

CREATE TABLE `table_federal` (
  `id_fed` int(11) NOT NULL,
  `desig_fed` varchar(60) DEFAULT NULL,
  `nomf_f` varchar(100) DEFAULT NULL,
  `contact_f` varchar(100) DEFAULT NULL,
  `email_f` varchar(60) DEFAULT NULL,
  `siege_f` varchar(30) DEFAULT NULL,
  `nbrec_f` int(11) DEFAULT NULL,
  `idcr` int(11) DEFAULT NULL,
  `id_ajout` int(11) NOT NULL,
  `datenr` date NOT NULL,
  `datenrf` date DEFAULT NULL,
  `id_modif` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_federal`
--

INSERT INTO `table_federal` (`id_fed`, `desig_fed`, `nomf_f`, `contact_f`, `email_f`, `siege_f`, `nbrec_f`, `idcr`, `id_ajout`, `datenr`, `datenrf`, `id_modif`) VALUES
(1, '', 'FGNIU', '8560933', 'fop@g', 'Fuyyy', 5, 3, 3000, '2023-02-02', '2023-02-02', 3000);

-- --------------------------------------------------------

--
-- Structure de la table `table_gab`
--

CREATE TABLE `table_gab` (
  `id_bdv` int(11) NOT NULL,
  `desig_bdv` varchar(60) DEFAULT NULL,
  `nom_bdv` varchar(100) DEFAULT NULL,
  `contact_bdv` varchar(100) DEFAULT NULL,
  `email_bdv` varchar(60) DEFAULT NULL,
  `siege_bdv` varchar(30) DEFAULT NULL,
  `nbrec_bdv` int(11) DEFAULT NULL,
  `idsec` int(11) DEFAULT NULL,
  `id_ajout` int(11) NOT NULL,
  `id_modif` int(11) DEFAULT NULL,
  `datenr` date NOT NULL,
  `datenrf` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_gab`
--

INSERT INTO `table_gab` (`id_bdv`, `desig_bdv`, `nom_bdv`, `contact_bdv`, `email_bdv`, `siege_bdv`, `nbrec_bdv`, `idsec`, `id_ajout`, `id_modif`, `datenr`, `datenrf`) VALUES
(1, '', 'sfgj', '456677777', 'gf@gmail.com', 'Angre', 4, NULL, 3000, NULL, '2023-02-03', NULL),
(2, '', 'test', '0987654433', 'ghy@gmail.com', 'Dokui', NULL, 1, 3000, 3000, '2023-02-03', '2023-02-03');

-- --------------------------------------------------------

--
-- Structure de la table `table_gpe_users`
--

CREATE TABLE `table_gpe_users` (
  `idgpe` int(11) NOT NULL,
  `coden` varchar(15) DEFAULT NULL,
  `descn` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `table_militant` (
  `id` int(11) NOT NULL,
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
  `inscrit_liste` int(11) DEFAULT 0 COMMENT '1 oui 0 non',
  `cartembre` int(11) DEFAULT 0 COMMENT '0 non 1 oui',
  `lieuenr` varchar(60) DEFAULT NULL,
  `iddistrict` int(11) DEFAULT NULL,
  `idregion` int(11) DEFAULT NULL,
  `idsect` int(11) DEFAULT NULL,
  `idgab` int(11) DEFAULT NULL,
  `idfed` int(11) DEFAULT NULL,
  `dateenr` varchar(30) DEFAULT NULL,
  `idenr` int(11) DEFAULT NULL,
  `supp` int(11) DEFAULT 0,
  `idmodif` int(11) DEFAULT 0,
  `datesupp` varchar(30) DEFAULT NULL,
  `datemodif` varchar(30) DEFAULT NULL,
  `photom` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_region`
--

CREATE TABLE `table_region` (
  `idregion` int(11) NOT NULL,
  `desig_region` varchar(60) DEFAULT NULL,
  `nomr` varchar(100) DEFAULT NULL,
  `contactr` varchar(100) DEFAULT NULL,
  `emailr` varchar(60) DEFAULT NULL,
  `sieger` varchar(30) DEFAULT NULL,
  `nbrecr` int(11) DEFAULT NULL,
  `iddistrict` int(11) DEFAULT NULL,
  `id_ajout` int(11) NOT NULL,
  `id_modif` int(11) NOT NULL,
  `datenr` date NOT NULL,
  `datenrf` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_region`
--

INSERT INTO `table_region` (`idregion`, `desig_region`, `nomr`, `contactr`, `emailr`, `sieger`, `nbrecr`, `iddistrict`, `id_ajout`, `id_modif`, `datenr`, `datenrf`) VALUES
(1, 'Capture-d’écran-2022-10-30-230925_j528.png', 'Flore', '356890', 'zertyuio', '§oui', 2, NULL, 3000, 3000, '2023-02-02', '2023-02-02'),
(2, 'Capture-d’écran-2022-10-30-230925_vov1.png', 'Florentine', '356890', 'zertyuio', '§oui', 2, 1, 3000, 0, '2023-02-02', NULL),
(3, '', 'Flo', '982356', 'nnnnnnnnnnnnnnnnnnnnn', 'fgghnn', 3, 2, 3000, 3000, '2023-02-02', '2023-02-02');

-- --------------------------------------------------------

--
-- Structure de la table `table_secteur`
--

CREATE TABLE `table_secteur` (
  `id_section` int(11) NOT NULL,
  `desig_sec` varchar(60) DEFAULT NULL,
  `noms` varchar(100) DEFAULT NULL,
  `contacts` varchar(100) DEFAULT NULL,
  `emails` varchar(60) DEFAULT NULL,
  `sieges` varchar(30) DEFAULT NULL,
  `nbrecs` int(11) DEFAULT NULL,
  `idfed` int(11) DEFAULT NULL,
  `id_ajout` int(11) NOT NULL,
  `datenr` date DEFAULT NULL,
  `datenrs` date DEFAULT NULL,
  `id_modif` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_secteur`
--

INSERT INTO `table_secteur` (`id_section`, `desig_sec`, `noms`, `contacts`, `emails`, `sieges`, `nbrecs`, `idfed`, `id_ajout`, `datenr`, `datenrs`, `id_modif`) VALUES
(1, '', 'flora', '78905567', 'flo@gmail.com', 'Cocody', 5, 1, 3000, '2023-02-03', '2023-02-03', 3000);

-- --------------------------------------------------------

--
-- Structure de la table `tab_connexion`
--

CREATE TABLE `tab_connexion` (
  `idconn` bigint(20) UNSIGNED NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `statconn` int(11) DEFAULT NULL,
  `dateconn` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tab_connexion`
--

INSERT INTO `tab_connexion` (`idconn`, `iduser`, `statconn`, `dateconn`) VALUES
(164, NULL, 0, '2023-02-01 20:24:17'),
(165, 3000, 1, '2023-02-01 20:27:50');

-- --------------------------------------------------------

--
-- Structure de la table `tab_depot`
--

CREATE TABLE `tab_depot` (
  `id_depot` int(11) NOT NULL,
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
  `id_modif` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tab_histoconnexion`
--

CREATE TABLE `tab_histoconnexion` (
  `idhisto` int(11) NOT NULL,
  `ipaddress` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `dateconn` datetime DEFAULT NULL,
  `statconn` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tab_histoconnexion`
--

INSERT INTO `tab_histoconnexion` (`idhisto`, `ipaddress`, `user_email`, `dateconn`, `statconn`) VALUES
(83, '::1', NULL, '2023-02-01 21:24:17', 0);

-- --------------------------------------------------------

--
-- Structure de la table `tab_prospect`
--

CREATE TABLE `tab_prospect` (
  `id_prospect` int(11) NOT NULL,
  `nameprospect` text NOT NULL,
  `phoneprospect` varchar(200) NOT NULL,
  `mailprospect` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idqag` int(11) NOT NULL,
  `nomag` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `emailag` varchar(255) DEFAULT NULL,
  `telag` varchar(30) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `gpe` int(11) DEFAULT NULL,
  `dateenr` datetime DEFAULT NULL,
  `datemodify` datetime DEFAULT NULL,
  `user_status` int(11) DEFAULT 0,
  `author_modify` int(11) DEFAULT NULL,
  `numag` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `table_adherent`
--
ALTER TABLE `table_adherent`
  ADD PRIMARY KEY (`id_adhr`);

--
-- Index pour la table `table_district`
--
ALTER TABLE `table_district`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `table_federal`
--
ALTER TABLE `table_federal`
  ADD PRIMARY KEY (`id_fed`);

--
-- Index pour la table `table_gab`
--
ALTER TABLE `table_gab`
  ADD PRIMARY KEY (`id_bdv`);

--
-- Index pour la table `table_gpe_users`
--
ALTER TABLE `table_gpe_users`
  ADD PRIMARY KEY (`idgpe`);

--
-- Index pour la table `table_militant`
--
ALTER TABLE `table_militant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `table_region`
--
ALTER TABLE `table_region`
  ADD PRIMARY KEY (`idregion`);

--
-- Index pour la table `table_secteur`
--
ALTER TABLE `table_secteur`
  ADD PRIMARY KEY (`id_section`);

--
-- Index pour la table `tab_connexion`
--
ALTER TABLE `tab_connexion`
  ADD PRIMARY KEY (`idconn`),
  ADD UNIQUE KEY `idconn` (`idconn`);

--
-- Index pour la table `tab_depot`
--
ALTER TABLE `tab_depot`
  ADD PRIMARY KEY (`id_depot`);

--
-- Index pour la table `tab_histoconnexion`
--
ALTER TABLE `tab_histoconnexion`
  ADD PRIMARY KEY (`idhisto`);

--
-- Index pour la table `tab_prospect`
--
ALTER TABLE `tab_prospect`
  ADD PRIMARY KEY (`id_prospect`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idqag`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `table_adherent`
--
ALTER TABLE `table_adherent`
  MODIFY `id_adhr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `table_district`
--
ALTER TABLE `table_district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `table_federal`
--
ALTER TABLE `table_federal`
  MODIFY `id_fed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `table_gab`
--
ALTER TABLE `table_gab`
  MODIFY `id_bdv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `table_gpe_users`
--
ALTER TABLE `table_gpe_users`
  MODIFY `idgpe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `table_militant`
--
ALTER TABLE `table_militant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `table_region`
--
ALTER TABLE `table_region`
  MODIFY `idregion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `table_secteur`
--
ALTER TABLE `table_secteur`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tab_connexion`
--
ALTER TABLE `tab_connexion`
  MODIFY `idconn` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT pour la table `tab_depot`
--
ALTER TABLE `tab_depot`
  MODIFY `id_depot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `tab_histoconnexion`
--
ALTER TABLE `tab_histoconnexion`
  MODIFY `idhisto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT pour la table `tab_prospect`
--
ALTER TABLE `tab_prospect`
  MODIFY `id_prospect` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idqag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
