-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 25 Août 2017 à 06:24
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf32 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `expo_token`
--

INSERT INTO `expo_token` (`id`, `user_id`, `token`, `connected`) VALUES
(6, 'toavina', 'ExponentPushToken[5NG-MAH3q7DlrRwZR-rGAq]', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
