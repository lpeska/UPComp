-- phpMyAdmin SQL Dump
-- version 4.2.13
-- http://www.phpmyadmin.net
--
-- Počítač: 10.5.0.155
-- Vytvořeno: Čtv 17. pro 2015, 16:20
-- Verze serveru: 5.5.46-0+deb7u1-log
-- Verze PHP: 5.5.27-1~dotdeb+7.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `tatraturcz`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `vsm_object_model`
--

CREATE TABLE IF NOT EXISTS `vsm_object_model` (
  `oid` int(11) NOT NULL,
  `relevance` double NOT NULL,
  `feature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `vsm_user_model`
--

CREATE TABLE IF NOT EXISTS `vsm_user_model` (
  `uid` int(11) NOT NULL,
  `relevance` double NOT NULL,
  `feature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `vsm_object_model`
--
ALTER TABLE `vsm_object_model`
 ADD PRIMARY KEY (`oid`,`feature`), ADD KEY `feature` (`feature`);

--
-- Klíče pro tabulku `vsm_user_model`
--
ALTER TABLE `vsm_user_model`
 ADD PRIMARY KEY (`uid`,`feature`), ADD KEY `feature` (`feature`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
