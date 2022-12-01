-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 nov 2022 om 14:03
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
  `secretkey` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id_gebruiker`, `voornaam`, `tussenvoegsel`, `achternaam`, `email`, `wachtwoord`, `usertype`, `secretkey`, `image`) VALUES
(1, 'Dev', 'Elo', 'Per', 'Developer@dev.nl', '$2y$10$AFkUWwv7PfbpbvMQhuan8ek23rdYSb5jqNJSVejSa0R1K4CHTUOVO', 'admin', 'LOF4TVGGlKF7GK3U', 'profile.jpg'),
(2, 'Tester', 'de', 'Eric', 'test@test.nl', '$2y$10$oA3p6XFPdRrcI6pfMhpa5uoTKBEz./XgfWW/wiPrkNPbXK.OslgR.', 'medewerker', '36KW2Q5SWEHL4MUW', ''),
(3, 'Petra', 'van der', 'meer', 'petra@dijkstraenvanpuffelen.nl', '$2y$10$ZzMULihCbhlLkzkyW/r0oeGDEFzjxfQTZO7ZZ7Owh3/deluLhlBKe', 'non-actief', 'NIKLMJCGP5HFPRML', '');

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
  `telefoonnummer` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`id_klant`, `klantnaam`, `straatnaam`, `huisnummer`, `postcode`, `woonplaats`, `telefoonnummer`) VALUES
(1, 'test', 'test', '124', '1234an', 'test', '0687654321'),
(2, 'klanten', 'klantenstraat', '123', '1234sa', 'klanterije', '0683231385'),
(3, 'pro', 'pro', '234', '3422ds', 'prososoo', '0612346576');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projecten`
--

CREATE TABLE `projecten` (
  `id_project` int(11) NOT NULL,
  `id_klant` int(11) NOT NULL,
  `projectnaam` varchar(20) NOT NULL,
  `begindatum` date NOT NULL,
  `laatst_gewerkt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `projecten`
--

INSERT INTO `projecten` (`id_project`, `id_klant`, `projectnaam`, `begindatum`, `laatst_gewerkt`) VALUES
(1, 2, 'abc', '2022-11-16', '0000-00-00');

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
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id_gebruiker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `id_klant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `projecten`
--
ALTER TABLE `projecten`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `projecten`
--
ALTER TABLE `projecten`
  ADD CONSTRAINT `klant project link` FOREIGN KEY (`id_klant`) REFERENCES `klanten` (`id_klant`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;