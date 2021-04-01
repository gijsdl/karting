-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 01 apr 2021 om 12:22
-- Serverversie: 10.4.17-MariaDB
-- PHP-versie: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karting`
--
CREATE DATABASE IF NOT EXISTS `karting` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `karting`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activiteiten`
--

DROP TABLE IF EXISTS `activiteiten`;
CREATE TABLE `activiteiten` (
  `id` int(11) NOT NULL,
  `soort_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `max_deelnemers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `activiteiten`
--

INSERT INTO `activiteiten` (`id`, `soort_id`, `datum`, `tijd`, `max_deelnemers`) VALUES
(1, 1, '2021-04-26', '09:00:00', 5),
(2, 4, '2021-04-26', '10:00:00', 5),
(3, 2, '2021-04-26', '11:00:00', 5),
(4, 1, '2021-05-03', '09:00:00', 5),
(5, 4, '2021-05-03', '10:00:00', 5),
(6, 2, '2021-05-03', '00:00:00', 5),
(7, 1, '2021-06-06', '09:00:00', 5),
(8, 1, '2021-06-06', '10:00:00', 5),
(9, 4, '2021-06-06', '11:00:00', 5),
(10, 4, '2021-06-13', '11:30:00', 5),
(11, 1, '2021-06-13', '12:00:00', 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `app_users`
--

DROP TABLE IF EXISTS `app_users`;
CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voorletters` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tussenvoegsel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `achternaam` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adres` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `woonplaats` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefoon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `roles`, `password`, `email`, `voorletters`, `tussenvoegsel`, `achternaam`, `adres`, `postcode`, `woonplaats`, `telefoon`) VALUES
(1, 'gijsdl', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$Q1lKQXM4Ti5Jc2hvTzZ3TQ$x0D8sao93PWCbJNmN5s5kkmNN3yDrQ7EYw+qxV2VwNo', 'gijs.de.lange@live.nl', 'G.', 'de', 'Lange', 'luxemburgstraat 11', '2552RA', 'Den Haag', '06-25458978'),
(2, 'ravo', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$Zi9Pekt6bVZQOUouMnJtQQ$+oSBjlf8eiHnvUK3NCieoTbYk/nG3s1srPl1WymCAm0', 'gijs.de.lange@live.nl', 'R.', 'de', 'Lange', 'luxemburgstraat 11', '2552RA', 'Den Haag', '06-25458978');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `app_users_activiteiten`
--

DROP TABLE IF EXISTS `app_users_activiteiten`;
CREATE TABLE `app_users_activiteiten` (
  `app_users_id` int(11) NOT NULL,
  `activiteiten_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `app_users_activiteiten`
--

INSERT INTO `app_users_activiteiten` (`app_users_id`, `activiteiten_id`) VALUES
(2, 11);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20210318105324', '2021-03-25 12:05:05'),
('20210325135543', '2021-03-25 13:56:04'),
('20210401101019', '2021-04-01 10:10:29');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `soort_activiteiten`
--

DROP TABLE IF EXISTS `soort_activiteiten`;
CREATE TABLE `soort_activiteiten` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_leeftijd` int(11) NOT NULL,
  `tijdsduur` int(11) NOT NULL,
  `prijs` decimal(6,2) NOT NULL,
  `beschrijving` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `soort_activiteiten`
--

INSERT INTO `soort_activiteiten` (`id`, `naam`, `min_leeftijd`, `tijdsduur`, `prijs`, `beschrijving`) VALUES
(1, 'Vrije training', 12, 15, '15.00', 'Dit is een vrije training'),
(2, 'Grand Prix', 12, 60, '50.00', 'Dit is de grand Prix'),
(3, 'Endurance race', 16, 90, '65.00', 'Dit is de endurance race'),
(4, 'Kinder race', 8, 10, '18.00', 'Dit is de kinder race'),
(6, 'Senioren race', 45, 30, '15.50', 'Zo veel mogelijk rondjes rijden'),
(7, 'Duo race', 16, 45, '20.00', 'Deelnemers worden aan elkaar gekoppeld. De langzaamste deelnemer bepaald de positie op de scorelijst');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `activiteiten`
--
ALTER TABLE `activiteiten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1C50895F3DEE50DF` (`soort_id`);

--
-- Indexen voor tabel `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`);

--
-- Indexen voor tabel `app_users_activiteiten`
--
ALTER TABLE `app_users_activiteiten`
  ADD PRIMARY KEY (`app_users_id`,`activiteiten_id`),
  ADD KEY `IDX_2F05642B6F33D490` (`app_users_id`),
  ADD KEY `IDX_2F05642B808BDE57` (`activiteiten_id`);

--
-- Indexen voor tabel `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `soort_activiteiten`
--
ALTER TABLE `soort_activiteiten`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `activiteiten`
--
ALTER TABLE `activiteiten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `soort_activiteiten`
--
ALTER TABLE `soort_activiteiten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `activiteiten`
--
ALTER TABLE `activiteiten`
  ADD CONSTRAINT `FK_1C50895F3DEE50DF` FOREIGN KEY (`soort_id`) REFERENCES `soort_activiteiten` (`id`);

--
-- Beperkingen voor tabel `app_users_activiteiten`
--
ALTER TABLE `app_users_activiteiten`
  ADD CONSTRAINT `FK_2F05642B6F33D490` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2F05642B808BDE57` FOREIGN KEY (`activiteiten_id`) REFERENCES `activiteiten` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
