-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2021 at 12:50 PM
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
-- Database: `db_studentattendancesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `academicyear` varchar(10) NOT NULL,
  `academicsemester` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceid`, `studentid`, `classid`, `academicyear`, `academicsemester`, `date`) VALUES
(1, 8, 10, '2020/2021', 1, '2021-07-17 09:39:22'),
(2, 66, 10, '2020/2021', 1, '2021-07-17 09:43:10'),
(3, 14, 10, '2020/2021', 1, '2021-07-17 09:50:12'),
(4, 9, 10, '2020/2021', 1, '2021-07-17 09:50:17'),
(5, 44, 10, '2020/2021', 1, '2021-07-17 09:50:22'),
(6, 8, 11, '2020/2021', 1, '2021-07-18 09:16:44'),
(7, 66, 11, '2020/2021', 1, '2021-07-18 09:17:02'),
(8, 14, 11, '2020/2021', 1, '2021-07-18 09:17:12'),
(9, 9, 11, '2020/2021', 1, '2021-07-18 09:17:23'),
(10, 44, 11, '2020/2021', 1, '2021-07-18 09:17:32'),
(11, 16, 6, '2020/2021', 1, '2021-07-24 19:08:02'),
(12, 16, 6, '2020/2021', 1, '2021-07-24 19:08:38'),
(13, 16, 6, '2020/2021', 1, '2021-07-24 19:08:42'),
(14, 16, 6, '2020/2021', 1, '2021-07-24 19:08:45'),
(15, 16, 6, '2020/2021', 1, '2021-07-24 19:08:52'),
(16, 16, 6, '2020/2021', 1, '2021-07-24 19:15:20'),
(17, 16, 6, '2020/2021', 1, '2021-07-24 19:17:48'),
(18, 6, 16, '2020/2021', 1, '2021-07-24 19:48:56'),
(19, 6, 17, '2020/2021', 1, '2021-07-28 13:39:08'),
(20, 8, 17, '2020/2021', 1, '2021-07-28 13:43:16'),
(22, 9, 18, '2020/2021', 1, '2021-07-30 00:27:52'),
(23, 3, 18, '2020/2021', 1, '2021-07-30 00:28:09'),
(24, 4, 18, '2020/2021', 1, '2021-07-30 01:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `classid` int(11) NOT NULL,
  `courseAllocationId` int(11) NOT NULL,
  `date` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`classid`, `courseAllocationId`, `date`, `startTime`, `endTime`) VALUES
