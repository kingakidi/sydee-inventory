-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2021 at 04:26 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esphem`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `branch_address` varchar(255) NOT NULL,
  `facility_type` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number_of_shops` int(11) NOT NULL,
  `rental_cost` int(11) NOT NULL,
  `rental_expiring_date` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch_name`, `branch_address`, `facility_type`, `user_id`, `number_of_shops`, `rental_cost`, `rental_expiring_date`, `status`, `date`) VALUES
(1, 'ganaja junction', 'suite 1, destiny garden plaza, lokoja, kog state', 'mall', 3, 2, 650000, '2021-04-30', 'active', '2021-02-24 17:40:01'),
(2, 'nepa', 'suite 1, opposite nepa, lokoja, kogi state', 'mall', 3, 1, 100000, '2021-12-30', 'active', '2021-02-24 17:41:08');

-- --------------------------------------------------------

--
-- Table structure for table `branch_items`
--

CREATE TABLE `branch_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch_items`
--

INSERT INTO `branch_items` (`id`, `user_id`, `branch_id`, `item_id`, `qty`, `date`) VALUES
(1, 3, 1, 1, 32, '2021-02-24 17:43:20'),
(2, 3, 1, 2, 28, '2021-02-24 17:43:55'),
(3, 3, 1, 3, 60, '2021-02-24 17:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `user_id`, `date`) VALUES
(1, 'power', 3, '2021-02-24 17:24:45'),
(2, 'Poweri', 3, '2021-02-24 17:25:03'),
(3, 'cables', 3, '2021-02-24 17:25:18'),
(4, 'others', 3, '2021-02-24 17:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `creditor`
--

CREATE TABLE `creditor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `organization` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'approved'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `branch_id`, `user_id`, `section`, `amount`, `description`, `date`, `status`) VALUES
(1, 1, 3, 'sales', 878, 'fuel', '2021-02-24 20:47:34', 'approved'),
(2, 1, 3, 'general', 500, 'fuel', '2021-02-25 08:24:52', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `program_type` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `reg_no`, `branch_id`, `fullname`, `phone`, `program_type`, `amount`, `comment`, `user_id`, `status`, `date`) VALUES
(1, 'ete/0900/2022', 1, 'ilyas sherifudeen', '09088788788', '6-months-diploma', 1000, 'matt', 3, 'pending', '2021-02-24 18:03:36'),
(2, 'etf/0045/2023', 1, 'ilyas sherifudeen', '09088788788', '6-months-diploma', 1000, 'matt', 3, 'pending', '2021-02-24 18:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `image` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `sub_category_id`, `name`, `qty`, `cost_price`, `selling_price`, `image`, `user_id`, `status`, `date`) VALUES
(1, 1, 1, '32 gb flash', 40, 1300, 2000, '3_32 gb flash_2021-02-24.jpg', 3, 'active', '2021-02-24 17:43:20'),
(2, 1, 1, '16 gb flash', 40, 1300, 2000, '3_16 gb flash_2021-02-24.jpg', 3, 'active', '2021-02-24 17:43:55'),
(3, 1, 1, '8 gb flash', 20, 200, 500, '3_8 gb flash_2021-02-26.jpg', 3, 'active', '2021-02-26 14:09:30'),
(4, 1, 2, '8 gb flash', 80, 200, 500, '3_8 gb flash_2021-02-24.jpg', 3, 'active', '2021-02-24 17:34:50'),
(5, 1, 2, '8 gb otg flash', 80, 200, 500, '3_8 gb otg flash_2021-02-24.jpg', 3, 'active', '2021-02-24 17:35:01'),
(6, 1, 2, '16 gb otg flash', 80, 200, 500, '3_16 gb otg flash_2021-02-24.jpg', 3, 'active', '2021-02-24 17:35:10'),
(7, 1, 2, '32 gb otg flash', 80, 200, 500, '3_32 gb otg flash_2021-02-24.jpg', 3, 'active', '2021-02-24 17:35:16'),
(8, 2, 3, '8 gb flash', 20, 200, 500, '3_8 gb flash_2021-02-26.png', 3, 'active', '2021-02-26 10:48:07'),
(9, 2, 4, '8 gb flash', 40, 200, 600, '3_8 gb flash_2021-02-26.jpg', 3, 'active', '2021-02-26 14:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `fees` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

CREATE TABLE `revenue` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'paid',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`id`, `branch_id`, `user_id`, `item_id`, `item_name`, `selling_price`, `qty`, `amount`, `section`, `payment_type`, `status`, `date`, `comment`) VALUES
(1, 1, 3, 1, '', 2000, 3, 2700, 'sales', 'cash', 'paid', '2021-02-24 17:54:51', 'within range'),
(2, 1, 3, 1, '', 2000, 15, 30000, 'sales', 'cash', 'paid', '2021-02-24 17:55:26', 'within range'),
(3, 1, 3, 0, 'waecreg', 5, 5, 25, 'internet', 'cash', 'paid', '2021-02-24 18:01:43', 'matt'),
(4, 1, 3, 0, 'ete/0900/2022', 1000, 1, 1000, 'form', 'cash', 'completed', '2021-02-24 18:03:36', 'matt'),
(5, 1, 3, 0, 'etf/0045/2023', 1000, 1, 1000, 'form', 'cash', 'completed', '2021-02-24 18:05:44', 'matt'),
(6, 1, 3, 0, 'laminating', 234, 2, 468, 'internet', 'unionbank', 'paid', '2021-02-25 08:24:25', 'me'),
(7, 1, 3, 0, 'airforcereg', 1000, 2, 2000, 'internet', 'unionbank', 'paid', '2021-02-25 08:24:36', 'me'),
(8, 1, 3, 0, 'navyreg', 987, 1, 987, 'internet', 'cash', 'paid', '2021-02-26 15:20:09', 'e'),
(9, 1, 3, 0, 'photocopy', 12, 1, 12, 'internet', 'cash', 'paid', '2021-02-26 15:21:34', 'yeks'),
(10, 1, 3, 0, 'hdd', 9800, 1, 9800, 'engineering', 'cash', 'paid', '2021-02-26 15:21:51', 'akdjk'),
(11, 1, 3, 2, '', 2000, 3, 6000, 'sales', 'cash', 'paid', '2021-02-26 15:23:57', 'yesk'),
(12, 1, 3, 2, '', 2000, 12, 24000, 'sales', 'cash', 'paid', '2021-02-26 15:24:46', 'yes'),
(13, 1, 3, 2, '', 2000, 7, 14000, 'sales', 'cash', 'paid', '2021-02-26 15:25:16', 'yeks');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `category_id`, `sub_category_name`, `user_id`, `date`) VALUES
(1, 1, 'normal flash', 3, '2021-02-24 17:26:00'),
(2, 1, 'otg flash', 3, '2021-02-24 17:26:12'),
(3, 2, 'adapter', 3, '2021-02-24 17:26:30'),
(4, 2, 'desktop power pack', 3, '2021-02-24 17:27:20'),
(5, 4, 'others', 3, '2021-02-24 17:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `reg_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_address` varchar(255) NOT NULL,
  `program_type` varchar(255) NOT NULL,
  `amount_charge` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `fill_form` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `verification_code` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `phone`, `branch_id`, `gender`, `password`, `type`, `verification_code`, `status`, `date`) VALUES
