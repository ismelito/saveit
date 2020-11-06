-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 04 nov. 2020 à 13:18
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogfavvideo`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200721144943', '2020-07-21 14:50:38', 386);

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id`, `email`, `password`) VALUES
(1, 'emilie@hotmail.com', '8866a6cf193c843044c3591678350063d2cbc660e40559995cb9343bb15f36ae'),
(5, 'ismel@hotmail.com', '76df2c1b943fba6b5e603095c4f45af624c281ce4cc9872a1976125ef1b825d4'),
(6, 'usu1@hotmail.com', 'd8e0fd621f8745ab21c9c7de66778d00d9d41b2e2682a5fbc5bff87361c47102'),
(11, 'lolo@gmail.com', 'abd8cfba151826bb7bf3de57387e9653e9d7f54d61e2e107213b3add4383cf91'),
(12, 'loblito@gmail.com', 'f842a01f352e198588eb6eebca4964a4333a3a3fc2c8a7b4ba16f1259625079f'),
(13, 'loblita@gmail.com', 'eb8011e1cb893915f32b693f2a4171238e1fb0be0e712297a89b7c6c24eec0c1'),
(14, 'david@gmail.com', '07d046d5fac12b3f82daf5035b9aae86db5adc8275ebfbf05ec83005a4a8ba3e'),
(15, 'roberto@gmail.com', '72534c4a93ddc043fe3229ed46b1d526c4ccc747febdcd0f284f7f6057a37858'),
(16, 'billyelliot@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(17, 'remi@gmail.com', '899e40470c37df17ceb7addb7a06b255765f34440466dfe39484bfbd626b3392'),
(18, 'teddy@gmail.com', '8de85d6d6394dce9a483b086c293bf02b0ed32545fbd470883b491a5e2b7f10b'),
(19, 'javithere@gmail.com', '6e89996fccb6f42b37b173f362194d498f34092696528a3ea26289371058ce18');

-- --------------------------------------------------------

--
-- Structure de la table `marital_status`
--

DROP TABLE IF EXISTS `marital_status`;
CREATE TABLE IF NOT EXISTS `marital_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marital_status`
--

INSERT INTO `marital_status` (`id`, `marital_status`) VALUES
(1, 'Marie'),
(2, 'Celibataire');

-- --------------------------------------------------------

--
-- Structure de la table `nationality`
--

DROP TABLE IF EXISTS `nationality`;
CREATE TABLE IF NOT EXISTS `nationality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `nationality`
--

INSERT INTO `nationality` (`id`, `nationality`) VALUES
(1, 'Française'),
(2, 'Cubaine');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Administrateur'),
(2, 'Utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `sex`
--

DROP TABLE IF EXISTS `sex`;
CREATE TABLE IF NOT EXISTS `sex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sex`
--

INSERT INTO `sex` (`id`, `sex`) VALUES
(1, 'Feminin '),
(2, 'Masculin');

-- --------------------------------------------------------

--
-- Structure de la table `telephone`
--

DROP TABLE IF EXISTS `telephone`;
CREATE TABLE IF NOT EXISTS `telephone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_type_telephone` int(11) NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `telephone`
--

INSERT INTO `telephone` (`id`, `id_user`, `id_type_telephone`, `telephone`) VALUES
(1, 5, 2, '0780553562'),
(2, 1, 2, '0780553563'),
(3, 6, 2, '0780553564'),
(5, 11, 1, '55358065'),
(6, 15, 2, '758968542'),
(7, 14, 2, '7854966852'),
(8, 19, 2, '4915142239671'),
(9, 17, 2, '780553562');

-- --------------------------------------------------------

--
-- Structure de la table `type_telephone`
--

DROP TABLE IF EXISTS `type_telephone`;
CREATE TABLE IF NOT EXISTS `type_telephone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typetelephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_telephone`
--

INSERT INTO `type_telephone` (`id`, `typetelephone`) VALUES
(1, 'Maison'),
(2, 'Portable'),
(3, 'Travail');

-- --------------------------------------------------------

--
-- Structure de la table `url`
--

DROP TABLE IF EXISTS `url`;
CREATE TABLE IF NOT EXISTS `url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `url`
--

INSERT INTO `url` (`id`, `url`) VALUES
(5, 'https://www.youtube.com/watch?v=9HSEicHyCBo'),
(9, 'https://www.youtube.com/watch?v=FBacuhimW8k'),
(10, 'https://www.youtube.com/watch?v=7IpYU6TKU-Q'),
(11, 'https://www.youtube.com/watch?v=73_DOquGBD4'),
(12, 'https://www.youtube.com/watch?v=6EBNIgkrU74'),
(14, 'https://www.youtube.com/watch?v=k_WvAH3AE1w'),
(15, 'https://www.youtube.com/watch?v=MOysl6rVBdM'),
(18, 'https://www.youtube.com/watch?v=khdH-heeojU'),
(20, 'https://www.youtube.com/watch?v=xEwPVphGS70'),
(21, 'https://www.youtube.com/watch?v=8WgP_NzXdd8'),
(22, 'https://www.youtube.com/watch?v=x94m407UJSI'),
(23, 'https://www.youtube.com/watch?v=6FJapX0fR84'),
(24, 'https://www.youtube.com/watch?v=_Bm14Bv1DKU'),
(26, 'https://www.youtube.com/watch?v=UyaZmFGyuMg'),
(27, 'https://www.youtube.com/watch?v=ZbZSe6N_BXs'),
(28, 'https://www.youtube.com/watch?v=gdiLVBTMtnU');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_sex` int(11) NOT NULL,
  `id_nationality` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `id_marital_status` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `last_name`, `birthday`, `id_login`, `id_sex`, `id_nationality`, `id_role`, `create_at`, `update_at`, `id_marital_status`, `is_active`) VALUES
(1, 'Emilie', 'Plateau', '1990/05/1', 1, 1, 1, 2, '2020-07-22 08:03:04', '2020-07-22 08:42:34', 2, 1),
(5, 'Ismel', 'Castellanos', '1985/05/10', 5, 2, 2, 1, '2020-07-22 08:14:16', '2020-07-22 14:03:07', 2, 1),
(6, 'usu1', 'usu1', '1990/05/1', 6, 1, 1, 2, '2020-07-22 13:43:06', '2020-07-22 13:43:06', 2, 1),
(11, 'lolo', 'castellanos', '2020-08-10', 11, 2, 1, 2, '2020-08-10 10:51:44', '2020-08-24 21:02:36', 1, 1),
(12, 'loblito', 'loblito', '2020-08-10', 12, 2, 1, 2, '2020-08-10 11:03:23', '2020-08-10 11:03:23', 2, 1),
(13, 'loblita', 'loblita', '2020-08-10', 13, 1, 1, 2, '2020-08-10 11:04:54', '2020-08-10 11:04:54', 2, 1),
(14, 'david', 'david', '2020-08-10', 14, 2, 2, 2, '2020-08-10 11:06:59', '2020-08-26 14:31:39', 2, 1),
(15, 'Roberto', 'Fernandez', '2020-08-25', 15, 2, 1, 2, '2020-08-25 15:56:01', '2020-08-25 15:56:01', 2, 1),
(16, 'rodolphe', 'd', '1987-12-06', 16, 2, 1, 2, '2020-08-26 09:58:09', '2020-08-26 09:58:09', 2, 1),
(17, 'remi', 'remiii', '2020-08-26', 17, 2, 1, 2, '2020-08-26 10:09:09', '2020-09-24 12:58:07', 2, 1),
(18, 'Teddy', 'Swims', '2020-08-26', 18, 2, 2, 2, '2020-08-26 14:02:26', '2020-08-26 14:02:26', 2, 1),
(19, 'javi', 'suarez', '2020-11-28', 19, 2, 2, 2, '2020-09-10 20:02:55', '2020-09-10 20:02:55', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_video`
--

DROP TABLE IF EXISTS `user_video`;
CREATE TABLE IF NOT EXISTS `user_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_video`
--

INSERT INTO `user_video` (`id`, `id_user`, `id_video`) VALUES
(2, 5, 4),
(6, 5, 8),
(7, 11, 9),
(8, 11, 10),
(9, 11, 11),
(11, 11, 13),
(12, 11, 14),
(15, 11, 17),
(17, 11, 19),
(18, 11, 20),
(19, 11, 21),
(20, 11, 22),
(21, 15, 23),
(26, 15, 37),
(27, 11, 38),
(28, 18, 37),
(29, 1, 40),
(30, 19, 41);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `id_url` int(11) NOT NULL,
  `id_video_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `title`, `description`, `create_at`, `update_at`, `id_url`, `id_video_status`) VALUES
(4, 'bachata', 'danza popular dominicana', '2020-07-24 10:31:21', '2020-07-24 10:31:21', 5, 2),
(8, 'merengue', 'republica dominicana', '2020-08-03 09:17:24', '2020-08-03 09:17:24', 9, 1),
(9, 'Someone You Loved', 'romantique', '2020-08-18 14:28:37', '2020-08-18 14:28:37', 10, 2),
(10, 'All of me', 'romantique(Jhon Legend)', '2020-08-18 14:52:24', '2020-08-18 14:52:24', 11, 2),
(11, 'C#', 'developpement', '2020-08-20 14:03:45', '2020-08-20 14:03:45', 12, 1),
(13, 'Maluma - Parce', 'reguetton', '2020-08-21 08:45:16', '2020-08-24 15:39:40', 14, 2),
(14, 'Hello ', 'MANDINGA - Hello (Salsa Version)', '2020-08-21 10:23:09', '2020-08-21 10:23:09', 15, 1),
(17, 'let me love you', 'pop', '2020-08-24 11:48:25', '2020-08-24 11:48:25', 18, 1),
(19, 'Let Me Love You (Karaoke)', 'Mario - Let Me Love You (Karaoke Version)', '2020-08-24 12:46:04', '2020-08-24 12:46:04', 20, 1),
(20, 'When I Was Your Man', 'When I Was Your Man - Bruno Mars (Lyrics) HD\n', '2020-08-24 13:12:52', '2020-08-24 13:27:57', 21, 1),
(21, 'Talking To The Moon', 'Bruno Mars - Talking To The Moon ', '2020-08-24 13:19:13', '2020-08-24 13:27:13', 22, 2),
(22, 'Make You Feel My Love ', 'Teddy Swims - Make You Feel My Love (Cover)', '2020-08-25 16:03:00', '2020-08-25 16:03:00', 23, 2),
(23, ' I Can\'t Make You Love Me', ' I Can\'t Make You Love Me', '2020-08-25 16:06:38', '2020-08-25 16:06:38', 24, 2),
(37, 'let me love you', 'Teddy Swims - Let Me Love You (Mario Cover)', '2020-08-26 09:23:34', '2020-08-26 09:23:34', 18, 2),
(38, ' Keeping Me Alive', 'Jonathan Roy - Keeping Me Alive (Live Acoustic Performance)', '2020-08-26 10:02:26', '2020-08-26 10:02:26', 26, 2),
(39, 'Let Me Love You', 'Teddy Swims - Let Me Love You (Mario Cover)', '2020-08-26 14:06:06', '2020-08-26 14:06:06', 18, 2),
(40, 'Happy', 'Pharrell Williams - Happy (Official Music Video)', '2020-08-26 14:43:54', '2020-08-26 14:43:54', 27, 2),
(41, 'REGGAETON CUBANO', 'COMO SE BAILE REGGAETON CUBANO ► CLASE DE BAILE 1 ► REGGAETON CHOREOGRAPHY ► CON CUQUITA', '2020-09-10 20:05:18', '2020-09-10 20:05:18', 28, 2);

-- --------------------------------------------------------

--
-- Structure de la table `video_status`
--

DROP TABLE IF EXISTS `video_status`;
CREATE TABLE IF NOT EXISTS `video_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video_status`
--

INSERT INTO `video_status` (`id`, `status`) VALUES
(1, 'prive'),
(2, 'public');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
