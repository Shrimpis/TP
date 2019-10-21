-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 21 okt 2019 kl 12:14
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
  `id` int(11) NOT NULL,
  `losenord` varchar(70) DEFAULT NULL,
  `salt` varchar(30) DEFAULT NULL,
  `anamn` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `anvandare`
--

INSERT INTO `anvandare` (`id`, `losenord`, `salt`, `anamn`, `email`, `aktiv`) VALUES
(1, 'admin', '1', 'Hugomeister', 'hugo.malmstrom@hotmail.se', 1),
(2, 'anvandare', '2', 'l33th4xor', 'l33th4xor@yahoo.com', 1),
(3, 'anvandare', '3', 'originallt', 'steffe.personsson@outlook.se', 1),
(4, 'anvandare', '4', 'rapport', 'johanledel@gmail.com', 1),
(5, 'anvandare', '5', 'htm', 'edwar.oddish-oh@hotmail.dk', 1),
(6, '12345', '1', 'meister', 'hugo.malmstrom@hotmail.se', 1),
(7, '12345', '1', 'fixarn', 'greger.andersson@hotmail.se', 1),
(8, '12345', '1', 'programmeraren', 'anton.augustsson@hotmail.se', 1),
(9, '12345', '1', 'ditto', 'stina.karlsson@hotmail.se', 1),
(10, '12345', '1', 'gryta', 'morgan.andersson@hotmail.se', 1),
(11, '12345', '1', 'originallt', 'steffe.personsson@hotmail.se', 1),
(12, '12345', '1', 'nilsalskartrad', 'nilsalskartrad@hotmail.se', 1),
(13, 'dirk', 'dirk', 'polkis', 'polkis.dirk@polkisdirk.dk', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `anvandarroll`
--

CREATE TABLE `anvandarroll` (
  `id` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL,
  `rollId` int(11) NOT NULL,
  `tjanstId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `anvandarroll`
--

INSERT INTO `anvandarroll` (`id`, `anvandarId`, `rollId`, `tjanstId`) VALUES
(1, 1, 1, 0),
(2, 2, 2, 2),
(3, 3, 2, 2),
(4, 4, 4, 2),
(5, 5, 5, 2),
(6, 6, 2, 2),
(7, 7, 4, 1),
(8, 8, 3, 4),
(9, 9, 4, 2),
(10, 10, 3, 7),
(11, 11, 5, 7),
(12, 12, 6, 3),
(13, 13, 1, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur `blogg`
--

CREATE TABLE `blogg` (
  `id` int(11) NOT NULL,
  `tjanstId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `blogg`
--

INSERT INTO `blogg` (`id`, `tjanstId`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `blogginlagg`
--

CREATE TABLE `blogginlagg` (
  `id` int(11) NOT NULL,
  `bloggId` int(11) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `innehall` text NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `blogginlagg`
--

INSERT INTO `blogginlagg` (`id`, `bloggId`, `titel`, `innehall`, `datum`) VALUES
(1, 2, 'En dag i mitt liv', 'blah blah blah blah blah Wraith dödar mig varenda gång blah blah blah', '2019-10-02'),
(2, 2, 'Fotboll är kul', 'Messi är en fotbollspelare som är okej enligt mig.', '2019-10-09'),
(3, 1, 'Polkagrisar är inte så värst nyttiga...', 'Varför!?!', '2019-10-15');

-- --------------------------------------------------------

--
-- Tabellstruktur `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `skapadAv` int(11) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `innehall` varchar(255) NOT NULL,
  `startTid` datetime NOT NULL,
  `slutTid` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `event`
--

INSERT INTO `event` (`id`, `skapadAv`, `titel`, `innehall`, `startTid`, `slutTid`) VALUES
(1, 1, 'Picknick med Morsan', 'Ska ?ta lite bullar med morsan', '2019-10-15 15:00:00', '2019-10-15 20:00:00'),
(2, 12, 'Picknick med Morsan', 'Ska ?ta lite bullar med morsan', '2019-10-16 12:00:00', '2019-10-16 12:30:03'),
(3, 12, 'Picknick med Tjejen', 'Ska ?ta lite bullar med tjejen', '2019-10-25 14:00:00', '2019-10-25 14:00:05'),
(4, 1, 'M?te med Chefen', 'Ska ?ta lite bullar med Chefen', '2019-10-27 09:00:00', '2019-10-28 14:30:00'),
(5, 12, 'Picknick med hunden', 'Ska ?ta lite bullar och kasta till hunden', '2019-10-19 18:00:00', '2019-10-19 19:30:00'),
(6, 1, 'Picknick med Morsan *igen*', 'Ska ?ta lite bullar med morsan *sigh*', '2019-10-31 14:33:30', '2019-10-31 15:49:27');

-- --------------------------------------------------------

--
-- Tabellstruktur `flaggadblogg`
--

CREATE TABLE `flaggadblogg` (
  `id` int(11) NOT NULL,
  `bloggId` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `flaggadblogg`
--

INSERT INTO `flaggadblogg` (`id`, `bloggId`, `anvandarId`) VALUES
(1, 1, 2),
(2, 2, 8),
(3, 1, 8),
(4, 1, 7),
(5, 2, 7),
(6, 1, 3),
(7, 1, 6),
(8, 2, 4),
(9, 2, 8);

-- --------------------------------------------------------

--
-- Tabellstruktur `flaggadkommentar`
--

CREATE TABLE `flaggadkommentar` (
  `id` int(11) NOT NULL,
  `kommentarId` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `gillningar`
--

CREATE TABLE `gillningar` (
  `id` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL,
  `inlaggId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `gillningar`
--

INSERT INTO `gillningar` (`id`, `anvandarId`, `inlaggId`) VALUES
(1, 4, 2),
(2, 3, 2),
(3, 2, 1),
(4, 3, 1),
(5, 1, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `kalender`
--

CREATE TABLE `kalender` (
  `id` int(11) NOT NULL,
  `tjanstId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `kalender`
--

INSERT INTO `kalender` (`id`, `tjanstId`) VALUES
(1, 3),
(2, 6);

-- --------------------------------------------------------

--
-- Tabellstruktur `kalenderevent`
--

CREATE TABLE `kalenderevent` (
  `id` int(11) NOT NULL,
  `kalenderId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `kalenderevent`
--

INSERT INTO `kalenderevent` (`id`, `kalenderId`, `eventId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 1, 4),
(5, 2, 5),
(6, 1, 6);

-- --------------------------------------------------------

--
-- Tabellstruktur `kommentar`
--

CREATE TABLE `kommentar` (
  `id` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL,
  `inlaggId` int(11) NOT NULL,
  `hierarkiId` int(11) NOT NULL,
  `innehall` varchar(2000) NOT NULL,
  `redigerad` tinyint(4) NOT NULL,
  `censurerad` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `kommentar`
--

INSERT INTO `kommentar` (`id`, `anvandarId`, `inlaggId`, `hierarkiId`, `innehall`, `redigerad`, `censurerad`) VALUES
(1, 3, 2, 0, 'Hur vågar du kalla honom okej!', 1, 0),
(2, 2, 1, 0, 'Hej! Jag gillar också wraith', 0, 0),
(3, 2, 2, 1, 'Nej, han är bara okej...', 1, 1),
(4, 4, 2, 0, 'Du vet meningen med livet är komplicerat.', 0, 0),
(5, 3, 1, 3, 'Nu är du lite taskig!', 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `kundrattigheter`
--

CREATE TABLE `kundrattigheter` (
  `id` int(11) NOT NULL,
  `tjanst` tinyint(4) NOT NULL,
  `superadmin` tinyint(4) NOT NULL,
  `kontoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `kundrattigheter`
--

INSERT INTO `kundrattigheter` (`id`, `tjanst`, `superadmin`, `kontoId`) VALUES
(1, 1, 1, 1),
(2, 0, 0, 0),
(3, 0, 0, 0),
(4, 0, 0, 0),
(5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `nekadwikiuppdatering`
--

CREATE TABLE `nekadwikiuppdatering` (
  `id` int(11) NOT NULL,
  `wikiId` int(11) NOT NULL,
  `sidId` int(11) NOT NULL,
  `bidragsgivare` int(11) NOT NULL,
  `nekadAv` int(11) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `innehall` text NOT NULL,
  `anledning` varchar(250) NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `nekadwikiuppdatering`
--

INSERT INTO `nekadwikiuppdatering` (`id`, `wikiId`, `sidId`, `bidragsgivare`, `nekadAv`, `titel`, `innehall`, `anledning`, `datum`) VALUES
(1, 0, 3, 10, 4, 'Vapen under andra v?rldskriget', 'vapen d?dar', 'Du är fel', '2019-10-16'),
(2, 0, 4, 11, 5, 'Gr?na potatisar ?r giftiga', 'De innh?ller ett gift som kan d?da!', 'De är inte giftiga om du inte äter de gröna delarna', '2019-10-01'),
(3, 0, 6, 11, 5, 'Julafton', 'Julafton firas den 24 december, f?rutom i USA d?r den firas den 25 december', 'Tomten är en scam gjord av fox news', '2019-10-24'),
(4, 0, 8, 11, 9, 'Katter', 'Katter ?r inte m?nniskans b?sta v?n, men de ?r i alla fall s?ta', 'Hundar är bättre', '2019-10-12');

-- --------------------------------------------------------

--
-- Tabellstruktur `roll`
--

CREATE TABLE `roll` (
  `id` int(11) NOT NULL,
  `rollNamn` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `roll`
--

INSERT INTO `roll` (`id`, `rollNamn`) VALUES
(1, 'superadmin'),
(2, 'admin_blogg'),
(3, 'admin_wiki'),
(4, 'anvandare_blogg'),
(5, 'anvandare_wiki'),
(6, 'anvandare_kalender'),
(7, 'gast');

-- --------------------------------------------------------

--
-- Tabellstruktur `sidversion`
--

CREATE TABLE `sidversion` (
  `id` int(11) NOT NULL,
  `sidId` int(11) NOT NULL,
  `godkantAv` int(11) NOT NULL,
  `bidragsgivare` int(11) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `innehall` text NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `sidversion`
--

INSERT INTO `sidversion` (`id`, `sidId`, `godkantAv`, `bidragsgivare`, `titel`, `innehall`, `datum`) VALUES
(1, 3, 10, 4, 'Vapen under andra v?rldskriget', 'vapen d?dar', '2019-10-15'),
(2, 4, 11, 5, 'Gr?na potatisar ?r giftiga', 'De innh?ller ett gift som kan d?da!', '2019-10-17'),
(3, 6, 11, 5, 'Julafton', 'Julafton firas den 24 december, f?rutom i USA d?r den firas den 25 december', '2019-10-19'),
(4, 8, 11, 9, 'Katter', 'Katter ?r inte m?nniskans b?sta v?n, men de ?r i alla fall s?ta', '2019-10-24'),
(5, 1, 10, 4, 'Vapen under andra v?rldskriget', 'vapen d?dar', '2019-10-09');

-- --------------------------------------------------------

--
-- Tabellstruktur `tjanst`
--

CREATE TABLE `tjanst` (
  `id` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL,
  `titel` varchar(70) NOT NULL,
  `privat` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tjanst`
--

INSERT INTO `tjanst` (`id`, `anvandarId`, `titel`, `privat`) VALUES
(1, 1, 'Polkis Blogg', 0),
(2, 1, 'Glada Snickaren', 0),
(3, 1, 'Polkis Kalender', 0),
(4, 1, 'Wikihow-Ripoff', 0),
(5, 1, 'Minecraft-Wiki', 0),
(6, 1, 'EngrishKalender', 0),
(7, 1, 'Allt om Malmström', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `wiki`
--

CREATE TABLE `wiki` (
  `id` int(11) NOT NULL,
  `tjanstId` int(11) NOT NULL,
  `dolt` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `wiki`
--

INSERT INTO `wiki` (`id`, `tjanstId`, `dolt`) VALUES
(1, 4, 0),
(2, 5, 0),
(3, 7, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `wikisidor`
--

CREATE TABLE `wikisidor` (
  `id` int(11) NOT NULL,
  `wikiId` int(11) NOT NULL,
  `godkantAv` int(11) NOT NULL,
  `bidragsgivare` int(11) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `innehall` text NOT NULL,
  `datum` date NOT NULL,
  `dolt` tinyint(4) NOT NULL,
  `last` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `wikisidor`
--

INSERT INTO `wikisidor` (`id`, `wikiId`, `godkantAv`, `bidragsgivare`, `titel`, `innehall`, `datum`, `dolt`, `last`) VALUES
(1, 3, 10, 4, 'Vapen under andra v?rldskriget', 'vapen d?dar', '2019-10-09', 0, 0),
(2, 4, 11, 5, 'Gr?na potatisar ?r giftiga', 'De innh?ller ett gift som kan d?da!', '2019-10-10', 0, 0),
(3, 6, 11, 5, 'Julafton', 'Julafton firas den 24 december, f?rutom i USA d?r den firas den 25 december', '2019-10-18', 0, 0),
(4, 8, 11, 9, 'Katter', 'Katter ?r inte m?nniskans b?sta v?n, men de ?r i alla fall s?ta', '2019-10-15', 0, 0),
(5, 3, 10, 4, 'Vapen under andra v?rldskriget', 'vapen d?dar', '0000-00-00', 0, 0),
(6, 4, 11, 5, 'Gr?na potatisar ?r giftiga', 'De innh?ller ett gift som kan d?da!', '0000-00-00', 0, 0),
(7, 6, 11, 5, 'Julafton', 'Julafton firas den 24 december, f?rutom i USA d?r den firas den 25 december', '0000-00-00', 0, 0),
(8, 8, 11, 9, 'Katter', 'Katter ?r inte m?nniskans b?sta v?n, men de ?r i alla fall s?ta', '0000-00-00', 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `wikiuppdatering`
--

CREATE TABLE `wikiuppdatering` (
  `id` int(11) NOT NULL,
  `wikiId` int(11) NOT NULL,
  `sidId` int(11) DEFAULT NULL,
  `bidragsgivare` int(11) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `innehall` text NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `wikiuppdatering`
--

INSERT INTO `wikiuppdatering` (`id`, `wikiId`, `sidId`, `bidragsgivare`, `titel`, `innehall`, `datum`) VALUES
(1, 0, 3, 10, 'Vapen under andra v?rldskriget', 'vapen d?dar', '2019-10-23'),
(2, 0, 4, 11, 'Gr?na potatisar ?r giftiga', 'De innh?ller ett gift som kan d?da!', '2019-10-25'),
(3, 0, 6, 11, 'Julafton', 'Julafton firas den 24 december, f?rutom i USA d?r den firas den 25 december', '2019-10-29'),
(4, 0, 8, 11, 'Katter', 'Katter ?r inte m?nniskans b?sta v?n, men de ?r i alla fall s?ta', '2019-10-22');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `anvandare`
--
ALTER TABLE `anvandare`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `anvandarroll`
--
ALTER TABLE `anvandarroll`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `blogg`
--
ALTER TABLE `blogg`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index för tabell `blogginlagg`
--
ALTER TABLE `blogginlagg`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `flaggadblogg`
--
ALTER TABLE `flaggadblogg`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `flaggadkommentar`
--
ALTER TABLE `flaggadkommentar`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `gillningar`
--
ALTER TABLE `gillningar`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `kalender`
--
ALTER TABLE `kalender`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index för tabell `kalenderevent`
--
ALTER TABLE `kalenderevent`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `kommentar`
--
ALTER TABLE `kommentar`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `kundrattigheter`
--
ALTER TABLE `kundrattigheter`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `nekadwikiuppdatering`
--
ALTER TABLE `nekadwikiuppdatering`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `roll`
--
ALTER TABLE `roll`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `sidversion`
--
ALTER TABLE `sidversion`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `tjanst`
--
ALTER TABLE `tjanst`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `wiki`
--
ALTER TABLE `wiki`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index för tabell `wikisidor`
--
ALTER TABLE `wikisidor`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `wikiuppdatering`
--
ALTER TABLE `wikiuppdatering`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `anvandare`
--
ALTER TABLE `anvandare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT för tabell `anvandarroll`
--
ALTER TABLE `anvandarroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT för tabell `blogg`
--
ALTER TABLE `blogg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `blogginlagg`
--
ALTER TABLE `blogginlagg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `flaggadblogg`
--
ALTER TABLE `flaggadblogg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT för tabell `flaggadkommentar`
--
ALTER TABLE `flaggadkommentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `gillningar`
--
ALTER TABLE `gillningar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `kalender`
--
ALTER TABLE `kalender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `kalenderevent`
--
ALTER TABLE `kalenderevent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `kommentar`
--
ALTER TABLE `kommentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `kundrattigheter`
--
ALTER TABLE `kundrattigheter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `nekadwikiuppdatering`
--
ALTER TABLE `nekadwikiuppdatering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `roll`
--
ALTER TABLE `roll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `sidversion`
--
ALTER TABLE `sidversion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `tjanst`
--
ALTER TABLE `tjanst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `wiki`
--
ALTER TABLE `wiki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `wikisidor`
--
ALTER TABLE `wikisidor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT för tabell `wikiuppdatering`
--
ALTER TABLE `wikiuppdatering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
