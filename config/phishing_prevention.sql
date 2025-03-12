-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 12 mars 2025 à 00:05
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `phishing_prevention`
--

-- --------------------------------------------------------

--
-- Structure de la table `characteristics`
--

CREATE TABLE `characteristics` (
  `id` int(11) NOT NULL,
  `phishing_type_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `characteristics`
--

INSERT INTO `characteristics` (`id`, `phishing_type_id`, `content`, `active`) VALUES
(1, 1, 'Liens suspects', 1),
(2, 1, 'Fautes d’orthographe', 1),
(3, 1, 'Urgence artificielle', 1),
(4, 2, 'Ton professionnel', 1),
(5, 2, 'Données personnelles utilisées', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phishing_type_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `phishing_type_id`, `content`, `active`, `created_at`) VALUES
(1, 2, 1, 'J’ai reçu un email comme ça hier, merci pour les infos !', 1, '2025-03-07 14:40:46');

-- --------------------------------------------------------

--
-- Structure de la table `comment_replies`
--

CREATE TABLE `comment_replies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment_replies`
--

INSERT INTO `comment_replies` (`id`, `user_id`, `comment_id`, `content`, `active`, `created_at`) VALUES
(1, 1, 1, 'Fais attention aux pièces jointes aussi !', 1, '2025-03-07 14:40:46');

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` enum('CREATE','UPDATE','DELETE','LOGIN','LOGOUT','VIEW') NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action_type`, `table_name`, `record_id`, `description`, `ip_address`, `created_at`) VALUES
(1, 1, 'LOGIN', 'users', 1, 'Connexion de l’admin', '192.168.1.1', '2025-03-07 14:40:46'),
(2, 2, 'CREATE', 'comments', 1, 'Ajout d’un commentaire sur Email Phishing', '192.168.1.2', '2025-03-07 14:40:46'),
(3, 1, 'CREATE', 'phishing_types', 1, 'Ajout du type Email Phishing', '192.168.1.1', '2025-03-07 14:40:46');

-- --------------------------------------------------------

--
-- Structure de la table `phishing_types`
--

CREATE TABLE `phishing_types` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `phishing_types`
--

INSERT INTO `phishing_types` (`id`, `title`, `description`, `image`, `active`, `created_at`) VALUES
(1, 'Email Phishing', 'Attaque utilisant des emails frauduleux imitant des entités légitimes.', 'email_phishing.jpg', 1, '2025-03-07 14:40:46'),
(2, 'Spear Phishing', 'Phishing ciblé avec des données personnalisées.', 'spear_phishing.jpg', 1, '2025-03-07 14:40:46');

-- --------------------------------------------------------

--
-- Structure de la table `protections`
--

CREATE TABLE `protections` (
  `id` int(11) NOT NULL,
  `phishing_type_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `protections`
--

INSERT INTO `protections` (`id`, `phishing_type_id`, `content`, `active`) VALUES
(1, 1, 'Vérifiez l’expéditeur avant de cliquer sur quoi que ce soit.', 1),
(2, 1, 'Évitez de cliquer sur les liens suspects dans les emails.', 1),
(3, 1, 'Utilisez un filtre antispam pour réduire les risques.', 1),
(4, 2, 'Confirmez toute demande inhabituelle par un autre canal (ex. : téléphone).', 1),
(5, 2, 'Méfiez-vous des emails qui semblent trop personnalisés.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `identity_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `birth_date`, `nationality`, `identity_number`, `email`, `gender`, `password`, `profile_picture`, `role`, `active`, `created_at`) VALUES
(1, 'Dupont', 'Jean', '1980-05-15', 'Française', 'ID123456789', 'admin@example.com', NULL, '$2y$10$YOUR_HASHED_PASSWORD', 'admin_profile.jpg', 'admin', 1, '2025-03-07 14:40:46'),
(2, 'Martin', 'Sophie', '1995-08-22', 'Française', 'ID987654321', 'sophie@example.com', NULL, '$2y$10$USER_HASHED_PASSWORD', 'sophie_profile.jpg', 'user', 1, '2025-03-07 14:40:46'),
(3, 'Crawford', 'Mariam', '1994-03-28', 'Et quis fugiat prae', '443', 'wetaharah@mailinator.com', 'female', '$2y$10$Q0VrecMGIgWQofn0X2b2fOcIrXtEOUWmmmIfXKPKlSYID23vGA.Cu', '67cf10ab2ca23_image.png', 'user', 1, '2025-03-10 16:17:47'),
(4, 'Nelson', 'Irene', '2008-02-24', 'Quo unde suscipit of', '338', 'xajam@mailinator.com', 'female', '$2y$10$MQEh0YsA/Sp/IfPhCYJVVeQ0Bq03vN1Blaf89r2uFYxRUzipM8w/.', '67cf16f64cf56_image.png', 'user', 1, '2025-03-10 16:44:38'),
(5, 'Hood', 'Prescott', '1984-04-11', 'Beatae cillum qui ne', '984', 'ramecox@mailinator.com', 'male', '$2y$10$.urAAMuBo/gPeHH.58rffOOjFasxTgxWfOBPyEgePqwQQdjSfVOda', '67cf4a84e35a2_image.png', 'user', 1, '2025-03-10 20:24:37'),
(6, 'Morin', 'Lewis', '1995-10-30', 'Sint optio tempora ', '768', 'mowecap@mailinator.com', 'female', '$2y$10$SBQBwEHsTHLWDcVJsOBQH.kp7bb2wTlB3WFrXjPi0o185DFsGm11q', '67cf4d753f18a_image.png', 'admin', 1, '2025-03-10 20:37:09');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `characteristics`
--
ALTER TABLE `characteristics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phishing_type_id` (`phishing_type_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `phishing_type_id` (`phishing_type_id`);

--
-- Index pour la table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `phishing_types`
--
ALTER TABLE `phishing_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `protections`
--
ALTER TABLE `protections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phishing_type_id` (`phishing_type_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `identity_number` (`identity_number`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `characteristics`
--
ALTER TABLE `characteristics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `phishing_types`
--
ALTER TABLE `phishing_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `protections`
--
ALTER TABLE `protections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `characteristics`
--
ALTER TABLE `characteristics`
  ADD CONSTRAINT `characteristics_ibfk_1` FOREIGN KEY (`phishing_type_id`) REFERENCES `phishing_types` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`phishing_type_id`) REFERENCES `phishing_types` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD CONSTRAINT `comment_replies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_replies_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `protections`
--
ALTER TABLE `protections`
  ADD CONSTRAINT `protections_ibfk_1` FOREIGN KEY (`phishing_type_id`) REFERENCES `phishing_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
