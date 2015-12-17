-- phpMyAdmin SQL Dump
-- version 4.2.13
-- http://www.phpmyadmin.net
--
-- Počítač: 10.5.0.155
-- Vytvořeno: Čtv 17. pro 2015, 16:21
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
-- Struktura tabulky `meta_preference`
--

CREATE TABLE IF NOT EXISTS `meta_preference` (
  `border_from` int(11) NOT NULL,
  `border_to` int(11) NOT NULL,
  `preference` double NOT NULL,
  `confidence` double NOT NULL,
  `eventType` text COLLATE utf8_czech_ci NOT NULL,
  `lastModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `meta_preference`
--
ALTER TABLE `meta_preference`
 ADD PRIMARY KEY (`border_from`,`border_to`,`eventType`(50));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
