-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 08:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group3ddl`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderId` int(10) NOT NULL,
  `productId` int(10) NOT NULL,
  `quantity` int(10) DEFAULT NULL,
  `unitPrice` int(10) DEFAULT NULL,
  `discount` int(10) DEFAULT NULL,
  `statusId` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(10) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `orderDate` date DEFAULT NULL,
  `shippedDate` date DEFAULT NULL,
  `shipperId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `productCode` int(11) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `standardCost` double NOT NULL,
  `listPrice` double NOT NULL,
  `reorderLevel` int(11) DEFAULT NULL,
  `targetLevel` int(11) DEFAULT NULL,
  `quantityPerUnit` int(11) DEFAULT NULL,
  `discontinued` varchar(50) DEFAULT NULL,
  `minimumReorderCount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderId`,`productId`),
  ADD UNIQUE KEY `statusId` (`statusId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD UNIQUE KEY `employeeId` (`employeeId`),
  ADD UNIQUE KEY `customerID` (`customerID`),
  ADD UNIQUE KEY `shipperId` (`shipperId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`),
  ADD UNIQUE KEY `productCode` (`productCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
