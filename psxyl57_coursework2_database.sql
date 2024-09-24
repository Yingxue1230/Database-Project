-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： mariadb
-- 生成日期： 2023-12-07 13:41:00
-- 服务器版本： 10.8.8-MariaDB-1:10.8.8+maria~ubu2204
-- PHP 版本： 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `coursework2`
--

-- --------------------------------------------------------

--
-- 表的结构 `Fines`
--

CREATE TABLE `Fines` (
  `Fine_ID` int(11) NOT NULL,
  `Fine_Amount` int(11) NOT NULL,
  `Fine_Points` int(11) NOT NULL,
  `Incident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Fines`
--

INSERT INTO `Fines` (`Fine_ID`, `Fine_Amount`, `Fine_Points`, `Incident_ID`) VALUES
(1, 2000, 6, 3),
(2, 50, 0, 2),
(3, 500, 3, 4),
(14, 300, 6, 1);

-- --------------------------------------------------------

--
-- 表的结构 `Incident`
--

CREATE TABLE `Incident` (
  `Incident_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) DEFAULT NULL,
  `People_ID` int(11) DEFAULT NULL,
  `Incident_Date` date NOT NULL,
  `Incident_Report` varchar(500) NOT NULL,
  `Offence_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Incident`
--

INSERT INTO `Incident` (`Incident_ID`, `Vehicle_ID`, `People_ID`, `Incident_Date`, `Incident_Report`, `Offence_ID`) VALUES
(1, 15, 4, '2017-12-01', '40mph in a 30 limit', 1),
(2, 20, 8, '2017-11-01', 'Double parked', 4),
(3, 13, 4, '2017-09-17', '110mph on motorway', 1),
(4, 14, 2, '2017-08-22', 'Failure to stop at a red light - travelling 25mph', 8),
(5, 13, 4, '2017-10-17', 'Not wearing a seatbelt on the M1', 3),
(7, 31, 2, '2023-11-16', 'Overspeed', 1);

-- --------------------------------------------------------

--
-- 表的结构 `Offence`
--

CREATE TABLE `Offence` (
  `Offence_ID` int(11) NOT NULL,
  `Offence_description` varchar(50) NOT NULL,
  `Offence_maxFine` int(11) NOT NULL,
  `Offence_maxPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Offence`
--

INSERT INTO `Offence` (`Offence_ID`, `Offence_description`, `Offence_maxFine`, `Offence_maxPoints`) VALUES
(1, 'Speeding', 1000, 3),
(2, 'Speeding on a motorway', 2500, 6),
(3, 'Seat belt offence', 500, 0),
(4, 'Illegal parking', 500, 0),
(5, 'Drink driving', 10000, 11),
(6, 'Driving without a licence', 10000, 0),
(7, 'Traffic light offences', 1000, 3),
(8, 'Cycling on pavement', 500, 0),
(9, 'Failure to have control of vehicle', 1000, 3),
(10, 'Dangerous driving', 1000, 11),
(11, 'Careless driving', 5000, 6),
(12, 'Dangerous cycling', 2500, 0);

-- --------------------------------------------------------

--
-- 表的结构 `officer`
--

CREATE TABLE `officer` (
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 转存表中的数据 `officer`
--

INSERT INTO `officer` (`Username`, `Password`, `User_ID`) VALUES
('mcnulty', 'plod123', 1),
('moreland', 'fuzz42', 2),
('daniels', 'copper99', 4);

-- --------------------------------------------------------

--
-- 表的结构 `Ownership`
--

CREATE TABLE `Ownership` (
  `People_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Ownership`
--

INSERT INTO `Ownership` (`People_ID`, `Vehicle_ID`) VALUES
(3, 12),
(8, 20),
(4, 15),
(4, 13),
(1, 16),
(2, 14),
(5, 17),
(6, 18),
(7, 21);

-- --------------------------------------------------------

--
-- 表的结构 `People`
--

CREATE TABLE `People` (
  `People_ID` int(11) NOT NULL,
  `People_name` varchar(50) NOT NULL,
  `People_address` varchar(50) DEFAULT NULL,
  `People_licence` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `People`
--

INSERT INTO `People` (`People_ID`, `People_name`, `People_address`, `People_licence`) VALUES
(1, 'James Smith', '23 Barnsdale Road, Leicester', 'SMITH92LDOFJJ829'),
(2, 'Jennifer Allen', '46 Bramcote Drive, Nottingham', 'ALLEN88K23KLR9B3'),
(3, 'John Myers', '323 Derby Road, Nottingham', 'MYERS99JDW8REWL3'),
(4, 'James Smith', '26 Devonshire Avenue, Nottingham', 'SMITHR004JFS20TR'),
(5, 'Terry Brown', '7 Clarke Rd, Nottingham', 'BROWND3PJJ39DLFG'),
(6, 'Mary Adams', '38 Thurman St, Nottingham', 'ADAMSH9O3JRHH107'),
(7, 'Neil Becker', '6 Fairfax Close, Nottingham', 'BECKE88UPR840F9R'),
(8, 'Angela Smith', '30 Avenue Road, Grantham', 'SMITH222LE9FJ5DS'),
(9, 'Xene Medora', '22 House Drive, West Bridgford', 'MEDORH914ANBB223');

-- --------------------------------------------------------

--
-- 表的结构 `Trail`
--

CREATE TABLE `Trail` (
  `Audit_ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Audit_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Type` varchar(255) NOT NULL,
  `Table_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 转存表中的数据 `Trail`
--

INSERT INTO `Trail` (`Audit_ID`, `Username`, `Audit_time`, `Type`, `Table_name`) VALUES
(11, 'daniels', '2023-12-05 23:30:49', 'Add fines', 'Fines'),
(13, 'daniels', '2023-12-06 23:44:34', 'Change password', 'officer'),
(14, 'mcnulty', '2023-12-06 23:45:27', 'Change password', 'officer'),
(15, 'daniels', '2023-12-06 23:52:12', 'Log in', 'None');

-- --------------------------------------------------------

--
-- 表的结构 `Vehicle`
--

CREATE TABLE `Vehicle` (
  `Vehicle_ID` int(11) NOT NULL,
  `Vehicle_type` varchar(20) NOT NULL,
  `Vehicle_colour` varchar(20) NOT NULL,
  `Vehicle_licence` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Vehicle`
--

INSERT INTO `Vehicle` (`Vehicle_ID`, `Vehicle_type`, `Vehicle_colour`, `Vehicle_licence`) VALUES
(12, 'Ford Fiesta', 'Blue', 'LB15AJL'),
(13, 'Ferrari 458', 'Red', 'MY64PRE'),
(14, 'Vauxhall Astra', 'Silver', 'FD65WPQ'),
(15, 'Honda Civic', 'Green', 'FJ17AUG'),
(16, 'Toyota Prius', 'Silver', 'FP16KKE'),
(17, 'Ford Mondeo', 'Black', 'FP66KLM'),
(18, 'Ford Focus', 'White', 'DJ14SLE'),
(20, 'Nissan Pulsar', 'Red', 'NY64KWD'),
(21, 'Renault Scenic', 'Silver', 'BC16OEA'),
(22, 'Hyundai i30', 'Grey', 'AD223NG'),
(31, 'Benz E300L', 'black', 'LD34DAF');

--
-- 转储表的索引
--

--
-- 表的索引 `Fines`
--
ALTER TABLE `Fines`
  ADD PRIMARY KEY (`Fine_ID`),
  ADD KEY `fk_fines_incident` (`Incident_ID`);

--
-- 表的索引 `Incident`
--
ALTER TABLE `Incident`
  ADD PRIMARY KEY (`Incident_ID`),
  ADD KEY `fk_incident_offence` (`Offence_ID`),
  ADD KEY `fk_incident_people` (`People_ID`),
  ADD KEY `fk_incident_vehicle` (`Vehicle_ID`);

--
-- 表的索引 `Offence`
--
ALTER TABLE `Offence`
  ADD PRIMARY KEY (`Offence_ID`);

--
-- 表的索引 `officer`
--
ALTER TABLE `officer`
  ADD PRIMARY KEY (`User_ID`);

--
-- 表的索引 `Ownership`
--
ALTER TABLE `Ownership`
  ADD KEY `fk_ownership_people` (`People_ID`),
  ADD KEY `fk_ownership_vehicle` (`Vehicle_ID`);

--
-- 表的索引 `People`
--
ALTER TABLE `People`
  ADD PRIMARY KEY (`People_ID`);

--
-- 表的索引 `Trail`
--
ALTER TABLE `Trail`
  ADD PRIMARY KEY (`Audit_ID`);

--
-- 表的索引 `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD PRIMARY KEY (`Vehicle_ID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `Fines`
--
ALTER TABLE `Fines`
  MODIFY `Fine_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `Incident`
--
ALTER TABLE `Incident`
  MODIFY `Incident_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `Offence`
--
ALTER TABLE `Offence`
  MODIFY `Offence_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `officer`
--
ALTER TABLE `officer`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `People`
--
ALTER TABLE `People`
  MODIFY `People_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 使用表AUTO_INCREMENT `Trail`
--
ALTER TABLE `Trail`
  MODIFY `Audit_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `Vehicle`
--
ALTER TABLE `Vehicle`
  MODIFY `Vehicle_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 限制导出的表
--

--
-- 限制表 `Fines`
--
ALTER TABLE `Fines`
  ADD CONSTRAINT `fk_fines_incident` FOREIGN KEY (`Incident_ID`) REFERENCES `Incident` (`Incident_ID`);

--
-- 限制表 `Incident`
--
ALTER TABLE `Incident`
  ADD CONSTRAINT `fk_incident_offence` FOREIGN KEY (`Offence_ID`) REFERENCES `Offence` (`Offence_ID`),
  ADD CONSTRAINT `fk_incident_people` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  ADD CONSTRAINT `fk_incident_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`);

--
-- 限制表 `Ownership`
--
ALTER TABLE `Ownership`
  ADD CONSTRAINT `fk_ownership_people` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  ADD CONSTRAINT `fk_ownership_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
