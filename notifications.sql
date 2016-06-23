-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:8080
-- Generation Time: 2016 年 6 朁E23 日 20:21
-- サーバのバージョン： 10.1.10-MariaDB
-- PHP Version: 5.5.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cebroad`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `click_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `partner_id`, `event_id`, `topic_id`, `click_flag`, `created`, `modified`) VALUES
(1, 1, 2, 4, 1, 1, '2016-06-20 19:53:26', '2016-06-20 15:54:27'),
(2, 1, 2, 4, 1, 1, '2016-06-20 20:21:21', '2016-06-20 15:54:20'),
(3, 1, 2, 4, 1, 1, '2016-06-20 20:22:14', '2016-06-20 15:46:17'),
(4, 1, 1, 4, 1, 1, '2016-06-21 01:01:35', '2016-06-23 01:42:09'),
(5, 1, 1, 4, 1, 1, '2016-06-21 01:01:42', '2016-06-23 01:42:07'),
(6, 1, 1, 4, 1, 1, '2016-06-21 01:04:25', '2016-06-23 01:42:06'),
(7, 1, 1, 4, 1, 1, '2016-06-21 01:04:41', '2016-06-23 01:42:03'),
(8, 1, 1, 4, 1, 1, '2016-06-21 01:05:29', '2016-06-23 01:42:01'),
(9, 2, 1, 3, 1, 1, '2016-06-21 09:59:03', '2016-06-23 01:42:47'),
(10, 2, 1, 3, 1, 1, '2016-06-21 09:59:07', '2016-06-23 01:42:43'),
(11, 1, 2, 2, 2, 1, '2016-06-23 10:32:53', '2016-06-23 01:34:43'),
(12, 2, 1, 4, 3, 0, '2016-06-23 11:54:42', '2016-06-23 02:54:42'),
(13, 2, 2, 4, 3, 0, '2016-06-23 11:54:42', '2016-06-23 02:54:42'),
(14, 1, 2, 4, 3, 0, '2016-06-23 11:57:57', '2016-06-23 02:57:57'),
(15, 2, 2, 4, 3, 0, '2016-06-23 11:57:57', '2016-06-23 02:57:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
