-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: Po 15.Máj 2023, 22:14
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
  `task` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `question` varchar(1000) COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `imageTask` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `solution` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `latexFile` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `date` date DEFAULT NULL,
  `canGenerate` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `equation`
--

INSERT INTO `equation` (`task`, `question`, `imageTask`, `solution`, `latexFile`, `date`, `canGenerate`) VALUES
(NULL, '\n    Nájdite prenosovú funkciu $F(s)=\\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou: \n\n    \n', '/var/www/site112.webte.fei.stuba.sk/zaverecne-zadanie/blokovka01_00002.jpg', '\n    \\begin{equation*}\n        \\dfrac{2s^2+13s+10}{s^3+7s^2+18s+15}\n    \\end{equation*}\n', 'blokovka01pr.tex', '2023-05-15', 1),
(NULL, '\n    Nájdite prenosovú funkciu $F(s)=\\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou: \n\n    \n', '/var/www/site112.webte.fei.stuba.sk/zaverecne-zadanie/blokovka01_00003.jpg', '\n    \\begin{equation*}\n        \\dfrac{7s+10}{2s^3+11s^2+12s+10}\n    \\end{equation*}\n', 'blokovka01pr.tex', '2023-05-15', 1),
(NULL, '\n    Nájdite prenosovú funkciu $F(s)=\\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou: \n\n    \n', '/var/www/site112.webte.fei.stuba.sk/zaverecne-zadanie/blokovka01_00004.jpg', '\n    \\begin{equation*}\n        4\\dfrac{3s+1}{s^3+10s^2+13s+14}\n    \\end{equation*}\n', 'blokovka01pr.tex', '2023-05-15', 1);

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
  `user_type` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `login`, `password`, `2fa_code`, `created_at`, `updated_at`, `user_type`) VALUES
(1, 'Tomáš Jenčík', 'xjencikt@stuba.sk', 'xjenciktstudent', '$argon2id$v=19$m=65536,t=4,p=1$R3YyMnVwckNpQzg2dldMZQ$3nbKIGX3z84OtHWMBC2X4WQx3XfBhVVJgVssrPO8FCQ', '5EWSV5CI5GE4T4LO', '2023-05-15 13:14:16', '2023-05-15 13:14:16', 'student'),
(2, 'Tomáš Jenčík', 'abba@stuba.sk', 'xjenciktucitel', '$argon2id$v=19$m=65536,t=4,p=1$TUN6dlU2cGNPN2oxOGFEVA$T2vOS5+YWeEHR4Hu2QCJubbixpCeB0U/7G9mqW61Zv4', '7CONSCKVYF2OVM3V', '2023-05-15 13:23:15', '2023-05-15 13:23:15', 'teacher'),
(3, 'Martin Hajdučko', 'xhajducko@stuba.sk', 'xhajducko', '$argon2id$v=19$m=65536,t=4,p=1$NThVUm9sWjRuMmpnT3FkWQ$idIk/Er78Yg+utE3uee0ph93rGIzTGpjqtW9U/FO0CI', 'LZHPFGTIQXL5LBY4', '2023-05-15 17:40:08', '2023-05-15 17:40:08', 'student'),
(4, 'Martin Hajdučko', 'a@b.com', 'hajdyUcitel', '$argon2id$v=19$m=65536,t=4,p=1$bHJTeXRVcVA3RWQvcVFHMg$CWuWd2LGfcNODXEqLMra1r3KcsT3MedcA3mEj9UAFVY', 'JNHD4Y2AY25GZR6H', '2023-05-15 18:07:31', '2023-05-15 18:07:31', 'teacher');
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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
