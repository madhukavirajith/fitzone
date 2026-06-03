-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 25, 2025 at 07:16 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitzone`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `class_type` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_appointments_customer` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `customer_id`, `class_type`, `appointment_date`, `appointment_time`, `created_at`) VALUES
(1, 7, 'Yoga', '2025-04-16', '16:33:00', '2025-04-25 10:59:18'),
(2, 7, 'Yoga', '2025-04-16', '16:33:00', '2025-04-25 11:13:32'),
(3, 7, 'Zumba', '2025-04-16', '16:33:00', '2025-04-25 11:13:46'),
(4, 7, 'Cardio', '2025-04-08', '23:27:00', '2025-04-25 17:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `class` varchar(255) NOT NULL,
  `membershipplan` varchar(255) NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`fullname`, `email`, `password`, `created_at`, `class`, `membershipplan`, `id`) VALUES
('madhuka', 'Madkuruppu99@gmail.com', '$2y$10$emiMvS01nei9exMj43eUZeoxsvGTq93pPWkzzLOX0NTgdKmjyFSWm', '2025-04-19 23:54:44', 'yoga', 'vip', 7);

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

DROP TABLE IF EXISTS `queries`;
CREATE TABLE IF NOT EXISTS `queries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `query_text` text NOT NULL,
  `response` text,
  `admin_id` int DEFAULT NULL,
  `date_submitted` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_responded` timestamp NULL DEFAULT NULL,
  `submission_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_response` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `customer_id`, `query_text`, `response`, `admin_id`, `date_submitted`, `date_responded`, `submission_time`, `admin_response`) VALUES
(9, 7, 'Do you require vaccinations or masks?', NULL, NULL, '2025-04-25 19:14:41', NULL, '2025-04-25 19:14:41', NULL),
(8, 7, 'What are your opening and closing times?', NULL, NULL, '2025-04-25 19:14:02', NULL, '2025-04-25 19:14:02', NULL),
(7, 7, 'Do you offer any discounts for students/seniors/corporate memberships?', NULL, NULL, '2025-04-25 19:13:10', NULL, '2025-04-25 19:13:10', 'Yes, we offer a 10% student discount and custom corporate rates. Please contact management for details.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('staff','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `date_created`) VALUES
(2, 'dinuka', '1111', 'staff', '2025-04-20 15:15:24'),
(3, 'imesh', '1111', 'staff', '2025-04-20 15:15:43'),
(4, 'kasun', '1111', 'staff', '2025-04-20 15:16:06'),
(5, 'lasith', '1111', 'admin', '2025-04-20 15:16:37'),
(6, 'sumith', 'sumith', 'staff', '2025-04-20 15:54:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
