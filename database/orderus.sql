-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: aug. 06, 2019 la 05:47 PM
-- Versiune server: 10.3.16-MariaDB
-- Versiune PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `orderus`
--
CREATE DATABASE IF NOT EXISTS `orderus` DEFAULT CHARACTER SET utf32 COLLATE utf32_general_ci;
USE `orderus`;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `minHealth` int(11) NOT NULL,
  `maxHealth` int(11) NOT NULL,
  `minStrength` int(11) NOT NULL,
  `maxStrength` int(11) NOT NULL,
  `minDefence` int(11) NOT NULL,
  `maxDefence` int(11) NOT NULL,
  `minSpeed` int(11) NOT NULL,
  `maxSpeed` int(11) NOT NULL,
  `minLuck` int(11) NOT NULL,
  `maxLuck` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Eliminarea datelor din tabel `players`
--

INSERT INTO `players` (`id`, `minHealth`, `maxHealth`, `minStrength`, `maxStrength`, `minDefence`, `maxDefence`, `minSpeed`, `maxSpeed`, `minLuck`, `maxLuck`, `name`) VALUES
(1, 70, 100, 70, 80, 45, 55, 40, 50, 10, 30, 'Orderus'),
(2, 60, 90, 60, 90, 40, 60, 40, 60, 25, 40, 'Beast');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `playerskills`
--

DROP TABLE IF EXISTS `playerskills`;
CREATE TABLE `playerskills` (
  `id` int(11) NOT NULL,
  `forPlayer` int(11) NOT NULL,
  `skillName` varchar(255) NOT NULL,
  `skillLuck` int(11) NOT NULL,
  `occurOnAttack` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Eliminarea datelor din tabel `playerskills`
--

INSERT INTO `playerskills` (`id`, `forPlayer`, `skillName`, `skillLuck`, `occurOnAttack`) VALUES
(1, 1, 'Rapid strike', 10, 1),
(2, 1, 'Magic shield', 20, 0);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `playerskills`
--
ALTER TABLE `playerskills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `playerskills`
--
ALTER TABLE `playerskills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
