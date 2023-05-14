-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: Sun 14.Máj 2023, 19:20
-- Verzia serveru: 8.0.32-0ubuntu0.22.04.2
-- Verzia PHP: 8.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `zadanie5`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `equation`
--

CREATE TABLE `equation` (
  `task` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `solution` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `latexFile` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `fullname` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `login` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `password` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `2fa_code` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` varchar(64) COLLATE utf8mb4_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `login`, `password`, `2fa_code`, `created_at`, `updated_at`, `user_type`) VALUES
(11, 'Tomáš Jenčík', 'xjencik@stuba.sk', 'xjencik', '$argon2id$v=19$m=65536,t=4,p=1$UC9aQUY2b1l3aHllMXVMNA$yLKDns4//hc024x4kv9tUXw6Grgzpyx2xwDMRlEb0Oc', 'AZH245DH2VZG2IS4', '2023-05-13 15:22:50', '2023-05-13 15:22:50', ''),
(14, 'Jakub Taňkoš', 'xtankos@stuba.sk', 'xtankos', '$argon2id$v=19$m=65536,t=4,p=1$azNWMjVlb21JTHNvUXBsYw$hDDpiMAUPTZWYqBQMLBHTncr0veM1o/6XMUpoNAQv3w', 'ONM5SDRICKZJ4RCH', '2023-05-14 19:18:17', '2023-05-14 19:18:17', 'student');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
