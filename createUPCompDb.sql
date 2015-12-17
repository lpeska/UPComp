-- phpMyAdmin SQL Dump
-- version 2.8.0.2
-- http://www.phpmyadmin.net
-- 
-- Počítač: mysql5.spider.cz
-- Vygenerováno: Středa 08. prosince 2010, 21:09
-- Verze MySQL: 5.0.41
-- Verze PHP: 5.0.4
-- 
-- Databáze: `slantour`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabulky `aggregated_events`
-- 

CREATE TABLE `aggregated_events` (
  `objectID` int(11) NOT NULL,
  `eventType` text NOT NULL,
  `eventValue` double NOT NULL,
  PRIMARY KEY  (`objectID`,`eventType`(100))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Struktura tabulky `explicit_events`
-- 

CREATE TABLE `explicit_events` (
  `id` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL default '0',
  `objectID` int(11) NOT NULL default '0',
  `eventType` text NOT NULL,
  `eventValue` double NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `userID` (`userID`,`objectID`,`eventType`(50))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Struktura tabulky `implicit_events`
-- 

CREATE TABLE `implicit_events` (
  `id` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL default '0',
  `objectID` int(11) NOT NULL default '0',
  `eventType` text NOT NULL,
  `eventValue` float NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `userID` (`userID`,`objectID`,`eventType`(50))
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Struktura tabulky `users`
-- 

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
