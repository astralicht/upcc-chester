-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2022 at 12:44 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upcc`
--

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

--
-- Dumping data for table `company_natures`
--

INSERT INTO `company_natures` (`id`, `nature`, `date_added`, `date_removed`) VALUES
(1, 'Waste-Water Treatment', '2022-06-07 21:56:31', NULL),
(2, 'Steam and Water Supply', '2022-06-07 21:56:31', NULL),
(3, 'LNG', '2022-06-07 21:56:31', NULL),
(4, 'Marine', '2022-06-07 21:56:31', NULL),
(5, 'Oxygen Service', '2022-06-07 21:56:31', NULL),
(6, 'Pipeline', '2022-06-07 21:56:31', NULL),
(7, 'Chemical and Petrochem', '2022-06-07 21:56:31', NULL),
(8, 'Slurry', '2022-06-07 21:56:31', NULL),
(9, 'Pharmaceutical', '2022-06-07 21:56:31', NULL),
(10, 'Food and Beverage', '2022-06-07 21:56:31', NULL),
(11, 'Mining and Construction', '2022-06-07 21:56:31', NULL),
(12, 'Pulp and Paper', '2022-06-07 21:56:31', NULL),
(13, 'Refinery', '2022-06-07 21:56:31', NULL),
(14, 'Geothermal Energy', '2022-06-07 21:56:31', NULL),
(15, 'Power Generation', '2022-06-07 21:56:31', NULL);

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `discount_amount`, `status`, `date_added`, `date_removed`) VALUES
(1, 2, '0.00', 'APPROVED', '2022-07-03 13:37:12', NULL);

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

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`id`, `order_id`, `product_id`, `item_count`, `date_added`, `date_removed`) VALUES
(10, 1, 12, 5, '2022-07-03 13:37:42', NULL),
(11, 1, 1, 5, '2022-07-03 13:47:46', NULL);

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
  `image_name` text DEFAULT NULL,
  `image_path` varchar(300) DEFAULT 'uploads/img/default_img.webp',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `type_id`, `material`, `brand`, `connection_type`, `length`, `width`, `thickness`, `image_name`, `image_path`, `date_added`, `date_removed`) VALUES
(12, 'Banana', 8, 'Banana', 'Banana', NULL, 'Banana', 'Banana', 'Banana', NULL, 'uploads/img/default_img.webp', '2022-06-29 16:44:14', NULL),
(15, 'Banana 5 pcs.', 8, 'Banana', 'Banana', '', '5m', '0.5m', '1m', 'email.webp', 'uploads/img/62d132416268f0.26032753.webp', '2022-07-14 15:07:08', NULL),
(16, 'Rubber bands 30 pcs.', 9, 'Rubber', 'National', '', '5m', '0.5m', '1m', NULL, 'uploads/img/default_img.webp', '2022-07-14 15:40:09', NULL),
(17, 'Pencil', 9, 'Wood', 'National', '', '5m', '0.5m', '1m', NULL, 'uploads/img/default_img.webp', '2022-07-14 19:24:32', NULL);

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

--
-- Dumping data for table `products_prices`
--

INSERT INTO `products_prices` (`id`, `product_id`, `unit_price`, `date_added`, `date_removed`) VALUES
(1, 1, '60.00', '2022-06-29 14:25:17', NULL),
(5, 12, '69.00', '2022-06-29 16:44:14', NULL),
(6, 15, '32.50', '2022-07-14 15:07:08', NULL),
(7, 16, '33.00', '2022-07-14 15:40:10', NULL),
(8, 17, '4.00', '2022-07-14 19:24:32', NULL);

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

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `name`, `description`, `date_added`, `date_removed`) VALUES
(8, 'Food', '', '2022-06-29 13:56:04', NULL),
(9, 'Tools', '', '2022-06-29 13:57:35', NULL),
(11, 'Miscellaneous', '', '2022-06-29 14:04:59', NULL),
(14, 'Furniture', 'chairs', '2022-07-06 11:07:01', '2022-07-06 11:07:58'),
(15, 'Chair', 'not furniture\n', '2022-07-06 11:07:46', '2022-07-06 11:07:58');

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
  `type` varchar(10) DEFAULT 'CLIENT',
  `is_email_confirmed` varchar(20) NOT NULL DEFAULT 'FALSE',
  `dp_path` varchar(300) NOT NULL DEFAULT 'uploads/img/default_dp.webp',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_removed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `company_name`, `company_address`, `company_nature`, `phone_number`, `email`, `password`, `type`, `is_email_confirmed`, `dp_path`, `date_created`, `date_removed`) VALUES
(1, 'Admini', 'Strator', NULL, NULL, NULL, '09617177797', 'admin@mail.com', '$2y$10$.AIHm0SoXbxsSx643AZfFupLaYqb/wo9cO.y2EbjQucHFA3PtA06i', 'ADMIN', 'TRUE', 'uploads/img/default_dp.webp', '2022-05-17 22:21:27', NULL),
(2, 'User', 'One', '', '', 'Steam and Water Supply', '621-1410', 'user1@mail.com', '$2y$10$OHVsK.ftys6Ak0s.LFzKCeEn17fXfRXwaIcU/O1ip9sIHvzpdW10y', 'CLIENT', 'TRUE', 'uploads/img/default_dp.webp', '2022-05-17 22:30:19', NULL),
(3, 'Agent', 'One', NULL, NULL, NULL, '09012345678', 'agent1@mail.com', '$2y$10$4wdi6dyt4UaNd5UWDW786ex.YufclDcjb5Fkoxx65JRaSaDStqmDC', 'AGENT', 'TRUE', 'uploads/img/default_dp.webp', '2022-06-24 00:33:21', NULL),
(13, 'Juan', 'Dela Cruz', '', 'L2 B5', 'NULL', '09171234567', 'juandc@gmail.com', '$2y$10$zG27JOekoISH4VBhJhGurujesWxHHcpIJ4IWCrdN1zmE4xRVC3Lny', 'CLIENT', 'FALSE', 'uploads/img/default_dp.webp', '2022-07-04 17:35:18', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products_prices`
--
ALTER TABLE `products_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users_carts`
--
ALTER TABLE `users_carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
