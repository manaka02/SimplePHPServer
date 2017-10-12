-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 12 Octobre 2017 à 14:01
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
  `pseudo` varchar(50) NOT NULL,
  `alias` varchar(60) NOT NULL,
  `idmobile` varchar(100) NOT NULL,
  `exptoken` varchar(100) NOT NULL,
  `connected` smallint(6) NOT NULL,
  PRIMARY KEY (`id_account`),
  UNIQUE KEY `exptoken` (`exptoken`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`id_account`, `pseudo`, `alias`, `idmobile`, `exptoken`, `connected`) VALUES
(1, 'toavina', 'toavina', 'sony', 'expSony', 0),
(2, 'miora', 'miora', 'zte', 'expZTE', 1),
(4, 'toavina', 'marchand2', 'sonyoooh', 'expSonnyyy', 1),
(5, 'toavina', 'mrchand3', 'snny', 'espsony', 1),
(7, 'miora', 'mrchand1', '', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9R7]', 1),
(8, 'toavina', 'marchnd4', 'sony4', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9RFG]', 0),
(9, 'toavina', 'marchand5', 'sony2', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9R4]', 0),
(12, 'toavina', 'caisse3', 'sonyXperia ZR', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9Ro]', 1),
(10, 'toavina', 'caisse1', 'sony', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9RFGsdfg]', 0),
(11, 'toavina', 'caisse2', 'sony2', 'ExponentPushToken[Ry2QvANEDLZLfcwRQnd9R4df]', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `tree`
--

INSERT INTO `tree` (`id_tree`, `id_account`, `father`) VALUES
(1, 11, 1),
(2, 12, 1),
(3, 12, 1),
(4, 12, 1),
(5, 12, 1),
(6, 12, 1),
(7, 12, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
