-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2026 at 03:36 PM
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
-- Database: `ustpegallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `admin_id`, `action`, `created_at`) VALUES
(1, 3, 'Logged into the system', '2026-04-04 09:00:25'),
(2, 3, 'Logged into the system', '2026-04-04 09:03:46'),
(3, 2, 'Logged into the system', '2026-04-04 09:05:17'),
(4, 8, 'Logged into the system', '2026-04-04 09:58:35'),
(5, 10, 'Logged into the system', '2026-04-04 10:03:31'),
(6, 3, 'Added new Student: 2024304660', '2026-04-04 11:55:12'),
(7, 3, 'Added new Student: 2024304550', '2026-04-04 12:45:00'),
(8, 4, 'Logged into the system', '2026-04-04 13:11:17'),
(9, 10, 'Logged into the system', '2026-04-05 10:15:03'),
(10, 10, 'Logged into the system', '2026-04-06 14:56:51'),
(11, 10, 'Deleted Department (ID: 8)', '2026-04-06 16:03:53'),
(12, 10, 'Deleted Program (ID: 35)', '2026-04-06 16:04:54'),
(13, 10, 'Deleted Program (ID: 36)', '2026-04-06 16:29:54'),
(14, 10, 'Added new Program: CIty BOIII', '2026-04-06 16:30:36'),
(15, 10, 'Added new Program: BAKLA', '2026-04-06 16:32:08'),
(16, 10, 'Deleted Program: BAKLA', '2026-04-06 16:48:16'),
(17, 10, 'Deleted Program: CIty BOIII', '2026-04-06 17:12:27'),
(18, 10, 'Deleted Department: Art Major in City', '2026-04-06 17:12:36'),
(19, 10, 'Added new Section: IT - 4R1', '2026-04-07 13:05:40'),
(20, 10, 'Updated General System Settings', '2026-04-07 14:07:32'),
(21, 10, 'Uploaded photo for Student: Durain, Jussy Jay G.', '2026-04-07 14:15:17'),
(22, 10, 'Added new Section: CS - 4R1', '2026-04-07 14:32:08'),
(23, 10, 'Uploaded photo for Student: Tangarorang, Maui Alenxander', '2026-04-07 14:35:12'),
(24, 10, 'Added new Section: CE - 4R1', '2026-04-07 14:36:49'),
(25, 10, 'Uploaded photo for Student: Pabia, Jared', '2026-04-07 14:38:02'),
(26, 10, 'Updated General System Settings', '2026-04-08 00:17:40'),
(27, 10, 'Updated General System Settings', '2026-04-08 00:17:54'),
(28, 10, 'Updated General System Settings', '2026-04-08 00:19:03'),
(29, 10, 'Updated General System Settings', '2026-04-08 00:29:48'),
(30, 10, 'Added new Section: DS - 4R1', '2026-04-08 00:32:04'),
(31, 10, 'Uploaded photo for Student: Lapinid, Abigail', '2026-04-08 00:33:24'),
(32, 10, 'Added new Student: 2024305222', '2026-04-08 00:49:42'),
(33, 10, 'Added new Section: CpE - 4R1', '2026-04-08 00:51:02'),
(34, 10, 'Uploaded photo for Student: Caroro, Andrei', '2026-04-08 00:52:02'),
(35, 3, 'Logged into the system', '2026-04-08 10:18:59'),
(36, 3, 'Added new Class Year: 2033', '2026-04-08 10:57:53'),
(37, 3, 'Added new Class Year: 2034', '2026-04-08 10:59:59'),
(38, 3, 'Added new Class Year: 2035', '2026-04-08 11:06:37'),
(39, 3, 'Added new Section: CS - 4R2', '2026-04-11 06:25:31'),
(40, 3, 'Uploaded photo for Student: Cabanlit, Anika Jasmine', '2026-04-11 06:27:15'),
(41, 3, 'Added new Department: hahahahaha', '2026-04-11 06:28:43'),
(42, 3, 'Added new Program: h1h1h1h1h1h', '2026-04-11 06:29:11'),
(43, 3, 'Added new Class Year: 2036', '2026-04-11 06:30:09'),
(44, 3, 'Deleted Program: h1h1h1h1h1h', '2026-04-11 06:36:53'),
(45, 3, 'Deleted Department: hahahahaha', '2026-04-11 06:36:59'),
(46, 3, 'Logged into the system', '2026-04-15 03:39:53'),
(47, 3, 'Logged into the system', '2026-04-15 03:41:17'),
(48, 3, 'Logged into the system', '2026-04-15 03:42:34'),
(49, 3, 'Logged into the system via 2FA', '2026-04-15 03:49:03'),
(50, 4, 'Logged into the system', '2026-04-15 04:12:28'),
(51, 3, 'Logged into the system via 2FA', '2026-04-15 04:15:04'),
(52, 3, 'Logged into the system via 2FA', '2026-04-21 04:09:42'),
(53, 3, 'Deleted Student: Lapinid, Abigail', '2026-04-21 04:10:19'),
(54, 3, 'Edited student profile: Cabalit, Anika Jasmine', '2026-04-21 04:31:07'),
(55, 3, 'Edited student profile: Cabanlit, Anika Jasmine', '2026-04-21 04:32:08'),
(56, 3, 'Updated System Settings (Maintenance: ON)', '2026-04-21 04:56:22'),
(57, 4, 'Logged into the system', '2026-04-21 05:13:02'),
(58, 3, 'Updated System Settings (Maintenance: OFF)', '2026-04-21 05:13:41'),
(59, 3, 'Uploaded photo for Student: Lapinid, Abigail', '2026-04-21 05:16:31'),
(60, 3, 'Exported Class of 2029 records to CSV', '2026-04-21 06:09:00'),
(61, 3, 'Generated full database SQL backup', '2026-04-21 06:45:07'),
(62, 3, 'Updated System Settings (Maintenance: ON)', '2026-04-21 13:43:06'),
(63, 3, 'Generated full database SQL backup', '2026-04-21 13:43:58'),
(64, 3, 'Exported all student records to CSV', '2026-04-21 13:45:09'),
(65, 4, 'Logged into the system', '2026-04-21 13:47:25'),
(66, 4, 'Updated System Settings (Maintenance: OFF)', '2026-04-21 13:48:41'),
(67, 4, 'Updated System Settings (Maintenance: ON)', '2026-04-21 13:50:44'),
(68, 4, 'Updated System Settings (Maintenance: OFF)', '2026-04-21 13:51:12'),
(69, 4, 'Edited student profile: Durain, Jussy Jayyyy G.', '2026-04-21 13:52:19'),
(70, 4, 'Deleted Student: Durain, Jussy Jayyyy G.', '2026-04-21 13:52:46'),
(71, 3, 'Logged into the system via 2FA', '2026-04-21 13:54:36'),
(72, 4, 'Logged into the system', '2026-04-24 14:06:13'),
(73, 3, 'Logged into the system via 2FA', '2026-04-24 14:40:57'),
(74, 3, 'Updated School Logo', '2026-04-24 15:35:12'),
(75, 3, 'Updated School Logo', '2026-04-24 15:42:25'),
(76, 4, 'Logged into the system', '2026-04-25 15:47:31'),
(77, 4, 'Logged into the system', '2026-04-25 16:15:39'),
(78, 4, 'Logged into the system', '2026-04-25 16:16:50'),
(79, 4, 'Updated School Logo', '2026-04-25 16:17:36'),
(80, 4, 'Updated School Logo', '2026-04-26 00:23:13'),
(81, 4, 'Updated School Logo', '2026-04-26 00:23:52'),
(82, 4, 'Logged into the system', '2026-05-08 22:20:00'),
(83, 3, 'Logged into the system via 2FA', '2026-05-08 22:21:37'),
(84, 3, 'Updated School Logo', '2026-05-08 22:42:12'),
(85, 4, 'Logged into the system', '2026-05-08 22:42:59'),
(86, 4, 'Logged into the system', '2026-05-08 22:44:09'),
(87, 4, 'Updated School Logo', '2026-05-08 22:44:51'),
(88, 4, 'Updated School Logo', '2026-05-08 22:45:28'),
(89, 4, 'Updated School Logo', '2026-05-08 22:46:39'),
(90, 4, 'Updated School Logo', '2026-05-08 22:55:37'),
(91, 4, 'Updated School Logo', '2026-05-08 23:02:26'),
(92, 4, 'Updated System Settings (Maintenance: ON)', '2026-05-08 23:12:21'),
(93, 4, 'Updated System Settings (Maintenance: OFF)', '2026-05-08 23:12:45'),
(94, 4, 'Updated System Settings (Maintenance: OFF)', '2026-05-08 23:54:09'),
(95, 3, 'Logged into the system via 2FA', '2026-05-11 03:27:48'),
(96, 3, 'Updated System Settings (Maintenance: OFF)', '2026-05-11 03:36:16'),
(97, 3, 'Updated System Settings (Maintenance: OFF)', '2026-05-11 03:57:53'),
(98, 3, 'Logged into the system via 2FA', '2026-05-14 00:47:02'),
(99, 3, 'Updated System Settings (Maintenance: OFF)', '2026-05-14 08:44:52'),
(100, 4, 'Logged into the system', '2026-05-14 15:51:12'),
(101, 4, 'Edited student profile: Cabanlit, Anika Jasmine', '2026-05-14 15:51:51'),
(102, 4, 'Added new Section: TCM - 4R1', '2026-05-14 16:46:58'),
(103, 4, 'Uploaded photo for Student: Cabalde, Christian Carl C.', '2026-05-14 16:47:52'),
(104, 4, 'Added new Section: ECE - 4R1', '2026-05-14 16:49:22'),
(105, 4, 'Uploaded photo for Student: Jandayan, John Claude E.', '2026-05-14 16:51:25'),
(106, 4, 'Added new Section: Archi - 4R1', '2026-05-14 16:51:45'),
(107, 4, 'Uploaded photo for Student: Galindo, Justin Vince L.', '2026-05-14 16:53:16'),
(108, 4, 'Added new Section: EE - 4R1', '2026-05-14 16:54:55'),
(109, 4, 'Uploaded photo for Student: Cañizares, Carl Michael S.', '2026-05-14 16:55:33'),
(110, 4, 'Added new Section: ABE - 4R1', '2026-05-14 16:57:24'),
(111, 4, 'Uploaded photo for Student: Caboverde, Chanice', '2026-05-14 16:58:41'),
(112, 4, 'Added new Section: EnE - 4R1', '2026-05-14 16:59:25'),
(113, 4, 'Uploaded photo for Student: Flores, Zyra Nadine A.', '2026-05-14 17:01:13'),
(114, 4, 'Added new Section: GE - 4R1', '2026-05-14 17:01:32'),
(115, 4, 'Uploaded photo for Student: Fugnit, Remiel Charles', '2026-05-14 17:02:27'),
(116, 4, 'Added new Section: IT - 4R2', '2026-05-14 17:03:46'),
(117, 4, 'Uploaded photo for Student: Durain, Jussy Jay G.', '2026-05-14 17:04:31'),
(118, 4, 'Added new Section: ME - 4R1', '2026-05-14 17:05:10'),
(119, 4, 'Added new Section: NAME - 4R1', '2026-05-14 17:24:46'),
(120, 4, 'Uploaded photo for Student: Ondoy, Noel C. Jr.', '2026-05-14 17:25:39'),
(121, 4, 'Added new Section: Agri - 4R1', '2026-05-14 17:25:50'),
(122, 4, 'Added new Section: AF - 4R1', '2026-05-14 17:26:09'),
(123, 4, 'Added new Section: HM - 4R1', '2026-05-14 17:26:19'),
(124, 4, 'Added new Section: MarBio - 4R1', '2026-05-14 17:26:57'),
(125, 4, 'Added new Section: AM - 4R1', '2026-05-14 17:27:12'),
(126, 4, 'Added new Section: AP - 4R1', '2026-05-14 17:27:23'),
(127, 4, 'Added new Section: Chem - 4R1', '2026-05-14 17:27:35'),
(128, 4, 'Added new Section: ES - 4R1', '2026-05-14 17:27:52'),
(129, 4, 'Added new Section: SW - 4R1', '2026-05-14 17:28:09'),
(130, 4, 'Added new Section: Auto - 4R1', '2026-05-15 15:40:31'),
(131, 4, 'Uploaded photo for Student: Montes, Nasc Benedict', '2026-05-15 15:42:00'),
(132, 4, 'Added new Section: EM - 4R1', '2026-05-15 15:42:14'),
(133, 4, 'Uploaded photo for Student: Macahilos, Mark Jerald D.', '2026-05-15 15:43:11'),
(134, 4, 'Added new Section: EST - 4R1', '2026-05-15 15:43:26'),
(135, 4, 'Uploaded photo for Student: Navarro, Jhon Llyod M.', '2026-05-15 15:44:29'),
(136, 4, 'Added new Section: ESM - 4R1', '2026-05-15 15:44:43'),
(137, 4, 'Uploaded photo for Student: Awiten, Chosen Grace', '2026-05-15 15:45:48'),
(138, 4, 'Added new Section: MET - 4R1', '2026-05-15 15:45:59'),
(139, 4, 'Uploaded photo for Student: Domaog, Maira Lorraine', '2026-05-15 15:47:09'),
(140, 4, 'Uploaded photo for Student: Espragera, Allyza Jane D.', '2026-05-15 15:48:13'),
(141, 4, 'Added new Section: SEM - 4R1', '2026-05-15 15:50:58'),
(142, 4, 'Uploaded photo for Student: Clerigo, Erich B.', '2026-05-15 15:52:10'),
(143, 4, 'Added new Section: SES - 4R1', '2026-05-15 15:52:24'),
(144, 4, 'Uploaded photo for Student: Cailing, Jon Mc Rogel IV', '2026-05-15 15:53:15'),
(145, 4, 'Uploaded photo for Student: Tabaniag, J-vhonne L.', '2026-05-15 15:58:25'),
(146, 4, 'Uploaded photo for Student: Alegre, Dyjei Queen C.', '2026-05-15 16:03:43'),
(147, 4, 'Uploaded photo for Student: Fuestes, King Jethro', '2026-05-15 16:19:28'),
(148, 4, 'Uploaded photo for Student: Justiniani, Jonathan', '2026-05-15 16:23:48'),
(149, 4, 'Added new Section: TLE - 4R1', '2026-05-15 16:30:35'),
(150, 4, 'Uploaded photo for Student: Tuba, Shane Abby', '2026-05-15 16:31:25'),
(151, 4, 'Added new Section: IT - 4R3', '2026-05-15 16:59:17'),
(152, 4, 'Added new Section: IT - 4R4', '2026-05-15 16:59:31'),
(153, 4, 'Added new Section: IT - 4R5', '2026-05-15 16:59:41'),
(154, 4, 'Added new Section: IT - 4R6', '2026-05-15 16:59:54'),
(155, 4, 'Added new Section: IT - 4R7', '2026-05-15 17:00:10'),
(156, 4, 'Added new Section: IT - 4R8', '2026-05-15 17:00:22'),
(157, 4, 'Added new Section: IT - 4R9', '2026-05-15 17:03:45'),
(158, 4, 'Added new Section: IT - 4R10', '2026-05-15 17:04:04'),
(159, 4, 'Added new Section: IT - 4R11', '2026-05-15 17:04:17'),
(160, 4, 'Logged into the system', '2026-05-16 03:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `class_years`
--

CREATE TABLE `class_years` (
  `id` int(11) NOT NULL,
  `year` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_years`
