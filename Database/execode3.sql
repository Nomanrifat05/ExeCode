-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 04:17 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `execode`
--

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE `contests` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('upcoming','ongoing','past') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `title`, `start_time`, `end_time`, `status`, `created_at`) VALUES
(44, 'Weekly Contest 1', '2025-06-24 02:06:00', '2025-06-24 02:08:00', 'past', '2025-06-23 20:05:29'),
(45, 'Weekly Contest 2', '2025-06-24 02:07:00', '2025-06-24 02:09:00', 'past', '2025-06-23 20:05:29'),
(46, 'Weekly Contest 3', '2025-06-24 02:08:00', '2025-06-24 02:10:00', 'past', '2025-06-23 20:05:29'),
(47, 'Weekly Contest 4', '2025-06-24 02:09:00', '2025-06-24 02:11:00', 'past', '2025-06-23 20:05:29'),
(48, 'Weekly Contest 5', '2025-06-24 02:10:00', '2025-06-24 02:12:00', 'past', '2025-06-23 20:05:29'),
(49, 'Weekly Contest 6', '2025-06-24 02:11:00', '2025-06-24 02:13:00', 'past', '2025-06-23 20:05:29'),
(50, 'Weekly Contest 7', '2025-06-24 02:12:00', '2025-06-24 02:14:00', 'past', '2025-06-23 20:05:29'),
(51, 'Weekly Contest 8', '2025-06-24 02:13:00', '2025-06-24 02:15:00', 'past', '2025-06-23 20:05:29'),
(52, 'Weekly Contest 9', '2025-06-24 02:14:00', '2025-06-24 02:16:00', 'past', '2025-06-23 20:05:29'),
(53, 'Weekly Contest 10', '2025-06-24 02:15:00', '2025-06-24 02:17:00', 'past', '2025-06-23 20:05:29'),
(54, 'Weekly Contest 11', '2025-06-24 02:16:00', '2025-06-24 02:18:00', 'past', '2025-06-23 20:05:29'),
(55, 'Weekly Contest 12', '2025-06-24 02:17:00', '2025-06-24 02:19:00', 'past', '2025-06-23 20:05:29'),
(56, 'Weekly Contest 13', '2025-06-24 02:18:00', '2025-06-24 02:20:00', 'past', '2025-06-23 20:05:29'),
(57, 'Weekly Contest 14', '2025-06-24 02:19:00', '2025-06-24 02:21:00', 'past', '2025-06-23 20:05:29'),
(58, 'Weekly Contest 15', '2025-06-24 02:20:00', '2025-06-24 02:22:00', 'past', '2025-06-23 20:05:29'),
(59, 'Weekly Contest 16', '2025-06-24 02:21:00', '2025-06-24 02:23:00', 'past', '2025-06-23 20:05:29'),
(60, 'Weekly Contest 17', '2025-06-24 02:22:00', '2025-06-24 02:24:00', 'past', '2025-06-23 20:05:29'),
(61, 'Weekly Contest 18', '2025-06-24 02:23:00', '2025-06-24 02:25:00', 'past', '2025-06-23 20:05:29'),
(62, 'Weekly Contest 19', '2025-06-24 02:24:00', '2025-06-24 02:26:00', 'past', '2025-06-23 20:05:29'),
(63, 'Weekly Contest 20', '2025-06-24 02:25:00', '2025-06-24 02:27:00', 'past', '2025-06-23 20:05:29'),
(64, 'Weekly Contest 21', '2025-06-24 02:26:00', '2025-06-24 02:28:00', 'past', '2025-06-23 20:05:29'),
(65, 'Weekly Contest 22', '2025-06-24 02:27:00', '2025-06-24 02:29:00', 'past', '2025-06-23 20:05:29'),
(66, 'Weekly Contest 23', '2025-06-24 02:28:00', '2025-06-24 02:30:00', 'past', '2025-06-23 20:05:29'),
(67, 'Weekly Contest 24', '2025-06-24 02:29:00', '2025-06-24 02:31:00', 'past', '2025-06-23 20:05:29'),
(68, 'Weekly Contest 25', '2025-06-24 02:30:00', '2025-06-24 02:32:00', 'past', '2025-06-23 20:05:29'),
(69, 'Weekly Contest 26', '2025-06-24 02:31:00', '2025-06-24 02:33:00', 'past', '2025-06-23 20:05:29'),
(70, 'Weekly Contest 27', '2025-06-24 02:32:00', '2025-06-24 02:34:00', 'past', '2025-06-23 20:05:29'),
(71, 'Weekly Contest 28', '2025-06-24 02:33:00', '2025-06-24 02:35:00', 'past', '2025-06-23 20:05:29'),
(72, 'Weekly Contest 29', '2025-06-24 02:34:00', '2025-06-24 02:36:00', 'past', '2025-06-23 20:05:29'),
(73, 'Weekly Contest 30', '2025-06-24 02:35:00', '2025-06-24 02:37:00', 'past', '2025-06-23 20:05:29'),
(74, 'Weekly Contest 31', '2025-06-24 03:12:00', '2025-06-24 03:14:00', 'past', '2025-06-23 21:11:34'),
(75, 'Weekly Contest 32', '2025-06-24 03:13:00', '2025-06-24 03:15:00', 'past', '2025-06-23 21:11:34'),
(76, 'Weekly Contest 33', '2025-06-24 03:14:00', '2025-06-24 03:16:00', 'past', '2025-06-23 21:11:34'),
(77, 'Weekly Contest 34', '2025-06-24 03:15:00', '2025-06-24 03:17:00', 'past', '2025-06-23 21:11:34'),
(78, 'Weekly Contest 35', '2025-06-24 03:16:00', '2025-06-24 03:18:00', 'past', '2025-06-23 21:11:34'),
(79, 'Weekly Contest 36', '2025-06-24 03:17:00', '2025-06-24 03:19:00', 'past', '2025-06-23 21:11:34'),
(80, 'Weekly Contest 37', '2025-06-24 03:18:00', '2025-06-24 03:20:00', 'past', '2025-06-23 21:11:34'),
(81, 'Weekly Contest 38', '2025-06-24 03:19:00', '2025-06-24 03:21:00', 'past', '2025-06-23 21:11:34'),
(82, 'Weekly Contest 39', '2025-06-24 03:20:00', '2025-06-24 03:22:00', 'past', '2025-06-23 21:11:34'),
(83, 'Weekly Contest 40', '2025-06-24 03:21:00', '2025-06-24 03:23:00', 'past', '2025-06-23 21:11:34'),
(84, 'Weekly Contest 41', '2025-06-24 03:22:00', '2025-06-24 03:24:00', 'past', '2025-06-23 21:11:34'),
(85, 'Weekly Contest 42', '2025-06-24 03:23:00', '2025-06-24 03:25:00', 'past', '2025-06-23 21:11:34'),
(86, 'Weekly Contest 43', '2025-06-24 03:24:00', '2025-06-24 03:26:00', 'past', '2025-06-23 21:11:34'),
(87, 'Weekly Contest 44', '2025-06-24 03:25:00', '2025-06-24 03:27:00', 'past', '2025-06-23 21:11:34'),
(88, 'Weekly Contest 45', '2025-06-24 03:26:00', '2025-06-24 03:28:00', 'past', '2025-06-23 21:11:34'),
(89, 'Weekly Contest 46', '2025-06-24 03:27:00', '2025-06-24 03:29:00', 'past', '2025-06-23 21:11:34'),
(90, 'Weekly Contest 47', '2025-06-24 03:28:00', '2025-06-24 03:30:00', 'past', '2025-06-23 21:11:34'),
(91, 'Weekly Contest 48', '2025-06-24 03:29:00', '2025-06-24 03:31:00', 'past', '2025-06-23 21:11:34'),
(92, 'Weekly Contest 49', '2025-06-24 03:30:00', '2025-06-24 03:32:00', 'past', '2025-06-23 21:11:34'),
(93, 'Weekly Contest 50', '2025-06-24 03:31:00', '2025-06-24 03:33:00', 'past', '2025-06-23 21:11:34'),
(94, 'Weekly Contest 51', '2025-06-24 03:32:00', '2025-06-24 03:34:00', 'past', '2025-06-23 21:27:50'),
(95, 'Weekly Contest 52', '2025-06-24 03:33:00', '2025-06-24 03:35:00', 'past', '2025-06-23 21:27:50'),
(96, 'Weekly Contest 53', '2025-06-24 03:34:00', '2025-06-24 03:36:00', 'past', '2025-06-23 21:27:50'),
(97, 'Weekly Contest 54', '2025-06-24 03:35:00', '2025-06-24 03:37:00', 'past', '2025-06-23 21:27:50'),
(98, 'Weekly Contest 55', '2025-06-24 03:36:00', '2025-06-24 03:38:00', 'past', '2025-06-23 21:27:50'),
(99, 'Weekly Contest 56', '2025-06-24 03:37:00', '2025-06-24 03:39:00', 'past', '2025-06-23 21:27:50'),
(100, 'Weekly Contest 57', '2025-06-24 03:38:00', '2025-06-24 03:40:00', 'past', '2025-06-23 21:27:50'),
(101, 'Weekly Contest 58', '2025-06-24 03:39:00', '2025-06-24 03:41:00', 'past', '2025-06-23 21:27:50'),
(102, 'Weekly Contest 59', '2025-06-24 03:40:00', '2025-06-24 03:42:00', 'past', '2025-06-23 21:27:50'),
(103, 'Weekly Contest 60', '2025-06-24 03:41:00', '2025-06-24 03:43:00', 'past', '2025-06-23 21:27:50'),
(104, 'Weekly Contest 61', '2025-06-24 03:42:00', '2025-06-24 03:44:00', 'past', '2025-06-23 21:27:50'),
(105, 'Weekly Contest 62', '2025-06-24 03:43:00', '2025-06-24 03:45:00', 'past', '2025-06-23 21:27:50'),
(106, 'Weekly Contest 63', '2025-06-24 03:44:00', '2025-06-24 03:46:00', 'past', '2025-06-23 21:27:50'),
(107, 'Weekly Contest 64', '2025-06-24 03:45:00', '2025-06-24 03:47:00', 'past', '2025-06-23 21:27:50'),
(108, 'Weekly Contest 65', '2025-06-24 03:46:00', '2025-06-24 03:48:00', 'past', '2025-06-23 21:27:50'),
(109, 'Weekly Contest 66', '2025-06-24 03:47:00', '2025-06-24 03:49:00', 'past', '2025-06-23 21:27:50'),
(110, 'Weekly Contest 67', '2025-06-24 03:48:00', '2025-06-24 03:50:00', 'past', '2025-06-23 21:27:50'),
(111, 'Weekly Contest 68', '2025-06-24 03:49:00', '2025-06-24 03:51:00', 'past', '2025-06-23 21:27:50'),
(112, 'Weekly Contest 69', '2025-06-24 03:50:00', '2025-06-24 03:52:00', 'past', '2025-06-23 21:27:50'),
(113, 'Weekly Contest 70', '2025-06-24 03:51:00', '2025-06-24 03:53:00', 'past', '2025-06-23 21:27:50'),
(114, 'Weekly Contest 71', '2025-06-24 03:52:00', '2025-06-24 03:54:00', 'past', '2025-06-23 21:50:47'),
(115, 'Weekly Contest 72', '2025-06-24 03:53:00', '2025-06-24 03:55:00', 'past', '2025-06-23 21:50:47'),
(116, 'Weekly Contest 73', '2025-06-24 03:54:00', '2025-06-24 03:56:00', 'past', '2025-06-23 21:50:47'),
(117, 'Weekly Contest 74', '2025-06-24 03:55:00', '2025-06-24 03:57:00', 'past', '2025-06-23 21:50:47'),
(118, 'Weekly Contest 75', '2025-06-24 03:56:00', '2025-06-24 03:58:00', 'past', '2025-06-23 21:50:47'),
(119, 'Weekly Contest 76', '2025-06-24 03:57:00', '2025-06-24 03:59:00', 'past', '2025-06-23 21:50:47'),
(120, 'Weekly Contest 77', '2025-06-24 03:58:00', '2025-06-24 04:00:00', 'past', '2025-06-23 21:50:47'),
(121, 'Weekly Contest 78', '2025-06-24 03:59:00', '2025-06-24 04:01:00', 'past', '2025-06-23 21:50:47'),
(122, 'Weekly Contest 79', '2025-06-24 04:00:00', '2025-06-24 04:02:00', 'past', '2025-06-23 21:50:47'),
(123, 'Weekly Contest 80', '2025-06-24 04:01:00', '2025-06-24 04:03:00', 'past', '2025-06-23 21:50:47'),
(124, 'Weekly Contest 81', '2025-06-24 04:02:00', '2025-06-24 04:04:00', 'past', '2025-06-23 21:50:47'),
(125, 'Weekly Contest 82', '2025-06-24 04:03:00', '2025-06-24 04:05:00', 'past', '2025-06-23 21:50:47'),
(126, 'Weekly Contest 83', '2025-06-24 04:04:00', '2025-06-24 04:06:00', 'past', '2025-06-23 21:50:47'),
(127, 'Weekly Contest 84', '2025-06-24 04:05:00', '2025-06-24 04:07:00', 'past', '2025-06-23 21:50:47'),
(128, 'Weekly Contest 85', '2025-06-24 04:06:00', '2025-06-24 04:08:00', 'past', '2025-06-23 21:50:47'),
(129, 'Weekly Contest 86', '2025-06-24 04:07:00', '2025-06-24 04:09:00', 'past', '2025-06-23 21:50:47'),
(130, 'Weekly Contest 87', '2025-06-24 04:08:00', '2025-06-24 04:10:00', 'past', '2025-06-23 21:50:47'),
(131, 'Weekly Contest 88', '2025-06-24 04:09:00', '2025-06-24 04:11:00', 'past', '2025-06-23 21:50:47'),
(132, 'Weekly Contest 89', '2025-06-24 04:10:00', '2025-06-24 04:12:00', 'past', '2025-06-23 21:50:47'),
(133, 'Weekly Contest 90', '2025-06-24 04:11:00', '2025-06-24 04:13:00', 'past', '2025-06-23 21:50:47'),
(134, 'Weekly Contest 91', '2025-06-24 04:12:00', '2025-06-24 04:14:00', 'past', '2025-06-23 22:12:46'),
(135, 'Weekly Contest 92', '2025-06-24 04:13:00', '2025-06-24 04:15:00', 'past', '2025-06-23 22:12:46'),
(136, 'Weekly Contest 93', '2025-06-24 04:14:00', '2025-06-24 04:16:00', 'past', '2025-06-23 22:12:46'),
(137, 'Weekly Contest 94', '2025-06-24 04:15:00', '2025-06-24 04:17:00', 'past', '2025-06-23 22:12:46'),
(138, 'Weekly Contest 95', '2025-06-24 04:16:00', '2025-06-24 04:18:00', 'ongoing', '2025-06-23 22:12:46'),
(139, 'Weekly Contest 96', '2025-06-24 04:17:00', '2025-06-24 04:19:00', 'ongoing', '2025-06-23 22:12:46'),
(140, 'Weekly Contest 97', '2025-06-24 04:18:00', '2025-06-24 04:20:00', 'upcoming', '2025-06-23 22:12:46'),
(141, 'Weekly Contest 98', '2025-06-24 04:19:00', '2025-06-24 04:21:00', 'upcoming', '2025-06-23 22:12:46'),
(142, 'Weekly Contest 99', '2025-06-24 04:20:00', '2025-06-24 04:22:00', 'upcoming', '2025-06-23 22:12:46'),
(143, 'Weekly Contest 100', '2025-06-24 04:21:00', '2025-06-24 04:23:00', 'upcoming', '2025-06-23 22:12:46'),
(144, 'Weekly Contest 101', '2025-06-24 20:13:00', '2025-06-24 22:13:00', 'upcoming', '2025-06-24 14:12:42'),
(145, 'Weekly Contest 102', '2025-06-24 23:13:00', '2025-06-25 01:13:00', 'upcoming', '2025-06-24 14:12:42'),
(146, 'Weekly Contest 103', '2025-06-25 02:13:00', '2025-06-25 04:13:00', 'upcoming', '2025-06-24 14:12:42'),
(147, 'Weekly Contest 104', '2025-06-25 05:13:00', '2025-06-25 07:13:00', 'upcoming', '2025-06-24 14:12:42'),
(148, 'Weekly Contest 105', '2025-06-25 08:13:00', '2025-06-25 10:13:00', 'upcoming', '2025-06-24 14:12:42'),
(149, 'Weekly Contest 106', '2025-06-25 11:13:00', '2025-06-25 13:13:00', 'upcoming', '2025-06-24 14:13:27'),
(150, 'Weekly Contest 107', '2025-06-25 14:13:00', '2025-06-25 16:13:00', 'upcoming', '2025-06-24 14:13:27'),
(151, 'Weekly Contest 108', '2025-06-25 17:13:00', '2025-06-25 19:13:00', 'upcoming', '2025-06-24 14:13:27'),
(152, 'Weekly Contest 109', '2025-06-25 20:13:00', '2025-06-25 22:13:00', 'upcoming', '2025-06-24 14:13:27'),
(153, 'Weekly Contest 110', '2025-06-25 23:13:00', '2025-06-26 01:13:00', 'upcoming', '2025-06-24 14:13:27'),
(154, 'Weekly Contest 111', '2025-06-26 02:13:00', '2025-06-26 04:13:00', 'upcoming', '2025-06-24 14:13:27'),
(155, 'Weekly Contest 112', '2025-06-26 05:13:00', '2025-06-26 07:13:00', 'upcoming', '2025-06-24 14:13:27'),
(156, 'Weekly Contest 113', '2025-06-26 08:13:00', '2025-06-26 10:13:00', 'upcoming', '2025-06-24 14:13:27'),
(157, 'Weekly Contest 114', '2025-06-26 11:13:00', '2025-06-26 13:13:00', 'upcoming', '2025-06-24 14:13:27'),
(158, 'Weekly Contest 115', '2025-06-26 14:13:00', '2025-06-26 16:13:00', 'upcoming', '2025-06-24 14:13:27'),
(159, 'Weekly Contest 116', '2025-06-26 17:13:00', '2025-06-26 19:13:00', 'upcoming', '2025-06-24 14:13:27'),
(160, 'Weekly Contest 117', '2025-06-26 20:13:00', '2025-06-26 22:13:00', 'upcoming', '2025-06-24 14:13:27'),
(161, 'Weekly Contest 118', '2025-06-26 23:13:00', '2025-06-27 01:13:00', 'upcoming', '2025-06-24 14:13:27'),
(162, 'Weekly Contest 119', '2025-06-27 02:13:00', '2025-06-27 04:13:00', 'upcoming', '2025-06-24 14:13:27'),
(163, 'Weekly Contest 120', '2025-06-27 05:13:00', '2025-06-27 07:13:00', 'upcoming', '2025-06-24 14:13:27'),
(164, 'Weekly Contest 121', '2025-06-27 08:13:00', '2025-06-27 10:13:00', 'upcoming', '2025-06-24 14:13:27'),
(165, 'Weekly Contest 122', '2025-06-27 11:13:00', '2025-06-27 13:13:00', 'upcoming', '2025-06-24 14:13:27'),
(166, 'Weekly Contest 123', '2025-06-27 14:13:00', '2025-06-27 16:13:00', 'upcoming', '2025-06-24 14:13:27'),
(167, 'Weekly Contest 124', '2025-06-27 17:13:00', '2025-06-27 19:13:00', 'upcoming', '2025-06-24 14:13:27'),
(168, 'Weekly Contest 125', '2025-06-27 20:13:00', '2025-06-27 22:13:00', 'upcoming', '2025-06-24 14:13:27'),
(169, 'Weekly Contest 126', '2025-06-27 23:13:00', '2025-06-28 01:13:00', 'upcoming', '2025-06-24 14:13:27'),
(170, 'Weekly Contest 127', '2025-06-28 02:13:00', '2025-06-28 04:13:00', 'upcoming', '2025-06-24 14:13:27'),
(171, 'Weekly Contest 128', '2025-06-28 05:13:00', '2025-06-28 07:13:00', 'upcoming', '2025-06-24 14:13:27'),
(172, 'Weekly Contest 129', '2025-06-28 08:13:00', '2025-06-28 10:13:00', 'upcoming', '2025-06-24 14:13:27'),
(173, 'Weekly Contest 130', '2025-06-28 11:13:00', '2025-06-28 13:13:00', 'upcoming', '2025-06-24 14:13:27'),
(174, 'Weekly Contest 131', '2025-06-28 14:13:00', '2025-06-28 16:13:00', 'upcoming', '2025-06-24 14:13:27'),
(175, 'Weekly Contest 132', '2025-06-28 17:13:00', '2025-06-28 19:13:00', 'upcoming', '2025-06-24 14:13:27'),
(176, 'Weekly Contest 133', '2025-06-28 20:13:00', '2025-06-28 22:13:00', 'upcoming', '2025-06-24 14:13:27'),
(177, 'Weekly Contest 134', '2025-06-28 23:13:00', '2025-06-29 01:13:00', 'upcoming', '2025-06-24 14:13:27'),
(178, 'Weekly Contest 135', '2025-06-29 02:13:00', '2025-06-29 04:13:00', 'upcoming', '2025-06-24 14:13:27'),
(179, 'Weekly Contest 136', '2025-06-29 05:13:00', '2025-06-29 07:13:00', 'upcoming', '2025-06-24 14:13:27'),
(180, 'Weekly Contest 137', '2025-06-29 08:13:00', '2025-06-29 10:13:00', 'upcoming', '2025-06-24 14:13:27'),
(181, 'Weekly Contest 138', '2025-06-29 11:13:00', '2025-06-29 13:13:00', 'upcoming', '2025-06-24 14:13:27'),
(182, 'Weekly Contest 139', '2025-06-29 14:13:00', '2025-06-29 16:13:00', 'upcoming', '2025-06-24 14:13:27'),
(183, 'Weekly Contest 140', '2025-06-29 17:13:00', '2025-06-29 19:13:00', 'upcoming', '2025-06-24 14:13:27'),
(184, 'Weekly Contest 141', '2025-06-29 20:13:00', '2025-06-29 22:13:00', 'upcoming', '2025-06-24 14:13:27'),
(185, 'Weekly Contest 142', '2025-06-29 23:13:00', '2025-06-30 01:13:00', 'upcoming', '2025-06-24 14:13:27'),
(186, 'Weekly Contest 143', '2025-06-30 02:13:00', '2025-06-30 04:13:00', 'upcoming', '2025-06-24 14:13:27'),
(187, 'Weekly Contest 144', '2025-06-30 05:13:00', '2025-06-30 07:13:00', 'upcoming', '2025-06-24 14:13:27'),
(188, 'Weekly Contest 145', '2025-06-30 08:13:00', '2025-06-30 10:13:00', 'upcoming', '2025-06-24 14:13:27'),
(189, 'Weekly Contest 146', '2025-06-30 11:13:00', '2025-06-30 13:13:00', 'upcoming', '2025-06-24 14:13:27'),
(190, 'Weekly Contest 147', '2025-06-30 14:13:00', '2025-06-30 16:13:00', 'upcoming', '2025-06-24 14:13:27'),
(191, 'Weekly Contest 148', '2025-06-30 17:13:00', '2025-06-30 19:13:00', 'upcoming', '2025-06-24 14:13:27'),
(192, 'Weekly Contest 149', '2025-06-30 20:13:00', '2025-06-30 22:13:00', 'upcoming', '2025-06-24 14:13:27'),
(193, 'Weekly Contest 150', '2025-06-30 23:13:00', '2025-07-01 01:13:00', 'upcoming', '2025-06-24 14:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `contest_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `statement` text DEFAULT NULL,
  `input` text DEFAULT NULL,
  `output` text DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') DEFAULT NULL,
  `time_limit` float DEFAULT 2,
  `memory_limit` int(11) DEFAULT 262144
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `contest_id`, `title`, `statement`, `input`, `output`, `difficulty`, `time_limit`, `memory_limit`) VALUES
(1, 1, 'Two Sum', 'Given an array of integers nums and an integer target, return indices of the two numbers such that they add up to the target.', '4\n2 7 11 15\n9', '[0,1]', 'easy', 2, 262144),
(2, 1, 'Palindrome Check', 'Check if a given string is a palindrome.', 'racecar', 'Yes', 'easy', 2, 262144),
(3, 2, 'Fibonacci Modulo', 'Print the Nth Fibonacci number modulo 1000000007.', '10', '55', 'medium', 1.5, 262144);

