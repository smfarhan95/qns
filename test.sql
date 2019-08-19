-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2019 at 12:47 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_Id` int(11) NOT NULL,
  `department_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_Id`, `department_Name`) VALUES
(1, 'Consultation'),
(2, 'Pharmacy'),
(3, 'X-Ray'),
(4, 'Dental');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_Name` varchar(100) NOT NULL,
  `patient_IC` varchar(12) NOT NULL,
  `patient_Address` varchar(400) NOT NULL,
  `patient_Sex` varchar(10) NOT NULL,
  `patient_Phone` varchar(11) NOT NULL,
  `patient_Nationality` varchar(100) NOT NULL,
  `staff_Id` varchar(50) DEFAULT NULL,
  `token` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_Name`, `patient_IC`, `patient_Address`, `patient_Sex`, `patient_Phone`, `patient_Nationality`, `staff_Id`, `token`) VALUES
('Nur Mardhiah binti Ali', '950321105222', 'Taman Sri Buana, Melaka', 'Female', '0168426632', 'Malaysia', '', ''),
('Mohd Razali bin Kamaruzaman', '950321105233', 'Taman Desa Ria, Melaka', 'Male', '0165223158', 'Malaysia', '', ''),
('Rajagopal a/l Padmanathan', '950321105287', 'Taman Desa Ria, melaka', 'Male', '0145826865', 'Malaysia', '', ''),
('Shaik Mohd Farhan bin S M Salmi', '950621106131', 'Taman Desa Idaman, Melaka', 'Male', '0176931471', 'Malaysia', NULL, 'cUfUK9uVGZc:APA91bFYFIcTJLJDT8mBggtwvl6pw1Gc3GgA1cl4zAhuSGHN6aswo6yY9SgAZSSxNQekwT-ickVU0oevevapm-X0zdb-3enWAm5Dzl3MDO7y4Xsrr7FDX13NB82pkpCW1-K8Ydtf7C_Z');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `queue_Id` int(11) NOT NULL,
  `queue_No` varchar(1000) NOT NULL,
  `patient_IC` varchar(12) NOT NULL,
  `room_Id` int(11) DEFAULT NULL,
  `staff_Id` varchar(50) DEFAULT NULL,
  `queue_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `queue_Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`queue_Id`, `queue_No`, `patient_IC`, `room_Id`, `staff_Id`, `queue_Date`, `queue_Status`) VALUES
(3, '1003', '950321105233', 1, 'S0010', '2019-05-06 06:24:09', 'Waiting'),
(4, '1004', '950321105233', 2, 'S0010', '2019-05-06 06:25:03', 'Waiting'),
(10, '1003', '950321105222', 2, 'S0010', '2019-05-11 19:23:59', 'Waiting'),
(11, '1004', '950321105222', 3, 'S0010', '2019-05-11 19:24:19', 'Waiting'),
(12, '1005', '950321105233', 2, 'S0010', '2019-05-11 19:24:30', 'Waiting'),
(13, '1006', '950321105233', 3, 'S0010', '2019-05-11 19:24:37', 'Waiting'),
(14, '1007', '950321105222', 0, NULL, '2019-05-11 19:30:03', 'Waiting'),
(15, '1008', '950321105233', 3, NULL, '2019-05-11 19:30:15', 'Waiting'),
(17, '1002', '950321105233', 3, 'S0011', '2019-08-07 09:37:49', 'Complete'),
(19, '1004', '950621106131', 1, 'S0010', '2019-08-07 12:01:58', 'Waiting'),
(20, '1005', '950321105222', 1, 'S0010', '2019-08-07 12:03:05', 'Waiting'),
(21, '1006', '950321105233', 1, NULL, '2019-08-07 12:02:08', 'Waiting'),
(25, '1001', '950321105222', 3, 'S0011', '2019-08-09 03:56:38', 'Discharge'),
(26, '1002', '950321105287', 2, 'S0011', '2019-08-08 06:02:55', 'Waiting'),
(27, '1003', '950621106131', 2, NULL, '2019-08-08 03:36:53', 'Waiting'),
(28, '1001', '950321105222', 3, 'S0011', '2019-08-09 03:56:38', 'Discharge'),
(29, '1002', '950621106131', 2, 'S0011', '2019-08-09 03:56:46', 'Consult'),
(30, '1003', '950321105287', 0, 'S0010', '2019-08-09 03:49:25', 'Discharge');

-- --------------------------------------------------------

--
-- Table structure for table `queue_log`
--

CREATE TABLE `queue_log` (
  `queue_Id` int(11) NOT NULL,
  `queue_No` varchar(1000) NOT NULL,
  `patient_IC` varchar(12) NOT NULL,
  `room_Id` int(11) NOT NULL,
  `staff_Id` varchar(50) NOT NULL,
  `queue_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `queue_Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queue_log`
--

