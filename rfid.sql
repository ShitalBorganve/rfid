-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2017 at 01:33 PM
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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0),
(2, 'admins', '21232f297a57a5a743894a0e4a801fc3', 0),
(3, 'admin1', '435cf92c486ad7eb00af889a1049cc3c', 0),
(4, 'adminaass', '89c8bfeda88f98cdd2c09e02f1abbd9d', 0),
(5, 'admin11', '0aaf7c3566870c7f35c1f1a58fcea9e3', 0);

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
(1, 'Diamond', '2nd grade', 1, '', '', 0),
(2, 'Silver', '2nd gradesss', 0, '', '', 0);

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
(7, 5, 1491809129, 1491753600, 'entry', 2, 'staffs'),
(8, 3, 1491970970, 1491926400, 'entry', 1, 'teachers'),
(9, 4, 1492494474, 1492444800, 'entry', 2, 'students'),
(10, 4, 1492494675, 1492444800, 'exit', 2, 'students'),
(11, 1, 1493110453, 1493049600, 'entry', 1, 'staffs'),
(12, 4, 1493112474, 1493049600, 'entry', 2, 'students'),
(13, 1, 1493112766, 1493049600, 'exit', 1, 'staffs'),
(14, 1, 1493112850, 1493049600, 'entry', 1, 'staffs'),
(15, 5, 1493112898, 1493049600, 'entry', 2, 'staffs'),
(16, 1, 1493112916, 1493049600, 'exit', 1, 'staffs'),
(17, 1, 1493112982, 1493049600, 'entry', 1, 'staffs'),
(18, 1, 1493113052, 1493049600, 'exit', 1, 'staffs'),
(19, 1, 1493113115, 1493049600, 'entry', 1, 'staffs'),
(20, 1, 1493113207, 1493049600, 'exit', 1, 'staffs'),
(21, 4, 1493113252, 1493049600, 'exit', 2, 'students'),
(22, 4, 1493177837, 1493136000, 'entry', 2, 'students'),
(23, 4, 1493178032, 1493136000, 'exit', 2, 'students'),
(24, 2, 1493178070, 1493136000, 'entry', 1, 'students');

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
(1, 'asdasd', 'address', '09301167850', 1, 1, 'jpgulayan@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'jjj', '', '09301167851', 1, 1, 'jpgulayan@gmail.coms', '2b400702d514c79b0f9bcde29f25c180', 0),
(3, 'asd', 'address', '09301167820', 1, 1, 'jpgulayan@gmail.com', '7d142498320a6c13393ad8544d4f730e', 0),
(4, 'asdasd', 'address', '09301167821', 0, 0, 'jpgulayan@gmail.com', 'b7736cb9372eccf3329e28d61cd5b1c6', 0),
(5, 'John Paul Gulayan', 'R. Castillo', '09301167822', 1, 1, 'jpgulayan@gmail.com', '5e8676c207ce53957fe1d81f7152a925', 0),
(6, 'John Paul Gulayan', 'R. Castillo', '93011678500', 0, 0, 'jpgulayan@gmail.com', 'd90d4c54bf1b41261f19c4ce9ef8919b', 0),
(7, 'John Paul Gulayan', 'R. Castillo', '93011678501', 1, 1, 'jpgulayan@gmail.com', '5dd7e756acadc7cdad5180926b05d727', 0),
(8, 'John Paul Gulayan', 'R. Castillo', '09301167850', 1, 1, 'jpgulayan@gmail.com', 'a2e9a4ab48d1d02abb15cdd4fcb5c351', 0);

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
  `valid_date` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rfid`
--

INSERT INTO `rfid` (`id`, `rfid`, `load_credits`, `ref_id`, `ref_table`, `pin`, `valid`, `valid_date`, `deleted`) VALUES
(1, '221', 0, 1, 'staffs', 0, 1, 1646323200, 0),
(2, '1231', 0, 1, 'students', 0, 1, 1643904000, 0),
(3, '', 0, 1, 'teachers', 0, 1, 1585929600, 0),
(4, '', 0, 2, 'students', 0, 1, 1549123200, 0),
(5, '112', 0, 2, 'staffs', 0, 1, 1546358400, 0),
(6, '12311', 0, 2, 'teachers', 0, 1, 1551456000, 0),
(7, '1231126', 0, 3, 'teachers', 0, 1, 1551456000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rfid_photo`
--

CREATE TABLE `rfid_photo` (
  `id` bigint(20) NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rfid_photo`
--

INSERT INTO `rfid_photo` (`id`, `name`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0),
(13, 0),
(14, 0);

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
(1, 1491753600, 1491818059, 1, 'admins'),
(2, 1491753600, 1491818876, 1, 'admins'),
(3, 1492617600, 1492678529, 1, 'admins'),
(4, 1492617600, 1492678634, 1, 'admins'),
(5, 1492617600, 1492678674, 1, 'admins'),
(6, 1492617600, 1492678695, 1, 'admins'),
(7, 1492617600, 1492678721, 1, 'admins'),
(8, 1492617600, 1492678841, 1, 'admins'),
(9, 1492617600, 1492678867, 1, 'admins'),
(10, 1492617600, 1492678899, 1, 'admins'),
(11, 1492617600, 1492678971, 1, 'admins'),
(12, 1492617600, 1492679373, 1, 'admins'),
(13, 1492617600, 1492679430, 1, 'admins'),
(14, 1492617600, 1492679666, 1, 'admins'),
(15, 1492617600, 1492679690, 1, 'admins'),
(16, 1492617600, 1492679744, 1, 'admins'),
(17, 1492617600, 1492679791, 1, 'admins'),
(18, 1492617600, 1492679858, 1, 'admins'),
(19, 1492617600, 1492680296, 1, 'admins'),
(20, 1492617600, 1492680313, 1, 'admins'),
(21, 1492617600, 1492680369, 1, 'admins'),
(22, 1492617600, 1492680448, 1, 'admins'),
(23, 1492617600, 1492680695, 1, 'admins'),
(24, 1492617600, 1492680982, 1, 'admins'),
(25, 1492704000, 1492740514, 1, 'admins'),
(26, 1492704000, 1492740562, 1, 'admins'),
(27, 1492704000, 1492740846, 1, 'admins'),
(28, 1492704000, 1492740995, 1, 'admins'),
(29, 1492704000, 1492741053, 1, 'admins'),
(30, 1492704000, 1492741388, 1, 'admins'),
(31, 1492704000, 1492741422, 1, 'admins'),
(32, 1492704000, 1492741458, 1, 'admins'),
(33, 1492704000, 1492741606, 1, 'admins'),
(34, 1492704000, 1492741636, 1, 'admins'),
(35, 1492704000, 1492741940, 1, 'admins'),
(36, 1492704000, 1492746759, 1, 'admins'),
(37, 1492704000, 1492746770, 1, 'admins'),
(38, 1492704000, 1492747397, 1, 'admins'),
(39, 1492704000, 1492749649, 1, 'admins'),
(40, 1492704000, 1492749755, 1, 'admins'),
(41, 1492704000, 1492749810, 1, 'admins'),
(42, 1492704000, 1492749953, 1, 'admins'),
(43, 1492704000, 1492749998, 1, 'admins'),
(44, 1492704000, 1492750037, 1, 'admins'),
(45, 1492704000, 1492750125, 1, 'admins'),
(46, 1492704000, 1492750194, 1, 'admins'),
(47, 1492704000, 1492750399, 1, 'admins'),
(48, 1492704000, 1492750426, 1, 'admins'),
(49, 1492704000, 1492752502, 1, 'admins'),
(50, 1492704000, 1492754555, 1, 'admins'),
(51, 1492704000, 1492754591, 1, 'admins'),
(52, 1492704000, 1492754592, 1, 'admins'),
(53, 1492704000, 1492754984, 1, 'admins'),
(54, 1492704000, 1492755128, 1, 'admins'),
(55, 1492704000, 1492755146, 1, 'admins'),
(56, 1492704000, 1492756595, 1, 'admins'),
(57, 1492704000, 1492756616, 1, 'admins'),
(58, 1492704000, 1492756677, 1, 'admins'),
(59, 1492704000, 1492757108, 1, 'admins'),
(60, 1492704000, 1492758036, 1, 'admins'),
(61, 1492704000, 1492758050, 1, 'admins'),
(62, 1492704000, 1492759688, 1, 'admins'),
(63, 1492704000, 1492759776, 1, 'admins'),
(64, 1492704000, 1492761558, 1, 'admins'),
(65, 1492704000, 1492762059, 1, 'admins'),
(66, 1492704000, 1492762397, 2, 'admins'),
(67, 1492704000, 1492763150, 2, 'admins'),
(68, 1492704000, 1492763929, 2, 'admins'),
(69, 1492704000, 1492764266, 2, 'admins');

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
  `ref_id` bigint(20) NOT NULL,
  `ref_table` varchar(50) NOT NULL,
  `status_code` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_list`
--

INSERT INTO `sms_list` (`id`, `sms_id`, `message`, `mobile_number`, `recipient`, `ref_id`, `ref_table`, `status_code`, `status`) VALUES
(1, 1, 'This is a test', '09301167850', 'last, first m. suffix', 0, '', 0, 'Success! Message is now on queue and will be sent soon.'),
(2, 2, 'Test Message', '09301167850', 'last, first m. suffix', 0, '', 0, 'Success! Message is now on queue and will be sent soon.'),
(3, 2, 'Test Message', '09301167850', 'Teach, Teach T. test', 0, '', 0, 'Success! Message is now on queue and will be sent soon.'),
(4, 2, 'Test Message', '09301167850', 'aaaa, asdsdfsdfs a. aaaa', 0, '', 0, 'Success! Message is now on queue and will be sent soon.'),
(5, 2, 'Test Message', '09301167850', 'aaaa, asdsdfsdfs a. aaaa', 0, '', 0, 'Success! Message is now on queue and will be sent soon.'),
(6, 2, 'Test Message', '09301167850', 'asdasd', 0, '', 0, 'Success! Message is now on queue and will be sent soon.'),
(7, 2, 'Test Message', '09301167850', 'asdasd', 0, '', 0, 'Success! Message is now on queue and will be sent soon.'),
(8, 34, 'sdaf', '09301167851', '', 1, 'students', 0, ''),
(9, 35, 'asdasdasd', '09301167851', '', 1, 'students', 0, ''),
(10, 35, 'asdasdasd', '09301167852', '', 2, 'students', 0, ''),
(11, 35, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(12, 37, 'asdasd', '09301167851', '', 1, 'students', 0, ''),
(13, 37, 'asdasd', '09301167852', '', 2, 'students', 0, ''),
(14, 37, 'asdasd', '09301167850', '', 1, 'teachers', 0, ''),
(15, 38, 'asdasdasd', '09301167851', '', 1, 'students', 0, ''),
(16, 38, 'asdasdasd', '09301167852', '', 2, 'students', 0, ''),
(17, 38, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(18, 39, 'asdasd', '09301167851', '', 1, 'students', 0, ''),
(19, 39, 'asdasd', '09301167850', '', 1, 'teachers', 0, ''),
(20, 39, 'asdasd', '09301167852', '', 2, 'students', 0, ''),
(21, 40, 'asdasd', '09301167850', '', 1, 'teachers', 0, ''),
(22, 40, 'asdasd', '09301167851', '', 1, 'students', 0, ''),
(23, 40, 'asdasd', '09301167852', '', 2, 'students', 0, ''),
(24, 41, 'sadasd', '09301167851', '', 1, 'students', 0, ''),
(25, 41, 'sadasd', '09301167850', '', 1, 'teachers', 0, ''),
(26, 41, 'sadasd', '09301167852', '', 2, 'students', 0, ''),
(27, 42, 'asdasd', '09301167851', '', 1, 'students', 0, ''),
(28, 42, 'asdasd', '09301167850', '', 1, 'teachers', 0, ''),
(29, 42, 'asdasd', '09301167852', '', 2, 'students', 0, ''),
(30, 43, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(31, 43, 'asdasdasd', '09301167851', '', 1, 'students', 0, ''),
(32, 43, 'asdasdasd', '09301167852', '', 2, 'students', 0, ''),
(33, 44, 'asdasd', '09301167850', '', 1, 'teachers', 0, ''),
(34, 44, 'asdasd', '09301167851', '', 1, 'students', 0, ''),
(35, 44, 'asdasd', '09301167852', '', 2, 'students', 0, ''),
(36, 45, 'asdasd', '09301167851', '', 1, 'students', 0, ''),
(37, 45, 'asdasd', '09301167850', '', 1, 'teachers', 0, ''),
(38, 45, 'asdasd', '09301167852', '', 2, 'students', 0, ''),
(39, 46, 'asdasdasd', '09301167852', '', 2, 'students', 0, ''),
(40, 46, 'asdasdasd', '09301167851', '', 1, 'students', 0, ''),
(41, 46, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(42, 47, 'asdaasdklmaklsmdklmklamskldkamklsmdklamskldasd', '09301167852', '', 2, 'students', 0, ''),
(43, 47, 'asdaasdklmaklsmdklmklamskldkamklsmdklamskldasd', '09301167851', '', 1, 'students', 0, ''),
(44, 47, 'asdaasdklmaklsmdklmklamskldkamklsmdklamskldasd', '09301167850', '', 1, 'teachers', 0, ''),
(45, 48, 'asdasdasd', '09301167851', '', 1, 'students', 0, ''),
(46, 48, 'asdasdasd', '09301167852', '', 2, 'students', 0, ''),
(47, 48, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(48, 49, 'asdasasd', '09301167851', '', 1, 'students', 0, ''),
(49, 49, 'asdasasd', '09301167852', '', 2, 'students', 0, ''),
(50, 49, 'asdasasd', '09301167850', '', 1, 'teachers', 0, ''),
(51, 53, 'asdasdasd', '09301167851', '', 1, 'students', 0, ''),
(52, 53, 'asdasdasd', '09301167851', '', 2, 'teachers', 0, ''),
(53, 53, 'asdasdasd', '09301167852', '', 2, 'students', 0, ''),
(54, 53, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(55, 53, 'asdasdasd', '09301167850', '', 1, 'guardians', 0, ''),
(56, 53, 'asdasdasd', '09301167852', '', 3, 'teachers', 0, ''),
(57, 54, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(58, 55, 'asdasdasd', '09301167851', '', 1, 'students', 0, ''),
(59, 55, 'asdasdasd', '09301167852', '', 2, 'students', 0, ''),
(60, 55, 'asdasdasd', '09301167850', '', 1, 'guardians', 0, ''),
(61, 55, 'asdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(62, 57, 'asdasd', '09301167850', '', 1, 'staffs', 0, ''),
(63, 58, 'asdasd', '09088651245', '', 1, 'staffs', 0, ''),
(64, 58, 'asdasd', '09322322322', '', 2, 'staffs', 0, ''),
(65, 59, 'ASDASD', '09088651245', '', 1, 'staffs', 0, ''),
(66, 59, 'ASDASD', '09322322322', '', 2, 'staffs', 0, ''),
(67, 60, 'asdasdasd', '09088651245', '', 1, 'staffs', 0, ''),
(68, 60, 'asdasdasd', '09322322322', '', 2, 'staffs', 0, ''),
(69, 61, 'asdasdasdasd', '09301167851', '', 1, 'students', 0, ''),
(70, 61, 'asdasdasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(71, 61, 'asdasdasdasd', '09301167851', '', 2, 'teachers', 0, ''),
(72, 61, 'asdasdasdasd', '09301167852', '', 2, 'students', 0, ''),
(73, 61, 'asdasdasdasd', '09301167852', '', 3, 'teachers', 0, ''),
(74, 61, 'asdasdasdasd', '09301167850', '', 1, 'guardians', 0, ''),
(75, 61, 'asdasdasdasd', '09088651245', '', 1, 'staffs', 0, ''),
(76, 61, 'asdasdasdasd', '09322322322', '', 2, 'staffs', 0, ''),
(77, 62, 'asasdasd', '09301167851', '', 1, 'students', 0, ''),
(78, 62, 'asasdasd', '09301167850', '', 1, 'teachers', 0, ''),
(79, 62, 'asasdasd', '09301167852', '', 2, 'students', 0, ''),
(80, 63, 'asdasd', '09301167851', '', 1, 'students', 0, ''),
(81, 63, 'asdasd', '09301167852', '', 2, 'students', 0, ''),
(82, 63, 'asdasd', '09301167850', '', 1, 'teachers', 0, ''),
(83, 64, 'asdasdasdasda', '09301167852', ',  . ', 3, 'teachers', 0, ''),
(84, 64, 'asdasdasdasda', '09301167851', 'last, first m. suffix', 1, 'students', 0, ''),
(85, 64, 'asdasdasdasda', '09301167852', 'test, Teach T. test', 2, 'students', 0, ''),
(86, 64, 'asdasdasdasda', '09301167850', ',  . ', 1, 'teachers', 0, ''),
(87, 64, 'asdasdasdasda', '09301167851', ',  . ', 2, 'teachers', 0, ''),
(88, 64, 'asdasdasdasda', '09301167850', 'asdasd', 1, 'guardians', 0, ''),
(89, 64, 'asdasdasdasda', '09088651245', ',  . ', 1, 'staffs', 0, ''),
(90, 64, 'asdasdasdasda', '09322322322', ',  . ', 2, 'staffs', 0, ''),
(91, 65, 'dfgklbvvvbbv', '09301167852', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, ''),
(92, 65, 'dfgklbvvvbbv', '09301167851', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, ''),
(93, 65, 'dfgklbvvvbbv', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, ''),
(94, 65, 'dfgklbvvvbbv', '09301167850', 'asdasd', 1, 'guardians', 0, ''),
(95, 65, 'dfgklbvvvbbv', '09301167851', 'last, first m. suffix', 1, 'students', 0, ''),
(96, 65, 'dfgklbvvvbbv', '09301167852', 'test, Teach T. test', 2, 'students', 0, ''),
(97, 65, 'dfgklbvvvbbv', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, ''),
(98, 65, 'dfgklbvvvbbv', '09322322322', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, ''),
(99, 66, 'asdasd', '09301167851', 'last, first m. suffix', 1, 'students', 0, ''),
(100, 66, 'asdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, ''),
(101, 66, 'asdasd', '09301167852', 'test, Teach T. test', 2, 'students', 0, ''),
(102, 67, 'asdasdasd', '09301167851', 'last, first m. suffix', 1, 'students', 0, ''),
(103, 67, 'asdasdasd', '09301167852', 'test, Teach T. test', 2, 'students', 0, ''),
(104, 67, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, ''),
(105, 68, 'Needless to say that I''m going for the kill.', '09301167851', 'last, first m. suffix', 1, 'students', 0, ''),
(106, 68, 'Needless to say that I''m going for the kill.', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, ''),
(107, 68, 'Needless to say that I''m going for the kill.', '09301167852', 'test, Teach T. test', 2, 'students', 0, ''),
(108, 69, 'Sa lungkot at ligaya kami ang kasama mo', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.');

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
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `staffs` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `gender`, `contact_number`, `address`, `birthdate`, `position`, `display_photo`, `display_photo_type`, `rfid_status`, `deleted`) VALUES
(1, 'Last Name', 'First Name', 'Middle Names', 'suffix', 'MALE', '09088651245', 'Address', 315504000, 'Positions', '1_Last-Name_First-Name_Middle-Names_suffix-269d0e538e11a79ca4df29040ac6beba.png', '', 1, 0),
(2, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'MALE', '09322322322', 'Address', 315504000, 'TE', '2_aaaa_asdsdfsdfs_aaa_aaaa.png', '', 1, 0);

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
(1, 'last', 'first', 'middle', 'suffix', '09301167851', 'Address', 320601600, 'MALE', 'mother', 'father', 'empty.jpg', '', 1, 1, 1, 0),
(2, 'asdaasd', 'Teach', 'Teach', 'test', '09301167852', 'ADDress', 349891200, 'FEMALE', '', '', '2_asdaasd_Teach_Teach_test_bb4d37d345a20e619763e391ff1a46fd.png', '', 0, 1, 0, 0);

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
(1, 'Last Name', 'First Name', 'Middle Name', 'Suffix', 'MALE', '09301167850', 'Address', '21232f297a57a5a743894a0e4a801fc3', 347212800, '1_Last-Name_First-Name_Middle-Name_Suffix_3d8a517db6aba6ad0e57692473bb9d1b.png', '', 0, 1, 0, 0),
(2, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'MALE', '09301167851', 'address', '3d82576b589c04b0caeae416b691edac', 349804800, 'empty.jpg', '', 0, 0, 1, 0),
(3, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'FEMALE', '09301167852', 'address', '4fc5f0dbde510194f47236948b0e7c1e', 383846400, 'empty.jpg', '', 0, 0, 1, 0);

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
-- Indexes for table `rfid_photo`
--
ALTER TABLE `rfid_photo`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
-- AUTO_INCREMENT for table `rfid_photo`
--
ALTER TABLE `rfid_photo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `sms_list`
--
ALTER TABLE `sms_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
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
