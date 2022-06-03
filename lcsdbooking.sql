-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2022-06-03 07:48:14
-- 服务器版本： 10.4.24-MariaDB
-- PHP 版本： 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `lcsdbooking`
--

-- --------------------------------------------------------

--
-- 表的结构 `account`
--

CREATE TABLE `account` (
  `UserID` int(11) NOT NULL,
  `AreaCode` int(11) NOT NULL DEFAULT 852,
  `PhoneNumber` int(11) NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `account`
--

INSERT INTO `account` (`UserID`, `AreaCode`, `PhoneNumber`, `Password`) VALUES
(0, 0, 0, '1234'),
(1, 852, 27665433, '12421'),
(2, 852, 11223344, '123465'),
(3, 852, 11223355, '123465'),
(4, 852, 11223366, '123465');

-- --------------------------------------------------------

--
-- 表的结构 `session`
--

CREATE TABLE `session` (
  `SessCode` int(13) NOT NULL,
  `VenueCode` int(11) NOT NULL,
  `FromTime` datetime NOT NULL,
  `ToTime` datetime NOT NULL,
  `UserID` int(11) NOT NULL,
  `IsAttended` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `session`
--

INSERT INTO `session` (`SessCode`, `VenueCode`, `FromTime`, `ToTime`, `UserID`, `IsAttended`) VALUES
(1, 1, '2022-06-10 12:00:00', '2022-06-10 13:00:00', 1, 0),
(2, 1, '2022-06-01 08:00:00', '2022-06-01 09:00:00', 2, 1),
(3, 1, '2022-06-05 09:00:00', '2022-06-05 10:00:00', 0, 0),
(4, 1, '2022-06-08 11:00:00', '2022-06-08 12:00:00', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `venue`
--

CREATE TABLE `venue` (
  `VenueCode` int(11) NOT NULL,
  `Address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `venue`
--

INSERT INTO `venue` (`VenueCode`, `Address`) VALUES
(1, 'Wuhu Street Temporary Playground, Lo Lung Hang, Hong Kong');

-- --------------------------------------------------------

--
-- 表的结构 `waitlist`
--

CREATE TABLE `waitlist` (
  `WLID` int(15) NOT NULL,
  `Session` int(13) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `waitlist`
--

INSERT INTO `waitlist` (`WLID`, `Session`, `UserID`) VALUES
(5, 4, 2),
(6, 4, 3);

--
-- 转储表的索引
--

--
-- 表的索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- 表的索引 `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`SessCode`),
  ADD KEY `VenueCode` (`VenueCode`,`UserID`),
  ADD KEY `2` (`UserID`);

--
-- 表的索引 `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`VenueCode`),
  ADD KEY `VenueCode` (`VenueCode`);

--
-- 表的索引 `waitlist`
--
ALTER TABLE `waitlist`
  ADD PRIMARY KEY (`WLID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `Session` (`Session`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `account`
--
ALTER TABLE `account`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `session`
--
ALTER TABLE `session`
  MODIFY `SessCode` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `venue`
--
ALTER TABLE `venue`
  MODIFY `VenueCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `waitlist`
--
ALTER TABLE `waitlist`
  MODIFY `WLID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 限制导出的表
--

--
-- 限制表 `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `1` FOREIGN KEY (`VenueCode`) REFERENCES `venue` (`VenueCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `2` FOREIGN KEY (`UserID`) REFERENCES `account` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `waitlist`
--
ALTER TABLE `waitlist`
  ADD CONSTRAINT `waitlist_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `account` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waitlist_ibfk_2` FOREIGN KEY (`Session`) REFERENCES `session` (`SessCode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