INSERT INTO `queue_log` (`queue_Id`, `queue_No`, `patient_IC`, `room_Id`, `staff_Id`, `queue_Date`, `queue_Status`) VALUES
(37, '1001', '950321105222', 2, '', '2019-08-08 03:36:39', 'Waiting'),
(38, '1002', '950321105287', 2, '', '2019-08-08 03:36:47', 'Waiting'),
(39, '1003', '950621106131', 2, '', '2019-08-08 03:36:53', 'Waiting'),
(40, '1001', '950321105222', 2, 'S0011', '2019-08-08 03:37:01', 'Consult'),
(41, '1001', '950321105222', 2, 'S0011', '2019-08-08 03:37:07', 'Waiting'),
(42, '1001', '950321105222', 2, 'S0011', '2019-08-08 03:45:20', 'Consult'),
(43, '1001', '950321105222', 2, 'S0011', '2019-08-08 06:01:28', 'Waiting'),
(44, '1002', '950321105287', 2, 'S0011', '2019-08-08 06:02:11', 'Consult'),
(45, '1002', '950321105287', 2, 'S0011', '2019-08-08 06:02:55', 'Waiting'),
(46, '1001', '950321105222', 2, 'S0011', '2019-08-08 06:03:08', 'Consult'),
(47, '1001', '950321105222', 2, 'S0011', '2019-08-08 06:03:28', 'Waiting'),
(48, '1001', '950321105222', 2, '', '2019-08-09 01:22:06', 'Waiting'),
(49, '1002', '950621106131', 2, '', '2019-08-09 02:20:06', 'Waiting'),
(50, '1001', '950321105222', 2, 'S0011', '2019-08-09 02:20:28', 'Consult'),
(51, '1001', '950321105222', 2, 'S0011', '2019-08-09 02:21:14', 'Waiting'),
(52, '1002', '950621106131', 2, 'S0011', '2019-08-09 02:21:21', 'Consult'),
(53, '1002', '950621106131', 2, 'S0011', '2019-08-09 02:21:30', 'Waiting'),
(54, '1002', '950621106131', 2, 'S0011', '2019-08-09 02:21:35', 'Consult'),
(55, '1003', '950321105287', 1, '', '2019-08-09 03:47:22', 'Waiting'),
(56, '1003', '950321105287', 1, 'S0010', '2019-08-09 03:48:58', 'Consult'),
(57, '1003', '950321105287', 0, 'S0010', '2019-08-09 03:49:25', 'Discharge'),
(58, '1001', '950321105222', 2, 'S0011', '2019-08-09 03:51:56', 'Consult'),
(59, '1001', '950321105222', 2, 'S0011', '2019-08-09 03:52:04', 'Waiting'),
(60, '1001', '950321105222', 2, 'S0011', '2019-08-09 03:55:44', 'Consult'),
(61, '1001', '950321105222', 3, 'S0011', '2019-08-09 03:56:38', 'Discharge'),
(62, '1002', '950621106131', 2, 'S0011', '2019-08-09 03:56:46', 'Consult');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_Id` int(11) NOT NULL,
  `room_Name` varchar(100) NOT NULL,
  `department_Id` int(11) NOT NULL,
  `staff_Id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_Id`, `room_Name`, `department_Id`, `staff_Id`) VALUES
(2, 'Consultation room 2', 1, 'S0011'),
(3, 'Pharmacy', 2, 'S0013'),
(4, 'X-ray room 1', 3, 'S0012');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_Id` varchar(50) NOT NULL,
  `staff_IC` varchar(12) NOT NULL,
  `staff_Name` varchar(100) NOT NULL,
  `staff_Address` varchar(1000) NOT NULL,
  `staff_Sex` varchar(12) NOT NULL,
  `staff_Phone` varchar(11) NOT NULL,
  `staff_Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_Id`, `staff_IC`, `staff_Name`, `staff_Address`, `staff_Sex`, `staff_Phone`, `staff_Password`) VALUES
('admin', '111111111111', 'Farid Nuzman bin Alfa Khalid', '', 'admin', '0176931471', 'admin'),
('S0010', '950621106123', 'Dr. Jamal bin Abdullah', 'Taman Murai Jaya, Melaka', 'Male', '0164223779', '123'),
('S0011', '950621106126', 'Dr. Siti Jamilah binti Salim', 'Taman Mutiara, Melaka', 'Female', '0136931471', '123'),
('S0012', '930831019143', 'Dr. Hasif Ali bin Mahad', 'Taman Sri Buana, Melaka', 'Male', '0123334584', '123'),
('S0013', '860101106038', 'Nur Mariana binti Azman', 'Taman Desa Ria, Melaka', 'Female', '0176844121', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_Id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_IC`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`queue_Id`);

--
-- Indexes for table `queue_log`
--
ALTER TABLE `queue_log`
  ADD PRIMARY KEY (`queue_Id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_Id`),
  ADD UNIQUE KEY `staff_Id` (`staff_Id`),
  ADD KEY `roomdep` (`department_Id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `queue_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `queue_log`
--
ALTER TABLE `queue_log`
  MODIFY `queue_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `roomdep` FOREIGN KEY (`department_Id`) REFERENCES `department` (`department_Id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
