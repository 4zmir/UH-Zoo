-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2020 at 05:14 PM
-- Server version: 5.7.29
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nika_zoo`
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
  `animal_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`animal_id`, `department_id`, `animal_name`, `animal_DOB`, `animal_gender`, `animal_breed`, `animal_display`, `user_id`, `animal_time`) VALUES
(20, 1, 'Daisy Duck', '1996-10-31', 'Female', 'Bird', 'Yes', 30, '2020-04-13 20:49:15'),
(22, 1, 'Dumbo', '1941-10-23', 'Male', 'Elephant', 'Yes', 24, '2020-04-13 21:08:08');

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
  `member_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `member_expire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `sale_id`, `member_fname`, `member_fsize`, `member_lname`, `member_start`, `user_id`, `member_expire`) VALUES
(17, 23, 'John', 6, 'Turner', '2020-04-13 21:27:22', 31, '2021-04-13 21:27:22'),
(18, 29, 'Austin', 8, 'Zarz', '2020-04-13 21:16:10', 31, '2021-04-13 21:16:10'),
(20, 41, 'Timmy', 4, 'Turner', '2020-04-13 21:31:19', 31, '2021-04-13 21:31:19'),
(21, 38, 'Bolo', 5, 'Bala', '2020-04-14 21:21:01', 31, '2021-04-14 21:21:01'),
(22, 53, 'Jasmine', 4, 'Mifand', '2020-04-15 22:15:05', 26, '2021-04-15 22:15:05'),
(23, 41, 'Charles', 3, 'Villa', '2020-04-15 22:17:39', 26, '2021-04-15 22:17:39'),
(24, 42, 'Alyssa', 3, 'Edwards', '2020-04-24 00:22:49', 31, '2021-04-24 00:22:49');

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
  `product_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_type_id`, `product_name`, `product_price`, `user_id`, `product_time`) VALUES
(28, 4, 'Pencil', 0.99, 22, '2020-04-13 17:11:15'),
(29, 2, 'Bunny Cap', 5.99, 22, '2020-04-13 20:58:00'),
(30, 3, 'Silver membership', 125.00, 22, '2020-04-13 20:59:01'),
(31, 3, 'Bronze Membership', 75.00, 35, '2020-04-13 21:01:34'),
(32, 2, 'Necklace', 10.50, 35, '2020-04-13 21:03:48'),
(33, 2, 'Coca cola', 1.99, 35, '2020-04-14 15:20:52'),
(34, 2, 'Coffee Cup', 2.99, 25, '2020-04-14 23:32:58'),
(35, 2, 'Coffee Big Cup', 4.99, 25, '2020-04-14 23:32:58'),
(36, 3, 'Gold Membership', 175.00, 25, '2020-04-15 03:07:04'),
(38, 4, 'Adult Ticket', 75.00, 25, '2020-04-16 13:16:21'),
(39, 1, 'Teacup Ticket', 0.99, 25, '2020-04-16 13:21:49'),
(40, 1, 'Pony Ride', 0.50, 25, '2020-04-16 13:22:17');

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
DELIMITER $$
CREATE TRIGGER `RIDE_PRICE_VIOLATION` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
	IF(NEW.product_type_id = 1 
	AND 
	EXISTS(SELECT 1 FROM product WHERE product_type_id = 4 AND product_price < NEW.product_price))
	THEN
	BEGIN
		DECLARE v2 DECIMAL(10,2);
		SELECT MIN(product_price) INTO v2
		FROM product WHERE product_type_id = 4;
		SET NEW.product_price = v2;
	END;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TICKET_PRICE_VIOLATION` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
	IF(NEW.product_type_id = 4 
	AND 
	EXISTS(SELECT 1 FROM product WHERE product_type_id = 3 AND product_price < NEW.product_price))
	THEN
	BEGIN
		DECLARE v1 DECIMAL(10,2);
		SELECT MIN(product_price) INTO v1
		FROM product WHERE product_type_id = 3;
		SET NEW.product_price = v1;
	END;
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
  `ride_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ride`
--

INSERT INTO `ride` (`ride_id`, `department_id`, `ride_name`, `user_id`, `ride_time`) VALUES
(22, 3, 'Pony Ride', 39, '2020-04-13 21:00:40'),
(23, 3, 'Wild Water Ride', 32, '2020-04-13 21:18:32'),
(24, 3, 'Hide', 39, '2020-04-22 13:29:33');

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
  `sale_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`sale_id`, `user_id`, `product_id`, `sale_date`, `sale_qty`) VALUES
