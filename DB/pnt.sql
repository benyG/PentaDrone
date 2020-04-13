-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2020 at 06:29 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pnt`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `id_agent` varchar(50) NOT NULL,
  `Commentaires` text DEFAULT NULL,
  `file_conf` tinyblob NOT NULL,
  `operationpc_fk` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_cmd`
--

CREATE TABLE `category_cmd` (
  `category_name` varchar(20) NOT NULL,
  `syntaxe` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cmd_auto`
--

CREATE TABLE `cmd_auto` (
  `id_cmdauto` int(11) NOT NULL,
  `cmd_auto` varchar(250) NOT NULL,
  `operationpc_cmd_fk` varchar(50) NOT NULL,
  `ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `pc` varchar(100) NOT NULL,
  `cmd` tinytext NOT NULL,
  `result` text DEFAULT NULL,
  `ok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `command_list`
--

CREATE TABLE `command_list` (
  `id_listcmd` int(11) NOT NULL,
  `name_cmd` varchar(30) NOT NULL,
  `param` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `category_fk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `computer`
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
-- Table structure for table `operationpc`
--

CREATE TABLE `operationpc` (
  `ops_name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `etat_ops` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `avatar` blob DEFAULT NULL,
  `roles` int(11) NOT NULL,
  `user_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `roles_name` varchar(255) NOT NULL,
  `permission_name` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id_agent`),
  ADD KEY `operationpc_fk` (`operationpc_fk`);

--
-- Indexes for table `category_cmd`
--
ALTER TABLE `category_cmd`
  ADD PRIMARY KEY (`category_name`);

--
-- Indexes for table `cmd_auto`
--
ALTER TABLE `cmd_auto`
  ADD PRIMARY KEY (`id_cmdauto`),
  ADD KEY `operationpc_cmd_fk` (`operationpc_cmd_fk`);

--
-- Indexes for table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pc` (`pc`);

--
-- Indexes for table `command_list`
--
ALTER TABLE `command_list`
  ADD PRIMARY KEY (`id_listcmd`),
  ADD KEY `category_fk` (`category_fk`);

--
-- Indexes for table `computer`
--
ALTER TABLE `computer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pc_2` (`pc`),
  ADD KEY `ops_linked` (`ops_linked`),
  ADD KEY `pc` (`pc`);

--
-- Indexes for table `operationpc`
--
ALTER TABLE `operationpc`
  ADD PRIMARY KEY (`ops_name`),
  ADD UNIQUE KEY `ops_name` (`ops_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`roles_name`,`permission_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cmd_auto`
--
ALTER TABLE `cmd_auto`
  MODIFY `id_cmdauto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `command_list`
--
ALTER TABLE `command_list`
  MODIFY `id_listcmd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `computer`
--
ALTER TABLE `computer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `operationpc_fk` FOREIGN KEY (`operationpc_fk`) REFERENCES `operationpc` (`ops_name`);

--
-- Constraints for table `cmd_auto`
--
ALTER TABLE `cmd_auto`
  ADD CONSTRAINT `operationpc_cmd_fk` FOREIGN KEY (`operationpc_cmd_fk`) REFERENCES `operationpc` (`ops_name`);

--
-- Constraints for table `commands`
--
ALTER TABLE `commands`
  ADD CONSTRAINT `pc` FOREIGN KEY (`pc`) REFERENCES `computer` (`pc`);

--
-- Constraints for table `command_list`
--
ALTER TABLE `command_list`
  ADD CONSTRAINT `category_fk` FOREIGN KEY (`category_fk`) REFERENCES `category_cmd` (`category_name`);

--
-- Constraints for table `computer`
--
ALTER TABLE `computer`
  ADD CONSTRAINT `ops_linked` FOREIGN KEY (`ops_linked`) REFERENCES `operationpc` (`ops_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