-- --------------------------------------------------------

--
-- Table structure for table `problem_start_times`
--

CREATE TABLE `problem_start_times` (
  `user_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `opened_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `problem_start_times`
--

INSERT INTO `problem_start_times` (`user_id`, `problem_id`, `opened_at`) VALUES
(1, 1, '2025-06-20 13:53:37'),
(1, 2, '2025-06-20 13:53:47'),
(1, 3, '2025-06-20 14:03:12');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `problem_id` int(11) DEFAULT NULL,
  `code` text DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Accepted','WA','TLE','RE') DEFAULT NULL,
  `runtime` float DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `output` text DEFAULT NULL,
  `error` text DEFAULT NULL,
  `input` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `user_id`, `problem_id`, `code`, `language`, `status`, `runtime`, `submitted_at`, `output`, `error`, `input`) VALUES
(1, 1, 1, 'function twoSum(nums, target) {\n let map = {};\n for(let i = 0; i < nums.length; i++) {\n let complement = target - nums[i];\n if(map[complement] !== undefined) return [map[complement], i];\n map[nums[i]] = i;\n }\n}', 'javascript', 'Accepted', 0.15, '2025-06-20 10:51:45', '[0,1]', '', '4\n2 7 11 15\n9'),
(2, 1, 1, 'function twoSum(nums, target) {\\n  let map = {};\\n  for(let i = 0; i < nums.length; i++) {\\n    let complement = target - nums[i];\\n    if(map[complement] !== undefined) return [map[complement], i];\\n    map[nums[i]] = i;\\n  }\\n}', 'javascript', 'Accepted', 0.015, '2025-06-20 11:04:17', '', '', '4\\n2 7 11 15\\n9'),
(3, 1, 1, 'function twoSum(nums, target) {\\n  let map = {};\\n  for(let i = 0; i < nums.length; i++) {\\n    let complement = target - nums[i];\\n    if(map[complement] !== undefined) return [map[complement], i];\\n    map[nums[i]] = i;\\n  }\\n}', 'javascript', 'Accepted', 0.015, '2025-06-20 11:30:13', '', '', '4\\n2 7 11 15\\n9'),
(4, 1, 1, '#include <iostream>\\nusing namespace std;\\n\\nint main() {\\n  // Your code here\\n  return 0;\\n}', 'cpp', '', 0.001, '2025-06-20 11:45:10', '', '', '4\\n2 7 11 15\\n9'),
(5, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\n\\nusing namespace std;\\n\\nvector<int> twoSum(const vector<int>& nums, int target) {\\n    unordered_map<int, int> map; // number -> index\\n\\n    for (int i = 0; i < nums.size(); i++) {\\n        int complement = target - nums[i];\\n        // Check if complement exists in map\\n        if (map.find(complement) != map.end()) {\\n            return {map[complement], i};\\n        }\\n        // Store current number and its index\\n        map[nums[i]] = i;\\n    }\\n    // If no solution found (problem guarantees one)\\n    return {};\\n}\\n\\nint main() {\\n    vector<int> nums = {2, 7, 11, 15};\\n    int target = 9;\\n    vector<int> result = twoSum(nums, target);\\n\\n    if (!result.empty()) {\\n        cout << \\\"Indices: \\\" << result[0] << \\\", \\\" << result[1] << endl;\\n    } else {\\n        cout << \\\"No solution found.\\\" << endl;\\n    }\\n    return 0;\\n}\\n', 'cpp', '', 0.003, '2025-06-20 11:46:16', 'Indices: 0, 1\\n', '', '4\\n2 7 11 15\\n9'),
(6, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\n\\nusing namespace std;\\n\\nvector<int> twoSum(const vector<int>& nums, int target) {\\n    unordered_map<int, int> map; // number -> index\\n\\n    for (int i = 0; i < nums.size(); i++) {\\n        int complement = target - nums[i];\\n        if (map.find(complement) != map.end()) {\\n            return {map[complement], i};\\n        }\\n        map[nums[i]] = i;\\n    }\\n    return {};\\n}\\n\\nint main() {\\n    vector<int> nums = {2, 7, 11, 15};\\n    int target = 9;\\n    vector<int> result = twoSum(nums, target);\\n\\n    if (!result.empty()) {\\n        cout << \\\"[\\\" << result[0] << \\\",\\\" << result[1] << \\\"]\\\";\\n    } else {\\n        cout << \\\"No solution found.\\\";\\n    }\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.002, '2025-06-20 11:51:31', '[0,1]', '', '4\\n2 7 11 15\\n9'),
(7, 1, 1, '#include <iostream>\\nusing namespace std;\\n\\nint main() {\\n  // Your code here\\n  return 0;\\n}', 'cpp', '', 0.002, '2025-06-20 12:08:18', '', '', '4\\n2 7 11 15\\n9'),
(8, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\n\\nusing namespace std;\\n\\nvector<int> twoSum(const vector<int>& nums, int target) {\\n    unordered_map<int, int> map; // number -> index\\n\\n    for (int i = 0; i < nums.size(); i++) {\\n        int complement = target - nums[i];\\n        if (map.find(complement) != map.end()) {\\n            return {map[complement], i};\\n        }\\n        map[nums[i]] = i;\\n    }\\n    return {};\\n}\\n\\nint main() {\\n    vector<int> nums = {2, 7, 11, 15};\\n    int target = 9;\\n    vector<int> result = twoSum(nums, target);\\n\\n    if (!result.empty()) {\\n        cout << \\\"[\\\" << result[0] << \\\",\\\" << result[1] << \\\"]\\\";\\n    } else {\\n        cout << \\\"No solution found.\\\";\\n    }\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.001, '2025-06-20 12:11:37', '[0,1]', '', '4\\n2 7 11 15\\n9'),
(9, 1, 2, '#include <iostream>\\nusing namespace std;\\n\\nint main() {\\n  // Your code here\\n  return 0;\\n}', 'cpp', '', 0.001, '2025-06-20 12:11:54', '', '', 'racecar'),
(10, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\nusing namespace std;\\n\\nvector<int> twoSum(vector<int>& nums, int target) {\\n    unordered_map<int, int> numMap; // value -> index\\n    for (int i = 0; i < nums.size(); ++i) {\\n        int complement = target - nums[i];\\n        if (numMap.find(complement) != numMap.end()) {\\n            return {numMap[complement], i};\\n        }\\n        numMap[nums[i]] = i;\\n    }\\n    return {};\\n}\\n\\nint main() {\\n    int n, target;\\n    cin >> n;\\n\\n    vector<int> nums(n);\\n    for (int i = 0; i < n; ++i)\\n        cin >> nums[i];\\n\\n    cin >> target;\\n\\n    vector<int> result = twoSum(nums, target);\\n    if (!result.empty())\\n        cout << \\\"[\\\" << result[0] << \\\",\\\" << result[1] << \\\"]\\\" << endl;\\n    else\\n        cout << \\\"No solution found\\\" << endl;\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.002, '2025-06-20 13:55:41', '[0,1]\\n', '', '4\\n2 7 11 15\\n9'),
(11, 1, 2, '#include <iostream>\\n#include <string>\\nusing namespace std;\\n\\nbool isPalindrome(const string& str) {\\n    int left = 0;\\n    int right = str.length() - 1;\\n    while (left < right) {\\n        if (str[left] != str[right])\\n            return false;\\n        ++left;\\n        --right;\\n    }\\n    return true;\\n}\\n\\nint main() {\\n    string input;\\n    cin >> input;\\n\\n    if (isPalindrome(input))\\n        cout << \\\"Yes\\\" << endl;\\n    else\\n        cout << \\\"No\\\" << endl;\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.002, '2025-06-20 14:02:11', 'Yes\\n', '', 'racecar'),
(12, 1, 3, '#include <iostream>\\nusing namespace std;\\n\\nconst int MOD = 1000000007;\\n\\nint fibonacci(int n) {\\n    if (n == 0) return 0;\\n    if (n == 1) return 1;\\n\\n    long long prev = 0, curr = 1;\\n    for (int i = 2; i <= n; ++i) {\\n        long long next = (prev + curr) % MOD;\\n        prev = curr;\\n        curr = next;\\n    }\\n    return curr;\\n}\\n\\nint main() {\\n    int n;\\n    cin >> n;\\n    cout << fibonacci(n) << endl;\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.001, '2025-06-20 14:04:10', '55\\n', '', '10');

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE `users_info` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`id`, `username`, `email`, `password`) VALUES
(1, 'mahbub', 'mrahman221441@bscse.uiu.ac.bd', '12345678'),
(2, 'musfiqur', 'musfiq@gmail.com', 'password123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contests`
--
ALTER TABLE `contests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contest_id` (`contest_id`);

--
-- Indexes for table `problem_start_times`
--
ALTER TABLE `problem_start_times`
  ADD PRIMARY KEY (`user_id`,`problem_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- Indexes for table `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_info`
--
ALTER TABLE `users_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_info` (`id`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
