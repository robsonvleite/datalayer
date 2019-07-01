-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 30-Jun-2019 às 20:39
-- Versão do servidor: 10.2.14-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datalayer_example`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `address_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  KEY `user_address` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `address`
--

INSERT INTO `address` (`address_id`, `user_id`, `address`) VALUES
(1, 1, 'Coruscant, República Galática, Centro Imperial'),
(2, 1, 'Coruscant, República Galática, Centro Imperial'),
(3, 1, 'Coruscant, República Galática, Centro Imperial'),
(4, 1, 'Coruscant, República Galática, Centro Imperial'),
(5, 1, 'Coruscant, República Galática, Centro Imperial');

-- --------------------------------------------------------

--
-- Estrutura da tabela `socials`
--

DROP TABLE IF EXISTS `socials`;
CREATE TABLE IF NOT EXISTS `socials` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `social` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_socials` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `socials`
--

INSERT INTO `socials` (`id`, `user_id`, `social`, `link`) VALUES
(1, 6, 'facebook', 'https://www.facebook.com/thalleskoester'),
(2, 6, 'linkedin', 'https://www.linkedin.com/in/thalleskoester/');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `genre` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `genre`, `created_at`, `updated_at`) VALUES
(1, 'Robson', 'Leite', NULL, '2018-09-03 19:39:07', '2018-11-13 17:11:45'),
(3, 'Willian', 'Santos', NULL, '2018-09-03 19:39:07', '2018-10-24 14:26:46'),
(4, 'Eleno', 'Santos', NULL, '2018-09-03 19:39:07', '2018-10-24 14:26:46'),
(5, 'Lucas', 'Santos', NULL, '2018-09-03 19:39:07', '2018-10-24 14:26:46'),
(6, 'Thalles', 'Koester', NULL, '2019-06-30 03:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users` ADD FULLTEXT KEY `full_text` (`first_name`,`last_name`);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `user_address` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `socials`
--
ALTER TABLE `socials`
  ADD CONSTRAINT `user_socials` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
