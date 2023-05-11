-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 02 mai 2023 à 19:02
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `la112398`
--

-- --------------------------------------------------------

--
-- Structure de la table `trame`
--

DROP TABLE IF EXISTS `trame`;
CREATE TABLE IF NOT EXISTS `trame` (
  `numtrame` int NOT NULL AUTO_INCREMENT,
  `date` varchar(30) NOT NULL,
  `pmid` varchar(30) NOT NULL,
  `bench3` varchar(30) NOT NULL,
  `bench5` varchar(30) NOT NULL,
  `framesize` varchar(30) NOT NULL,
  `macdst` varchar(30) NOT NULL,
  `macsrc` varchar(30) NOT NULL,
  `field1` varchar(30) NOT NULL,
  `field2` varchar(30) NOT NULL,
  `field3` varchar(30) NOT NULL,
  `field4` varchar(30) NOT NULL,
  `field5` varchar(30) NOT NULL,
  `field6` varchar(30) NOT NULL,
  `field7` varchar(30) NOT NULL,
  `ipsrc` varchar(30) NOT NULL,
  `ipdst` varchar(30) NOT NULL,
  `field9` varchar(30) NOT NULL,
  `field10` varchar(30) NOT NULL,
  `field11` varchar(30) NOT NULL,
  `field14` varchar(30) NOT NULL,
  `field16` varchar(30) NOT NULL,
  `field17` varchar(30) NOT NULL,
  `field18` varchar(30) NOT NULL,
  `field20` varchar(30) NOT NULL,
  `field21` varchar(30) NOT NULL,
  `field23` varchar(30) NOT NULL,
  `field25` varchar(30) NOT NULL,
  `field26` varchar(30) NOT NULL,
  `field28` varchar(30) NOT NULL,
  `field29` varchar(30) NOT NULL,
  `field30` varchar(30) NOT NULL,
  `field32` varchar(30) NOT NULL,
  `field333435` varchar(30) NOT NULL,
  `timepacket` varchar(30) NOT NULL,
  `field2bis` varchar(30) NOT NULL,
  `field3bis` varchar(30) NOT NULL,
  `field4bis` varchar(30) NOT NULL,
  `field5bis` varchar(30) NOT NULL,
  `field6bis` varchar(30) NOT NULL,
  `macsender` varchar(30) NOT NULL,
  `ipsender` varchar(30) NOT NULL,
  `mactarget` varchar(30) NOT NULL,
  `iptarget` varchar(30) NOT NULL,
  PRIMARY KEY (`numtrame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
