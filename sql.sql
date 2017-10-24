-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 24 Octobre 2017 à 06:38
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `usertoken`
--
CREATE DATABASE IF NOT EXISTS `usertoken` DEFAULT CHARACTER SET utf32 COLLATE utf32_general_ci;
USE `usertoken`;

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id_account` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `alias` varchar(60) NOT NULL,
  `idmobile` varchar(100) NOT NULL,
  `exptoken` varchar(100) NOT NULL,
  `connected` smallint(6) NOT NULL,
  PRIMARY KEY (`id_account`),
  UNIQUE KEY `uq_unike_account` (`code`,`exptoken`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`id_account`, `code`, `pseudo`, `alias`, `idmobile`, `exptoken`, `connected`) VALUES
(1, 'AA027', 'toavina', 'hasina', 'sony', 'expSony', 1),
(2, 'AA027', 'miora', 'miora', 'zte', 'expZTE', 1),
(4, 'AA001', 'toavina', 'marchand2', 'sonyoooh', 'expSonnyyy', 1),
(5, 'AA012', 'toavina', 'mrchand3', 'snny', 'espsony', 1),
(7, 'AA027', 'miora', 'mrchand1', '', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9R7]', 1),
(8, 'AA027', 'toavina', 'marchnd4', 'sony4', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9RFG]', 0),
(9, 'AA027', 'toavina', 'marchand5', 'sony2', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9R4]', 0),
(12, 'AA027', 'toavina', 'caisse3', 'sonyXperia ZR', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9Ro]', 1),
(10, 'AA027', 'toavina', 'caisse1', 'sony', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9RFGsdfg]', 0),
(11, 'AA027', 'toavina', 'caisse2', 'sony2', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9R4df]', 0),
(13, 'AA027', 'toavina', 'Caisse 7', 'CSS05', 'ExponentPushToken[83D9aJCoDivkqZzPSKL7v8]', 1);

-- --------------------------------------------------------

--
-- Structure de la table `expo_token`
--

CREATE TABLE IF NOT EXISTS `expo_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL,
  `token` varchar(250) NOT NULL,
  `connected` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `expo_token`
--

INSERT INTO `expo_token` (`id`, `user_id`, `token`, `connected`) VALUES
(6, 'toavina', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1),
(7, 'Rakoto', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1),
(8, 'Harena16', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1),
(9, 'toavina', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1),
(10, 'toavina', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1),
(11, 'sam', 'ExponentPushToken[D9NQh3AxoQB_PSporLKfsI]', 1),
(12, 'toavina', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1),
(13, 'toavina', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1);

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id_transaction` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `date_transaction` datetime DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `comment` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_transaction`),
  KEY `fk_recipient` (`recipient`),
  KEY `fk_sender` (`sender`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tree`
--

CREATE TABLE IF NOT EXISTS `tree` (
  `id_tree` int(11) NOT NULL AUTO_INCREMENT,
  `id_account` int(11) NOT NULL,
  `father` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tree`),
  KEY `fk_account` (`id_account`),
  KEY `fk_pere` (`father`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `tree`
--

INSERT INTO `tree` (`id_tree`, `id_account`, `father`) VALUES
(1, 4, 1),
(2, 5, 1),
(3, 8, 1),
(4, 9, 1),
(5, 10, 1),
(6, 11, 1),
(7, 7, 2),
(8, 13, 1),
(9, 13, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
