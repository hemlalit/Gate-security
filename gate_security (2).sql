-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 02:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gate security`
--

-- --------------------------------------------------------

--
-- Table structure for table `college_staff`
--

CREATE TABLE `college_staff` (
  `s_name` varchar(20) NOT NULL,
  `s_userName` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `contact` int(10) NOT NULL,
  `id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college_staff`
--

INSERT INTO `college_staff` (`s_name`, `s_userName`, `role`, `password`, `contact`, `id`) VALUES
('im', 'imInstructor', 'teacher', '123', 1234343, 13434),
('instructer1', 'imInstructor1', 'teacher', '123', 1234343, 13435),
('instructer2', 'imInstructor2', 'teacher', '123', 123123, 13436),
('instructer3', 'imInstructor3', 'teacher', '123', 123454, 13437),
('instructer4', 'imInstructor4', 'teacher', '123', 123465, 13438),
('imSecurity', 'imSecurity1', 'security', '123', 123456, 1),
('teacher1', 'imTeacher1', 'teacher', '123', 123456543, 13439),
('teacher2', 'imTeacher2', 'teacher', '123', 1264523, 134310),
('teacher3', 'imTeacher3', 'teacher', '123', 128666454, 134311);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dep_id` varchar(20) NOT NULL,
  `depName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dep_id`, `depName`) VALUES
('123', 'IT'),
('124', 'BBA');

-- --------------------------------------------------------

--
-- Table structure for table `non_teaching_staff`
--

CREATE TABLE `non_teaching_staff` (
  `s_userName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `childName` varchar(20) NOT NULL,
  `childCtrl_id` varchar(20) NOT NULL,
  `childCourse` varchar(20) NOT NULL,
  `u_userName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`childName`, `childCtrl_id`, `childCourse`, `u_userName`) VALUES
('', '4044A019', '', '@Gulabrao41042');

-- --------------------------------------------------------

--
-- Table structure for table `pass`
--

CREATE TABLE `pass` (
  `pass_id` varchar(20) NOT NULL,
  `passGenTime` varchar(20) NOT NULL,
  `duration` varchar(20) NOT NULL,
  `passInfo` varchar(50) NOT NULL,
  `u_userName` varchar(20) NOT NULL,
  `s_userName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `s_userName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teaching_staff`
--

CREATE TABLE `teaching_staff` (
  `dep_id` varchar(20) NOT NULL,
  `s_userName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching_staff`
--

INSERT INTO `teaching_staff` (`dep_id`, `s_userName`) VALUES
('123', 'imInstructor'),
('123', 'imInstructor1'),
('123', 'imInstructor2'),
('123', 'imInstructor3'),
('123', 'imInstructor4'),
('124', 'imTeacher1'),
('124', 'imTeacher2'),
('124', 'imTeacher3');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_userName` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `u_name` varchar(20) NOT NULL,
  `userType` varchar(20) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `idProof` varchar(100) NOT NULL,
  `profile_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_userName`, `password`, `u_name`, `userType`, `phone`, `email`, `idProof`, `profile_photo`) VALUES
('@Gulabrao41042', 'gulabrao@mali', 'Gulabrao Mali', 'parent', '9579041042', 'gulabmali03@gmail.com', 'pic1.jpg', ''),
('@hem51972', 'hem@vaze', 'hem', 'visitor', '9021951972', 'hemlalitmali015@gmail.com', 'WIN_20231006_10_23_27_Pro.jpg', ''),
('Hem11111', '123', 'Hem', 'vendor', '1111111111', 'Hem@gamil.com', 'IMG-20240605-WA0000.jpg', ''),
('ram12121', '123', 'ram', 'visitor', '1211212121', 'ram@gamil.com', 'WIN_20231007_20_15_07_Pro.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `compName` varchar(30) NOT NULL,
  `u_userName` varchar(20) NOT NULL,
  `pass_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`compName`, `u_userName`, `pass_id`) VALUES
('Mali.com', 'Hem11111', ''),
('', '@hem51972', ''),
('', '@hem51972', '');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id` varchar(100) NOT NULL,
  `u_userName` varchar(20) NOT NULL,
  `pass_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `u_userName`, `pass_id`) VALUES
('726242473ra', 'ram12121', '');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` varchar(100) NOT NULL,
  `visiting_id` bigint(20) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `exitTime` varchar(20) DEFAULT NULL,
  `entryTime` varchar(20) NOT NULL,
  `meetOverTime` varchar(20) NOT NULL,
  `personToMeet` varchar(20) NOT NULL,
  `date_of_visit` varchar(100) NOT NULL,
  `date_of_schedule` varchar(100) NOT NULL,
  `timeStamp` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `userName` varchar(20) NOT NULL,
  `entry_s_userName` varchar(20) NOT NULL,
  `exit_s_userName` varchar(20) NOT NULL,
  `meet_staff_dep_id` varchar(20) NOT NULL,
  `s_userName` varchar(20) NOT NULL,
  `isOver` varchar(20) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `visiting_id`, `purpose`, `exitTime`, `entryTime`, `meetOverTime`, `personToMeet`, `date_of_visit`, `date_of_schedule`, `timeStamp`, `userName`, `entry_s_userName`, `exit_s_userName`, `meet_staff_dep_id`, `s_userName`, `isOver`, `status`) VALUES