(34, 38, 31, '2020-04-13 21:23:39', 8),
(35, 23, 29, '2020-04-13 21:23:49', 2),
(36, 33, 28, '2020-04-13 21:24:06', 3),
(37, 33, 28, '2020-04-13 21:24:25', 3),
(38, 33, 31, '2020-04-13 21:24:56', 1),
(39, 23, 32, '2020-04-13 21:25:17', 2),
(40, 23, 29, '2020-04-13 21:25:17', 2),
(42, 23, 30, '2020-04-13 21:39:20', 4),
(43, 33, 33, '2020-04-15 01:08:27', 12),
(44, 38, 35, '2020-04-15 01:08:27', 17),
(45, 38, 34, '2020-04-15 01:08:45', 8),
(46, 38, 32, '2020-04-15 01:09:33', 3),
(47, 33, 29, '2020-04-15 01:09:33', 23),
(48, 33, 29, '2020-04-15 17:43:25', 8),
(49, 33, 29, '2020-04-15 17:43:25', 7),
(50, 23, 33, '2020-04-15 18:43:35', 10),
(51, 23, 29, '2020-04-15 18:43:35', 99),
(52, 23, 29, '2020-04-15 20:25:12', 17),
(53, 23, 36, '2020-04-15 20:25:12', 2),
(54, 23, 28, '2020-04-16 03:28:32', 2),
(55, 23, 32, '2020-04-16 03:28:32', 45),
(56, 23, 34, '2020-04-16 03:28:32', 46),
(57, 23, 36, '2020-04-21 22:19:17', 120),
(58, 23, 36, '2020-04-21 22:20:03', 20),
(60, 33, 29, '2020-04-22 11:38:21', 234),
(61, 33, 36, '2020-04-22 11:39:15', 235),
(62, 23, 31, '2020-04-22 11:45:23', 1345),
(63, 23, 36, '2020-04-22 11:52:53', 101),
(64, 23, 31, '2020-04-22 11:55:18', 150),
(65, 23, 38, '2020-04-22 14:29:17', 190),
(66, 23, 30, '2020-04-22 14:29:17', 222),
(67, 23, 31, '2020-04-22 15:22:21', 122),
(68, 23, 30, '2020-04-22 15:22:21', 321),
(69, 23, 36, '2020-04-22 15:22:21', 108),
(70, 23, 29, '2020-04-22 15:22:21', 145),
(71, 23, 30, '2020-04-23 18:13:33', 1),
(72, 23, 31, '2020-04-23 20:06:21', 120),
(73, 23, 29, '2020-04-23 21:22:31', 45),
(74, 23, 36, '2020-04-23 21:22:31', 6),
(75, 23, 29, '2020-04-23 21:23:04', 234);

--
-- Triggers `sale`
--
DELIMITER $$
CREATE TRIGGER `WEIRD_SALE` AFTER INSERT ON `sale` FOR EACH ROW BEGIN
	IF((NEW.sale_qty >= 100) 
	AND 
	(4.99 <= (SELECT product_price FROM product WHERE NEW.product_id = product.product_id)))
	THEN
	BEGIN
		INSERT INTO unusual_sale (sale_id, user_id, product_id, sale_date, sale_qty) VALUES (NEW.sale_id, NEW.user_id, NEW.product_id, NEW.sale_date, 			NEW.sale_qty);
	END;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `unusual_sale`
--

