-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2026 at 09:30 AM
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
-- Database: `gym_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_record`
--

CREATE TABLE `attendance_record` (
  `attendance_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `checkin_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_income`
--

CREATE TABLE `daily_income` (
  `income_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `audit_note` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_pass`
--

CREATE TABLE `daily_pass` (
  `pass_id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `visitor_type` varchar(50) DEFAULT NULL,
  `valid_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_check`
--

CREATE TABLE `equipment_check` (
  `equipment_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `equipment_name` varchar(255) DEFAULT NULL,
  `condition` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_log`
--

CREATE TABLE `inventory_log` (
  `log_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership_applications`
--

CREATE TABLE `membership_applications` (
  `application_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'member',
  `status` enum('pending','active','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_applications`
--

INSERT INTO `membership_applications` (`application_id`, `fullname`, `email`, `phone`, `photo_path`, `role`, `status`, `created_at`) VALUES
(1, 'Gabrielle Calica', 'calicagab69@gmail.com', '+639752736755', 'uploads/applications/app_697b1a631667f.jpg', 'member', 'pending', '2026-01-29 08:29:23');

-- --------------------------------------------------------

--
-- Table structure for table `membership_record`
--

CREATE TABLE `membership_record` (
  `record_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_card`
--

CREATE TABLE `qr_card` (
  `qr_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `issue_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance_record`
--
ALTER TABLE `attendance_record`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `daily_income`
--
ALTER TABLE `daily_income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `daily_pass`
--
ALTER TABLE `daily_pass`
  ADD PRIMARY KEY (`pass_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `equipment_check`
--
ALTER TABLE `equipment_check`
  ADD PRIMARY KEY (`equipment_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `inventory_log`
--
ALTER TABLE `inventory_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `membership_applications`
--
ALTER TABLE `membership_applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `membership_record`
--
ALTER TABLE `membership_record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `qr_card`
--
ALTER TABLE `qr_card`
  ADD PRIMARY KEY (`qr_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_record`
--
ALTER TABLE `attendance_record`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_income`
--
ALTER TABLE `daily_income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_pass`
--
ALTER TABLE `daily_pass`
  MODIFY `pass_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipment_check`
--
ALTER TABLE `equipment_check`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_log`
--
ALTER TABLE `inventory_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership_applications`
--
ALTER TABLE `membership_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `membership_record`
--
ALTER TABLE `membership_record`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qr_card`
--
ALTER TABLE `qr_card`
  MODIFY `qr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_record`
--
ALTER TABLE `attendance_record`
  ADD CONSTRAINT `attendance_record_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`),
  ADD CONSTRAINT `attendance_record_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `daily_income`
--
ALTER TABLE `daily_income`
  ADD CONSTRAINT `daily_income_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `daily_pass`
--
ALTER TABLE `daily_pass`
  ADD CONSTRAINT `daily_pass_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`);

--
-- Constraints for table `equipment_check`
--
ALTER TABLE `equipment_check`
  ADD CONSTRAINT `equipment_check_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `inventory_log`
--
ALTER TABLE `inventory_log`
  ADD CONSTRAINT `inventory_log_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `inventory_log_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `membership_record`
--
ALTER TABLE `membership_record`
  ADD CONSTRAINT `membership_record_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`),
  ADD CONSTRAINT `membership_record_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `qr_card`
--
ALTER TABLE `qr_card`
  ADD CONSTRAINT `qr_card_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
