-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2020 at 10:23 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newzoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `animal_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `animal_name` varchar(30) NOT NULL,
  `animal_DOB` date NOT NULL,
  `animal_gender` varchar(6) DEFAULT NULL,
  `animal_breed` varchar(30) NOT NULL,
  `animal_display` varchar(3) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `animal_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`animal_id`, `department_id`, `animal_name`, `animal_DOB`, `animal_gender`, `animal_breed`, `animal_display`, `user_id`, `animal_time`) VALUES
(8, 1, 'Leopard', '2000-01-02', 'Male', 'Orange', 'Yes', 6, '2020-04-07 21:26:51'),
(9, 1, 'Elephant', '2018-01-02', 'Male', 'African', 'Yes', 6, '2020-04-07 21:27:21'),
(10, 1, 'Lion', '1990-02-03', 'Male', 'Lion', 'Yes', 6, '2020-04-07 21:27:57'),
(11, 1, 'Cat', '1990-04-04', 'Male', 'Persian', 'Yes', 7, '2020-04-07 21:28:42'),
(12, 1, 'Tiger', '1999-04-25', 'Male', 'Bengal', 'Yes', 7, '2020-04-07 21:29:13'),
(13, 1, 'Horse', '2007-07-07', 'Female', 'Morgan', 'Yes', 7, '2020-04-07 21:29:42'),
(14, 1, 'Tiger', '1998-07-15', 'Male', 'Siberian', 'Yes', 6, '2020-04-08 02:00:20'),
(15, 1, 'Penguin', '2000-08-24', 'Male', 'Emperor', 'Yes', 7, '2020-04-08 02:04:04'),
(17, 1, 'Elephant', '2004-07-04', 'Female', 'Borneo', 'Yes', 6, '2020-04-08 18:34:56');

--
-- Triggers `animal`
--
DELIMITER $$
CREATE TRIGGER `DUP_ANIMAL` BEFORE INSERT ON `animal` FOR EACH ROW BEGIN
IF(EXISTS(SELECT 1 FROM animal WHERE
          animal_name = NEW.animal_name AND
          animal_breed = NEW.animal_breed AND
          animal_DOB = NEW.animal_DOB AND
          animal_gender = NEW.animal_gender)) THEN
          SIGNAL SQLSTATE VALUE '45000'
          SET MESSAGE_TEXT = 'Animal already exists';
          END IF;
          END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'Animal'),
(2, 'Membership'),
(3, 'Ride'),
(4, 'SuperAdmin'),
(5, 'Sale'),
(6, 'Product');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `member_fname` varchar(30) NOT NULL,
  `member_fsize` int(11) NOT NULL,
  `member_lname` varchar(30) NOT NULL,
  `member_start` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_type_id`, `product_name`, `product_price`, `user_id`, `product_time`) VALUES
(11, 1, 'Coca cola', '1.00', 8, '2020-04-07 22:31:25'),
(12, 1, 'Coca cola', '1.00', 8, '2020-04-07 22:31:50'),
(13, 2, 'Book', '2.00', 8, '2020-04-07 23:16:47'),
(14, 2, 'Sanitizer', '5.00', 8, '2020-04-07 23:20:13'),
(15, 2, 'Sanitizer', '5.00', 8, '2020-04-07 23:21:29'),
(16, 2, 'Sanitizer', '12.00', 8, '2020-04-07 23:22:29'),
(17, 1, 'Crazy lazy', '10.20', 8, '2020-04-07 23:28:03'),
(18, 2, 'flowers', '1.30', 9, '2020-04-07 23:30:53'),
(19, 4, 'adult ticket', '9.99', 9, '2020-04-07 23:31:35'),
(20, 2, 'milky way', '1.99', 10, '2020-04-07 23:32:28'),
(21, 1, 'Book', '0.03', 10, '2020-04-07 23:33:02'),
(22, 2, 'Teddy Bear', '25.00', 8, '2020-04-08 02:09:54'),
(23, 2, 'Water Bottle', '2.50', 10, '2020-04-08 02:11:46'),
(24, 2, 'Zoo Poster', '10.00', 8, '2020-04-08 19:06:16');

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `DUP_PRODUCT` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
IF(EXISTS(SELECT 1 FROM product WHERE
          product_name = NEW.product_name AND
          product_price = NEW.product_price AND
          product_type_id = NEW.product_type_id)) THEN
          SIGNAL SQLSTATE VALUE '45000'
          SET MESSAGE_TEXT = 'Product already exists';
          END IF;
          END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `product_type_id` int(11) NOT NULL,
  `product_type_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `product_type_name`) VALUES
