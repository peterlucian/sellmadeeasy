-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 02-Maio-2020 às 16:48
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` varchar(175) NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `image` varchar(75) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `item_id`, `title`, `price`, `image`, `qty`) VALUES
(6, 5, 5, 'i5 2500k', '39.99', 'http://localhost/codeigniter/uploads/i52500k1_thumb.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`id`, `name`, `parent_cat_id`) VALUES
(3, 'Eletrônica', 0),
(4, 'Informática', 0),
(6, 'Robótica', 0),
(7, 'GPU', 4),
(9, 'Diodos', 3),
(14, 'Drone', 6),
(15, '3d print', 0),
(16, 'models', 15),
(17, 'CPU', 4),
(18, 'Impressora', 15);

-- --------------------------------------------------------

--
-- Estrutura da tabela `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `history`
--

INSERT INTO `history` (`id`, `item_id`, `user_id`, `date`) VALUES
(20, 8, 5, '2020-05-02'),
(21, 4, 5, '2020-05-02'),
(22, 5, 5, '2020-05-02'),
(23, 5, 5, '2020-05-02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `file_name` varchar(75) NOT NULL,
  `content` text NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `title` varchar(175) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `items`
--

INSERT INTO `items` (`id`, `user_id`, `categorie_id`, `file_name`, `content`, `price`, `title`, `qty`) VALUES
(4, 5, 16, 'buda1_thumb.png', '<p>este é o seu buda.</p>', '9.99', 'budaoriginal', 2),
(5, 5, 16, 'budadv2_thumb.png', '<p>buda darth vader  model</p>', '9.99', 'budadarthvader', 5),
(6, 5, 16, 'supermario_thumb.jpg', '<p>supermario right from his castell</p>', '19.99', 'supermario', 4),
(8, 5, 17, 'i52500k1_thumb.jpg', '<p>i5 2500k unlocked</p>', '39.99', 'i5 2500k', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `apelido` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `apelido`, `email`, `password`, `ip`) VALUES
(4, 'peterpan', 'pan', 'peterpan@gmail.com', '$2y$10$MgY2K5.PqG656fk6mMI0RuTv/WImoNtGFIyZ/gDXoWno9X.lvm5Sq', ''),
(5, 'Pedro', 'Nascimento', 'plnascimento@hotmail.com', '$2y$10$ylVZ4cwhSMHhrpHyaYeYO.p/sf4TLiDKQnpYH5e/aj11swGqWcuEm', '::1'),
(6, 'luc', 'fernnandes', 'luc@gmail.com', '$2y$10$c6usqrJTeeh/28uJtpYMl.1Dz3PmCRS.x.mmsaor5MMUPaPZMokX2', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