('3', 20240815520914653, 'this is test message', NULL, '', '', 'not specified', '24/08/2024', '15/08/2024 12:25:17am', '2024-08-15 00:25:17', 'Hem11111', '', '', '123', '', '', ''),
('4', 20240825353141267, 'meet hod of IT department', NULL, '', '', 'instructer2', '25/08/2024', '25/08/2024 02:15:31am', '2024-08-25 02:15:31', '@hem51972', '', '', '123', '', '', ''),
('1', 202408151307419573, 'meet hod of IT department', '', '', '09:27:18 pm', 'not specified', '24/08/2024', '15/08/2024 12:21:03am', '2024-08-15 00:21:03', '@hem51972', 'imSecurity1', '', '123', '', '', 'entered'),
('2', 202408151849659995, 'adaklm,s', NULL, '', '', 'not specified', '24/08/2024', '15/08/2024 12:22:54am', '2024-08-15 00:22:54', 'ram12121', '', '', '124', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `college_staff`
--
ALTER TABLE `college_staff`
  ADD PRIMARY KEY (`s_userName`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `non_teaching_staff`
--
ALTER TABLE `non_teaching_staff`
  ADD KEY `s_userName` (`s_userName`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD KEY `u_userName` (`u_userName`);

--
-- Indexes for table `pass`
--
ALTER TABLE `pass`
  ADD PRIMARY KEY (`pass_id`),
  ADD KEY `u_userName` (`u_userName`),
  ADD KEY `s_userName` (`s_userName`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD KEY `s_userName` (`s_userName`);

--
-- Indexes for table `teaching_staff`
--
ALTER TABLE `teaching_staff`
  ADD KEY `dep_id` (`dep_id`),
  ADD KEY `s_userName` (`s_userName`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_userName`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD KEY `u_userName` (`u_userName`),
  ADD KEY `pass_id` (`pass_id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD KEY `u_userName` (`u_userName`),
  ADD KEY `pass_id` (`pass_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`visiting_id`),
  ADD KEY `userName` (`userName`),
  ADD KEY `entry_s_userName` (`entry_s_userName`),
  ADD KEY `exit_s_userName` (`exit_s_userName`),
  ADD KEY `meet_user_dep_id` (`meet_staff_dep_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `non_teaching_staff`
--
ALTER TABLE `non_teaching_staff`
  ADD CONSTRAINT `non_teaching_staff_ibfk_1` FOREIGN KEY (`s_userName`) REFERENCES `college_staff` (`s_userName`);

--
-- Constraints for table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_ibfk_1` FOREIGN KEY (`u_userName`) REFERENCES `user` (`u_userName`);

--
-- Constraints for table `pass`
--
ALTER TABLE `pass`
  ADD CONSTRAINT `pass_ibfk_1` FOREIGN KEY (`u_userName`) REFERENCES `user` (`u_userName`),
  ADD CONSTRAINT `pass_ibfk_2` FOREIGN KEY (`s_userName`) REFERENCES `college_staff` (`s_userName`);

--
-- Constraints for table `security`
--
ALTER TABLE `security`
  ADD CONSTRAINT `security_ibfk_1` FOREIGN KEY (`s_userName`) REFERENCES `college_staff` (`s_userName`);

--
-- Constraints for table `teaching_staff`
--
ALTER TABLE `teaching_staff`
  ADD CONSTRAINT `teaching_staff_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`),
  ADD CONSTRAINT `teaching_staff_ibfk_2` FOREIGN KEY (`s_userName`) REFERENCES `college_staff` (`s_userName`);

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `vendor_ibfk_1` FOREIGN KEY (`u_userName`) REFERENCES `user` (`u_userName`),
  ADD CONSTRAINT `vendor_ibfk_2` FOREIGN KEY (`pass_id`) REFERENCES `pass` (`pass_id`);

--
-- Constraints for table `visitor`
--
ALTER TABLE `visitor`
  ADD CONSTRAINT `visitor_ibfk_1` FOREIGN KEY (`u_userName`) REFERENCES `user` (`u_userName`),
  ADD CONSTRAINT `visitor_ibfk_2` FOREIGN KEY (`pass_id`) REFERENCES `pass` (`pass_id`);

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`userName`) REFERENCES `user` (`u_userName`),
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`entry_s_userName`) REFERENCES `security` (`s_userName`),
  ADD CONSTRAINT `visits_ibfk_3` FOREIGN KEY (`exit_s_userName`) REFERENCES `security` (`s_userName`),
  ADD CONSTRAINT `visits_ibfk_4` FOREIGN KEY (`meet_staff_dep_id`) REFERENCES `teaching_staff` (`dep_id`),
  ADD CONSTRAINT `visits_ibfk_5` FOREIGN KEY (`s_userName`) REFERENCES `college_staff` (`s_userName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
