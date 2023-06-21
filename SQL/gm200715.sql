-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 22 juin 2023 à 01:39
-- Version du serveur : 10.5.19-MariaDB-0+deb11u2
-- Version de PHP : 7.3.33-10+0~20230409.104+debian11~1.gbp88ff76

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gm200715`
--

-- --------------------------------------------------------

--
-- Structure de la table `fic`
--

CREATE TABLE `fic` (
  `numfic` int(11) NOT NULL,
  `nomfic` varchar(30) NOT NULL,
  `obsw` varchar(30) DEFAULT NULL,
  `bds` varchar(30) DEFAULT NULL,
  `tv` varchar(30) DEFAULT NULL,
  `dt` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trame800`
--

CREATE TABLE `trame800` (
  `numtrame` int(11) NOT NULL,
  `numfic` varchar(30) NOT NULL,
  `date` varchar(50) NOT NULL,
  `pmid` varchar(40) NOT NULL,
  `bench3` varchar(40) NOT NULL,
  `bench5` varchar(40) NOT NULL,
  `framesize` varchar(40) NOT NULL,
  `macdst` varchar(40) NOT NULL,
  `macsrc` varchar(40) NOT NULL,
  `field1` varchar(40) NOT NULL,
  `field2` varchar(40) NOT NULL,
  `field3` varchar(40) NOT NULL,
  `field4` varchar(40) NOT NULL,
  `field5` varchar(40) NOT NULL,
  `field6` varchar(40) NOT NULL,
  `field7` varchar(40) NOT NULL,
  `ipsrc` varchar(40) NOT NULL,
  `ipdst` varchar(40) NOT NULL,
  `field9` varchar(40) NOT NULL,
  `field10` varchar(40) NOT NULL,
  `field11` varchar(40) NOT NULL,
  `field14` varchar(40) NOT NULL,
  `field16` varchar(40) NOT NULL,
  `field17` varchar(40) NOT NULL,
  `field18` varchar(40) NOT NULL,
  `field20` varchar(40) NOT NULL,
  `field21` varchar(40) NOT NULL,
  `field23` varchar(40) NOT NULL,
  `field25` varchar(40) NOT NULL,
  `field26` varchar(40) NOT NULL,
  `field28` varchar(40) NOT NULL,
  `field29` varchar(40) NOT NULL,
  `field30` varchar(40) NOT NULL,
  `field32` varchar(40) NOT NULL,
  `field333435` varchar(40) NOT NULL,
  `timepacket` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trame806`
--

CREATE TABLE `trame806` (
  `numtrame` int(11) NOT NULL,
  `numfic` varchar(30) NOT NULL,
  `date` varchar(50) NOT NULL,
  `bench3` varchar(40) NOT NULL,
  `bench5` varchar(40) NOT NULL,
  `framesize` varchar(40) NOT NULL,
  `macdst` varchar(40) NOT NULL,
  `macsrc` varchar(40) NOT NULL,
  `field1` varchar(40) NOT NULL,
  `field2` varchar(40) NOT NULL,
  `field3` varchar(40) NOT NULL,
  `field4` varchar(40) NOT NULL,
  `field5` varchar(40) NOT NULL,
  `field6` varchar(40) NOT NULL,
  `macsender` varchar(40) NOT NULL,
  `ipsender` varchar(40) NOT NULL,
  `mactarget` varchar(40) NOT NULL,
  `iptarget` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `fic`
--
ALTER TABLE `fic`
  ADD PRIMARY KEY (`numfic`);

--
-- Index pour la table `trame800`
--
ALTER TABLE `trame800`
  ADD PRIMARY KEY (`numtrame`),
  ADD KEY `numfic#` (`numfic`);

--
-- Index pour la table `trame806`
--
ALTER TABLE `trame806`
  ADD PRIMARY KEY (`numtrame`),
  ADD KEY `numfic#` (`numfic`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `fic`
--
ALTER TABLE `fic`
  MODIFY `numfic` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trame800`
--
ALTER TABLE `trame800`
  MODIFY `numtrame` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trame806`
--
ALTER TABLE `trame806`
  MODIFY `numtrame` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
