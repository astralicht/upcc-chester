-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2022 at 05:24 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upcc_unit_tests`
--
CREATE DATABASE IF NOT EXISTS `upcc_unit_tests` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `upcc_unit_tests`;

-- --------------------------------------------------------

--
-- Table structure for table `company_natures`
--

CREATE TABLE `company_natures` (
  `id` int(11) NOT NULL,
  `nature` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(10) NOT NULL DEFAULT 'PENDING',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_count` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `material` text DEFAULT NULL,
  `brand` text DEFAULT NULL,
  `connection_type` text DEFAULT NULL,
  `length` varchar(20) DEFAULT NULL,
  `width` varchar(20) DEFAULT NULL,
  `thickness` varchar(20) DEFAULT NULL,
  `clicks` int(20) NOT NULL DEFAULT 0,
  `shop_id` int(11) DEFAULT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `office_address` text DEFAULT NULL,
  `contact_number` text DEFAULT NULL,
  `image_name` text DEFAULT NULL,
  `image_path` varchar(300) DEFAULT 'uploads/img/default_img.webp',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products_prices`
--

CREATE TABLE `products_prices` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date_added` datetime DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products_stocks`
--

CREATE TABLE `products_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stocks` int(11) NOT NULL DEFAULT 0,
  `date_added` int(11) NOT NULL,
  `date_removed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products_tags`
--

CREATE TABLE `products_tags` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `tag` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shops_users`
--

CREATE TABLE `shops_users` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `company_name` text DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `company_nature` text DEFAULT NULL,
  `phone_number` text DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(256) NOT NULL,
  `type` varchar(20) DEFAULT 'CLIENT',
  `is_email_confirmed` varchar(20) NOT NULL DEFAULT 'FALSE',
  `dp_path` varchar(300) NOT NULL DEFAULT 'uploads/img/default_dp.webp',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_carts`
--

CREATE TABLE `users_carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_natures`
--
ALTER TABLE `company_natures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_prices`
--
ALTER TABLE `products_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_stocks`
--
ALTER TABLE `products_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_tags`
--
ALTER TABLE `products_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops_users`
--
ALTER TABLE `shops_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_carts`
--
ALTER TABLE `users_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_natures`
--
ALTER TABLE `company_natures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_prices`
--
ALTER TABLE `products_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_stocks`
--
ALTER TABLE `products_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_tags`
--
ALTER TABLE `products_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shops_users`
--
ALTER TABLE `shops_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_carts`
--
ALTER TABLE `users_carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
