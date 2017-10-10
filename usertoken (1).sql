-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 10 Octobre 2017 à 06:55
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
  `pseudo` varchar(50) DEFAULT NULL,
  `father` varchar(50) DEFAULT NULL,
  `idmobile` varchar(100) DEFAULT NULL,
  `exptoken` varchar(100) DEFAULT NULL,
  `connected` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_account`),
  UNIQUE KEY `exptoken` (`exptoken`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`id_account`, `pseudo`, `father`, `idmobile`, `exptoken`, `connected`) VALUES
(1, 'toavina', NULL, 'sony', 'expSony', 0),
(2, 'miora', NULL, 'htc', 'expohtc', 1),
(3, 'toavina', '1', 'zte', 'expzte', 1),
(4, 'miora', '2', 'xiaomi', 'expmi', 1),
(6, 'toavina', '1', 'expSony', NULL, 1),
(7, 'toavina', NULL, NULL, 'ExpXuaoi', 1),
(8, 'miora', '2', 'Siemens', 'expSiemens', 1),
(9, 'miora', '2', 'Siemens', 'expSiemen', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `transaction`
--

INSERT INTO `transaction` (`id_transaction`, `sender`, `recipient`, `currency`, `amount`, `date_transaction`, `type`, `comment`) VALUES
(1, 3, 2, 'Ar', 250, '2017-10-11 00:00:00', 'payement', NULL),
(2, 3, 2, 'Ar', 1250, '2017-10-11 00:00:00', 'payement', NULL),
(3, 4, 1, 'Ar', 250, '2017-10-11 00:00:00', 'payement', NULL),
(4, 4, 1, 'Ar', 2150, '2017-10-11 00:00:00', 'payement', NULL),
(5, 1, 4, 'Ar', 250, '2017-10-11 00:00:00', 'payement', NULL),
(6, 1, 2, 'Ar', 250, '2017-10-11 00:00:00', 'payement', NULL),
(7, 3, 4, 'Ar', 1500, NULL, 'expSiemen', 'comment');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
