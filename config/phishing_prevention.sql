-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 14 mars 2025 à 18:15
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
(1, 1, 'L’email semble provenir d’une entité de confiance (banque, service client, administration).', 1),
(2, 1, 'Contient un lien menant à un site web frauduleux imitant un site légitime.', 1),
(3, 1, 'Utilisation d’un ton urgent pour pousser l’utilisateur à agir rapidement (ex: \"Votre compte sera bloqué dans 24h\").', 1),
(4, 1, 'Peut contenir des pièces jointes malveillantes (ex: faux PDF de facture).', 1),
(5, 2, 'L’email est personnalisé avec des informations spécifiques sur la cible (nom, entreprise, poste).', 1),
(6, 2, 'Souvent envoyé depuis une adresse qui semble légitime mais qui est en réalité falsifiée.', 1),
(7, 3, 'Appels provenant de numéros masqués ou inconnus.', 1),
(8, 3, 'L’attaquant se fait parfois passer pour un collègue ou un supérieur hiérarchique.', 1);

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
(5, 2, 1, 'je suis un commentaire', 1, '2025-03-12 16:57:44');

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

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` enum('CREATE','UPDATE','DELETE','LOGIN','LOGOUT','VIEW','ACTIVATE') NOT NULL,
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
(1, 1, 'CREATE', 'users', 1, 'Inscription de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-12 14:53:40'),
(2, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-12 14:55:27'),
(3, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-12 15:30:45'),
(4, 1, 'CREATE', 'phishing_types', 1, 'Création du type de phishing : Phishing par email', '127.0.0.1', '2025-03-12 15:41:03'),
(5, 1, 'CREATE', 'phishing_types', 2, 'Création du type de phishing : Spear Phishing', '127.0.0.1', '2025-03-12 15:47:51'),
(6, 1, 'CREATE', 'phishing_types', 3, 'Création du type de phishing : Phishing par Téléphone (Vishing)', '127.0.0.1', '2025-03-12 16:10:47'),
(7, 2, 'CREATE', 'users', 2, 'Inscription de l\'utilisateur : nacyhulata@mailinator.com', '127.0.0.1', '2025-03-12 16:48:31'),
(8, 2, 'LOGIN', 'users', 2, 'Connexion de l\'utilisateur : nacyhulata@mailinator.com', '127.0.0.1', '2025-03-12 16:48:57'),
(9, 2, 'LOGIN', 'users', 2, 'Connexion de l\'utilisateur : nacyhulata@mailinator.com', '127.0.0.1', '2025-03-12 16:57:28'),
(10, 3, 'CREATE', 'users', 3, 'Inscription de l\'utilisateur : baheb@mailinator.com', '127.0.0.1', '2025-03-12 16:58:11'),
(11, 3, 'LOGIN', 'users', 3, 'Connexion de l\'utilisateur : baheb@mailinator.com', '127.0.0.1', '2025-03-12 16:58:37'),
(12, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-12 19:34:51'),
(13, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 00:35:16'),
(14, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 00:37:08'),
(15, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 13:01:48'),
(16, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 13:03:00'),
(17, 2, 'LOGIN', 'users', 2, 'Connexion de l\'utilisateur : nacyhulata@mailinator.com', '127.0.0.1', '2025-03-13 13:25:29'),
(18, 2, 'LOGIN', 'users', 2, 'Connexion de l\'utilisateur : nacyhulata@mailinator.com', '127.0.0.1', '2025-03-13 13:28:21'),
(19, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 17:53:02'),
(20, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 18:10:20'),
(21, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 18:22:42'),
(22, NULL, 'DELETE', 'users', NULL, 'Desactivation de l\'utilisateur : ', '127.0.0.1', '2025-03-13 18:25:01'),
(23, NULL, 'ACTIVATE', 'users', NULL, 'Activation de l\'utilisateur : ', '127.0.0.1', '2025-03-13 18:28:07'),
(24, NULL, 'DELETE', 'users', NULL, 'Desactivation de l\'utilisateur : ', '127.0.0.1', '2025-03-13 18:28:58'),
(25, NULL, 'ACTIVATE', 'users', NULL, 'Activation de l\'utilisateur : ', '127.0.0.1', '2025-03-13 18:29:03'),
(26, NULL, 'DELETE', 'users', NULL, 'Desactivation de l\'utilisateur : ', '127.0.0.1', '2025-03-13 18:30:16'),
(27, NULL, 'ACTIVATE', 'users', NULL, 'Activation de l\'utilisateur : baheb@mailinator.com', '127.0.0.1', '2025-03-13 18:32:53'),
(28, NULL, 'DELETE', 'users', NULL, 'Desactivation de l\'utilisateur : baheb@mailinator.com', '127.0.0.1', '2025-03-13 18:33:08'),
(29, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-13 23:58:28'),
(30, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-14 01:49:48'),
(31, NULL, 'UPDATE', 'phishing_types', 3, 'Activation du type de phishing : ', '127.0.0.1', '2025-03-14 02:06:48'),
(32, NULL, 'ACTIVATE', 'phishing_types', 2, 'Activation du type de phishing : ', '127.0.0.1', '2025-03-14 02:16:25'),
(33, 1, 'DELETE', 'phishing_types', 2, 'Desactivation du type de phishing : ', '127.0.0.1', '2025-03-14 02:17:43'),
(34, 1, 'ACTIVATE', 'phishing_types', 2, 'Activation du type de phishing : ', '127.0.0.1', '2025-03-14 02:18:16'),
(35, NULL, 'DELETE', 'phishing_types', 1, 'Desactivation du type de phishing : ', '127.0.0.1', '2025-03-14 02:19:32'),
(36, NULL, 'DELETE', 'phishing_types', 2, 'Desactivation du type de phishing : ', '127.0.0.1', '2025-03-14 02:19:36'),
(37, 1, 'LOGIN', 'users', 1, 'Connexion de l\'utilisateur : tutow@mailinator.com', '127.0.0.1', '2025-03-14 12:01:02'),
(38, NULL, 'ACTIVATE', 'phishing_types', 2, 'Activation du type de phishing : ', '127.0.0.1', '2025-03-14 12:01:11'),
(39, NULL, 'ACTIVATE', 'phishing_types', 1, 'Activation du type de phishing : ', '127.0.0.1', '2025-03-14 12:01:14');

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
(1, 'Phishing par email', 'Cette attaque consiste à envoyer des emails frauduleux qui semblent provenir d\'une source légitime (banque, service en ligne, entreprise) pour inciter la victime à divulguer des informations sensibles (identifiants, mots de passe, numéros de carte bancaire).', '67d1ab0f9c0a6_solen-feyissa-HQSEvyN56K0-unsplash.jpg', 1, '2025-03-12 15:41:03'),
(2, 'Spear Phishing', 'Variante ciblée du phishing où l\'attaquant personnalise l’attaque en fonction des informations sur la victime (nom, entreprise, poste) pour paraître plus crédible et augmenter les chances de succès.', '67d1aca793758_istockphoto-1814949098-1024x1024.jpg', 1, '2025-03-12 15:47:51'),
(3, 'Phishing par Téléphone (Vishing)', 'Le vishing est une technique où un attaquant appelle une victime en se faisant passer pour une entreprise ou une administration afin d\'obtenir des informations sensibles.', '67d1b207c1ba0_thewildrobot-poster-66686a8d0fd04-1.jpg', 1, '2025-03-12 16:10:47');

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
(1, 1, 'Toujours vérifier l’adresse email de l’expéditeur avant d’ouvrir un email suspect.', 1),
(2, 1, 'Ne jamais cliquer sur un lien sans vérifier l’URL en le survolant avec la souris.', 1),
(3, 1, 'Activer l’authentification à deux facteurs (2FA) sur les services sensibles.', 1),
(4, 1, 'Utiliser des filtres anti-phishing dans les boîtes mail.', 1),
(5, 1, 'Ne jamais fournir d’informations personnelles ou bancaires par email.', 1),
(6, 2, 'Sensibiliser les employés aux dangers du spear phishing et à la vérification des emails.', 1),
(7, 2, 'Ne jamais ouvrir de pièce jointe non attendue, même si elle semble venir d’un collègue.', 1),
(8, 3, 'Ne jamais divulguer d’informations sensibles par téléphone.', 1),
(9, 3, 'Raccrocher et contacter directement l’organisme via un numéro officiel.', 1);

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
  `last_login` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `birth_date`, `nationality`, `identity_number`, `email`, `gender`, `password`, `profile_picture`, `role`, `active`, `last_login`, `created_at`) VALUES
(1, 'Administrateur', 'Keren', '2002-02-19', 'Congolaise', 'ID8989898', 'tutow@mailinator.com', 'female', '$2y$10$0WFzCVQFT7qZAaXzMs3D6OpZw8d6YFfBvyWXFYOFFnMaU9Ew/zmwe', '67d19ff3d1e53_image.png', 'admin', 1, '2025-03-14', '2025-03-12 14:53:39'),
(2, 'Malundu', 'Ephraim', '1995-11-14', 'Française', 'ID89898456', 'nacyhulata@mailinator.com', 'male', '$2y$10$SQ9V3ZZG/06MP9qAQ.bubeeacVtIniQYCPnGZFfk9fk15DBLV2ACy', '67d2e070f3703.jpg', 'user', 1, '2025-03-13', '2025-03-12 16:48:31'),
(3, 'Hays', 'Luke', '2021-11-30', 'Irure enim nisi inci', '751', 'baheb@mailinator.com', 'female', '$2y$10$1gQiWH1GJSC3mDmhSDUzje6unhNCBZ9.E2vXLxSUor15fDCSj9dmO', '67d1bd233530b_image.png', 'user', 0, '2025-03-12', '2025-03-12 16:58:11');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `phishing_types`
--
ALTER TABLE `phishing_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `protections`
--
ALTER TABLE `protections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