CREATE TABLE `unusual_sale` (
  `unusual_sale_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_qty` int(11) NOT NULL,
  `seen_by_admin` varchar(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unusual_sale`
--

INSERT INTO `unusual_sale` (`unusual_sale_id`, `sale_id`, `user_id`, `product_id`, `sale_date`, `sale_qty`, `seen_by_admin`) VALUES
(4, 63, 23, 36, '2020-04-22 11:52:53', 101, '1'),
(3, 62, 23, 31, '2020-04-22 11:45:23', 1345, '1'),
(5, 64, 23, 31, '2020-04-22 11:55:18', 150, '1'),
(6, 65, 23, 38, '2020-04-22 14:29:17', 190, '1'),
(7, 66, 23, 30, '2020-04-22 14:29:17', 222, '1'),
(8, 67, 23, 31, '2020-04-22 15:22:21', 122, '1'),
(9, 68, 23, 30, '2020-04-22 15:22:21', 321, '0'),
(10, 69, 23, 36, '2020-04-22 15:22:21', 108, '0'),
(11, 70, 23, 29, '2020-04-22 15:22:21', 145, '0'),
(12, 72, 23, 31, '2020-04-23 20:06:21', 120, '1'),
(13, 75, 23, 29, '2020-04-23 21:23:04', 234, '0');

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
  `user_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_added` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `department_id`, `user_fname`, `user_lname`, `user_DOB`, `user_email`, `user_password`, `user_gender`, `user_create_date`, `user_added`) VALUES
(22, 4, 'Super', 'Admin', '2020-04-13', 'super', 'super', 'Male', '2020-04-13 17:04:04', 22),
(23, 5, 'Darina', 'Gabuardy', '2020-04-13', 'sale', 'sale', 'Female', '2020-04-13 17:12:55', 22),
(24, 1, 'Mike', 'Carney', '1973-04-07', 'mikec@yahoo.com', 'mikec', 'male', '2020-04-13 18:03:50', 22),
(25, 6, 'Jack', 'Griffin', '1995-08-16', 'jackg@yahoo.com', 'jackg', 'male', '2020-04-13 18:14:59', 22),
(26, 2, 'Hank', 'Falcon', '1980-08-17', 'hfalcon@gmail.com', 'hfalcon', 'male', '2020-04-13 19:23:22', 22),
(27, 3, 'Nika', 'Nika', '2020-04-01', 'nika', 'nika', 'female', '2020-04-13 20:19:49', 22),
(29, 4, 'Lauren', 'Tess', '2002-07-14', 'tess2002@gmail.com', 'tess2002', 'female', '2020-04-13 20:40:47', 22),
(30, 1, 'Jannet', 'Johnson', '1990-10-31', 'animal', 'animal', 'female', '2020-04-13 20:42:27', 22),
(31, 2, 'John', 'Toast', '1990-10-31', 'member', 'member', 'male', '2020-04-13 20:43:07', 22),
(32, 3, 'Manila', 'Luzon', '1990-10-31', 'ride90', 'ride', 'female', '2020-04-13 20:43:34', 22),
(33, 5, 'Gigi', 'Goode', '1990-10-31', 'sale90', 'sale', 'female', '2020-04-13 20:44:18', 22),
(34, 5, 'Kaitlin', 'Mending', '1994-07-19', 'km9419@aol.com', 'km9419', 'female', '2020-04-13 20:44:34', 22),
(35, 6, 'Katya', 'Zamolodchikova', '1990-10-31', 'product', 'product', 'female', '2020-04-13 20:45:46', 22),
(36, 3, 'Joe', 'Snapper', '1964-09-08', 'snapperj64@yahoo.com', 'snapperj64', 'male', '2020-04-13 20:46:26', 22),
(38, 5, 'Brian', 'Finch', '1964-10-07', 'sale64', 'sale64', 'Male', '2020-04-13 20:50:33', 22),
(39, 3, 'Leo', 'Black', '2020-04-01', 'ride', 'ride', 'male', '2020-04-13 20:59:08', 22),
(40, 4, 'SuperAd2', 'SuperAd2', '2020-04-08', 'sup2', 'sup2', 'male', '2020-04-13 21:54:58', 22),
(41, 3, 'Olga', 'White', '2020-04-09', '123456', '123456', 'female', '2020-04-13 21:55:54', 40),
(42, 6, 'James', 'Turner', '1988-11-21', 'jturner@gmail.com', 'supersecretpassword', 'male', '2020-04-13 21:58:03', 40),
(43, 6, 'Pang', 'Tin', '1995-08-08', 'product99', 'product99', 'female', '2020-04-13 21:58:06', 40);

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `MAX_EMPLOYEES` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
IF(((NEW.department_id <> 4) 
  AND
  (SELECT COUNT(*) FROM user WHERE NEW.department_id = user.department_id) >= 10)
OR
  ((NEW.department_id = 4)
  AND
  (SELECT COUNT(*) FROM user WHERE NEW.department_id = user.department_id) >= 3))
THEN
          SIGNAL SQLSTATE VALUE '45000'
          SET MESSAGE_TEXT = 'You already reached the max number of employees for this department.';
          END IF;
          END
$$
DELIMITER ;

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
-- Indexes for table `unusual_sale`
--
ALTER TABLE `unusual_sale`
  ADD PRIMARY KEY (`unusual_sale_id`);

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
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ride`
--
ALTER TABLE `ride`
  MODIFY `ride_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `unusual_sale`
--
ALTER TABLE `unusual_sale`
  MODIFY `unusual_sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
