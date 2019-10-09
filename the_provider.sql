-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 02 okt 2019 kl 09:48
-- Serverversion: 10.1.38-MariaDB
-- PHP-version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `the_provider`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `anvandare`
--

CREATE TABLE `anvandare` (
  `UID` int(11) NOT NULL,
  `fnman` varchar(30) NOT NULL,
  `enamn` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `anvandare`
--

INSERT INTO `anvandare` (`UID`, `fnman`, `enamn`) VALUES
(1, 'Brandon', 'Mogren \r'),
(2, 'Viktor', 'Karlsson\r'),
(3, 'Alvar', 'Ljungfär\r'),
(4, 'Joel', 'Magnusson\r'),
(5, 'Nils', 'Pettersson\r'),
(6, 'Eddie', 'Gustafsson\r'),
(7, 'Morgan', 'Augustsson\r'),
(8, 'Polkis', ' Dirk\r');

-- --------------------------------------------------------

--
-- Tabellstruktur `bildruta`
--

CREATE TABLE `bildruta` (
  `RID` int(11) NOT NULL,
  `bild` blob NOT NULL,
  `IID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `blogg`
--

CREATE TABLE `blogg` (
  `BID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `UID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `blogginlagg`
--

CREATE TABLE `blogginlagg` (
  `IID` int(11) NOT NULL,
  `BID` int(11) NOT NULL,
  `datum` date NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `kommentar`
--

CREATE TABLE `kommentar` (
  `KID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `IID` int(11) NOT NULL,
  `text` varchar(2000) NOT NULL,
  `hierarchyID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `rutor`
--

CREATE TABLE `rutor` (
  `RID` int(11) NOT NULL,
  `ordning` int(11) NOT NULL,
  `IID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `textruta`
--

CREATE TABLE `textruta` (
  `RID` int(11) NOT NULL,
  `text` varchar(20000) NOT NULL,
  `rubrik` varchar(50) DEFAULT NULL,
  `IID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `anvandare`
--
ALTER TABLE `anvandare`
  ADD PRIMARY KEY (`UID`);

--
-- Index för tabell `blogg`
--
ALTER TABLE `blogg`
  ADD PRIMARY KEY (`BID`);

--
-- Index för tabell `blogginlagg`
--
ALTER TABLE `blogginlagg`
  ADD PRIMARY KEY (`IID`);

--
-- Index för tabell `kommentar`
--
ALTER TABLE `kommentar`
  ADD PRIMARY KEY (`KID`);

--
-- Index för tabell `rutor`
--
ALTER TABLE `rutor`
  ADD PRIMARY KEY (`RID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `anvandare`
--
ALTER TABLE `anvandare`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT för tabell `blogg`
--
ALTER TABLE `blogg`
  MODIFY `BID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `blogginlagg`
--
ALTER TABLE `blogginlagg`
  MODIFY `IID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `kommentar`
--
ALTER TABLE `kommentar`
  MODIFY `KID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `rutor`
--
ALTER TABLE `rutor`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