--

INSERT INTO `class_years` (`id`, `year`) VALUES
(1, '2028'),
(2, '2029'),
(3, '2030'),
(4, '2031'),
(5, '2032'),
(6, '2033'),
(7, '2034'),
(8, '2035'),
(9, '2036');

-- --------------------------------------------------------

--
-- Table structure for table `community_comments`
--

CREATE TABLE `community_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_comments`
--

INSERT INTO `community_comments` (`id`, `post_id`, `user_id`, `body`, `created_at`, `parent_id`) VALUES
(2, 1, 2, 'hello i know him po', '2026-05-11 22:10:25', NULL),
(3, 1, 7, 'i know him po', '2026-05-11 22:12:17', NULL),
(4, 1, 7, 'can you tell where he is now?', '2026-05-11 22:21:15', 2),
(5, 1, 2, 'yes po', '2026-05-13 14:24:49', 4);

-- --------------------------------------------------------

--
-- Table structure for table `community_posts`
--

CREATE TABLE `community_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_posts`
--

INSERT INTO `community_posts` (`id`, `user_id`, `title`, `body`, `created_at`) VALUES
(1, 2, 'Hello everyone!!!!', 'I\'m looking for jussycutie', '2026-05-11 21:16:35'),
(3, 2, 'HEllOOOOO', 'can we normalized aHHEAHEAHHDSADSADA', '2026-05-13 14:30:12'),
(4, 7, 'ALUMNI PARTY', 'HEllO batch 2029 party tayo', '2026-05-14 09:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `abbreviation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `abbreviation`) VALUES
(1, 'Engineering', 'CEA'),
(2, 'Computer Science and Information Systems', 'CSIS'),
(3, 'Technology', 'COT'),
(4, 'Life Sciences', 'CST'),
(5, 'Natural Sciences', 'CNS'),
(6, 'Social Sciences', 'CSS'),
(7, 'Art and Humanities', 'CAH');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_id`, `created_at`) VALUES
(2, 3, 2, '2026-05-13 16:31:58'),
(6, 3, 7, '2026-05-15 04:37:02'),
(7, 4, 7, '2026-05-15 04:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `abbreviation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `department_id`, `name`, `abbreviation`) VALUES
(1, 1, 'BS Civil Engineering', 'CE'),
(2, 1, 'BS Electronic Engineering', 'ECE'),
(3, 1, 'BS Electrical Engineering', 'EE'),
(4, 1, 'BS Environment Engineering', 'EnE'),
(5, 1, 'BS Computer Engineering', 'CpE'),
(6, 1, 'BS Agricultural and Biosystems Engineering', 'ABE'),
(7, 1, 'BS Mechanical Engineering', 'ME'),
(8, 1, 'BS Naval Architecture and Marine Engineering', 'NAME'),
(9, 1, 'BS Geodetic Engineering', 'GE'),
(10, 2, 'BS Computer Science', 'CS'),
(11, 2, 'BS Data Science', 'DS'),
(12, 2, 'BS Technology Communication Management', 'TCM'),
(13, 2, 'BS Information Technology', 'IT'),
(14, 3, 'BS Agricultural Technology', 'AgTech'),
(15, 3, 'BS Autotronics', 'Auto'),
(16, 3, 'BS Electro-Mechanical', 'EM'),
(17, 3, 'BS Electronics Technology', 'EST'),
(18, 3, 'BS Energy System and Management', 'ESM'),
(19, 3, 'BS Food Processing and Management', 'FPM'),
(20, 3, 'BS Manufacturing Engineering Technology', 'MET'),
(21, 4, 'BS Agricultural', 'Agri'),
(22, 4, 'BS Agroforestry', 'AF'),
(23, 4, 'BS Horticulture and Management', 'HM'),
(24, 4, 'BS Marine Biology', 'MarBio'),
(25, 5, 'BS Applied Mathematics', 'AM'),
(26, 5, 'BS Applied Physics', 'AP'),
(27, 5, 'BS Chemistry', 'Chem'),
(28, 5, 'BS Environmental Science', 'ES'),
(29, 6, 'BS Secondary Education (major in Mathematics)', 'SEM'),
(30, 6, 'BS Secondary Education (major in Science)', 'SES'),
(31, 6, 'BS Social Work', 'SW'),
(32, 6, 'BS Technical-Vocational Teacher', 'TVT'),
(33, 6, 'BS Technology and Livelihood Education (major in Industrial Arts, Home Economics)', 'TLE'),
(34, 7, 'BS Architecture', 'Archi');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `program_id`, `name`) VALUES
(1, 13, 'IT - 4R1'),
(2, 10, 'CS - 4R1'),
(3, 1, 'CE - 4R1'),
(4, 11, 'DS - 4R1'),
(5, 5, 'CpE - 4R1'),
(6, 10, 'CS - 4R2'),
(7, 12, 'TCM - 4R1'),
(8, 2, 'ECE - 4R1'),
(9, 34, 'Archi - 4R1'),
(10, 3, 'EE - 4R1'),
(11, 6, 'ABE - 4R1'),
(12, 4, 'EnE - 4R1'),
(13, 9, 'GE - 4R1'),
(14, 13, 'IT - 4R2'),
(15, 7, 'ME - 4R1'),
(16, 8, 'NAME - 4R1'),
(17, 21, 'Agri - 4R1'),
(18, 22, 'AF - 4R1'),
(19, 23, 'HM - 4R1'),
(20, 24, 'MarBio - 4R1'),
(21, 25, 'AM - 4R1'),
(22, 26, 'AP - 4R1'),
(23, 27, 'Chem - 4R1'),
(24, 28, 'ES - 4R1'),
(25, 31, 'SW - 4R1'),
(26, 15, 'Auto - 4R1'),
(27, 16, 'EM - 4R1'),
(28, 17, 'EST - 4R1'),
(29, 18, 'ESM - 4R1'),
(30, 20, 'MET - 4R1'),
(31, 29, 'SEM - 4R1'),
(32, 30, 'SES - 4R1'),
(33, 33, 'TLE - 4R1'),
(34, 13, 'IT - 4R3'),
(35, 13, 'IT - 4R4'),
(36, 13, 'IT - 4R5'),
(37, 13, 'IT - 4R6'),
(38, 13, 'IT - 4R7'),
(39, 13, 'IT - 4R8'),
(40, 13, 'IT - 4R9'),
(41, 13, 'IT - 4R10'),
(42, 13, 'IT - 4R11');

