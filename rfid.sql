-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2017 at 11:54 AM
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
-- Table structure for table `app_config`
--

CREATE TABLE `app_config` (
  `id` int(11) NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `client_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_config`
--

INSERT INTO `app_config` (`id`, `password`, `client_name`, `version`, `deleted`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'demo', '1.00', 0);

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
  `grade` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `schedule` text COLLATE utf8_unicode_ci NOT NULL,
  `room` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `grade`, `teacher_id`, `schedule`, `room`, `deleted`) VALUES
(1, 'Class 2s', '2nd grade', 0, '', '', 0),
(2, 'Silver', '2nd gradesss', 2, '', '', 0);

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
(1, 2, 1491807357, 1491753600, 'entry', 1, 'students'),
(2, 4, 1491807385, 1491753600, 'entry', 2, 'students'),
(3, 3, 1491807766, 1491753600, 'entry', 1, 'teachers'),
(4, 6, 1491807845, 1491753600, 'entry', 2, 'teachers'),
(5, 3, 1491807931, 1491753600, 'exit', 1, 'teachers'),
(6, 1, 1491809127, 1491753600, 'entry', 1, 'staffs'),
(7, 5, 1491809129, 1491753600, 'entry', 2, 'staffs');

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `guardians` (`id`, `name`, `guardian_address`, `contact_number`, `sms_subscription`, `email_subscription`, `email_address`, `password`, `deleted`) VALUES
(1, 'asdasd', 'address', '09301167850', 1, 1, 'jpgulayan@gmail.com', 'a9dea56ac27eeb0fc7466755d1d74d85', 0),
(2, 'jjj', '', '09324019546', 1, 1, 'jpgulayan@gmail.coms', '2b400702d514c79b0f9bcde29f25c180', 0);

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
-- Table structure for table `jbtech`
--

CREATE TABLE `jbtech` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jbtech`
--

INSERT INTO `jbtech` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

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
(1, '201', 0, 1, 'staffs', 0, 1, 0),
(2, '123', 0, 1, 'students', 0, 1, 0),
(3, '101', 0, 1, 'teachers', 0, 1, 0),
(4, '321', 0, 2, 'students', 0, 1, 0),
(5, '202', 0, 2, 'staffs', 0, 1, 0),
(6, '102', 0, 2, 'teachers', 0, 1, 0),
(7, '', 0, 3, 'teachers', 0, 1, 0);

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
(1, 1491753600, 1491818059, 1, 'admins');

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
(1, 1, 'This is a test', '09301167850', 'last, first m. suffix', 0, 'Success! Message is now on queue and will be sent soon.');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` bigint(20) NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` int(11) NOT NULL,
  `position` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `display_photo` text COLLATE utf8_unicode_ci NOT NULL,
  `display_photo_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rfid_status` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `gender`, `contact_number`, `birthdate`, `position`, `display_photo`, `display_photo_type`, `rfid_status`, `deleted`) VALUES
(1, 'Last Name', 'First Name', 'Middle Name', 'suffix', 'MALE', '', 315504000, 'Positions', '1_Last-Name_First-Name_Middle-Name_suffix.png', '', 1, 0),
(2, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'MALE', '', 315504000, 'TE', 'empty.jpg', '', 1, 0);

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
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` int(11) NOT NULL,
  `gender` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mothers_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fathers_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `display_photo` text COLLATE utf8_unicode_ci NOT NULL,
  `display_photo_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `rfid_status` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `contact_number`, `address`, `birthdate`, `gender`, `mothers_name`, `fathers_name`, `display_photo`, `display_photo_type`, `guardian_id`, `class_id`, `rfid_status`, `deleted`) VALUES
(1, 'last', 'first', 'middle', 'suffix', '09301167850', 'Address', 320601600, 'MALE', 'father', 'mother', 'empty.jpg', '', 1, 2, 1, 0),
(2, 'test', 'Teach', 'Teach', 'test', '', 'ADDress', 349891200, 'FEMALE', '', '', 'empty.jpg', '', 1, 2, 1, 0);

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
  `gender` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` int(11) NOT NULL,
  `display_photo` text COLLATE utf8_unicode_ci NOT NULL,
  `display_photo_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `rfid_status` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `gender`, `contact_number`, `address`, `password`, `birthdate`, `display_photo`, `display_photo_type`, `guardian_id`, `class_id`, `rfid_status`, `deleted`) VALUES
(1, 'Teach', 'Teach', 'Teach', 'test', 'MALE', '09301167850', 'Address', '9903b681b732f67d52fad85b1fd601ba', 347212800, 'empty.jpg', '', 0, 0, 1, 0),
(2, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'MALE', '09301167851', 'address', '3d82576b589c04b0caeae416b691edac', 349804800, 'empty.jpg', '', 0, 2, 1, 0),
(3, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'FEMALE', '09301167852', 'address', '8bfeae4af515f79ff48aaad533da85fe', 383846400, 'empty.jpg', '', 0, 0, 0, 0);

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
-- Indexes for table `app_config`
--
ALTER TABLE `app_config`
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
-- Indexes for table `jbtech`
--
ALTER TABLE `jbtech`
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
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
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
-- AUTO_INCREMENT for table `app_config`
--
ALTER TABLE `app_config`
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gate_logs`
--
ALTER TABLE `gate_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `guards`
--
ALTER TABLE `guards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jbtech`
--
ALTER TABLE `jbtech`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rfid`
--
ALTER TABLE `rfid`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sms_list`
--
ALTER TABLE `sms_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `time_logs`
--
ALTER TABLE `time_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
