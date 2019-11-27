-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 14 nov. 2019 à 11:40
-- Version du serveur :  10.1.34-MariaDB
-- Version de PHP :  5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pnt`
--

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `id_agent` varchar(50) NOT NULL,
  `Commentaires` text,
  `file_conf` tinyblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `category_cmd`
--

CREATE TABLE `category_cmd` (
  `id_cat` varchar(20) NOT NULL,
  `syntaxe` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cmd_auto`
--

CREATE TABLE `cmd_auto` (
  `id_cmdauto` int(11) NOT NULL,
  `cmd_auto` varchar(250) NOT NULL,
  `opname` varchar(50) NOT NULL,
  `ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `pc` varchar(100) NOT NULL,
  `cmd` tinytext NOT NULL,
  `result` text,
  `ok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `command_list`
--

CREATE TABLE `command_list` (
  `id_listcmd` int(11) NOT NULL,
  `name_cmd` varchar(30) NOT NULL,
  `param` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `computer`
--

CREATE TABLE `computer` (
  `id` int(11) NOT NULL,
  `pc` varchar(100) NOT NULL,
  `hostname` varchar(50) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `domain` varchar(250) NOT NULL,
  `ops_linked` varchar(50) NOT NULL DEFAULT 'Default',
  `obs` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `operationpc`
--

CREATE TABLE `operationpc` (
  `ops_name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `agent_frgn` varchar(50) DEFAULT '0',
  `etat_ops` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `organisation`
--

CREATE TABLE `organisation` (
  `id` int(11) NOT NULL,
  `org` varchar(50) NOT NULL,
  `ops_frgn_key` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `avatar` blob,
  `roles` int(11) NOT NULL,
  `user_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `login`, `pass`, `email`, `avatar`, `roles`, `user_description`) VALUES
(0, 'root', 'toor', '', NULL, 0, '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id_agent`);

--
-- Index pour la table `category_cmd`
--
ALTER TABLE `category_cmd`
  ADD PRIMARY KEY (`id_cat`);

--
-- Index pour la table `cmd_auto`
--
ALTER TABLE `cmd_auto`
  ADD PRIMARY KEY (`id_cmdauto`);

--
-- Index pour la table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `command_list`
--
ALTER TABLE `command_list`
  ADD PRIMARY KEY (`id_listcmd`);

--
-- Index pour la table `computer`
--
ALTER TABLE `computer`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `operationpc`
--
ALTER TABLE `operationpc`
  ADD PRIMARY KEY (`ops_name`),
  ADD UNIQUE KEY `ops_name` (`ops_name`);

--
-- Index pour la table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cmd_auto`
--
ALTER TABLE `cmd_auto`
  MODIFY `id_cmdauto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `command_list`
--
ALTER TABLE `command_list`
  MODIFY `id_listcmd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `computer`
--
ALTER TABLE `computer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