(1, 'Rides'),
(2, 'Gift Shops'),
(3, 'Memberships'),
(4, 'Tickets');

-- --------------------------------------------------------

--
-- Table structure for table `ride`
--

CREATE TABLE `ride` (
  `ride_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `ride_name` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ride_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ride`
--

INSERT INTO `ride` (`ride_id`, `department_id`, `ride_name`, `user_id`, `ride_time`) VALUES
(5, 3, 'Loop', 11, '2020-04-07 23:41:12'),
(6, 3, 'Spinning Weel', 11, '2020-04-08 00:25:12'),
(7, 3, 'Spinning Weel', 11, '2020-04-08 00:25:46'),
(8, 3, 'Hide', 11, '2020-04-08 00:26:11'),
(9, 3, 'Spinning Weel', 11, '2020-04-08 01:59:10'),
(10, 3, 'Train', 11, '2020-04-08 19:07:58');

--
-- Triggers `ride`
--
DELIMITER $$
CREATE TRIGGER `DUP_RIDE` BEFORE INSERT ON `ride` FOR EACH ROW BEGIN
IF(EXISTS(SELECT 1 FROM ride WHERE
          department_id = NEW.department_id AND
          ride_name = NEW.ride_name)) THEN
          SIGNAL SQLSTATE VALUE '45000'
          SET MESSAGE_TEXT = 'Ride already exists';
          END IF;
          END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `sale_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_fname` varchar(30) NOT NULL,
  `user_lname` varchar(30) NOT NULL,
  `user_DOB` date NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `user_gender` varchar(6) DEFAULT NULL,
  `user_create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `department_id`, `user_fname`, `user_lname`, `user_DOB`, `user_email`, `user_password`, `user_gender`, `user_create_date`) VALUES
(2, 5, 'Jane', 'Doe', '1980-10-24', 'JaneDoe39@gmail.com', 'Password567', 'Female', '2020-03-25 16:08:41'),
(5, 5, 'Wanda', 'Maximoff', '1974-10-31', 'sale', 'sale', 'Female', '2020-03-25 16:31:47'),
(6, 1, 'Nika', 'Nika', '2020-04-15', 'animal1', 'animal1', 'Female', '2020-04-07 21:20:48'),
(7, 1, 'Varia', 'Varia', '2020-04-08', 'animal2', 'animal2', 'Female', '2020-04-07 21:20:48'),
(8, 6, 'John', 'John', '2020-04-05', 'product', 'product', 'Male', '2020-04-07 21:45:08'),
(9, 6, 'Violet', 'Vienna', '2000-11-04', 'product1', 'product1', 'Female', '2020-04-07 23:30:10'),
(10, 6, 'Hanna', 'Johns', '2020-01-15', 'product2', 'product2', 'Female', '2020-04-07 23:30:10'),
(11, 3, 'Juliana', 'Black', '2000-04-22', 'ride1', 'ride1', 'Female', '2020-04-07 23:40:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`animal_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_type_id` (`product_type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `ride`
--
ALTER TABLE `ride`
  ADD PRIMARY KEY (`ride_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ride`
--
ALTER TABLE `ride`
  MODIFY `ride_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ride`
--
ALTER TABLE `ride`
  ADD CONSTRAINT `ride_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `sale_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
