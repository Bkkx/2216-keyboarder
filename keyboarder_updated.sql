-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 05:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keyboarder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_email` varchar(45) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(5, 'barebone'),
(2, 'cables'),
(4, 'keyboard'),
(3, 'keycaps'),
(1, 'switches');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `customer_fname` varchar(45) DEFAULT NULL,
  `customer_lname` varchar(45) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_address` longtext NOT NULL,
  `customer_number` int(11) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_points` int(11) NOT NULL DEFAULT 0,
  `customer_joindate` date NOT NULL,
  `customer_verification` int(11) NOT NULL DEFAULT 0,
  `customer_code` varchar(7) NOT NULL,
  `customer_gacode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_fname`, `customer_lname`, `customer_email`, `customer_address`, `customer_number`, `customer_password`, `customer_points`, `customer_joindate`, `customer_verification`, `customer_code`, `customer_gacode`) VALUES
(1, 's', 's', 's@g.com', 'bruv', 843150712, '$2y$10$.kJ634AV24Rc2OaJBLVH3.UgM.o4r3L680Kc6UVna8YkdFU8ikkbO', 0, '2024-06-28', 0, '', ''),
(6, 'Shafeek', 'Shaik', 'yi@gmail.com', 'ds', 84315070, '$2y$10$O59fCITq.4QL3quAwOaKmuRymg4gmiCOxQBTX53gU8nVxgrz.tPDi', 0, '2024-07-01', 0, 'vnf3Nb', ''),
(7, 'Shafeek', 's', 'bonvoyage5070@gmail.com', 'bruv', 84315070, '$2y$10$mbJbbtrnuPSiLOM0KOK5vervle3F4uhUK5cLaMZhK/.9XjvQAGhD.', 0, '2024-07-01', 1, 'XCUdhf', 'Gc6//I6ke/FTIAs5bM2kCT0vq6V5Z0iGfho4ohKglxY='),
(8, 'Shafeek', 'Shaik', 'shafster9090@gmail.com', 'New York, New York ', 84315070, '$2y$10$xFk5536qtNE6bay1nl0xG./N7ngrSDqcbXaSVk..u5F/MI803bHja', 0, '2024-07-01', 1, '6wVE4N', 'XdJ5o4hSUNb18KqD4IdRqWISveSTOk/MuGw4ssuavuw=');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `order_tracking_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `customer_id`, `product_id`, `order_quantity`, `order_tracking_no`, `order_status`) VALUES
(1, 1, 5, 7, '20240628060928PM', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(45) NOT NULL,
  `product_cost` double NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `product_sd` varchar(255) NOT NULL,
  `product_ld` longtext DEFAULT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_cost`, `category_id`, `product_sd`, `product_ld`, `product_quantity`) VALUES
(1, 'Kailh Box White', 0.15, 1, 'Clicky Switch', 'Kailh Box switches have their signature box around a cross-shaped MX style stem which protects the switch from dust and moisture - giving it an IP56 resistance rating.', 50),
(2, 'CableMod Pro Coiled', 49.9, 2, 'Keyboard Cable', 'Elevate your keyboard setup to the next level with the CableMod Pro Keyboard Cable. Made for keyboards with a USB-C port, this coiled keyboard cable is sleeved with both ModFlex and ModMesh sleeving, and is the ultimate accessory to make your keyboard setup pop.', 10),
(3, 'Pikachu Keycaps', 79.9, 3, 'OEM Profile', 'Might not fit for Razer, Steelseries, Corsair, Logitec, Etc. If you`re unsure about this, please enquire as via IG DM @thekapco', 5),
(4, 'Keychron K2', 79.9, 4, 'Wireless', 'The Keychron K2 (Version 2) is a decent entry-level mechanical keyboard. Its small and compact design makes it fairly easy to carry around, and you shouldn`t have to worry about damaging it thanks to its excellent build quality.', 5),
(5, 'Tecware Veil 87', 85, 5, 'DIY Kit', 'Removable Type-C Cable, Southfacing per-key RGB PCB, 5-pin Mechanical Switch Compatible, Modular Kailh Switch Sockets, EVA PCB to Plate Dampener, Silicon Case Dampener, Key Remapping through Software, Customizable Fn1 Layer, RGB illumination, Compatible with Win XP,Vista 7,8,10, NKRO/87 Keys TKL Layout, Windows Key Disable, 1.8m Braided USB cable, Switch Keycap Puller Included, 1 Years Local Manufacturer Warranty', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_id_UNIQUE` (`admin_id`),
  ADD UNIQUE KEY `admin_email_UNIQUE` (`admin_email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_id_UNIQUE` (`category_id`),
  ADD UNIQUE KEY `category_name_UNIQUE` (`category_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_id_UNIQUE` (`customer_id`),
  ADD UNIQUE KEY `customer_email_UNIQUE` (`customer_email`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id_UNIQUE` (`order_id`),
  ADD KEY `product_id_idx` (`product_id`),
  ADD KEY `customer_id_idx` (`customer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id_UNIQUE` (`product_id`),
  ADD UNIQUE KEY `product_name_UNIQUE` (`product_name`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