(1, 'kingakidi', 'aka\'aba musa akidi', 'kingakidi@gmail.com', '07064711513', 1, 'male', '$2y$10$sv.RrvUWKkGjCPsQE21Zsu29TjN4TjFvEtDcPnwEi.tlVTyENfixK', 'user', '$2y$10$5obMjhqz2Iac8dzIhbYbt.lSZuHjoJFaezgBXoHk1OEMXwRZW5PqS', 'active', '2021-01-24 13:46:12'),
(2, 'yusufaliu', 'yusuf ali', 'yusufali@gmail.com', '08130356199', 0, 'male', '$2y$10$jheHr2XqovGQAhIVbyxsPe6lTQtrtjPkDMH0d0E6IIJZqJcFNJ6WW', 'user', '$2y$10$3WdyvWcl0YyCYl3KmjKlZ.dEmml/VDc3COjL04np1XR1Fr3sRxWFi', 'active', '2021-01-26 17:59:16'),
(3, 'esphem', 'adeboyin bamidele matthew', 'esphemtechnology@gmail.com', '08185485182', 1, 'male', '$2y$10$9u/7jbsjQgRK/KnV2DXZwOti7Hh7hV/CAY.FRQ0DYZUFcd8/F25VG', 'user', '$2y$10$QMhOHAep0ya7a4NfYMDS..WBuNqCsJUfdS6SbyhXu2OeI5xyk6F76', 'active', '2021-02-24 17:21:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_items`
--
ALTER TABLE `branch_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creditor`
--
ALTER TABLE `creditor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revenue`
--
ALTER TABLE `revenue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
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
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branch_items`
--
ALTER TABLE `branch_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `creditor`
--
ALTER TABLE `creditor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
