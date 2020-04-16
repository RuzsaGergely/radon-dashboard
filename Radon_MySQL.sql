-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2020. Ápr 16. 09:44
-- Kiszolgáló verziója: 8.0.19
-- PHP verzió: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `db2`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jobs`
--

CREATE TABLE `jobs` (
  `tasknum` smallint NOT NULL COMMENT 'ID of the task',
  `servernum` tinyint NOT NULL COMMENT 'ID of the desired server',
  `task` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Assigned task'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `old_jobs`
--

CREATE TABLE `old_jobs` (
  `tasknum` smallint NOT NULL COMMENT 'ID of the task',
  `servernum` tinyint NOT NULL COMMENT 'ID of the desired server',
  `task` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Assigned task'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `server_points`
--

CREATE TABLE `server_points` (
  `servernum` tinyint NOT NULL COMMENT 'ID of the server',
  `t_point` tinyint NOT NULL COMMENT 'Points of Terrorist forces',
  `ct_point` tinyint NOT NULL COMMENT 'Points of Counter-Terrorist forces'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `server_teams`
--

CREATE TABLE `server_teams` (
  `servernum` tinyint NOT NULL COMMENT 'ID of the server',
  `t_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Teamname of the Terrorist forces',
  `ct_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Teamname of the Counter-Terrorist forces'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`tasknum`);

--
-- A tábla indexei `server_points`
--
ALTER TABLE `server_points`
  ADD UNIQUE KEY `UNIQUE` (`servernum`);

--
-- A tábla indexei `server_teams`
--
ALTER TABLE `server_teams`
  ADD UNIQUE KEY `UNIQUE` (`servernum`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `jobs`
--
ALTER TABLE `jobs`
  MODIFY `tasknum` smallint NOT NULL AUTO_INCREMENT COMMENT 'ID of the task';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