(1, 2, '2021-07-14', '08:00:00', '10:00:00'),
(2, 1, '2021-07-13', '08:00:00', '10:00:00'),
(3, 1, '2021-07-16', '08:00:00', '10:00:00'),
(4, 3, '2021-07-14', '10:00:00', '12:00:00'),
(5, 3, '2021-07-14', '12:00:00', '14:00:00'),
(6, 7, '2021-07-14', '14:00:00', '16:00:00'),
(7, 2, '2021-07-16', '17:00:00', '19:00:00'),
(8, 8, '2021-07-17', '01:00:00', '03:00:00'),
(9, 9, '2021-07-17', '04:00:00', '06:00:00'),
(10, 4, '2021-07-17', '10:00:00', '12:00:00'),
(11, 13, '2021-07-18', '10:00:00', '12:00:00'),
(12, 0, '0000-00-00', '01:00:00', '01:00:00'),
(13, 14, '2021-07-23', '20:00:00', '22:00:00'),
(14, 14, '2021-07-23', '22:00:00', '23:30:00'),
(15, 2, '2021-07-24', '16:50:00', '19:10:00'),
(16, 2, '2021-07-24', '19:10:00', '21:00:00'),
(17, 11, '2021-07-28', '14:30:00', '17:00:00'),
(18, 11, '2021-07-30', '01:00:00', '03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseId` int(11) NOT NULL,
  `code` varchar(7) NOT NULL,
  `title` varchar(100) NOT NULL,
  `level` enum('1','2','3','4','5') NOT NULL,
  `semester` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseId`, `code`, `title`, `level`, `semester`) VALUES
(1, 'ITC1208', 'ITC Course Title', '1', '1'),
(2, 'CSC1303', 'CSC1303 Title', '1', '1'),
(3, 'CST1311', ' CST1311 Title', '1', '1'),
(4, 'MTH1301', 'MTH1301 Title', '1', '1'),
(5, 'PHY1210', 'PHY1210 Title', '1', '1'),
(6, 'PHY1220', 'PHY1220 Title', '1', '1'),
(7, 'GSP1201', 'GSP1201 Title', '1', '1'),
(8, 'SWE1301', 'SWE1301 Title', '1', '1'),
(9, 'CSC1302', 'CSC1302 Title', '1', '1'),
(10, 'ITC1203', 'ITC1203 Title', '1', '1'),
(11, 'CBS1202', 'Here Is The Title Of The Course', '1', '2'),
(12, 'CST1301', 'Course Title 3', '1', '2'),
(13, 'MTH1302', 'Course Title 4', '1', '2'),
(14, 'PHY1230', 'Course Title 5', '1', '2'),
(15, 'GSP1202', 'Course Title 6', '1', '2'),
(16, 'SWE1304', 'Course Title 7', '1', '2');

-- --------------------------------------------------------

--
-- Table structure for table `course_allocation`
--

CREATE TABLE `course_allocation` (
  `courseAllocationId` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `academicyear` varchar(9) NOT NULL,
  `academicsemester` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_allocation`
--

INSERT INTO `course_allocation` (`courseAllocationId`, `staffid`, `courseId`, `academicyear`, `academicsemester`) VALUES
(1, 2, 1, '2020/2021', '1'),
(2, 5, 2, '2020/2021', '1'),
(3, 3, 3, '2020/2021', '1'),
(4, 4, 6, '2020/2021', '1'),
(5, 2, 2, '', '1'),
(6, 5, 2, '', '1'),
(7, 8, 4, '2020/2021', '1'),
(8, 9, 5, '2020/2021', '1'),
(9, 10, 4, '2020/2021', '1'),
(10, 13, 4, '', '1'),
(11, 13, 10, '2020/2021', '1'),
(12, 13, 10, '', '1'),
(13, 16, 8, '2020/2021', '1'),
(14, 17, 7, '2020/2021', '1'),
(15, 15, 8, '2020/2021', '1');

-- --------------------------------------------------------

--
-- Table structure for table `course_registration`
--

CREATE TABLE `course_registration` (
  `registrationId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `academicyear` varchar(20) NOT NULL,
  `academicsemester` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_registration`
--

INSERT INTO `course_registration` (`registrationId`, `studentId`, `academicyear`, `academicsemester`, `level`) VALUES
(1, 1, '2020/2021', 1, 1),
(2, 2, '2020/2021', 1, 1),
(3, 3, '2020/2021', 1, 1),
(4, 4, '2020/2021', 1, 1),
(5, 5, '2020/2021', 1, 1),
(6, 6, '2020/2021', 1, 1),
(7, 7, '2020/2021', 1, 1),
(8, 8, '2020/2021', 1, 1),
(9, 9, '2020/2021', 1, 1),
(10, 10, '2020/2021', 1, 1),
(11, 11, '2020/2021', 1, 1),
(12, 12, '2020/2021', 1, 1),
(13, 13, '2020/2021', 1, 1),
(14, 14, '2020/2021', 1, 1),
(15, 15, '2020/2021', 1, 1),
(16, 16, '2020/2021', 1, 1),
(17, 17, '2020/2021', 1, 1),
(18, 18, '2020/2021', 1, 1),
(19, 19, '2020/2021', 1, 1),
(20, 20, '2020/2021', 1, 1),
(21, 21, '2020/2021', 1, 1),
(22, 22, '2020/2021', 1, 1),
(23, 23, '2020/2021', 1, 1),
(24, 24, '2020/2021', 1, 1),
(25, 25, '2020/2021', 1, 1),
(26, 26, '2020/2021', 1, 1),
(27, 27, '2020/2021', 1, 1),
(28, 28, '2020/2021', 1, 1),
(29, 29, '2020/2021', 1, 1),
(30, 30, '2020/2021', 1, 1),
(31, 31, '2020/2021', 1, 1),
(32, 32, '2020/2021', 1, 1),
(33, 33, '2020/2021', 1, 1),
(34, 34, '2020/2021', 1, 1),
(35, 35, '2020/2021', 1, 1),
(36, 36, '2020/2021', 1, 1),
(37, 37, '2020/2021', 1, 1),
(38, 38, '2020/2021', 1, 1),
(39, 39, '2020/2021', 1, 1),
(40, 40, '2020/2021', 1, 1),
(41, 41, '2020/2021', 1, 1),
(42, 42, '2020/2021', 1, 1),
(43, 43, '2020/2021', 1, 1),
(44, 44, '2020/2021', 1, 1),
(45, 45, '2020/2021', 1, 1),
(46, 46, '2020/2021', 1, 1),
(47, 47, '2020/2021', 1, 1),
(48, 48, '2020/2021', 1, 1),
(49, 49, '2020/2021', 1, 1),
(50, 50, '2020/2021', 1, 1),
(51, 51, '2020/2021', 1, 1),
(52, 52, '2020/2021', 1, 1),
(53, 53, '2020/2021', 1, 1),
(54, 54, '2020/2021', 1, 1),
(55, 55, '2020/2021', 1, 1),
(56, 56, '2020/2021', 1, 1),
(57, 57, '2020/2021', 1, 1),
(58, 58, '2020/2021', 1, 1),
(59, 59, '2020/2021', 1, 1),
(60, 60, '2020/2021', 1, 1),
(61, 61, '2020/2021', 1, 1),
(62, 62, '2020/2021', 1, 1),
(63, 63, '2020/2021', 1, 1),
(64, 64, '2020/2021', 1, 1),
(65, 65, '2020/2021', 1, 1),
(66, 66, '2020/2021', 1, 1),
(67, 67, '2020/2021', 1, 1),
(68, 68, '2020/2021', 1, 1),
(69, 69, '2020/2021', 1, 1),
(70, 70, '2020/2021', 1, 1),
(71, 71, '2020/2021', 1, 1),
(72, 72, '2020/2021', 1, 1),
(73, 73, '2020/2021', 1, 1),
(74, 74, '2020/2021', 1, 1),
(75, 75, '2020/2021', 1, 1),
(76, 76, '2020/2021', 1, 1),
(77, 77, '2020/2021', 1, 1),
(78, 78, '2020/2021', 1, 1),
(79, 79, '2020/2021', 1, 1),
(80, 80, '2020/2021', 1, 1),
(81, 81, '2020/2021', 1, 1),
(82, 82, '2020/2021', 1, 1),
(83, 83, '2020/2021', 1, 1),
(84, 84, '2020/2021', 1, 1),
(85, 85, '2020/2021', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `registered_courses`
--

CREATE TABLE `registered_courses` (
  `registeredId` int(11) NOT NULL,
  `registrationId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registered_courses`
--

INSERT INTO `registered_courses` (`registeredId`, `registrationId`, `courseId`) VALUES
(1, 1, 10),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 2),
(10, 2, 7),
(11, 2, 10),
(12, 2, 4),
(13, 2, 5),
(14, 2, 6),
(15, 2, 8),
(16, 3, 8),
(17, 3, 6),
(18, 3, 5),
(19, 3, 4),
(20, 3, 10),
(21, 3, 7),
(22, 3, 2),
(23, 4, 2),
(24, 4, 7),
(25, 4, 10),
(26, 4, 4),
(27, 4, 5),
(28, 4, 6),
(29, 4, 8),
(30, 5, 4),
(31, 5, 2),
(32, 5, 7),
(33, 5, 10),
(34, 5, 5),
(35, 5, 6),
(36, 5, 8),
(37, 6, 8),
(38, 6, 6),
(39, 6, 5),
(40, 6, 4),
(41, 6, 10),
(42, 6, 7),
(43, 6, 2),
(44, 7, 8),
(45, 7, 6),
(46, 7, 5),
(47, 7, 4),
(48, 7, 10),
(49, 7, 7),
(50, 7, 2),
(51, 8, 2),
(52, 8, 7),
(53, 8, 10),
(54, 8, 4),
(55, 8, 5),
(56, 8, 6),
(57, 8, 8),
(58, 9, 2),
(59, 9, 7),
(60, 9, 10),
(61, 9, 4),
(62, 9, 5),
(63, 9, 6),
(64, 9, 8),
(65, 10, 2),
(66, 10, 7),
(67, 10, 10),
(68, 10, 4),
(69, 10, 5),
(70, 10, 6),
(71, 10, 8),
(72, 11, 8),
(73, 11, 6),
(74, 11, 5),
(75, 11, 4),
(76, 11, 10),
(77, 11, 7),
(78, 11, 3),
(79, 11, 2),
(80, 12, 8),
(81, 12, 6),
(82, 12, 5),
(83, 12, 4),
(84, 12, 10),
(85, 12, 7),
(86, 12, 2),
(87, 13, 8),
(88, 13, 6),
(89, 13, 5),
(90, 13, 4),
(91, 13, 10),
(92, 13, 7),
(93, 13, 2),
(94, 14, 8),
(95, 14, 6),
(96, 14, 5),
(97, 14, 4),
(98, 14, 10),
(99, 14, 7),
(100, 14, 2),
(101, 15, 8),
(102, 15, 6),
(103, 15, 5),
(104, 15, 4),
(105, 15, 10),
(106, 15, 7),
(107, 15, 2),
(108, 16, 7),
(109, 16, 2),
(110, 16, 8),
(111, 16, 6),
(112, 16, 5),
(113, 16, 4),
(114, 16, 10),
(115, 17, 2),
(116, 17, 7),
(117, 17, 10),
(118, 17, 4),
(119, 17, 5),
(120, 17, 6),
(121, 17, 8),
(122, 18, 8),
(123, 18, 6),
(124, 18, 5),
(125, 18, 4),
(126, 18, 10),
(127, 18, 7),
(128, 18, 2),
(129, 19, 2),
(130, 19, 7),
(131, 19, 10),
(132, 19, 4),
(133, 19, 5),
(134, 19, 6),
(135, 19, 8),
(136, 20, 2),
(137, 20, 7),
(138, 20, 10),
(139, 20, 4),
(140, 20, 8),
(141, 20, 5),
(142, 20, 6),
(143, 21, 2),
(144, 21, 7),
(145, 21, 10),
(146, 21, 4),
(147, 21, 5),
(148, 21, 6),
(149, 21, 8),
(150, 22, 8),
(151, 22, 6),
(152, 22, 5),
(153, 22, 4),
(154, 22, 10),
(155, 22, 7),
(156, 22, 2),
(157, 23, 8),
(158, 23, 6),
(159, 23, 5),
(160, 23, 4),
(161, 23, 10),
(162, 23, 7),
(163, 23, 2),
(164, 24, 8),
(165, 24, 6),
(166, 24, 5),
(167, 24, 4),
(168, 24, 10),
(169, 24, 7),
(170, 24, 2),
(171, 25, 8),
(172, 25, 6),
(173, 25, 5),
(174, 25, 4),
(175, 25, 10),
(176, 25, 2),
(177, 25, 7),
(178, 26, 8),
(179, 26, 6),
(180, 26, 5),
(181, 26, 4),
(182, 26, 10),
(183, 26, 7),
(184, 26, 2),
(185, 27, 2),
(186, 27, 7),
(187, 27, 10),
(188, 27, 4),
(189, 27, 5),
(190, 27, 6),
(191, 27, 8),
(192, 28, 7),
(193, 28, 10),
(194, 28, 4),
(195, 28, 5),
(196, 28, 6),
(197, 28, 8),
(198, 28, 2),
(199, 29, 8),
(200, 29, 6),
(201, 29, 5),
(202, 29, 4),
(203, 29, 10),
(204, 29, 7),
(205, 29, 2),
(206, 30, 8),
(207, 30, 6),
(208, 30, 5),
(209, 30, 4),
(210, 30, 10),
(211, 30, 7),
(212, 30, 2),
(213, 31, 2),
(214, 31, 7),
(215, 31, 10),
(216, 31, 4),
(217, 31, 5),
(218, 31, 6),
(219, 31, 8),
(220, 32, 7),
(221, 32, 10),
(222, 32, 4),
(223, 32, 5),
(224, 32, 6),
(225, 32, 8),
(226, 33, 2),
(227, 33, 7),
(228, 33, 10),
(229, 33, 4),
(230, 33, 5),
(231, 33, 6),
(232, 33, 8),
(233, 34, 8),
(234, 34, 6),
(235, 34, 5),
(236, 34, 4),
(237, 34, 10),
(238, 34, 7),
(239, 34, 2),
(240, 35, 2),
(241, 35, 7),
(242, 35, 10),
(243, 35, 4),
(244, 35, 5),
(245, 35, 6),
(246, 35, 8),
(247, 36, 8),
(248, 36, 6),
(249, 36, 5),
(250, 36, 4),
(251, 36, 10),
(252, 36, 7),
(253, 36, 2),
(254, 37, 2),
(255, 37, 7),
(256, 37, 10),
(257, 37, 4),
(258, 37, 5),
(259, 37, 6),
(260, 37, 8),
(261, 38, 2),
(262, 38, 10),
(263, 38, 4),
(264, 38, 5),
(265, 38, 6),
(266, 38, 8),
(267, 38, 7),
(268, 39, 8),
(269, 39, 6),
(270, 39, 5),
(271, 39, 4),
(272, 39, 10),
(273, 39, 7),
(274, 39, 2),
(275, 40, 8),
(276, 40, 6),
(277, 40, 5),
(278, 40, 4),
(279, 40, 10),
(280, 40, 7),
(281, 40, 2),
(282, 41, 8),
(283, 41, 6),
(284, 41, 5),
(285, 41, 4),
(286, 41, 10),
(287, 41, 7),
(288, 41, 2),
(289, 42, 8),
(290, 42, 6),
(291, 42, 5),
(292, 42, 4),
(293, 42, 10),
(294, 42, 7),
(295, 42, 2),
(296, 43, 2),
(297, 43, 7),
(298, 43, 10),
(299, 43, 4),
(300, 43, 5),
(301, 43, 6),
(302, 43, 8),
(303, 44, 8),
(304, 44, 6),
(305, 44, 5),
(306, 44, 4),
(307, 44, 10),
(308, 44, 7),
(309, 44, 2),
(310, 45, 8),
(311, 45, 6),
(312, 45, 5),
(313, 45, 4),
(314, 45, 10),
(315, 45, 7),
(316, 45, 2),
(317, 46, 2),
(318, 46, 7),
(319, 46, 10),
(320, 46, 4),
(321, 46, 5),
(322, 46, 6),
(323, 46, 8),
(324, 47, 2),
(325, 47, 10),
(326, 47, 8),
(327, 47, 4),
(328, 47, 5),
(329, 47, 6),
(330, 47, 7),
(331, 48, 2),
(332, 48, 7),
(333, 48, 10),
(334, 48, 4),
(335, 48, 5),
(336, 48, 6),
(337, 48, 8),
(338, 49, 2),
(339, 49, 7),
(340, 49, 10),
(341, 49, 4),
(342, 49, 5),
(343, 49, 6),
(344, 49, 8),
(345, 50, 8),
(346, 50, 6),
(347, 50, 5),
(348, 50, 4),
(349, 50, 10),
(350, 50, 7),
(351, 50, 2),
(352, 51, 8),
(353, 51, 6),
(354, 51, 5),
(355, 51, 4),
(356, 51, 10),
(357, 51, 7),
(358, 51, 2),
(359, 52, 2),
(360, 52, 7),
(361, 52, 10),
(362, 52, 4),
(363, 52, 5),
(364, 52, 6),
(365, 52, 8),
(366, 53, 2),
(367, 53, 3),
(368, 53, 7),
(369, 53, 10),
(370, 53, 4),
(371, 53, 5),
(372, 53, 6),
(373, 53, 8),
(374, 54, 5),
(375, 54, 4),
(376, 54, 10),
(377, 54, 7),
(378, 54, 2),
(379, 54, 6),
(380, 54, 8),
(381, 55, 2),
(382, 55, 7),
(383, 55, 10),
(384, 55, 4),
(385, 55, 5),
(386, 55, 6),
(387, 55, 8),
(388, 56, 2),
(389, 56, 7),
(390, 56, 10),
(391, 56, 4),
(392, 56, 5),
(393, 56, 6),
(394, 56, 8),
(395, 57, 8),
(396, 57, 6),
(397, 57, 5),
(398, 57, 4),
(399, 57, 10),
(400, 57, 7),
(401, 57, 2),
(402, 58, 2),
(403, 58, 7),
(404, 58, 10),
(405, 58, 4),
(406, 58, 5),
(407, 58, 6),
(408, 58, 8),
(409, 59, 8),
(410, 59, 6),
(411, 59, 5),
(412, 59, 4),
(413, 59, 10),
(414, 59, 7),
(415, 59, 2),
(416, 60, 8),
(417, 60, 6),
(418, 60, 5),
(419, 60, 4),
(420, 60, 10),
(421, 60, 7),
(422, 60, 2),
(423, 61, 2),
(424, 61, 7),
(425, 61, 10),
(426, 61, 4),
(427, 61, 5),
(428, 61, 6),
(429, 61, 8),
(430, 62, 8),
(431, 62, 6),
(432, 62, 5),
(433, 62, 4),
(434, 62, 10),
(435, 62, 7),
(436, 62, 2),
(437, 63, 2),
(438, 63, 7),
(439, 63, 10),
(440, 63, 4),
(441, 63, 5),
(442, 63, 6),
(443, 63, 8),
(444, 64, 8),
(445, 64, 6),
(446, 64, 5),
(447, 64, 4),
(448, 64, 10),
(449, 64, 7),
(450, 64, 2),
(451, 65, 2),
(452, 65, 7),
(453, 65, 10),
(454, 65, 4),
(455, 65, 5),
(456, 65, 6),
(457, 65, 8),
(458, 66, 2),
(459, 66, 7),
(460, 66, 10),
(461, 66, 4),
(462, 66, 5),
(463, 66, 6),
(464, 66, 8),
(465, 67, 2),
(466, 67, 7),
(467, 67, 10),
(468, 67, 4),
(469, 67, 5),
(470, 67, 6),
(471, 67, 8),
(472, 68, 2),
(473, 68, 7),
(474, 68, 10),
(475, 68, 4),
(476, 68, 5),
(477, 68, 6),
(478, 68, 8),
(479, 69, 4),
(480, 69, 10),
(481, 69, 7),
(482, 69, 2),
(483, 69, 6),
(484, 69, 5),
(485, 69, 8),
(486, 70, 8),
(487, 70, 6),
(488, 70, 5),
(489, 70, 4),
(490, 70, 10),
(491, 70, 7),
(492, 70, 2),
(493, 71, 2),
(494, 71, 7),
(495, 71, 10),
(496, 71, 4),
(497, 71, 5),
(498, 71, 6),
(499, 71, 8),
(500, 72, 2),
(501, 72, 3),
(502, 72, 4),
(503, 72, 5),
(504, 72, 6),
(505, 72, 7),
(506, 72, 8),
(507, 72, 10),
(508, 73, 2),
(509, 73, 7),
(510, 73, 10),
(511, 73, 4),
(512, 73, 5),
(513, 73, 6),
(514, 73, 8),
(515, 74, 2),
(516, 74, 7),
(517, 74, 10),
(518, 74, 4),
(519, 74, 5),
(520, 74, 6),
(521, 74, 8),
(522, 75, 8),
(523, 75, 6),
(524, 75, 5),
(525, 75, 4),
(526, 75, 10),
(527, 75, 7),
(528, 75, 2),
(529, 76, 8),
(530, 76, 6),
(531, 76, 5),
(532, 76, 4),
(533, 76, 10),
(534, 76, 7),
(535, 76, 2),
(536, 77, 2),
(537, 77, 7),
(538, 77, 10),
(539, 77, 4),
(540, 77, 5),
(541, 77, 6),
(542, 77, 8),
(543, 78, 8),
(544, 78, 6),
(545, 78, 5),
(546, 78, 4),
(547, 78, 10),
(548, 78, 7),
(549, 78, 2),
(550, 79, 8),
(551, 79, 6),
(552, 79, 5),
(553, 79, 4),
(554, 79, 10),
(555, 79, 7),
(556, 79, 2),
(557, 80, 2),
(558, 80, 4),
(559, 80, 6),
(560, 80, 5),
(561, 80, 10),
(562, 80, 7),
(563, 80, 8),
(564, 81, 2),
(565, 81, 7),
(566, 81, 10),
(567, 81, 4),
(568, 81, 5),
(569, 81, 6),
(570, 81, 8),
(571, 82, 8),
(572, 82, 6),
(573, 82, 5),
(574, 82, 4),
(575, 82, 10),
(576, 82, 7),
(577, 82, 2),
(578, 83, 2),
(579, 83, 7),
(580, 83, 10),
(581, 83, 4),
(582, 83, 5),
(583, 83, 6),
(584, 83, 8),
(585, 84, 2),
(586, 84, 10),
(587, 84, 8),
(588, 84, 4),
(589, 84, 5),
(590, 84, 6),
(591, 84, 7),
(592, 85, 2),
(593, 85, 7),
(594, 85, 10),
(595, 85, 4),
(596, 85, 5),
(597, 85, 6),
(598, 85, 8);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settingsid` int(11) NOT NULL,
  `academicyear` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accademicsemester` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `current_principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enrollment_start_date` date NOT NULL,
  `enrollment_end_date` date NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settingsid`, `academicyear`, `accademicsemester`, `current_principal`, `enrollment_start_date`, `enrollment_end_date`, `isActive`) VALUES
(1, '2020/2021', '1', 'Mr. Benjie Magada', '2017-09-24', '2017-09-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentid` int(11) NOT NULL,
  `jambNo` varchar(15) NOT NULL,
  `regNo` varchar(20) NOT NULL DEFAULT '',
  `fullname` varchar(100) NOT NULL,
  `image` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `jambNo`, `regNo`, `fullname`, `image`) VALUES
(1, '96255044IF', 'CST/19/COM/00251', 'Abdulaziz Lawal', 'a3b6202873dacdbed2c88c75ef137943.jpeg'),
(2, '96197252CF', 'CST/19/COM/00252', 'Abdullahi Ibrahim Abba', ''),
(3, '96131878BD', 'CST/19/COM/00255', 'Salihu Idris Abubakar', ''),
(4, '96157320CG', 'CST/19/COM/00256', 'Abubakar Zahraddeen', ''),
(5, '96183479CC', 'CST/19/COM/00257', 'Abubakar Zarah Kari', ''),
(6, '97184810CC', 'CST/19/COM/00258', 'Abubakr Sherifdeen Gbolagade', ''),
(7, '96185019FI', 'CST/19/COM/00260', 'Adamu Ibrahim', ''),
(8, '97530601GE', 'CST/19/COM/00261', 'Adamu Zulaihat Oyiza', 'a3701cc4685b475c519bae03999aad3f.jpeg'),
(9, '97219947FA', 'CST/19/COM/00262', 'Adegbasa Nelson Favour', ''),
(10, '96206317IH', 'CST/19/COM/00263', 'Adeniji Isreal Tobiloba', ''),
(11, '96003271GF', 'CST/19/COM/00264', 'Adesoye Faruk Kayode', ''),
(12, '96197682JD', 'CST/19/COM/00265', 'Ahmad Hussain Adam', ''),
(13, '96187801FE', 'CST/19/COM/00266', 'Ahmed Usman Garba', ''),
(14, '97401373DJ', 'CST/19/COM/00268', 'Akpata Austine Adeiza', ''),
(15, '96170336GJ', 'CST/19/COM/00269', 'Alhassan Imam Liman', ''),
(16, '96177300DC', 'CST/19/COM/00270', 'Ali Bashir Sule', ''),
(17, '96310135AD', 'CST/19/COM/00271', 'Ali Zakariya Abubakar', ''),
(18, '96161388EE', 'CST/19/COM/00272', 'Aliyu Imam Saleh', ''),
(19, '96752831DJ', 'CST/19/COM/00273', 'Aliyu Muhammad Bello', ''),
(20, '96196542CB', 'CST/19/COM/00274', 'Aliyu Saudat Jogana', ''),
(21, '96185161CA', 'CST/19/COM/00275', 'Anodo Chigozie Daniel', ''),
(22, '96197353BD', 'CST/19/COM/00276', 'Auwal, Fatima Muhammad', ''),
(23, '96205164FE', 'CST/19/COM/00277', 'Bello Abdulrasheed Akanmu', ''),
(24, '96167356IF', 'CST/19/COM/00278', 'Bello Abubakar Sadiq', ''),
(25, '96313162EA', 'CST/19/COM/00279', 'Bello Christopher Onimisi', ''),
(26, '96209012FD', 'CST/19/COM/00281', 'Dalha Alamin Waziri', ''),
(27, '96196057CB', 'CST/19/COM/00282', 'Dauda Idris Ibrahim', ''),
(28, '96028985DI', 'CST/19/COM/00283', 'David Shaibu', ''),
(29, '95386188GJ', 'CST/19/COM/00284', 'Ejiuwa Lourin', ''),
(30, '96181241ED', 'CST/19/COM/00286', 'Friday Emmanuel', ''),
(31, '96026097GJ', 'CST/19/COM/00287', 'Gabriel Emmanuel Jatau', ''),
(32, '96161261DH', 'CST/19/COM/00288', 'Habib Mustapha Muhammad', ''),
(33, '96193759CI', 'CST/19/COM/00289', 'Hamza Ahmad', ''),
(34, '96496773HA', 'CST/19/COM/00290', 'Hassan Qudus Ayomide', ''),
(35, '96136023JB', 'CST/19/COM/00291', 'Hassan Sani Sani', ''),
(36, '96148850CC', 'CST/19/COM/00292', 'Ibrahim Abdulgaffar Abba', ''),
(37, '96148057HD', 'CST/19/COM/00294', 'Ibrahim Abdullahi', ''),
(38, '96178009DJ', 'CST/19/COM/00295', 'Ibrahim Anas', ''),
(39, '96193968IA', 'CST/19/COM/00296', 'Ibrahim Jibrin', ''),
(40, '95293505BJ', 'CST/19/COM/00297', 'Ibrahim Khalil Umar', ''),
(41, '96387603BB', 'CST/19/COM/00298', 'Ibrahim Muhammad Auwal', ''),
(42, '96308522IJ', 'CST/19/COM/00300', 'Isah Tihamiu Omeiza', ''),
(43, '96201680DA', 'CST/19/COM/00301', 'Isah Yusuf', ''),
(44, '97201393DE', 'CST/19/COM/00302', 'Isamot Uthman Oladeji', ''),
(45, '96189890JC', 'CST/19/COM/00303', 'Ishaq Salihu Jibril', ''),
(46, '96191150JF', 'CST/19/COM/00304', 'Ismail Abdullahi Muhammad', ''),
(47, '96634582FH', 'CST/19/COM/00305', 'Ismail Zainab Fareeha', ''),
(48, '96161867GC', 'CST/19/COM/00306', 'Jabir Saifullahi Malami', ''),
(49, '96161898GG', 'CST/19/COM/00307', 'Jibril Rilwan Gabi', ''),
(50, '96138551HD', 'CST/19/COM/00308', 'Kabir Sani Gambo', ''),
(51, '96144095CI', 'CST/19/COM/00309', 'Kazeem Kafeel Oluwafemi', ''),
(52, '96131771ED', 'CST/19/COM/00310', 'Khalifa Abdulkadir Idris', ''),
(53, '96220261GC', 'CST/19/COM/00311', 'Kutama Fatima Ibrahim', ''),
(54, '96133799HA', 'CST/19/COM/00312', 'Lukman Bello Usman', ''),
(55, '96126605CB', 'CST/19/COM/00313', 'Mahi Abdulrahman Said', ''),
(56, '96156555JA', 'CST/19/COM/00314', 'Mahmoud Ruqayya Abdullahi', ''),
(57, '96158372HB', 'CST/19/COM/00315', 'Mahmud Ibrahim', ''),
(58, '96197209FH', 'CST/19/COM/00317', 'Muhammad Umar Usman', ''),
(59, '96297833EJ', 'CST/19/COM/00318', 'Muhammed Fatima', ''),
(60, '96172617BG', 'CST/19/COM/00320', 'Musa Abubakar Abubakar', ''),
(61, '96208321IJ', 'CST/19/COM/00322', 'Muzakkar Ahmad Abdullahi', ''),
(62, '96204349HE', 'CST/19/COM/00323', 'Odidi Divine Thankgod', ''),
(63, '96203708FH', 'CST/19/COM/00324', 'Ogwuche Cecilia Ogbene', ''),
(64, '96947554AE', 'CST/19/COM/00325', 'Okpe Peter Echo', ''),
(65, '96148109BE', 'CST/19/COM/00326', 'Onyemaobi Linda John', ''),
(66, '97486518AF', 'CST/19/COM/00327', 'Otaru Abubakar Adeiza', ''),
(67, '96303947EA', 'CST/19/COM/00328', 'Raji Abdulmumin Adeiza', ''),
(68, '96153262HF', 'CST/19/COM/00329', 'Sadiq Abubakar Shakiru', ''),
(69, '96160933FB', 'CST/19/COM/00330', 'Dangaladima Usman Sani', ''),
(70, '96169873AD', 'CST/19/COM/00332', 'Shehu Mustapha Muhammad', ''),
(71, '96146568HI', 'CST/19/COM/00334', 'Sule Sulaiman Abdu', ''),
(72, '96762043EI', 'CST/19/COM/00335', 'Suleiman Salman Shuaibu', ''),
(73, '96143021EJ', 'CST/19/COM/00336', 'Sunusi Abdullahi Abdullahi', ''),
(74, '97360619IB', 'CST/19/COM/00337', 'Suraju Nasiru Mohammed', ''),
(75, '95678772HA', 'CST/19/COM/00338', 'Tijani Ibrahim Hanif', ''),
(76, '96156637DI', 'CST/19/COM/00339', 'Umar Mubarak Usman', ''),
(77, '96196993CG', 'CST/19/COM/00340', 'Usman Shafiu Adam', ''),
(78, '96188552DC', 'CST/19/COM/00341', 'Uzondu David Chukwuemeka', ''),
(79, '95376756EB', 'CST/19/COM/00342', 'Vernumbe Sesugh Timothy', ''),
(80, '96146378GG', 'CST/19/COM/00343', 'Wada Abdullahi Abubakar', ''),
(81, '96312956HG', 'CST/19/COM/00344', 'Yahaya Abdulhakeem Onoruoiza', ''),
(82, '96481940EG', 'CST/19/COM/00345', 'Yahaya Abubakar Abubakar', ''),
(83, '96138526FB', 'CST/19/COM/00346', 'Yaro Bala', ''),
(84, '96160725JD', 'CST/19/COM/00347', 'Yunusa Mujahid', ''),
(85, '96177249II', 'CST/19/COM/00348', 'Yusuf Sadiq Yakub', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_biometric`
--

CREATE TABLE `student_biometric` (
  `biometricid` int(11) NOT NULL,
  `enrollid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_biometric`
--

INSERT INTO `student_biometric` (`biometricid`, `enrollid`, `studentid`, `image`) VALUES
(5, 0, 1, '297a55f7524caead3033b7f1d9118314.jpeg'),
(6, 1, 8, 'd9b4b65e8368627f4cca0e694f2da98b.jpeg'),
(7, 2, 3, '23db160e541b9be0be0dce0487f87f3a.jpeg'),
(8, 3, 9, '29246724a9bea81f6a555b80f409b31e.jpeg'),
(9, 4, 2, 'eaadb91e4d4c09d7c11697b5d2ec8e78.jpeg'),
(10, 7, 4, 'ÿØÿà\0JFIF\0\0`\0`\0\0ÿÛ\0C\0		\n\r\Z\Z $.\' \",#(7),01444\'9=82<.342ÿÛ\0C			');

-- --------------------------------------------------------

--
-- Table structure for table `systemsettings`
--

CREATE TABLE `systemsettings` (
  `settingsid` int(11) NOT NULL,
  `academicyear` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accademicsemester` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `current_principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enrollment_start_date` date NOT NULL,
  `enrollment_end_date` date NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `systemsettings`
--

INSERT INTO `systemsettings` (`settingsid`, `academicyear`, `accademicsemester`, `current_principal`, `enrollment_start_date`, `enrollment_end_date`, `isActive`) VALUES
(1, '2020/2021', '1', 'Mr. Benjie Magada', '2017-09-24', '2017-09-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(64) NOT NULL,
  `position` enum('admin','lecturer') NOT NULL DEFAULT 'lecturer',
  `image` varchar(250) DEFAULT NULL,
  `access_pages` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL,
  `isdeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `email`, `fullname`, `phone`, `password`, `position`, `image`, `access_pages`, `date_added`, `date_updated`, `isdeleted`) VALUES
(1, 'admin@admin.com', 'Admin', '08076565454', '713796a8d84b4acbf899a2c9c28872a66922affcba754563abd73f24b98f74ad', 'admin', 'ca6bf547df8364c501e2df37294e0316.jpeg', '', '2021-07-24 07:58:03', '2017-09-18 07:40:43', 0),
(2, 'jigbashio@gmail.com', 'Dr. Igbashio Julius Iorlumun', '07018277223', '9011258beb98299a2b1ef632286723bd1d0880a435b09992a35c374acc7fa5fe', 'lecturer', NULL, '', '2021-07-28 13:20:58', '0000-00-00 00:00:00', 0),
(3, 'usman@gmail.com', 'Dr. Usman Bello Ali', '09018273635', '465035b27a30e60559dfe27f7dec48a929c028a5a504744e576d8704ea359fd0', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'manasseh@gmail.com', 'Mansseh Aliyu Ph.d', '07018152436', '0bce8816b87f8ec01524fcc134416f176420772e2cd75b2b932862197d25dcd4', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'muhammad@gmail.com', 'Dr. Hadizat Muhammad', '08017352425', 'f0e055ad4f1d78df30235601fd3c5328f604bbf3e975fe0c63727ffb1727e5f2', 'lecturer', 'a710bbcfb4d5928752919032bdafcd9d.jpeg', '', '2021-07-24 15:40:15', '0000-00-00 00:00:00', 0),
(6, 'mijadqualip@gmail.com', 'Mijad Qualip', '09018173635', '67797025123f9827f52d735a2d2302868c20b82ec085cb038d5a8fb50b595b4b', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(7, 'mimi@gmail.com', 'Mwuese Shakyar', '09017353636', '716f1e3c59c1a0187c096ccbf76f6341e9613d9c5b9531b7aef46ce56c56a65c', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(8, 'usman@gmail.com', 'Usman Baba Ahmad', '09024353637', 'a54ca321086e29e1c7b2a81734e1920699f740e7fa0385a14755f617f520087b', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(9, 'adamu@gmail.com', 'Dr. Adamu A Adamu', '08012345606', 'e1ba49395c9191bea1d02aa105bd6c7bd21933f84936e02126da27e700581aef', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(10, 'saadatu@gmail.com', 'Saadatu Garba', '09018266223', '0bce8816b87f8ec01524fcc134416f176420772e2cd75b2b932862197d25dcd4', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(11, 'habibu@gamil.com', 'Habibu Zaradeen', '09024354657', '6189d68b8aacf051e0152661f7461ce546bf438b827e6ef13d80a8f2c02599b3', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(12, 'habibu@gamil.com', 'Habibu Zaradeen', '09024354657', 'ae48424deb60fa64604673dc82aba9065bd73741635b1d351e5fc53db5dd8d3e', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(13, 'barasa@gmail.com', 'Habila Barasa', '09012354678', 'b6886a0bc273b4fcec0f31ef1680e820d3e4e6a48434a88e600eb68187a205b3', 'lecturer', NULL, '', '2021-07-28 13:34:57', '0000-00-00 00:00:00', 0),
(14, 'nathygeorge75@gmail.com', 'Nathaniel George', '09048510417', 'b84dec9bf146b65fe66e62f2ccb9369cc67e0c2bb423b16ee8becaf01be4cc16', 'lecturer', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(15, 'usmanbello@gmail.com', 'Usman Bello', '08018545412', '977e9540a4a27011f22a2e8a546043533aeda78eff37739d06c74d6850d40745', 'lecturer', NULL, '', '2021-07-22 16:26:12', '0000-00-00 00:00:00', 0),
(16, 'yusuftanko@gmail.com', 'Yusuf Tanko', '09078546567', '43ee7ed3c4badb27104bdb9d8a3a45d8ecbbccaef2fbceaf48ff18caea277fda', 'lecturer', NULL, '', '2021-07-22 16:28:55', '0000-00-00 00:00:00', 0),
(17, 'tsefahuma@gmail.com', 'Tsefa Huma', '08033445434', 'fd87f4a0cc127ebd1eca0b8a920978c3abddb02dc84acd252229e984fa7c9c7f', 'lecturer', NULL, '', '2021-07-22 16:26:19', '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceid`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseId`);

--
-- Indexes for table `course_allocation`
--
ALTER TABLE `course_allocation`
  ADD PRIMARY KEY (`courseAllocationId`);

--
-- Indexes for table `course_registration`
--
ALTER TABLE `course_registration`
  ADD PRIMARY KEY (`registrationId`);

--
-- Indexes for table `registered_courses`
--
ALTER TABLE `registered_courses`
  ADD PRIMARY KEY (`registeredId`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settingsid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`);

--
-- Indexes for table `student_biometric`
--
ALTER TABLE `student_biometric`
  ADD PRIMARY KEY (`biometricid`);

--
-- Indexes for table `systemsettings`
--
ALTER TABLE `systemsettings`
  ADD PRIMARY KEY (`settingsid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `course_allocation`
--
ALTER TABLE `course_allocation`
  MODIFY `courseAllocationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `course_registration`
--
ALTER TABLE `course_registration`
  MODIFY `registrationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `registered_courses`
--
ALTER TABLE `registered_courses`
  MODIFY `registeredId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=599;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settingsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `student_biometric`
--
ALTER TABLE `student_biometric`
  MODIFY `biometricid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `systemsettings`
--
ALTER TABLE `systemsettings`
  MODIFY `settingsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
