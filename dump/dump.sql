-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Host: portfolitlmyster.mysql.db
-- Generation Time: Oct 21, 2020 at 07:18 PM
-- Server version: 5.6.48-log

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `online` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `created_at`, `updated_at`, `creator_id`, `online`) VALUES
(1, 'Découvrez notre équipe', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad exercitationem illo numquam odio officiis omnis, perferendis sit tenetur vel! Assumenda cumque eius ipsa ipsam minus odit quaerat quibusdam, ratione reiciendis rerum! Et impedit vero voluptatem! A aut, eveniet iusto maiores nihil numquam optio perferendis quam qui quidem suscipit totam vel.', '2020-09-06 12:09:56', '2020-09-12 23:48:06', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `basketjoin`
--

CREATE TABLE `basketjoin` (
  `id` int(11) NOT NULL,
  `basket_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `basketjoin`
--

INSERT INTO `basketjoin` (`id`, `basket_id`, `product_id`) VALUES
(1, 6, 1),
(2, 7, 1),
(3, 5, 1),
(4, 4, 1),
(5, 3, 1),
(6, 2, 1),
(7, 6, 2),
(8, 7, 2),
(9, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `baskets`
--

CREATE TABLE `baskets` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `day` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `baskets`
--

INSERT INTO `baskets` (`id`, `title`, `created_at`, `updated_at`, `creator_id`, `day`) VALUES
(2, 'Le Panier du lundi', '2020-09-02 11:36:24', '2020-09-02 11:36:29', 1, 1),
(3, 'Le Panier du mardi', '2020-09-09 16:53:21', '2020-09-09 16:53:21', 1, 2),
(4, 'Le Panier du mercredi', '2020-09-09 16:53:21', '2020-09-09 16:53:21', 1, 3),
(5, 'Le Panier du jeudi', '2020-09-09 16:53:21', '2020-09-09 16:53:21', 1, 4),
(6, 'Le Panier du vendredi', '2020-09-09 16:53:21', '2020-09-09 16:53:21', 1, 5),
(7, 'Le Panier du samedi', '2020-09-09 16:53:21', '2020-09-14 16:27:22', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `provenance` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `created_at`, `updated_at`, `creator_id`, `provenance`) VALUES
(1, 'tomates', '2020-09-11 15:40:08', '2020-09-11 15:40:08', 1, 'Montesson'),
(2, 'Oignons', '2020-09-11 15:47:26', '2020-09-11 15:47:26', 1, 'Maisons-laffitte');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `login`, `password`) VALUES
(1, '2020-09-02 11:37:02', '2020-09-02 11:37:04', 'lol', '$2y$10$4I7nbc7/.y92fXMdwMZ3HuS8hlLncMqqZBaQf0CJ018NmoZaiYb/2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_creator_fk` (`creator_id`);

--
-- Indexes for table `basketjoin`
--
ALTER TABLE `basketjoin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkIdx_51` (`basket_id`),
  ADD KEY `fkIdx_54` (`product_id`);

--
-- Indexes for table `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `basket_creator_fk` (`creator_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_creator_fk` (`creator_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `basketjoin`
--
ALTER TABLE `basketjoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `baskets`
--
ALTER TABLE `baskets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `article_creator_fk` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `basketjoin`
--
ALTER TABLE `basketjoin`
  ADD CONSTRAINT `join_basket_fk` FOREIGN KEY (`basket_id`) REFERENCES `baskets` (`id`),
  ADD CONSTRAINT `join_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `baskets`
--
ALTER TABLE `baskets`
  ADD CONSTRAINT `basket_creator_fk` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_creator_fk` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
