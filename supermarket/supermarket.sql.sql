-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2023 at 11:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supermarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(6) NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(15) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Address` varchar(197) NOT NULL,
  `cphone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `FirstName`, `LastName`, `Gender`, `Address`, `cphone`) VALUES
(2, 'Chidiogo', 'Nwankwo', 'female', 'no. 68 obioma street', '08076465782'),
(3, 'Amaka', 'Onyedika', 'female', '45 oloshola street', '08046586733'),
(4, 'Ngozi', 'osula', 'female', '44 ololo street', '08076836453'),
(5, 'Mark', 'Anubalu', 'male', '98 flemming street', '09056443767');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(6) NOT NULL,
  `manager_id` int(7) NOT NULL,
  `dept_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `manager_id`, `dept_name`) VALUES
(1, 1234, 'food'),
(2, 1234, 'electronics'),
(3, 1234, 'household'),
(4, 1234, 'fruits'),
(5, 3, 'Medicine'),
(6, 3, 'beverages'),
(7, 5, 'appliances');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(6) NOT NULL,
  `F_name` varchar(46) NOT NULL,
  `L_name` varchar(50) NOT NULL,
  `dept_id` int(7) NOT NULL,
  `salary` int(8) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `cphone` int(20) NOT NULL,
  `join_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `F_name`, `L_name`, `dept_id`, `salary`, `dob`, `address`, `cphone`, `join_date`) VALUES
(1, 'Chidiogo', 'Nwankwo', 1, 10000, '2000-05-04', '34 idumu street', 2147483647, '2023-10-09'),
(2, 'Peter', 'Jameson', 2, 30000, '2003-06-27', '23 olamide street', 2147483647, '2023-07-05'),
(3, 'Rita', 'Onyebuke', 3, 50000, '2004-06-02', '65 olomo street', 908467787, '2022-12-02'),
(4, 'Olamide', 'Broke', 4, 500000, '1988-10-03', 'no. 51 flemming street', 938387532, '2019-02-21');

-- --------------------------------------------------------

--
-- Table structure for table `emp_login`
--

CREATE TABLE `emp_login` (
  `username` varchar(50) NOT NULL,
  `password` int(30) NOT NULL,
  `employee` tinyint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_login`
--

INSERT INTO `emp_login` (`username`, `password`, `employee`) VALUES
('cecilia', 12345, 0),
('jameson', 23456, 0),
('olamide', 34567, 0),
('', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `id` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `id`, `admin`) VALUES
('chidiogo', '12345', 1, 1),
('chinemere', '01234', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `cost_price` int(10) NOT NULL,
  `market_price` int(10) NOT NULL,
  `category` varchar(30) NOT NULL,
  `supplier_id` int(7) NOT NULL,
  `product_quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `cost_price`, `market_price`, `category`, `supplier_id`, `product_quantity`) VALUES
(1, 'colgate', 2000, 2300, 'household', 3, 50),
(2, 'Apple juice', 2000, 2200, 'soft drink', 2, 27),
(3, 'aspirin', 300, 450, 'medice', 5, 284),
(4, 'nexus', 7500, 8500, 'electronics', 2, 8),
(5, 'rice', 10000, 11500, 'foodstuff', 1, 243),
(6, 'orange', 50, 70, 'fruits', 4, 742),
(7, 'plates', 300, 400, 'utensils', 3, 65),
(8, 'blender', 4500, 5700, 'electronics', 2, 24);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(5) NOT NULL,
  `sdealer` varchar(40) NOT NULL,
  `sname` varchar(30) NOT NULL,
  `semail` varchar(40) NOT NULL,
  `saddress` varchar(40) NOT NULL,
  `sphone` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `sdealer`, `sname`, `semail`, `saddress`, `sphone`) VALUES
(1, 'food', 'sup1', 'dimma@gmail.com', '24 mark street', 908276767),
(2, 'electronics', 'sup2', 'sfsvfvsdfs', 'fsadeg', 43224546),
(3, 'household', 'sup3', 'cfvnbhghbv', 'fhbgjnhgf', 4657895),
(4, 'fruits', 'sup4', 'xbnhkmjn', 'hghjnkj', 54779765),
(5, 'Medice', 'supp5', 'supp5@gmail.com', '34 locast street', 2147483647),
(6, 'beverages', 'sup6', 'sup6@gmail.com', '45 ojota street', 908795674);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(5) NOT NULL,
  `p_name` varchar(40) NOT NULL,
  `p_id` int(5) NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT 1,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`),
  ADD KEY `manager_id` (`manager_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_name` (`product_name`),
  ADD KEY `market_price` (`market_price`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_name` (`p_name`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `price` (`price`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `prodIDFK` FOREIGN KEY (`p_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodPriceFK` FOREIGN KEY (`price`) REFERENCES `product` (`market_price`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodnameFK` FOREIGN KEY (`p_name`) REFERENCES `product` (`product_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
