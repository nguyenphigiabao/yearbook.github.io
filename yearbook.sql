-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 11:42 AM
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
-- Database: `yearbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `class` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `class`, `user_id`, `name`, `comment`, `date`) VALUES
(19, '12 Tin', 18, 'uploads/photo_upload__19.png', '', '2026-10-23 15:29:08'),
(20, '12 Tin', 20, 'uploads/photo_upload__20.jpg', '', '2026-10-24 11:25:58'),
(21, '12 Tin', 20, 'uploads/photo_upload__21.jpg', '', '2026-10-24 11:26:02'),
(22, '12 Tin', 20, 'uploads/photo_upload__22.jpg', 'no', '2026-10-24 11:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `class` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `comment` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `class`, `user_id`, `type`, `comment`) VALUES
(1, '12 Tin', 18, 1, 'Who\'s most likely to become a millionair?'),
(2, '12 Tin', 18, 1, 'Who\'s end up in jail?');

-- --------------------------------------------------------

--
-- Table structure for table `poll_answers`
--

CREATE TABLE `poll_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `answer_1` int(11) NOT NULL,
  `answer_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poll_answers`
--

INSERT INTO `poll_answers` (`id`, `user_id`, `poll_id`, `answer_1`, `answer_2`) VALUES
(1, 19, 2, 19, 0),
(2, 19, 1, 18, 0),
(3, 18, 2, 19, 0),
(4, 18, 1, 18, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `question`, `answer`) VALUES
(1, 1, 'Lời tự nhủ trong kỉ yếu', 'whatever'),
(2, 1, 'useless question', 'not empty'),
(3, 2, 'useless title', 'not empty'),
(4, 8, 'Lời tự nhủ trong kỉ yếu:', 'I am the strongest'),
(5, 8, 'Giới thiệu bản thân:', 'I am Dih'),
(6, 8, 'Công việc mơ ước trong tương lai:', 'entrepreneur'),
(7, 8, 'Lời nhắn đến bản thân trong tương lai:', 'Be strong!!'),
(8, 8, 'Kỉ niệm đáng nhớ thời cấp ba:', 'Don\'t have any'),
(9, 8, 'Môn học yêu thích:', 'Chinese'),
(10, 0, 'Góc confession ẩn danh:', 'I\'m in love with A'),
(11, 9, 'Lời tự nhủ trong kỉ yếu:', 'qwefqwe'),
(12, 9, 'Giới thiệu bản thân:', 'fqwefqwfe'),
(13, 9, 'Công việc mơ ước trong tương lai:', 'qefe'),
(14, 9, 'Lời nhắn đến bản thân trong tương lai:', 'fqeqe'),
(15, 9, 'Kỉ niệm đáng nhớ thời cấp ba:', 'qwefqweqwefqwe'),
(16, 9, 'Môn học yêu thích:', 'efqwefe'),
(17, 0, 'Góc confession ẩn danh:', 'wqfqwfew'),
(18, 10, 'Lời tự nhủ trong kỉ yếu:', 'qwefqwe'),
(19, 10, 'Giới thiệu bản thân:', 'fqwefqwfe'),
(20, 10, 'Công việc mơ ước trong tương lai:', 'qefe'),
(21, 10, 'Lời nhắn đến bản thân trong tương lai:', 'fqeqe'),
(22, 10, 'Kỉ niệm đáng nhớ thời cấp ba:', 'qwefqweqwefqwe'),
(23, 10, 'Môn học yêu thích:', 'efqwefe'),
(24, 0, 'Góc confession ẩn danh:', 'wqfqwfew'),
(25, 11, 'Lời tự nhủ trong kỉ yếu:', 'qwefqwe'),
(26, 11, 'Giới thiệu bản thân:', 'fqwefqwfe'),
(27, 11, 'Công việc mơ ước trong tương lai:', 'qefe'),
(28, 11, 'Lời nhắn đến bản thân trong tương lai:', 'fqeqe'),
(29, 11, 'Kỉ niệm đáng nhớ thời cấp ba:', 'qwefqweqwefqwe'),
(30, 11, 'Môn học yêu thích:', 'efqwefe'),
(31, 0, 'Góc confession ẩn danh:', 'wqfqwfew'),
(32, 12, 'Lời tự nhủ trong kỉ yếu:', 'ergae'),
(33, 12, 'Giới thiệu bản thân:', 'qwe'),
(34, 12, 'Công việc mơ ước trong tương lai:', 'qwe'),
(35, 12, 'Lời nhắn đến bản thân trong tương lai:', 'qwe'),
(36, 12, 'Kỉ niệm đáng nhớ thời cấp ba:', 'qwe'),
(37, 12, 'Môn học yêu thích:', 'qwe'),
(38, 0, 'Góc confession ẩn danh:', 'qwe'),
(39, 13, 'Lời tự nhủ trong kỉ yếu:', 'ergae'),
(40, 13, 'Giới thiệu bản thân:', 'qwe'),
(41, 13, 'Công việc mơ ước trong tương lai:', 'qwe'),
(42, 13, 'Lời nhắn đến bản thân trong tương lai:', 'qwe'),
(43, 13, 'Kỉ niệm đáng nhớ thời cấp ba:', 'qwe'),
(44, 13, 'Môn học yêu thích:', 'qwe'),
(45, 0, 'Góc confession ẩn danh:', 'qwe'),
(46, 14, 'Lời tự nhủ trong kỉ yếu:', 'abc'),
(47, 14, 'Giới thiệu bản thân:', 'abc'),
(48, 14, 'Công việc mơ ước trong tương lai:', 'abc'),
(49, 14, 'Lời nhắn đến bản thân trong tương lai:', 'abc'),
(50, 14, 'Kỉ niệm đáng nhớ thời cấp ba:', 'abc'),
(51, 14, 'Môn học yêu thích:', 'abc'),
(52, 0, 'Góc confession ẩn danh:', 'abc'),
(53, 15, 'Lời tự nhủ trong kỉ yếu:', 'abc'),
(54, 15, 'Giới thiệu bản thân:', 'abc'),
(55, 15, 'Công việc mơ ước trong tương lai:', 'abc'),
(56, 15, 'Lời nhắn đến bản thân trong tương lai:', 'abc'),
(57, 15, 'Kỉ niệm đáng nhớ thời cấp ba:', 'abc'),
(58, 15, 'Môn học yêu thích:', 'abc'),
(59, 0, 'Góc confession ẩn danh:', 'abc'),
(60, 16, 'Lời tự nhủ trong kỉ yếu:', 'abc'),
(61, 16, 'Giới thiệu bản thân:', 'abc'),
(62, 16, 'Công việc mơ ước trong tương lai:', 'abc'),
(63, 16, 'Lời nhắn đến bản thân trong tương lai:', 'abc'),
(64, 16, 'Kỉ niệm đáng nhớ thời cấp ba:', 'abc'),
(65, 16, 'Môn học yêu thích:', 'abc'),
(66, 0, 'Góc confession ẩn danh:', 'abc'),
(67, 18, 'Lời tự nhủ trong kỉ yếu:', 'I am the strongest'),
(68, 18, 'Giới thiệu bản thân:', 'No'),
(69, 18, 'Công việc mơ ước trong tương lai:', 'entrepreneur'),
(70, 18, 'Lời nhắn đến bản thân trong tương lai:', 'with great power comes with great responsibilities'),
(71, 18, 'Kỉ niệm đáng nhớ thời cấp ba:', 'no'),
(72, 18, 'Môn học yêu thích:', 'French'),
(73, 0, 'Góc confession ẩn danh:', 'no'),
(74, 19, 'Lời tự nhủ trong kỉ yếu:', 'ergae'),
(75, 19, 'Giới thiệu bản thân:', 'wefffwf'),
(76, 19, 'Công việc mơ ước trong tương lai:', 'wgwegweg'),
(77, 19, 'Lời nhắn đến bản thân trong tương lai:', 'wegegweg'),
(78, 19, 'Kỉ niệm đáng nhớ thời cấp ba:', 'wegwegwegweg'),
(79, 19, 'Môn học yêu thích:', 'wegweggwege'),
(80, 0, 'Góc confession ẩn danh:', 'gwegewgewgweg'),
(81, 20, 'Lời tự nhủ trong kỉ yếu:', 'asd'),
(82, 20, 'Giới thiệu bản thân:', 'asd'),
(83, 20, 'Công việc mơ ước trong tương lai:', 'asd'),
(84, 20, 'Lời nhắn đến bản thân trong tương lai:', 'asd'),
(85, 20, 'Kỉ niệm đáng nhớ thời cấp ba:', 'asd'),
(86, 20, 'Môn học yêu thích:', 'asd'),
(87, 0, 'Góc confession ẩn danh:', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `class` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `email`, `password`, `gender`, `birth_date`, `class`) VALUES
(1, 'Nguyễn Phi Gia Bảo', 'fulhenmc@gmail.com', '571cfdefb67df9a9cda4450ce4aab5d8195afa865f71642e965fa2287207d221', '', NULL, ''),
(18, 'Nguyễn Văn A', 'nguyenvana@gmail.com', 'a4c5535dc7803174143cb8a229e9be99b27298ab334e0ec53f0def94b04034dc', 'nam', '2006-09-05', '12 Tin'),
(19, 'Fake User', 'fakeuser1@gmail.com', 'f9d05ca4c8426e1bc0f6d1fca8bf6f159739ef36ca4ffb330615145de1c2fd80', 'nữ', '2047-10-23', '12 Tin'),
(20, 'Nguyễn Thị Quỳnh Trang', 'bi@gmail.com', 'e2eb7d1d56ea182cd104879c6e20d5ecbee0b0e9be33e55de00095b63e068dee', 'nữ', '2000-11-26', '12 Tin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_answers`
--
ALTER TABLE `poll_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `poll_answers`
--
ALTER TABLE `poll_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
