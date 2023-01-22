-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 jan 2023 om 21:05
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dijkstra_urenregistratie`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id_gebruiker` int(11) NOT NULL,
  `voornaam` varchar(20) NOT NULL,
  `tussenvoegsel` varchar(255) NOT NULL,
  `achternaam` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `secretkey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id_gebruiker`, `voornaam`, `tussenvoegsel`, `achternaam`, `email`, `wachtwoord`, `usertype`, `secretkey`) VALUES
(1, 'Dev', 'Elo', 'Per', 'Developer@dev.nl', '$2y$10$AFkUWwv7PfbpbvMQhuan8ek23rdYSb5jqNJSVejSa0R1K4CHTUOVO', 'admin', 'LOF4TVGGlKF7GK3U');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE `klanten` (
  `id_klant` int(11) NOT NULL,
  `klantnaam` varchar(255) NOT NULL,
  `straatnaam` varchar(255) NOT NULL,
  `huisnummer` varchar(7) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `woonplaats` varchar(50) NOT NULL,
  `telefoonnummer` varchar(10) NOT NULL,
  `archiveer` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projecten`
--

CREATE TABLE `projecten` (
  `id_project` int(11) NOT NULL,
  `id_klant` int(11) NOT NULL,
  `projectnaam` varchar(20) NOT NULL,
  `begindatum` date NOT NULL,
  `laatst_gewerkt` date NOT NULL,
  `archiveer` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uren`
--

CREATE TABLE `uren` (
  `id_uren` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `id_gebruiker` int(11) NOT NULL,
  `id_bonusmedewerker` int(11) DEFAULT NULL,
  `activiteit` varchar(255) NOT NULL,
  `declarabel` varchar(3) NOT NULL,
  `uren` int(11) NOT NULL,
  `begonnen` int(11) NOT NULL,
  `beeindigd` int(11) NOT NULL,
  `datum` date NOT NULL,
  `archiveer` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id_gebruiker`);

--
-- Indexen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`id_klant`);

--
-- Indexen voor tabel `projecten`
--
ALTER TABLE `projecten`
  ADD PRIMARY KEY (`id_project`),
  ADD KEY `klant project link` (`id_klant`);

--
-- Indexen voor tabel `uren`
--
ALTER TABLE `uren`
  ADD PRIMARY KEY (`id_uren`),
  ADD KEY `Project link` (`id_project`),
  ADD KEY `medewerker link` (`id_gebruiker`),
  ADD KEY `bonus medewerker link` (`id_bonusmedewerker`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id_gebruiker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `id_klant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `projecten`
--
ALTER TABLE `projecten`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `uren`
--
ALTER TABLE `uren`
  MODIFY `id_uren` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `projecten`
--
ALTER TABLE `projecten`
  ADD CONSTRAINT `klant project link` FOREIGN KEY (`id_klant`) REFERENCES `klanten` (`id_klant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `uren`
--
ALTER TABLE `uren`
  ADD CONSTRAINT `Project link` FOREIGN KEY (`id_project`) REFERENCES `projecten` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bonus medewerker link` FOREIGN KEY (`id_bonusmedewerker`) REFERENCES `gebruikers` (`id_gebruiker`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medewerker link` FOREIGN KEY (`id_gebruiker`) REFERENCES `gebruikers` (`id_gebruiker`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
