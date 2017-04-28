-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2017 at 02:03 PM
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
(24, 2, 1493178070, 1493136000, 'entry', 1, 'students'),
(25, 2, 1493280015, 1493222400, 'entry', 1, 'students'),
(26, 9, 1493301501, 1493222400, 'entry', 5, 'teachers'),
(27, 2, 1493301866, 1493222400, 'exit', 1, 'students'),
(28, 9, 1493301958, 1493222400, 'exit', 5, 'teachers'),
(29, 5, 1493302075, 1493222400, 'entry', 2, 'staffs'),
(30, 5, 1493302290, 1493222400, 'exit', 2, 'staffs'),
(31, 11, 1493303493, 1493222400, 'entry', 4, 'staffs');

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
(1, 'asdasd', 'address', '09301167840', 1, 1, 'jpgulayan@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'jjj', '', '09301167851', 1, 1, 'jpgulayan@gmail.coms', '2b400702d514c79b0f9bcde29f25c180', 0),
(3, 'asd', 'address', '09301167820', 1, 1, 'jpgulayan@gmail.com', '7d142498320a6c13393ad8544d4f730e', 0),
(4, 'asdasd', 'address', '09301167821', 0, 0, 'jpgulayan@gmail.com', 'b7736cb9372eccf3329e28d61cd5b1c6', 0),
(5, 'John Paul Gulayan', 'R. Castillo', '09301167822', 1, 1, 'jpgulayan@gmail.com', '5e8676c207ce53957fe1d81f7152a925', 0),
(6, 'John Paul Gulayan', 'R. Castillo', '93011678500', 0, 0, 'jpgulayan@gmail.com', 'd90d4c54bf1b41261f19c4ce9ef8919b', 0),
(7, 'John Paul Gulayan', 'R. Castillo', '93011678501', 1, 1, 'jpgulayan@gmail.com', '5dd7e756acadc7cdad5180926b05d727', 0),
(8, 'John Paul Gulayan', 'R. Castillo', '09301167840', 1, 1, 'jpgulayan@gmail.com', 'a2e9a4ab48d1d02abb15cdd4fcb5c351', 0),
(9, 'aaaaaa', 'address', '09301167899', 0, 0, 'jpgulayan@gmail.com', '567f5f8d5200dc6cb6fef292e7bd69a5', 0),
(10, 'asdasdasd', 'address', '09301167100', 0, 0, 'asda@ss.com', '1952869f85c21ab4b9f7ad39de37f394', 0),
(11, 'asdasd', 'address', '93011678502', 0, 0, 'asda@ss.com', 'd86880935449ac4cfbc7b114a9a996f1', 0),
(12, 'asdasdasd', 'aa', '93011678503', 0, 0, 'asda@ss.com', 'a42170296219e7fbbe01f7f381aac9a3', 0),
(13, 'asdasd', 'address', '93011678504', 0, 0, 'asda@ss.com', '79fce7a6b05a6e146e84b8bf70dc5ca5', 0),
(14, 'John Paul Gulayan', 'R. Castillo', '93011678505', 0, 0, 'jpgulayan@gmail.com', 'af40c0fc768503ec5d447a0c57643228', 0),
(15, 'asdasd', 'address', '93011678562', 0, 0, 'asda@ss.com', 'bb8ab6f9e31fa6f4f75f601d74a90d74', 0),
(16, 'aaaaaa', 'aa', '93011678522', 0, 0, 'anonympox@gmail.com', '4c7f34da19260c205d03719bf65238ef', 0),
(17, 'aaaaaa', 'address', '93011678521', 0, 0, 'asda@ss.com', '55cb6b3e6788053914c609b899b58ffd', 0),
(18, 'asdasd', 'address', '93011672212', 0, 0, 'asda@ss.com', '652e7f4c9b9bd42e52d5e8a0558795d9', 0),
(19, 'asdasd', 'Address', '12345678910', 0, 0, 'jpgulayan@gmail.com', 'f44c22e9b08ff92b35d7febffaf6f71f', 0);

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
(1, '', 0, 1, 'staffs', 0, 1, 1646323200, 0),
(2, '1221', 0, 1, 'students', 0, 1, 1514736000, 0),
(3, '', 0, 1, 'teachers', 0, 1, 1585929600, 0),
(4, '', 0, 2, 'students', 0, 1, 1549123200, 0),
(5, '112', 0, 2, 'staffs', 0, 1, 1546358400, 0),
(6, '12311', 0, 2, 'teachers', 0, 1, 1551456000, 0),
(7, '1231126', 0, 3, 'teachers', 0, 1, 1551456000, 0),
(8, '', 0, 4, 'teachers', 0, 1, 0, 0),
(9, '1231', 0, 5, 'teachers', 0, 1, 1546272000, 0),
(10, '', 0, 3, 'staffs', 0, 1, 0, 0),
(11, '330', 0, 4, 'staffs', 0, 1, 1580659200, 0);

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
(1, 1493222400, 1493264032, 1, 'admins'),
(2, 1493222400, 1493264115, 1, 'admins'),
(3, 1493222400, 1493264198, 1, 'admins'),
(4, 1493222400, 1493267495, 1, 'admins'),
(5, 1493222400, 1493267536, 1, 'admins'),
(6, 1493222400, 1493267857, 1, 'admins'),
(7, 1493222400, 1493268125, 1, 'admins'),
(8, 1493222400, 1493268223, 1, 'admins'),
(9, 1493222400, 1493268515, 1, 'admins'),
(10, 1493222400, 1493268641, 1, 'admins'),
(11, 1493222400, 1493268708, 1, 'admins'),
(12, 1493222400, 1493269270, 1, 'admins'),
(13, 1493222400, 1493270122, 1, 'admins'),
(14, 1493222400, 1493270148, 1, 'admins'),
(15, 1493222400, 1493270189, 1, 'admins'),
(16, 1493222400, 1493270284, 1, 'admins'),
(17, 1493222400, 1493270404, 1, 'admins'),
(18, 1493222400, 1493270485, 1, 'admins'),
(19, 1493222400, 1493270512, 1, 'admins'),
(20, 1493222400, 1493270538, 1, 'admins'),
(21, 1493222400, 1493270550, 1, 'admins'),
(22, 1493222400, 1493270615, 1, 'admins'),
(23, 1493222400, 1493270644, 1, 'admins'),
(24, 1493222400, 1493270898, 1, 'admins'),
(25, 1493222400, 1493270921, 1, 'admins'),
(26, 1493222400, 1493271110, 1, 'admins'),
(27, 1493222400, 1493271131, 1, 'admins'),
(28, 1493222400, 1493271146, 1, 'admins'),
(29, 1493222400, 1493271165, 1, 'admins'),
(30, 1493222400, 1493271207, 1, 'admins'),
(31, 1493222400, 1493271225, 1, 'admins'),
(32, 1493222400, 1493271242, 1, 'admins'),
(33, 1493222400, 1493271257, 1, 'admins'),
(34, 1493222400, 1493271300, 1, 'admins');

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
(1, 1, 'aSSS', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(2, 1, 'aSSS', '09301167851', 'jjj', 2, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(3, 1, 'aSSS', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(4, 2, 'Asdssaa', '09301167851', 'jjj', 2, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(5, 2, 'Asdssaa', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(6, 2, 'Asdssaa', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(7, 3, 'Asdasda', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(8, 3, 'Asdasda', '09301167851', 'jjj', 2, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(9, 3, 'Asdasda', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(10, 4, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(11, 4, 'asdasdasd', '09301167851', 'jjj', 2, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(12, 4, 'asdasdasd', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(13, 5, 'asasdad', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(14, 5, 'asasdad', '09301167851', 'jjj', 2, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(15, 5, 'asasdad', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(16, 6, 'asdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(17, 6, 'asdasd', '09301167851', 'asdaasd, Teach T. test', 2, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(18, 6, 'asdasd', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(19, 7, 'AJSdkjakjskjdasd', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(20, 7, 'AJSdkjakjskjdasd', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(21, 7, 'AJSdkjakjskjdasd', '09301167851', 'jjj', 2, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(22, 7, 'AJSdkjakjskjdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(23, 7, 'AJSdkjakjskjdasd', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(24, 7, 'AJSdkjakjskjdasd', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(25, 7, 'AJSdkjakjskjdasd', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(26, 8, 'dasdasd', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(27, 8, 'dasdasd', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(28, 8, 'dasdasd', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(29, 8, 'dasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(30, 8, 'dasdasd', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(31, 8, 'dasdasd', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(32, 9, 'bjhgfcx', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(33, 9, 'bjhgfcx', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(34, 9, 'bjhgfcx', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(35, 9, 'bjhgfcx', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(36, 9, 'bjhgfcx', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(37, 9, 'bjhgfcx', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(38, 9, 'bjhgfcx', '09301167859', 'asdaasd, Teach T. test', 2, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(39, 10, ',mjnhbgfdfghjkl;', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(40, 10, ',mjnhbgfdfghjkl;', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(41, 10, ',mjnhbgfdfghjkl;', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(42, 10, ',mjnhbgfdfghjkl;', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(43, 10, ',mjnhbgfdfghjkl;', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(44, 10, ',mjnhbgfdfghjkl;', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(45, 10, ',mjnhbgfdfghjkl;', '09301167859', 'asdaasd, Teach T. test', 2, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(46, 11, 'asdasdad', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(47, 11, 'asdasdad', '09301167852', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(48, 11, 'asdasdad', '09301167840', 'John Paul Gulayan', 8, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(49, 11, 'asdasdad', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(50, 11, 'asdasdad', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(51, 11, 'asdasdad', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(52, 11, 'asdasdad', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(53, 11, 'asdasdad', '09301167859', 'asdaasd, Teach T. test', 2, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(54, 12, 'ASADFGHJHGFDSA', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(55, 12, 'ASADFGHJHGFDSA', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(56, 12, 'ASADFGHJHGFDSA', '09301167840', 'John Paul Gulayan', 8, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(57, 12, 'ASADFGHJHGFDSA', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(58, 12, 'ASADFGHJHGFDSA', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(59, 12, 'ASADFGHJHGFDSA', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(60, 13, 'asdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(61, 17, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(62, 20, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(63, 21, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(64, 23, 'asdasdasd', '09301167840', 'John Paul Gulayan', 8, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(65, 23, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(66, 24, 'asdasdasd', '09301167840', 'John Paul Gulayan', 8, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(67, 25, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(68, 26, 'asdasdasd', '09301167840', 'John Paul Gulayan', 8, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(69, 26, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(70, 27, 'asdasdasd', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(71, 27, 'asdasdasd', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(72, 28, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(73, 28, 'asdasdasd', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(74, 28, 'asdasdasd', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(75, 29, 'asdasd', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(76, 29, 'asdasd', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(77, 29, 'asdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(78, 30, 'asdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(79, 30, 'asdasdasd', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(80, 30, 'asdasdasd', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(81, 30, 'asdasdasd', '09301167222', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(82, 31, 'asdasasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(83, 31, 'asdasasd', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(84, 31, 'asdasasd', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(85, 32, 'ewretrrytuyyiyutrew', '09301167222', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(86, 32, 'ewretrrytuyyiyutrew', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(87, 33, '343567666534321', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(88, 33, '343567666534321', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(89, 33, '343567666534321', '09301167222', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(90, 33, '343567666534321', '09301167840', 'John Paul Gulayan', 8, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(91, 33, '343567666534321', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(92, 33, '343567666534321', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(93, 33, '343567666534321', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(94, 34, 'asdasdasdasd', '09301167222', 'last, first m. suffix', 1, 'students', 0, 'Success! Message is now on queue and will be sent soon.'),
(95, 34, 'asdasdasdasd', '09301167853', 'aaaa, asdsdfsdfs a. aaaa', 2, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(96, 34, 'asdasdasdasd', '09088651245', 'Last Name, First Name M. suffix', 1, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.'),
(97, 34, 'asdasdasdasd', '09301167840', 'John Paul Gulayan', 8, 'guardians', 0, 'Success! Message is now on queue and will be sent soon.'),
(98, 34, 'asdasdasdasd', '09301167850', 'Last Name, First Name M. Suffix', 1, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(99, 34, 'asdasdasdasd', '09301167854', 'aaaa, asdsdfsdfs a. aaaa', 3, 'teachers', 0, 'Success! Message is now on queue and will be sent soon.'),
(100, 34, 'asdasdasdasd', '09301167855', 'aaaa, asdsdfsdfs a. aaaa', 2, 'staffs', 0, 'Success! Message is now on queue and will be sent soon.');

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
  `in_case_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `in_case_contact_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `in_case_contact_number_sms` int(11) NOT NULL,
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

INSERT INTO `staffs` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `gender`, `contact_number`, `in_case_name`, `in_case_contact_number`, `in_case_contact_number_sms`, `address`, `birthdate`, `position`, `display_photo`, `display_photo_type`, `rfid_status`, `deleted`) VALUES
(1, 'Last Name', 'First Name', 'Middle Names', 'suffix', 'MALE', '09088651245', 'Ako', '09301167850', 1, 'Address', 315504000, 'Positions', '1_Last-Name_First-Name_Middle-Names_suffix-269d0e538e11a79ca4df29040ac6beba.png', '', 0, 0),
(2, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'MALE', '09301167855', '', '', 0, 'Address', 315504000, 'TE', '2_aaaa_asdsdfsdfs_aaa_aaaa.png', '', 1, 0),
(3, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'FEMALE', '09301167850', 'Akosaa', '09301167850', 1, 'Address', -471945600, 'Position', 'empty.jpg', '', 0, 0),
(4, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'FEMALE', '09301167850', 'Akosaa', '09301167850', 1, 'Address', -437731200, 'Position', 'empty.jpg', '', 1, 0);

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
(1, 'asdaasd', 'first', 'Teach', 'III.', '09301167851', 'Address', 320601600, 'MALE', 'mother', 'father', 'empty.jpg', '', 0, 1, 1, 0),
(2, 'asdaasd', 'first', 'Teach', '', '09301167850', 'ADDress', 349891200, 'FEMALE', '', '', '2_asdaasd_Teach_Teach_test_bb4d37d345a20e619763e391ff1a46fd.png', '', 8, 1, 0, 0);

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
  `in_case_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `in_case_contact_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `in_case_contact_number_sms` int(11) NOT NULL,
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

INSERT INTO `teachers` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `gender`, `contact_number`, `in_case_name`, `in_case_contact_number`, `in_case_contact_number_sms`, `address`, `password`, `birthdate`, `display_photo`, `display_photo_type`, `guardian_id`, `class_id`, `rfid_status`, `deleted`) VALUES
(1, 'Last Name', 'First Name', 'Middle Name', 'Suffix', 'MALE', '09301167850', '', '09301167850', 1, 'Address', '21232f297a57a5a743894a0e4a801fc3', 347212800, '1_Last-Name_First-Name_Middle-Name_Suffix_3d8a517db6aba6ad0e57692473bb9d1b.png', '', 0, 1, 0, 0),
(2, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'MALE', '09301167853', '', '', 0, 'address', '3d82576b589c04b0caeae416b691edac', 349804800, 'empty.jpg', '', 0, 0, 1, 0),
(3, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'FEMALE', '09301167854', '', '', 0, 'address', '4fc5f0dbde510194f47236948b0e7c1e', 383846400, 'empty.jpg', '', 0, 0, 1, 0),
(4, 'asdaasd', 'asdasdasd', 'asdasd', 'aaaa', 'MALE', '09301167823', '', '09301167850', 1, 'Address', '5885d6a93572f3bee6635f7eec1f49fe', -408700800, 'empty.jpg', '', 0, 0, 0, 0),
(5, 'aaaa', 'asdsdfsdfs', 'aaa', 'aaaa', 'MALE', '09301167851', 'Akos', '09301167850', 1, 'Address', 'eb4bc223013543f70de7d563b4873d56', -944121600, 'empty.jpg', '', 0, 0, 1, 0);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `rfid_photo`
--
ALTER TABLE `rfid_photo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `sms_list`
--
ALTER TABLE `sms_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `time_logs`
--
ALTER TABLE `time_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
