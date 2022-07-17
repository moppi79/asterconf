-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 17. Jul 2022 um 11:03
-- Server-Version: 10.5.15-MariaDB-0+deb11u1
-- PHP-Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `asterconf`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Deleted_ID`
--

CREATE TABLE `Deleted_ID` (
  `ID` int(40) NOT NULL,
  `date` varchar(40) NOT NULL,
  `context` varchar(255) NOT NULL,
  `exten` varchar(255) NOT NULL,
  `Del_ID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `extensions`
--

CREATE TABLE `extensions` (
  `lslsls` int(10) NOT NULL,
  `id` bigint(20) NOT NULL,
  `context` varchar(40) NOT NULL,
  `exten` varchar(40) NOT NULL,
  `priority` text NOT NULL,
  `app` varchar(40) NOT NULL,
  `appdata` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Deleted_ID`
--
ALTER TABLE `Deleted_ID`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `extensions`
--
ALTER TABLE `extensions`
  ADD UNIQUE KEY `lslsls` (`lslsls`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `Deleted_ID`
--
ALTER TABLE `Deleted_ID`
  MODIFY `ID` int(40) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `extensions`
--
ALTER TABLE `extensions`
  MODIFY `lslsls` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
