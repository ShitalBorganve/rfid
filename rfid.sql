-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2017 at 05:02 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rfid`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `deleted`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `canteens`
--

CREATE TABLE `canteens` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canteen_items`
--

CREATE TABLE `canteen_items` (
  `id` bigint(20) NOT NULL,
  `category` text COLLATE utf8_unicode_ci NOT NULL,
  `item_name` text COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `stocks` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `canteen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canteen_purchases`
--

CREATE TABLE `canteen_purchases` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `date_time` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `canteen_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_comments` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canteen_purchase_items`
--

CREATE TABLE `canteen_purchase_items` (
  `id` bigint(20) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` double NOT NULL,
  `date` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `cateen_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canteen_sales`
--

CREATE TABLE `canteen_sales` (
  `id` bigint(20) NOT NULL,
  `customer_rfid_id` bigint(20) NOT NULL,
  `customer_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `date_time` int(11) NOT NULL,
  `total_cost` double NOT NULL,
  `total_sales` double NOT NULL,
  `canteen_id` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_comments` text COLLATE utf8_unicode_ci NOT NULL,
  `canteen_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canteen_sale_items`
--

CREATE TABLE `canteen_sale_items` (
  `id` bigint(20) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `customer_rfid_id` bigint(20) NOT NULL,
  `canteen_user_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `canteen_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canteen_users`
--

CREATE TABLE `canteen_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` text COLLATE utf8_unicode_ci NOT NULL,
  `canteen_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) NOT NULL,
  `class_name` text COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `schedule` text COLLATE utf8_unicode_ci NOT NULL,
  `room` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `teacher_id`, `schedule`, `room`, `deleted`) VALUES
(1, 'Class 2s', 0, 'c', 'Class 2', 0),
(2, 'Class 2s', 0, 'c1231', 'Class 2', 0),
(3, 'Class 2s', 0, 'c', 'Class 2', 0),
(4, 'Class 2s', 0, 'c', 'Class 2', 0),
(5, 'Class 2s', 0, 'c', 'Class 2', 0),
(6, 'Class 2s', 0, 'c', 'Class 2', 0),
(7, 'Class 2s', 0, 'caaa', 'Class 2', 0),
(8, 'Class', 4, 'c', 'Class 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gate_logs`
--

CREATE TABLE `gate_logs` (
  `id` bigint(20) NOT NULL,
  `rfid_id` bigint(20) NOT NULL,
  `date_time` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ref_id` bigint(20) NOT NULL,
  `ref_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_logs`
--

INSERT INTO `gate_logs` (`id`, `rfid_id`, `date_time`, `date`, `type`, `ref_id`, `ref_table`) VALUES
(13, 4, 1490890938, 1490889600, 'entry', 1, 'students'),
(14, 4, 1490937397, 1490889600, 'exit', 1, 'students'),
(15, 5, 1490937411, 1490889600, 'entry', 2, 'students');

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `sms_subscription` int(11) NOT NULL,
  `email_subscription` int(11) NOT NULL,
  `email_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `name`, `contact_number`, `sms_subscription`, `email_subscription`, `email_address`, `password`, `deleted`) VALUES
(1, 'john paul', '09301167850', 1, 1, 'jpgulayan@gmail.com', 'e40f24949bd2400d484cfd563b170414', 0),
(2, 'john paul', '', 0, 0, 'jpgulayan@gmail.comss', 'd92e07e495e65d0c491b9ee941e11fab', 0),
(3, 'john paul', '09301167852', 0, 0, 'jpgulayan@gmail.coms', '36bf0bdc74d77bf038cf7a95ea64ace4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `guards`
--

CREATE TABLE `guards` (
  `id` bigint(20) NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` int(11) NOT NULL,
  `display_photo` text COLLATE utf8_unicode_ci NOT NULL,
  `display_photo_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rfid`
--

CREATE TABLE `rfid` (
  `id` bigint(20) NOT NULL,
  `rfid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `load_credits` double NOT NULL,
  `ref_id` bigint(20) NOT NULL,
  `ref_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pin` int(11) NOT NULL,
  `valid` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rfid`
--

INSERT INTO `rfid` (`id`, `rfid`, `load_credits`, `ref_id`, `ref_table`, `pin`, `valid`, `deleted`) VALUES
(1, '22211', 0, 1, 'teachers', 0, 1, 0),
(2, '221133', 0, 2, 'teachers', 0, 1, 0),
(3, '221133', 0, 3, 'teachers', 0, 1, 0),
(4, '2221', 0, 1, 'students', 0, 1, 0),
(5, '11', 0, 2, 'students', 0, 1, 0),
(6, '221', 0, 4, 'teachers', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `date_time` int(11) NOT NULL,
  `sent_by_id` int(11) NOT NULL,
  `sent_by_table` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`id`, `date`, `date_time`, `sent_by_id`, `sent_by_table`) VALUES
(1, 1491148800, 1491213059, 0, ''),
(2, 1491148800, 1491213106, 0, ''),
(3, 1491148800, 1491213371, 0, ''),
(4, 1491148800, 1491215054, 0, ''),
(5, 1491148800, 1491215108, 0, ''),
(6, 1491148800, 1491215110, 0, ''),
(7, 1491148800, 1491215151, 0, ''),
(8, 1491148800, 1491215274, 0, ''),
(9, 1491148800, 1491215275, 0, ''),
(10, 1491148800, 1491215357, 0, ''),
(11, 1491148800, 1491215415, 0, ''),
(12, 1491148800, 1491215418, 0, ''),
(13, 1491148800, 1491215437, 0, ''),
(14, 1491148800, 1491215517, 0, ''),
(15, 1491148800, 1491215541, 0, ''),
(16, 1491148800, 1491215686, 0, ''),
(17, 1491148800, 1491215688, 0, ''),
(18, 1491148800, 1491215749, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sms_list`
--

CREATE TABLE `sms_list` (
  `id` bigint(20) NOT NULL,
  `sms_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `mobile_number` varchar(11) NOT NULL,
  `recipient` text NOT NULL,
  `status_code` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_list`
--

INSERT INTO `sms_list` (`id`, `sms_id`, `message`, `mobile_number`, `recipient`, `status_code`, `status`) VALUES
(1, 1, 'Announcement number 2', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(2, 1, 'Announcement number 2', '09301167851', 'jhjh, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(3, 1, 'Announcement number 2', '09301167854', 'test, Teach T. ', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(4, 1, 'Announcement number 2', '09301167852', 'Teach, Teach T. test', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(5, 1, 'Announcement number 2', '09301167853', 'Teach, Teach T. test', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(6, 1, 'Announcement number 2', '09301167850', 'aaaa, asdsdfsdfs a. aaaa', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(7, 1, 'Announcement number 2', '09301167852', 'john paul', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(8, 1, 'Announcement number 2', '09301167850', 'john paul', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(9, 2, 'Announcement number 3', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(10, 3, 'Test', '09301167851', 'jhjh, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(11, 4, 'Test', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(12, 5, 'Test', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(13, 6, 'Test', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(14, 7, 'Test', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(15, 8, 'TEST', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(16, 9, 'TEST', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(17, 10, 'sadasd', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(18, 11, 'TESST', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(19, 12, 'TESST', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(20, 13, 'TEST', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(21, 14, 'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(22, 15, 'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(23, 16, 'lorem Ipsum  lorem Ipsum lorem Ipsum  lorem Ipsum', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(24, 17, 'lorem Ipsum  lorem Ipsum lorem Ipsum  lorem Ipsum', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.'),
(25, 18, 'lorem Ipsum  lorem Ipsum lorem Ipsum  lorem Ipsumlorem Ipsum  lorem Ipsum lorem Ipsum  lorem Ipsum', '09301167850', 'jhbhjbhjbhj, jjhbhjbhjhbj j. jhbjhbhjhj', 4, 'Maximum Message per day reached. This will be reset every 12MN.');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` int(11) NOT NULL,
  `display_photo` text COLLATE utf8_unicode_ci NOT NULL,
  `display_photo_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `contact_number`, `birthdate`, `display_photo`, `display_photo_type`, `guardian_id`, `class_id`, `deleted`) VALUES
(1, 'jhbhjbhjbhj', 'jjhbhjbhjhbj', 'jhjh', 'jhbjhbhjhj', '09301167850', 347126400, 'empty.jpg', '', 3, 8, 0),
(2, 'jhjh', 'jjhbhjbhjhbj', 'jhjh', 'jhbjhbhjhj', '09301167851', 347126400, 'empty.jpg', '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` int(11) NOT NULL,
  `display_photo` text COLLATE utf8_unicode_ci NOT NULL,
  `display_photo_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `contact_number`, `birthdate`, `display_photo`, `display_photo_type`, `guardian_id`, `class_id`, `deleted`) VALUES
(1, 'test', 'Teach', 'Teach', '', '09301167854', 410284800, 'empty.jpg', '', 0, 0, 0),
(2, 'Teach', 'Teach', 'Teach', 'test', '09301167852', 347212800, 'empty.jpg', '', 0, 0, 0),
(3, 'Teach', 'Teach', 'Teach', 'test', '09301167853', 347212800, 'empty.jpg', '', 0, 0, 0),
(4, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', '09301167850', 378748800, 'empty.jpg', '', 0, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `time_logs`
--

CREATE TABLE `time_logs` (
  `id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `type` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `date_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canteens`
--
ALTER TABLE `canteens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canteen_items`
--
ALTER TABLE `canteen_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canteen_purchases`
--
ALTER TABLE `canteen_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canteen_purchase_items`
--
ALTER TABLE `canteen_purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canteen_sales`
--
ALTER TABLE `canteen_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canteen_sale_items`
--
ALTER TABLE `canteen_sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canteen_users`
--
ALTER TABLE `canteen_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gate_logs`
--
ALTER TABLE `gate_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guards`
--
ALTER TABLE `guards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfid`
--
ALTER TABLE `rfid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_list`
--
ALTER TABLE `sms_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_logs`
--
ALTER TABLE `time_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `canteens`
--
ALTER TABLE `canteens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `canteen_items`
--
ALTER TABLE `canteen_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `canteen_purchases`
--
ALTER TABLE `canteen_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `canteen_purchase_items`
--
ALTER TABLE `canteen_purchase_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `canteen_sales`
--
ALTER TABLE `canteen_sales`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `canteen_sale_items`
--
ALTER TABLE `canteen_sale_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `canteen_users`
--
ALTER TABLE `canteen_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `gate_logs`
--
ALTER TABLE `gate_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `guards`
--
ALTER TABLE `guards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rfid`
--
ALTER TABLE `rfid`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `sms_list`
--
ALTER TABLE `sms_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `time_logs`
--
ALTER TABLE `time_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