-- --------------------------------------------------------

--
-- Table structure for table `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(150) NOT NULL,
  `department_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `latin_honor` varchar(50) NOT NULL,
  `class_year` year(4) NOT NULL,
  `quote` text NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `uploaded_by` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `user_id`, `full_name`, `department_id`, `program_id`, `section_id`, `latin_honor`, `class_year`, `quote`, `photo_path`, `is_active`, `uploaded_by`, `uploaded_at`) VALUES
(15, NULL, 'Tangarorang, Maui Alenxander', 2, 13, 1, 'Cum Laude', '2029', 'I love my wifi', 'assets/img/student/student_69d516202295c4.60509213.jpg', 1, 10, '2026-04-07 14:35:12'),
(16, NULL, 'Pabia, Jared', 1, 1, 3, 'Summa Cum Laude', '2029', 'AYOOOOO', 'assets/img/student/student_69d516ca27e1f9.09941308.jpg', 1, 10, '2026-04-07 14:38:02'),
(18, NULL, 'Caroro, Andrei', 1, 5, 5, 'Cum Laude', '2029', 'I love latinas', 'assets/img/student/student_69d5a6b2c198c3.25979147.jpg', 1, 10, '2026-04-08 00:52:02'),
(19, NULL, 'Cabanlit, Anika Jasmine', 2, 10, 6, 'Summa Cum Laude', '2029', 'hahahahahahaha', 'assets/img/student/student_69d9e9c2d6d186.41129793.jpg', 1, 3, '2026-05-14 15:51:51'),
(20, NULL, 'Lapinid, Abigail', 2, 13, 1, 'Cum Laude', '2030', 'Thank you for working hard', 'assets/img/student/student_69e7082f2bb591.61135886.jpg', 1, 3, '2026-04-21 05:16:31'),
(21, NULL, 'Cabalde, Christian Carl C.', 2, 12, 7, 'Magna Cum Laude', '2030', 'I love cats', 'assets/img/student/student_6a05fcb87b2252.37216675.jpg', 1, 4, '2026-05-14 16:47:52'),
(22, NULL, 'Jandayan, John Claude E.', 1, 2, 8, 'Summa Cum Laude', '2028', 'Basketball mo na bago druga', 'assets/img/student/student_6a05fd8ddfe577.82041772.jpg', 1, 4, '2026-05-14 16:51:25'),
(23, NULL, 'Galindo, Justin Vince L.', 7, 34, 9, 'Magna Cum Laude', '2028', 'Shabukoy noon, basketball player na ngayon', 'assets/img/student/student_6a05fdfc501399.07641710.jpg', 1, 4, '2026-05-14 16:53:16'),
(24, NULL, 'Cañizares, Carl Michael S.', 1, 3, 10, 'Summa Cum Laude', '2031', 'Work Hard', 'assets/img/student/student_6a05fe8582dd86.89938860.jpg', 1, 4, '2026-05-14 16:55:33'),
(25, NULL, 'Caboverde, Chanice', 1, 6, 11, 'Magna Cum Laude', '2033', 'pa pos4 nga po', 'assets/img/student/student_6a05ff418e23f5.72434965.jpg', 1, 4, '2026-05-14 16:58:41'),
(26, NULL, 'Flores, Zyra Nadine A.', 1, 4, 12, 'Magna Cum Laude', '2032', 'rolobox nga po', 'assets/img/student/student_6a05ffd93a7bb9.47286359.jpeg', 1, 4, '2026-05-14 17:01:13'),
(27, NULL, 'Fugnit, Remiel Charles', 1, 9, 13, 'Summa Cum Laude', '2034', 'ulol ka ba?', 'assets/img/student/student_6a0600237927f1.07382132.jpg', 1, 4, '2026-05-14 17:02:27'),
(28, NULL, 'Durain, Jussy Jay G.', 2, 13, 14, 'Magna Cum Laude', '2028', 'Work Hard, Play Hard', 'assets/img/student/student_6a06009f448911.77675027.jpg', 1, 4, '2026-05-14 17:04:31'),
(29, NULL, 'Ondoy, Noel C. Jr.', 1, 8, 16, 'Magna Cum Laude', '2035', 'Gamerrrr', 'assets/img/student/student_6a06059342c338.87776515.jpg', 1, 4, '2026-05-14 17:25:39'),
(30, NULL, 'Montes, Nasc Benedict', 3, 15, 26, 'Cum Laude', '2036', 'Soon to be pro player', 'assets/img/student/student_6a073ec874b2a8.45236253.jpeg', 1, 4, '2026-05-15 15:42:00'),
(31, NULL, 'Macahilos, Mark Jerald D.', 3, 16, 27, 'Summa Cum Laude', '2036', 'Dota player', 'assets/img/student/student_6a073f0f553c84.87148986.jpg', 1, 4, '2026-05-15 15:43:11'),
(32, NULL, 'Navarro, Jhon Llyod M.', 3, 17, 28, 'Magna Cum Laude', '2034', 'Code lang ng code', 'assets/img/student/student_6a073f5d8eb6a2.12111416.jpg', 1, 4, '2026-05-15 15:44:29'),
(33, NULL, 'Awiten, Chosen Grace', 3, 18, 29, 'Magna Cum Laude', '2031', 'Ice cream is life', 'assets/img/student/student_6a073facc927d2.58051349.jpg', 1, 4, '2026-05-15 15:45:48'),
(34, NULL, 'Domaog, Maira Lorraine', 3, 20, 30, 'Cum Laude', '2032', 'Hello World', 'assets/img/student/student_6a073ffdadcb79.67381538.jpg', 1, 4, '2026-05-15 15:47:09'),
(35, NULL, 'Espragera, Allyza Jane D.', 4, 24, 20, 'Cum Laude', '2030', 'Rage baiter', 'assets/img/student/student_6a07403d5d71a3.96427609.jpg', 1, 4, '2026-05-15 15:48:13'),
(36, NULL, 'Clerigo, Erich B.', 6, 29, 31, 'Cum Laude', '2033', 'idk', 'assets/img/student/student_6a07412a749cc7.12354519.jpeg', 1, 4, '2026-05-15 15:52:10'),
(37, NULL, 'Cailing, Jon Mc Rogel IV', 6, 30, 32, 'Cum Laude', '2033', 'yo chill', 'assets/img/student/student_6a07416bc880e7.25148095.jpg', 1, 4, '2026-05-15 15:53:15'),
(38, NULL, 'Tabaniag, J-vhonne L.', 2, 10, 6, 'Magna Cum Laude', '2029', 'Matcha da best', 'assets/img/student/student_6a0742a11895b3.44855120.jpeg', 1, 4, '2026-05-15 15:58:25'),
(39, NULL, 'Alegre, Dyjei Queen C.', 2, 11, 4, 'Summa Cum Laude', '2029', 'Science', 'assets/img/student/student_6a0743df2de7d9.72887119.jpg', 1, 4, '2026-05-15 16:03:43'),
(40, NULL, 'Fuestes, King Jethro', 2, 13, 1, 'Magna Cum Laude', '2029', 'Bola muna bago druga', 'assets/img/student/student_6a0747906f9351.98641412.jpg', 1, 4, '2026-05-15 16:19:28'),
(41, NULL, 'Justiniani, Jonathan', 2, 13, 1, 'Magna Cum Laude', '2029', 'Lebron Fan since 2012', 'assets/img/student/student_6a074894bf6ef4.63851082.jpg', 1, 4, '2026-05-15 16:23:48'),
(42, NULL, 'Tuba, Shane Abby', 6, 33, 33, 'Magna Cum Laude', '2029', 'Study Hard.', 'assets/img/student/student_6a074a5d5d2784.35736687.png', 1, 4, '2026-05-15 16:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'system_name', 'E-Gallery'),
(2, 'default_class_year', '2029'),
(3, 'maintenance_mode', '0'),
(16, 'system_name', 'E-Gallery'),
(17, 'default_class_year', '2031'),
(18, 'maintenance_mode', '0'),
(19, 'system_name', 'E-Gallery'),
(20, 'maintenance_mode', '0'),
(21, 'school_logo', 'user/assets/Img/Logo/custom_logo_1778281346.webp'),
(22, 'school_logo', 'user/assets/Img/Logo/custom_logo_1778281346.webp'),
(23, 'school_logo', 'user/assets/Img/Logo/custom_logo_1778281346.webp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `recovery_email` varchar(100) NOT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `two_factor_code` varchar(10) DEFAULT NULL,
  `two_factor_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uuid`, `username`, `email`, `password`, `role`, `recovery_email`, `two_factor_enabled`, `dateCreated`, `two_factor_code`, `two_factor_expires`) VALUES
(2, 'd6ec2460-c7ed-4dae-b97a-3c588e4bfa1a', '2024304880', NULL, '$2y$10$TP.KoAaiLDsuVG5YVlJOk.Drq8ZYHPRa7NuptUgGZEVmKA1.3UzIG', 'user', '', 0, '2026-03-27 04:31:35', NULL, NULL),
(3, '77aea5f2-efca-495e-b9f1-0c8929908a36', 'admin1', NULL, '$2y$10$RWHUCN7tkeJakOcC.1a7vOOlI2J1AkISK6CRvFdRjVUVL94kRiLz.', 'admin', 'jvzxydvrain@gmail.com', 1, '2026-03-27 07:21:05', NULL, NULL),
(4, '85c45634-6ec6-4aa7-9ab2-587ec34360d9', 'admin2', NULL, '$2y$10$HUVAhmlyM1zElNiPJk27EeIJFM6leX/i830JbEOK3B0N1/jRFy5Uu', 'admin', '', 0, '2026-03-31 16:02:04', NULL, NULL),
(7, '48a4bd7c-ef4c-455f-961c-77c4cc304ed8', '2024304990', NULL, '$2y$10$NvuLlJZpb2p3VtGrjZ0I9uE4MBs3lB5aAzjfsYLA3ubjImQnUtUmu', 'user', '', 0, '2026-04-04 09:41:01', NULL, NULL),
(8, '244d5612-b20b-4f4b-99bf-6bfa1dc2ab8d', 'admin3', NULL, '$2y$10$W7/B2IJ63oiIpLo4vrz4DOMDP34N38MgzpYMxUOpB1hiWEpV7fbTW', 'admin', '', 0, '2026-04-04 09:57:28', NULL, NULL),
(9, '67f51324-34dc-436a-a8ae-41e3da80f4aa', '2024304770', NULL, '$2y$10$/MXGVZyHhbKwTt43fCfoKuyvZ4RE5QCWpxEPayWoWEmWSszDE8tlS', 'user', '', 0, '2026-04-04 09:57:28', NULL, NULL),
(10, 'd90565c2-319b-4939-bb76-768571b079e2', 'admin4', NULL, '$2y$10$Vzp7QBC.6DQ9gv8QLYKYC.7cfJNUPLPTyKHNwsPH.IURMOF8kaMmC', 'admin', '', 0, '2026-04-04 10:02:46', NULL, NULL),
(11, 'a2756c5f-ab12-4bae-8316-14b30d425447', '2024304660', NULL, '$2y$10$.GXkm67E7wj5xsUCK7rDPui8kDcmdzHAEkb8RyOLGo0zL9/9BmSZG', 'user', '', 0, '2026-04-04 11:55:12', NULL, NULL),
(12, '1ac2a7ca-cccf-40c6-94fe-563da6abb19f', '2024304550', NULL, '$2y$10$jPdH2uRT9lgJJoQbrLw92u6kkWyItbFZyI3ePiW.6.2kGwaQX0V9W', 'user', '', 0, '2026-04-04 12:45:00', NULL, NULL),
(13, 'd6afef41-e99f-4c21-8c87-c75a46d31135', '2024305222', NULL, '$2y$10$IRmnKgd2tOpiY3E4t7ZVi.g7UhRQz6UrpJWMyd2Z4JPPm2SExEdCe', 'user', '', 0, '2026-04-08 00:49:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_visits`
--

CREATE TABLE `user_visits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `visit_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_visits`
--

INSERT INTO `user_visits` (`id`, `user_id`, `visit_time`) VALUES
(1, 9, '2026-04-04 11:57:53'),
(2, 7, '2026-04-04 12:07:13'),
(3, 2, '2026-04-04 12:39:21'),
(4, 12, '2026-04-04 12:45:45'),
(5, 2, '2026-04-06 14:57:39'),
(6, 2, '2026-04-06 17:24:59'),
(7, 2, '2026-04-06 18:36:01'),
(8, 2, '2026-04-07 12:37:34'),
(9, 2, '2026-04-07 13:01:52'),
(10, 2, '2026-04-07 13:43:06'),
(11, 2, '2026-04-07 14:18:07'),
(12, 2, '2026-04-07 14:34:42'),
(13, 2, '2026-04-07 14:54:22'),
(14, 7, '2026-04-07 16:39:06'),
(15, 2, '2026-04-08 00:19:56'),
(16, 2, '2026-04-08 00:33:51'),
(17, 9, '2026-04-08 00:48:29'),
(18, 13, '2026-04-08 00:50:09'),
(19, 2, '2026-04-08 01:53:37'),
(20, 2, '2026-04-08 01:57:36'),
(21, 2, '2026-04-08 10:17:19'),
(22, 2, '2026-04-11 06:08:37'),
(23, 2, '2026-04-11 06:25:47'),
(24, 2, '2026-04-11 06:32:35'),
(25, 2, '2026-04-11 06:40:38'),
(26, 2, '2026-04-14 17:28:09'),
(27, 2, '2026-04-14 23:17:55'),
(28, 2, '2026-04-15 04:13:22'),
(29, 2, '2026-04-15 08:39:20'),
(30, 2, '2026-04-21 04:10:58'),
(31, 2, '2026-04-21 04:31:27'),
(32, 2, '2026-04-21 04:56:45'),
(33, 2, '2026-04-21 05:09:18'),
(34, 2, '2026-04-21 05:09:46'),
(35, 2, '2026-04-21 05:13:21'),
(36, 2, '2026-04-21 05:13:54'),
(37, 2, '2026-04-21 05:16:44'),
(38, 2, '2026-04-21 13:42:37'),
(39, 2, '2026-04-21 13:43:32'),
(40, 2, '2026-04-21 13:48:56'),
(41, 2, '2026-04-21 13:49:05'),
(42, 2, '2026-04-24 14:32:32'),
(43, 2, '2026-04-26 01:11:17'),
(44, 2, '2026-04-26 01:54:19'),
(45, 2, '2026-04-26 02:03:30'),
(46, 2, '2026-05-08 22:19:20'),
(47, 2, '2026-05-08 23:12:36'),
(48, 2, '2026-05-08 23:54:35'),
(49, 2, '2026-05-08 23:54:42'),
(50, 2, '2026-05-11 03:37:02'),
(51, 2, '2026-05-11 04:05:14'),
(52, 2, '2026-05-11 04:14:44'),
(53, 2, '2026-05-11 04:20:37'),
(54, 2, '2026-05-11 04:44:43'),
(55, 2, '2026-05-11 04:51:28'),
(56, 2, '2026-05-11 04:56:03'),
(57, 2, '2026-05-11 05:20:37'),
(58, 2, '2026-05-11 05:25:10'),
(59, 2, '2026-05-11 06:15:02'),
(60, 2, '2026-05-11 09:19:18'),
(61, 2, '2026-05-11 10:17:29'),
(62, 2, '2026-05-11 10:26:01'),
(63, 2, '2026-05-11 10:38:25'),
(64, 2, '2026-05-11 10:46:41'),
(65, 2, '2026-05-11 10:58:06'),
(66, 2, '2026-05-11 11:09:48'),
(67, 2, '2026-05-11 11:31:24'),
(68, 2, '2026-05-11 20:28:08'),
(69, 2, '2026-05-11 20:38:59'),
(70, 2, '2026-05-11 20:58:35'),
(71, 7, '2026-05-11 21:25:44'),
(72, 2, '2026-05-11 21:37:20'),
(73, 7, '2026-05-11 22:12:00'),
(74, 12, '2026-05-11 22:25:15'),
(75, 2, '2026-05-13 14:17:05'),
(76, 2, '2026-05-13 14:53:10'),
(77, 7, '2026-05-13 16:32:20'),
(78, 2, '2026-05-14 01:58:09'),
(79, 2, '2026-05-14 02:16:38'),
(80, 7, '2026-05-14 08:45:13'),
(81, 2, '2026-05-14 09:15:38'),
(82, 2, '2026-05-14 09:56:14'),
(83, 2, '2026-05-14 10:34:29'),
(84, 2, '2026-05-14 15:50:49'),
(85, 7, '2026-05-14 16:48:11'),
(86, 7, '2026-05-14 23:04:34'),
(87, 7, '2026-05-15 04:36:42'),
(88, 2, '2026-05-15 15:48:25'),
(89, 2, '2026-05-15 16:26:25'),
(90, 2, '2026-05-15 17:02:02'),
(91, 2, '2026-05-15 17:29:35'),
(92, 7, '2026-05-16 03:16:16'),
(93, 7, '2026-05-16 03:31:47'),
(94, 2, '2026-05-16 13:23:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `class_years`
--
ALTER TABLE `class_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `community_comments`
--
ALTER TABLE `community_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_visits`
--
ALTER TABLE `user_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `class_years`
--
ALTER TABLE `class_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `community_comments`
--
ALTER TABLE `community_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_visits`
--
ALTER TABLE `user_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `community_comments`
--
ALTER TABLE `community_comments`
  ADD CONSTRAINT `community_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `community_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD CONSTRAINT `community_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `community_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `fk_prog_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `fk_sec_prog` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`);

--
-- Constraints for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `fk_student_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_prog` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_sec` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_profiles_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `student_profiles_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  ADD CONSTRAINT `student_profiles_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `student_profiles_ibfk_5` FOREIGN KEY (`uploaded_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_visits`
--
ALTER TABLE `user_visits`
  ADD CONSTRAINT `user_visits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
