-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Värd: localhost
-- Tid vid skapande: 31 okt 2019 kl 14:26
-- Serverversion: 10.4.8-MariaDB
-- PHP-version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `TheProvider`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `anvandare`
--

CREATE TABLE `anvandare` (
  `id` int(11) NOT NULL,
  `losenord` varchar(70) NOT NULL,
  `salt` varchar(30) NOT NULL,
  `anamn` varchar(25) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `anvandare`
--

INSERT INTO `anvandare` (`id`, `losenord`, `salt`, `anamn`, `email`, `aktiv`) VALUES
(1, '$2a$10$Ubh1SH9evigYQTfZW9zL$.7QZIaTCKmiunuY0nb1M0y/UOpRejLmu', 'Ubh1SH9evigYQTfZW9zL', 'hugomeister1', 'hugo.malmstrom@hotmail.se', 1);

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
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `api`
--

CREATE TABLE `api` (
  `id` int(11) NOT NULL,
  `rattighetId` int(11) NOT NULL,
  `nyckel` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `api`
--

INSERT INTO `api` (`id`, `rattighetId`, `nyckel`) VALUES
(1, 1, 'JIOAJWWNPA259FB2');

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
  `slutTid` datetime NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `event`
--

INSERT INTO `event` (`id`, `skapadAv`, `titel`, `innehall`, `startTid`, `slutTid`, `aktiv`) VALUES
(1, 1, 'Picknick med Morsan', 'Ska ?ta lite bullar med morsan', '2019-10-15 15:00:00', '2019-10-15 20:00:00', 1),
(2, 12, 'Picknick med Morsan', 'Ska ?ta lite bullar med morsan', '2019-10-16 12:00:00', '2019-10-16 12:30:03', 1),
(3, 12, 'Picknick med Tjejen', 'Ska ?ta lite bullar med tjejen', '2019-10-25 14:00:00', '2019-10-25 14:00:05', 1),
(4, 1, 'M?te med Chefen', 'Ska ?ta lite bullar med Chefen', '2019-10-27 09:00:00', '2019-10-28 14:30:00', 1),
(5, 12, 'Picknick med hunden', 'Ska ?ta lite bullar och kasta till hunden', '2019-10-19 18:00:00', '2019-10-19 19:30:00', 1),
(6, 1, 'Picknick med Morsan *igen*', 'Ska ?ta lite bullar med morsan *sigh*', '2019-10-31 14:33:30', '2019-10-31 15:49:27', 1);

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

--
-- Dumpning av Data i tabell `flaggadkommentar`
--

INSERT INTO `flaggadkommentar` (`id`, `kommentarId`, `anvandarId`) VALUES
(1, 3, 1),
(2, 4, 1),
(3, 1, 1);

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
  `eventId` int(11) NOT NULL,
  `anledning` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `kalenderevent`
--

INSERT INTO `kalenderevent` (`id`, `kalenderId`, `eventId`, `anledning`, `status`) VALUES
(1, 1, 1, '', 0),
(2, 1, 2, '', 0),
(3, 2, 3, '', 0),
(4, 1, 4, '', 0),
(5, 2, 5, '', 0),
(6, 1, 6, '', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `kalendersida`
--

CREATE TABLE `kalendersida` (
  `id` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL,
  `kalenderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `kalendersida`
--

INSERT INTO `kalendersida` (`id`, `anvandarId`, `kalenderId`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `kommentar`
--

CREATE TABLE `kommentar` (
  `id` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL,
  `inlaggId` int(11) NOT NULL,
  `hierarkiId` int(11) NOT NULL DEFAULT 0,
  `innehall` varchar(2000) NOT NULL,
  `redigerad` tinyint(4) NOT NULL DEFAULT 0,
  `censurerad` tinyint(4) NOT NULL DEFAULT 0
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
  `tjanst` tinyint(4) NOT NULL DEFAULT 0,
  `superadmin` tinyint(4) NOT NULL DEFAULT 0,
  `kontoId` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `kundrattigheter`
--

INSERT INTO `kundrattigheter` (`id`, `tjanst`, `superadmin`, `kontoId`) VALUES
(1, 1, 1, 1);

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
(1, 2, 0, 10, 4, 'Vapen under andra v?rldskriget', 'vapen d?dar', 'Du är fel', '2019-10-16');

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
(5, 1, 10, 4, 'Vapen under andra v?rldskriget', 'vapen d?dar', '2019-10-09'),
(6, 1, 1, 10, 'Vapen under andra v?rldskriget', 'vapen d?dar', '2019-10-23'),
(7, 1, 1, 11, 'Julafton', 'Julafton firas den 24 december, f?rutom i USA d?r den firas den 25 december', '2019-10-29');

-- --------------------------------------------------------

--
-- Tabellstruktur `tjanst`
--

CREATE TABLE `tjanst` (
  `id` int(11) NOT NULL,
  `anvandarId` int(11) NOT NULL,
  `titel` varchar(70) NOT NULL,
  `privat` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tjanst`
--

INSERT INTO `tjanst` (`id`, `anvandarId`, `titel`, `privat`) VALUES
(1, 1, 'Polkis Blogg', 1),
(2, 1, 'Glada Snickaren', 0),
(3, 1, 'Polkis Kalender', 1),
(4, 1, 'Wikihow-Ripoff', 0),
(5, 1, 'Minecraft-Wiki', 0),
(6, 1, 'EngrishKalender', 1),
(7, 1, 'Allt om Malmström', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `tp_admin`
--

CREATE TABLE `tp_admin` (
  `id` int(11) NOT NULL,
  `anamn` varchar(25) NOT NULL,
  `losenord` varchar(70) NOT NULL,
  `salt` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tp_admin`
--

INSERT INTO `tp_admin` (`id`, `anamn`, `losenord`, `salt`) VALUES
(1, 'admin', '$2a$10$Ubh1SH9evigYQTfZW9zL$.34YYNmunJxBzNRJEwU/./BqsF1TimHK', 'Ubh1SH9evigYQTfZW9zL');

-- --------------------------------------------------------

--
-- Tabellstruktur `wiki`
--

CREATE TABLE `wiki` (
  `id` int(11) NOT NULL,
  `tjanstId` int(11) NOT NULL,
  `dolt` tinyint(4) NOT NULL DEFAULT 0
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
  `dolt` tinyint(4) NOT NULL DEFAULT 0,
  `last` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `wikisidor`
--

INSERT INTO `wikisidor` (`id`, `wikiId`, `godkantAv`, `bidragsgivare`, `titel`, `innehall`, `datum`, `dolt`, `last`) VALUES
(1, 3, 1, 11, 'Julafton', 'Julafton firas den 24 december, f?rutom i USA d?r den firas den 25 december', '2019-10-29', 0, 0),
(5, 3, 3, 11, 'Gr?na potatisar ?r giftiga', 'De innh?ller ett gift som kan d?da!', '2019-10-25', 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `wikiuppdatering`
--

CREATE TABLE `wikiuppdatering` (
  `id` int(11) NOT NULL,
  `wikiId` int(11) NOT NULL,
  `sidId` int(11) NOT NULL DEFAULT 0,
  `bidragsgivare` int(11) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `innehall` text NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `wikiuppdatering`
--

INSERT INTO `wikiuppdatering` (`id`, `wikiId`, `sidId`, `bidragsgivare`, `titel`, `innehall`, `datum`) VALUES
(5, 3, 5, 1, 'Hot Maymays', 'Jag vet inte vad vi gör längre... Plox Help!!!', '2019-10-30'),
(6, 3, 1, 1, 'Låtar som aldrig borde pratas om', 'Wake Me Up med Långben', '2019-10-28');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `anvandare_anvandarroll` (`anvandarId`);

--
-- Index för tabell `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `blogg`
--
ALTER TABLE `blogg`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tjanst_blogg` (`tjanstId`);

--
-- Index för tabell `blogginlagg`
--
ALTER TABLE `blogginlagg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogg_blogginlagg` (`bloggId`);

--
-- Index för tabell `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `flaggadblogg`
--
ALTER TABLE `flaggadblogg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogg_flaggadblogg` (`bloggId`);

--
-- Index för tabell `flaggadkommentar`
--
ALTER TABLE `flaggadkommentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kommentar_flaggadkommentar` (`kommentarId`);

--
-- Index för tabell `gillningar`
--
ALTER TABLE `gillningar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anvandare_gillningar` (`anvandarId`),
  ADD KEY `blogginlagg_gillningar` (`inlaggId`);

--
-- Index för tabell `kalender`
--
ALTER TABLE `kalender`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tjanst_kalender` (`tjanstId`);

--
-- Index för tabell `kalenderevent`
--
ALTER TABLE `kalenderevent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kalender_kalenderevent` (`kalenderId`),
  ADD KEY `event_kalenderevent` (`eventId`);

--
-- Index för tabell `kalendersida`
--
ALTER TABLE `kalendersida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anvandare_kalendersida` (`anvandarId`),
  ADD KEY `kalender_kalendersida` (`kalenderId`);

--
-- Index för tabell `kommentar`
--
ALTER TABLE `kommentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogginlagg_kommentar` (`inlaggId`);

--
-- Index för tabell `kundrattigheter`
--
ALTER TABLE `kundrattigheter`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `nekadwikiuppdatering`
--
ALTER TABLE `nekadwikiuppdatering`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wiki_nekadwikiuppdatering` (`wikiId`);

--
-- Index för tabell `roll`
--
ALTER TABLE `roll`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `sidversion`
--
ALTER TABLE `sidversion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wikisidor_sidversion` (`sidId`);

--
-- Index för tabell `tjanst`
--
ALTER TABLE `tjanst`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anvandare_tjanst` (`anvandarId`);

--
-- Index för tabell `tp_admin`
--
ALTER TABLE `tp_admin`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `wiki`
--
ALTER TABLE `wiki`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tjanst_wiki` (`tjanstId`);

--
-- Index för tabell `wikisidor`
--
ALTER TABLE `wikisidor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wiki_wikisidor` (`wikiId`);

--
-- Index för tabell `wikiuppdatering`
--
ALTER TABLE `wikiuppdatering`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wikidisor_wikiuppdatering` (`sidId`),
  ADD KEY `wiki_wikiuppdatering` (`wikiId`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `anvandare`
--
ALTER TABLE `anvandare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `anvandarroll`
--
ALTER TABLE `anvandarroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `api`
--
ALTER TABLE `api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT för tabell `kalendersida`
--
ALTER TABLE `kalendersida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `kommentar`
--
ALTER TABLE `kommentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `nekadwikiuppdatering`
--
ALTER TABLE `nekadwikiuppdatering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `roll`
--
ALTER TABLE `roll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `sidversion`
--
ALTER TABLE `sidversion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `tjanst`
--
ALTER TABLE `tjanst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `tp_admin`
--
ALTER TABLE `tp_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `wiki`
--
ALTER TABLE `wiki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `wikisidor`
--
ALTER TABLE `wikisidor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `wikiuppdatering`
--
ALTER TABLE `wikiuppdatering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `anvandarroll`
--
ALTER TABLE `anvandarroll`
  ADD CONSTRAINT `anvandare_anvandarroll` FOREIGN KEY (`anvandarId`) REFERENCES `anvandare` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `blogg`
--
ALTER TABLE `blogg`
  ADD CONSTRAINT `tjanst_blogg` FOREIGN KEY (`tjanstId`) REFERENCES `tjanst` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `blogginlagg`
--
ALTER TABLE `blogginlagg`
  ADD CONSTRAINT `blogg_blogginlagg` FOREIGN KEY (`bloggId`) REFERENCES `blogg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `flaggadblogg`
--
ALTER TABLE `flaggadblogg`
  ADD CONSTRAINT `blogg_flaggadblogg` FOREIGN KEY (`bloggId`) REFERENCES `blogg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `flaggadkommentar`
--
ALTER TABLE `flaggadkommentar`
  ADD CONSTRAINT `kommentar_flaggadkommentar` FOREIGN KEY (`kommentarId`) REFERENCES `kommentar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `gillningar`
--
ALTER TABLE `gillningar`
  ADD CONSTRAINT `anvandare_gillningar` FOREIGN KEY (`anvandarId`) REFERENCES `anvandare` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blogginlagg_gillningar` FOREIGN KEY (`inlaggId`) REFERENCES `blogginlagg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `kalender`
--
ALTER TABLE `kalender`
  ADD CONSTRAINT `tjanst_kalender` FOREIGN KEY (`tjanstId`) REFERENCES `tjanst` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `kalenderevent`
--
ALTER TABLE `kalenderevent`
  ADD CONSTRAINT `event_kalenderevent` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kalender_kalenderevent` FOREIGN KEY (`kalenderId`) REFERENCES `kalender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `kalendersida`
--
ALTER TABLE `kalendersida`
  ADD CONSTRAINT `anvandare_kalendersida` FOREIGN KEY (`anvandarId`) REFERENCES `anvandare` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kalender_kalendersida` FOREIGN KEY (`kalenderId`) REFERENCES `kalender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `kommentar`
--
ALTER TABLE `kommentar`
  ADD CONSTRAINT `blogginlagg_kommentar` FOREIGN KEY (`inlaggId`) REFERENCES `blogginlagg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `nekadwikiuppdatering`
--
ALTER TABLE `nekadwikiuppdatering`
  ADD CONSTRAINT `wiki_nekadwikiuppdatering` FOREIGN KEY (`wikiId`) REFERENCES `wiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `sidversion`
--
ALTER TABLE `sidversion`
  ADD CONSTRAINT `wikisidor_sidversion` FOREIGN KEY (`sidId`) REFERENCES `wikisidor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `tjanst`
--
ALTER TABLE `tjanst`
  ADD CONSTRAINT `anvandare_tjanst` FOREIGN KEY (`anvandarId`) REFERENCES `anvandare` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `wiki`
--
ALTER TABLE `wiki`
  ADD CONSTRAINT `tjanst_wiki` FOREIGN KEY (`tjanstId`) REFERENCES `tjanst` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `wikisidor`
--
ALTER TABLE `wikisidor`
  ADD CONSTRAINT `wiki_wikisidor` FOREIGN KEY (`wikiId`) REFERENCES `wiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `wikiuppdatering`
--
ALTER TABLE `wikiuppdatering`
  ADD CONSTRAINT `wiki_wikiuppdatering` FOREIGN KEY (`wikiId`) REFERENCES `wiki` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wikidisor_wikiuppdatering` FOREIGN KEY (`sidId`) REFERENCES `wikisidor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
