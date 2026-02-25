-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 25 fév. 2026 à 20:56
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact_message`
--

CREATE TABLE `contact_message` (
  `id_message` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE `project` (
  `id_project` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `skill_list` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id_project`, `title`, `description`, `link_url`, `image_url`, `skill_list`) VALUES
(1, 'CChat', 'J\'apprends le langage C et j\'ai réalisé CChat comme projet fil rouge pour mettre en pratique les concepts fondamentaux : programmation réseau avec sockets TCP, gestion des threads, synchronisation, gestion manuelle de la mémoire et conception d\'un protocole de messages simple. Le projet comprend un serveur multi‑clients capable de diffuser des messages, gérer des salons, supporter des messages privés et des commandes basiques. C\'est mon projet final en C visant à démontrer la maîtrise des aspects systèmes et des bonnes pratiques de développement en C.', 'https://github.com/EtonnaiLeSoleil/CChat', NULL, 'C'),
(2, 'Habibiatore', 'Habibiatore est un jeu de type Akinator qui devine des planètes du système solaire à partir d\'une série de questions. L\'interface web (PHP/HTML/CSS) pose des questions adaptées, collecte les réponses et utilise une logique simple d\'apprentissage pour améliorer ses prédictions. Le projet inclut la gestion des sessions de jeu, le calcul d\'un score de confiance pour la prédiction et une base de connaissances enrichie au fil des parties.', 'https://github.com/EtonnaiLeSoleil/Habibiatore', NULL, 'PHP,HTML,CSS'),
(3, 'APIcollaboratifs', 'Crée une API pour gérer des projets d\'équipes cross-fonctionnelles. Chaque projet a un organizer, des members aux rôles variés et un cahier des charges PDF ajouté à la création. Accès via JWT. Stockage en mémoire : chaque projet contient ses membres.', 'https://github.com/EtonnaiLeSoleil/APIcollaboratifs', 'https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg', 'JavaScript,Pug'),
(4, 'Waspail Demo', 'Waspail Demo est un réseau social mobile réalisé dans le cadre d’un examen d’une durée de 4 jours. L’application propose une interface interactive permettant de simuler les principales fonctionnalités d’un réseau social (navigation, affichage de contenu et interactions utilisateur) à travers une approche moderne front/back en JavaScript/TypeScript.', 'https://github.com/TysRzo/Waspail-Demo', './public/img/icon.png', 'Expo,React,Node.js,MongoDB');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `bio` text,
  `cv_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password_hash`, `job_title`, `bio`, `cv_url`) VALUES
(1, 'Admin@admin.admin', '$2y$10$Nm4uBY8UUGu6Sx0hrMHB4uAoRsaAbHof6cO15m1L8YW9JI4R/dwrm', 'Développeur Full Stack', 'Étudiant de 19 ans en seconde année d\'informatique à la 3W Academy en France.\r\nMes études me permettent d\'apprendre le métier de Développeur Full Stack. À l\'avenir, j\'aspire à évoluer dans les domaines de la cybersécurité et data.', 'Antoine-Gouet-CVG.pdf');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `id_project` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
