-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2020 at 06:41 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `top_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(1, 'Starter'),
(2, 'Main Course'),
(3, 'Breakfast'),
(4, 'Lunch'),
(5, 'Dinner');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_card`
--

CREATE TABLE `tbl_menu_card` (
  `menu_id` int(11) NOT NULL,
  `rest_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` double NOT NULL,
  `item_quantity` varchar(255) NOT NULL,
  `item_status` enum('Available','Not Available') NOT NULL DEFAULT 'Available',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menu_card`
--

INSERT INTO `tbl_menu_card` (`menu_id`, `rest_id`, `category_id`, `item_name`, `item_price`, `item_quantity`, `item_status`, `added_on`) VALUES
(1, 1, 4, 'Rice', 120, 'Full Plate', 'Available', '2020-05-28 23:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurant`
--

CREATE TABLE `tbl_restaurant` (
  `rest_id` int(11) NOT NULL,
  `rest_name` varchar(150) NOT NULL,
  `rest_email` varchar(150) NOT NULL,
  `rest_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_restaurant`
--

INSERT INTO `tbl_restaurant` (`rest_id`, `rest_name`, `rest_email`, `rest_pass`) VALUES
(1, 'Test Restaurant One', 'rest@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurant_details`
--

CREATE TABLE `tbl_restaurant_details` (
  `tbl_res_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `gst_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `establishment_year` int(11) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_mobile` varchar(16) NOT NULL,
  `rest_contact_no` varchar(16) NOT NULL,
  `menu_card_id` int(11) NOT NULL,
  `added_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `activation_status` enum('Accepted','Pending','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_restaurant_details`
--

INSERT INTO `tbl_restaurant_details` (`tbl_res_id`, `restaurant_id`, `gst_no`, `address`, `establishment_year`, `owner_name`, `owner_mobile`, `rest_contact_no`, `menu_card_id`, `added_on`, `activation_status`) VALUES
(1, 1, 123456, 'Mohbewala Dehradun', 2019, 'Rahul Kumar', '1234568790', '3214562541', 12, '2020-05-20 02:49:00', 'Accepted');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_menu_card`
--
ALTER TABLE `tbl_menu_card`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tbl_restaurant`
--
ALTER TABLE `tbl_restaurant`
  ADD PRIMARY KEY (`rest_id`);

--
-- Indexes for table `tbl_restaurant_details`
--
ALTER TABLE `tbl_restaurant_details`
  ADD PRIMARY KEY (`tbl_res_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_menu_card`
--
ALTER TABLE `tbl_menu_card`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_restaurant`
--
ALTER TABLE `tbl_restaurant`
  MODIFY `rest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_restaurant_details`
--
ALTER TABLE `tbl_restaurant_details`
  MODIFY `tbl_res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
