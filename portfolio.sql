-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 03 mars 2026 à 00:01
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
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id_project`, `title`, `description`, `link_url`, `image_url`) VALUES
(1, 'CChat', 'J\'apprends le langage C et j\'ai réalisé CChat comme projet fil rouge pour mettre en pratique les concepts fondamentaux : programmation réseau avec sockets TCP, gestion des threads, synchronisation, gestion manuelle de la mémoire et conception d\'un protocole de messages simple. Le projet comprend un serveur multi‑clients capable de diffuser des messages, gérer des salons, supporter des messages privés et des commandes basiques. C\'est mon projet final en C visant à démontrer la maîtrise des aspects systèmes et des bonnes pratiques de développement en C.', 'https://github.com/EtonnaiLeSoleil/CChat', NULL),
(2, 'Habibiatore', 'Habibiatore est un jeu de type Akinator qui devine des planètes du système solaire à partir d\'une série de questions. L\'interface web (PHP/HTML/CSS) pose des questions adaptées, collecte les réponses et utilise une logique simple d\'apprentissage pour améliorer ses prédictions. Le projet inclut la gestion des sessions de jeu, le calcul d\'un score de confiance pour la prédiction et une base de connaissances enrichie au fil des parties.', 'https://github.com/EtonnaiLeSoleil/Habibiatore', NULL),
(3, 'APIcollaboratifs', 'Crée une API pour gérer des projets d\'équipes cross-fonctionnelles. Chaque projet a un organizer, des members aux rôles variés et un cahier des charges PDF ajouté à la création. Accès via JWT. Stockage en mémoire : chaque projet contient ses membres.', 'https://github.com/EtonnaiLeSoleil/APIcollaboratifs', 'https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg'),
(4, 'Waspail Demo', 'Waspail Demo est un réseau social mobile réalisé dans le cadre d’un examen d’une durée de 4 jours. L’application propose une interface interactive permettant de simuler les principales fonctionnalités d’un réseau social (navigation, affichage de contenu et interactions utilisateur) à travers une approche moderne front/back en JavaScript/TypeScript.', 'https://github.com/TysRzo/Waspail-Demo', './img/icon.png');

-- --------------------------------------------------------

--
-- Structure de la table `project_skill`
--

CREATE TABLE `project_skill` (
  `project_id` int NOT NULL,
  `skill_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `project_skill`
--

INSERT INTO `project_skill` (`project_id`, `skill_id`) VALUES
(4, 1),
(3, 2),
(2, 3),
(1, 4),
(4, 5),
(3, 6),
(2, 7),
(4, 8),
(2, 9),
(4, 10);

-- --------------------------------------------------------

--
-- Structure de la table `skill`
--

CREATE TABLE `skill` (
  `id_skill` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `skill`
--

INSERT INTO `skill` (`id_skill`, `name`) VALUES
(4, 'C'),
(9, 'CSS'),
(1, 'Expo'),
(7, 'HTML'),
(2, 'JavaScript'),
(10, 'MongoDB'),
(8, 'Node.js'),
(3, 'PHP'),
(16, 'prout'),
(6, 'Pug'),
(5, 'React');

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
(1, 'Admin@admin.admin', '$2y$10$Nm4uBY8UUGu6Sx0hrMHB4uAoRsaAbHof6cO15m1L8YW9JI4R/dwrm', 'Développeur Full Stack', 'Bonjour ! Je m’appelle Antoine Gouet, je suis un développeur web full stack, actuellement en deuxième année de Bachelor Informatique à la 3W Academy.\r\n\r\nMa spécificité est de pouvoir concevoir des projets web de A à Z. Je commence par l\'analyse des besoins pour définir la solution la plus adaptée, je poursuis avec la conception technique et le design, puis j\'assure le développement complet (front-end et back-end) et la mise en ligne.\r\n\r\nAu-delà de la création d\'applications performantes, je porte un intérêt croissant aux enjeux de la cybersécurité et de l\'analyse de données, que j\'intègre progressivement dans ma pratique pour créer des outils non seulement fonctionnels, mais aussi robustes et sécurisés. Je peux ainsi vous accompagner sur toutes les étapes techniques de votre projet digital.', 'Antoine-Gouet-CVG.pdf');

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
-- Index pour la table `project_skill`
--
ALTER TABLE `project_skill`
  ADD PRIMARY KEY (`project_id`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Index pour la table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id_skill`),
  ADD UNIQUE KEY `name` (`name`);

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
  MODIFY `id_project` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `skill`
--
ALTER TABLE `skill`
  MODIFY `id_skill` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `project_skill`
--
ALTER TABLE `project_skill`
  ADD CONSTRAINT `project_skill_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id_project`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id_skill`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
