-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 17 juin 2019 à 05:44
-- Version du serveur :  10.1.31-MariaDB
-- Version de PHP :  7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `votesystem`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'codeprojects', '$2y$10$g4m/PfziRBxoM9fvwqiS9OgxAV29w0y8..XHruyEplYPxYnhZJ6bC', 'Code', 'Projects', 'avatar.png', '2018-04-02');

-- --------------------------------------------------------

--
-- Structure de la table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `platform` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `firstname`, `lastname`, `photo`, `platform`) VALUES
(18, 9, 'Josh ', 'Brolin', 'thanossmile.jpg', 'Marvel Cinematic Universe'),
(19, 9, 'Tom', 'Hiddleston', 'AvengerIW4 (2).jpg', 'Marvel Cinematic Universe'),
(20, 9, 'James', 'Spader', 'ultron.jpg', 'Marvel Cinematic Universe'),
(21, 9, 'Cate', 'Blanchett', 'hela.jpg', 'Marvel Cinematic Universe'),
(22, 9, 'Michael B', 'Jordan', 'killmongr.jpg', 'Marvel Cinematic Universe'),
(23, 9, 'Hugo', 'Weaving', 'reddd.jpg', 'Marvel Cinematic Universe'),
(24, 9, 'Tom', 'Vaughan', 'ebony.jpg', 'Marvel Cinematic Universe'),
(25, 8, 'Mark', 'Doe', 'mask.jpg', 'Sample ...............'),
(26, 8, 'Bruno', 'Jr', 'Opi51c74ead38850.png', 'Sample ..');

-- --------------------------------------------------------

--
-- Structure de la table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `max_vote` int(11) NOT NULL,
  `time_out_date` datetime DEFAULT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `positions`
--

INSERT INTO `positions` (`id`, `description`, `max_vote`, `time_out_date`, `priority`) VALUES
(8, 'Sample', 5, '2019-06-19 00:00:00', 2),
(9, 'Best Villian - MCU Actors', 5, '2019-06-18 05:13:50', 1),
(10, 'Test', 2, '2019-06-19 00:00:00', 3),
(11, 'dffs', 5, '2019-06-18 03:02:00', 4);

-- --------------------------------------------------------

--
-- Structure de la table `voters`
--

CREATE TABLE `voters` (
  `id` int(11) NOT NULL,
  `voters_id` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `photo`) VALUES
(5, 'pSMQYCjWk5dnmaD', '$2y$10$BhnhcZfQ40Bufse7yKqjoOu0/G4BuqZu2z8It5XpSUcKuTPhMcPxa', 'Harry', 'Den', 'dealer-logo.jpg'),
(6, 'Is92CPnGcvOy4ue', '$2y$10$2eF0UGUbOcH8L1ny0qXE0uw8pMJMNUUozoYSJw0ZXKGlZx8rYDuea', 'Tony', 'Jr', 'favicon.png'),
(7, 'gwvIniKqT5xsWJc', '$2y$10$wY1VSzxdR1X9RpSo3oKodumhkFihorsT2K1zausafYiNnnqYqscje', 'Danny', 'Hill', 'TROLLFACE-DEAL-WITH-IT.png'),
(8, 'IpqGblR7m6tQFhz', '$2y$10$3ov.kMMWqHBO8KBtjix6p.hw642C7Y5w/.r.OGU4VQRiG3qtvRji2', 'Tom', 'Lee', 'e360bc98dbb4441f73d253f90723d9a4.jpg'),
(9, 'fxdNBZ5hoi87rqI', '$2y$10$zrjd/OWccwoGfGA1Uh2moOSEfraxe7ozQt30thOGoYWupwmliVyDC', 'Logan', 'Paul', 'male2.png'),
(10, 'fpivPIEFjTL3qZ5', '$2y$10$SOTAHllEO.CrqSewCSHK4.g9w1xbmbOkiCsbulmrzXn/XlPSMjtlG', 'Angelina', 'Stone', 'female3.jpg'),
(11, 'KkMWRcTZPf7xNgU', '$2y$10$ZYpT8rgNn/ohBX1xx2DU6.QMCSjasqJNTRHpkJ/mFUPCGTk6wLOzW', 'James', 'Cooper', 'male.png'),
(12, 'syG6zQqTNDChdZ1', '$2y$10$iqhdKLw3VAopiEprzWM4letKheG23V.MYrAa330SmfdYE7bbuNFuO', 'Christine', 'Taylor', 'female4.jpg'),
(13, 'KPCDpH5TltFIkAB', '$2y$10$eMVtYY6tGlrhZuSQl7CYXebiS66gT8nuo6pLCk1DMKWI9M0iwABJm', 'Sophia', 'Turner', 'female.jpg'),
(14, 'pCPEeQjhu4KD6MO', '$2y$10$7kUrF.nydR2FZqxaTi1Qze.H.Ef7mSaWbJrH3VZ1FJoCqhKPEv7ZS', 'Martin', 'Gray', 'mask.jpg'),
(15, 'lAk28ZYIDhc1Knx', '$2y$10$jBJ7LbyEXa7E/bwW0lBmHu38Pa8o.bX2WyFxk3Zn3Gk5LbvSe1XMO', 'Thom', 'Yorke', 'profile.jpg'),
(16, 'lqyvXeC1ZIkbJHN', '$2y$10$8kW.nLUiUCrfnpK6.D.Fre40G0PvqgMwJD7hf/XVVm4.lEE.h3fRy', 'William', 'Carter', 'profile.jpg'),
(17, '8MGHvWJAI2CfeuU', '$2y$10$y1OqYFUHAbkCgWl/vTHoh.dcLyPInG0rXBiN3XXpT5fEBx215sf8.', 'Wilson', 'Cooper', 'profile.jpg'),
(18, 'GDYLaWCmnbz95Ai', '$2y$10$GPUY.tTVy71LVsd.oYPVROqS.dObrPAHpXtFM4R6nRcvytmz8YB6C', 'Mouad', 'ZIANI', '');

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `voters_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `votes`
--

INSERT INTO `votes` (`id`, `voters_id`, `candidate_id`, `position_id`) VALUES
(374, 16, 26, 8),
(375, 16, 19, 9),
(376, 18, 19, 9),
(377, 18, 25, 8);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
