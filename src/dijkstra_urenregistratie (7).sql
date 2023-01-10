-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 jan 2023 om 00:15
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
(1, 'Dev', 'Elo', 'Per', 'Developer@dev.nl', '$2y$10$AFkUWwv7PfbpbvMQhuan8ek23rdYSb5jqNJSVejSa0R1K4CHTUOVO', 'admin', 'LOF4TVGGlKF7GK3U'),
(2, 'Tester', 'de', 'Eric', 'test@test.nl', '$2y$10$oA3p6XFPdRrcI6pfMhpa5uoTKBEz./XgfWW/wiPrkNPbXK.OslgR.', 'medewerker', '36KW2Q5SWEHL4MUW'),
(3, 'Petra', 'van der', 'meer', 'petra@dijkstraenvanpuffelen.nl', '$2y$10$ZzMULihCbhlLkzkyW/r0oeGDEFzjxfQTZO7ZZ7Owh3/deluLhlBKe', 'non-actief', 'NIKLMJCGP5HFPRML');

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

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`id_klant`, `klantnaam`, `straatnaam`, `huisnummer`, `postcode`, `woonplaats`, `telefoonnummer`, `archiveer`) VALUES
(1, 'test', 'test', '124', '1234an', 'test', '0687654321', 'nee'),
(2, 'klanten', 'klantenstraat', '123', '1234sa', 'klanterije', '0683231385', 'nee'),
(3, 'pro', 'pro', '234', '3422ds', 'prososoo', '0612346576', 'nee');

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

--
-- Gegevens worden geëxporteerd voor tabel `projecten`
--

INSERT INTO `projecten` (`id_project`, `id_klant`, `projectnaam`, `begindatum`, `laatst_gewerkt`, `archiveer`) VALUES
(1, 2, 'res', '2022-11-16', '2023-01-10', 'nee'),
(2, 2, 'abvc', '2022-12-15', '2022-12-18', 'nee'),
(7, 1, 'ssssssssssssssssssss', '2022-12-31', '2023-01-08', 'nee');

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
-- Gegevens worden geëxporteerd voor tabel `uren`
--

INSERT INTO `uren` (`id_uren`, `id_project`, `id_gebruiker`, `id_bonusmedewerker`, `activiteit`, `declarabel`, `uren`, `begonnen`, `beeindigd`, `datum`, `archiveer`) VALUES
(1, 1, 1, NULL, 'prodoeodkemdmsd', 'ja', 0, 0, 0, '2022-12-18', 'nee'),
(4, 1, 1, NULL, 'prodemnt', 'ja', 16320, 50220, 64920, '2022-12-15', 'nee'),
(5, 1, 1, NULL, 'prodemnt', 'ja', 16320, 50220, 64920, '2022-12-15', 'nee'),
(6, 1, 1, NULL, 'prodenmstasdad', 'ja', 36000, 45480, 84360, '2022-12-12', 'nee'),
(7, 1, 2, NULL, 'testeranens', 'nee', 14400, 61380, 76080, '2022-12-31', 'nee'),
(8, 1, 2, NULL, 'testeranens', 'ja', 14400, 61380, 76080, '2022-12-31', 'nee'),
(9, 1, 1, 2, 'nunu', 'ja', 4980, 0, 0, '2022-12-25', 'nee'),
(14, 1, 1, NULL, 'ppppppppppppppppppppppppppppp', 'ja', 46740, 0, 0, '2023-01-10', 'nee');

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
  MODIFY `id_gebruiker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `id_klant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `projecten`
--
ALTER TABLE `projecten`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `uren`
--
ALTER TABLE `uren`
  MODIFY `id_uren` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
