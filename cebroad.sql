-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:8080
-- Generation Time: 2016 年 6 朁E21 日 03:09
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
-- テーブルの構造 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `event_id`, `comment`, `delete_flag`, `created`, `modified`) VALUES
(1, 1, 2, '保存実験', 0, '2016-06-16 23:30:34', '2016-06-16 14:30:34'),
(2, 1, 2, '保存実験', 0, '2016-06-16 23:30:45', '2016-06-16 14:30:45'),
(3, 1, 2, '保存実験', 0, '2016-06-16 23:31:40', '2016-06-16 14:31:40'),
(4, 1, 2, '保存', 0, '2016-06-16 23:32:21', '2016-06-16 14:32:21'),
(5, 1, 2, '保存', 0, '2016-06-16 23:57:07', '2016-06-16 14:57:07'),
(6, 1, 2, '保存', 0, '2016-06-17 11:06:35', '2016-06-17 02:06:35'),
(7, 2, 4, '保存', 0, '2016-06-20 19:52:40', '2016-06-20 10:52:40'),
(8, 2, 4, '保存', 0, '2016-06-20 19:52:46', '2016-06-20 10:52:46'),
(9, 2, 4, '保存', 0, '2016-06-20 19:53:26', '2016-06-20 10:53:26'),
(10, 2, 4, '保存', 0, '2016-06-20 20:21:21', '2016-06-20 11:21:21'),
(11, 2, 4, '保存', 0, '2016-06-20 20:22:14', '2016-06-20 11:22:14'),
(12, 1, 4, '保存', 0, '2016-06-21 01:01:35', '2016-06-20 16:01:35'),
(13, 1, 4, '保存', 0, '2016-06-21 01:01:41', '2016-06-20 16:01:41'),
(14, 1, 4, '保存', 0, '2016-06-21 01:04:25', '2016-06-20 16:04:25'),
(15, 1, 4, '保存', 0, '2016-06-21 01:04:41', '2016-06-20 16:04:41'),
(16, 1, 4, '保存', 0, '2016-06-21 01:05:29', '2016-06-20 16:05:29'),
(17, 1, 3, 'To yuta2', 0, '2016-06-21 09:59:03', '2016-06-21 00:59:03'),
(18, 1, 3, '', 0, '2016-06-21 09:59:07', '2016-06-21 00:59:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `place_name` varchar(255) NOT NULL,
  `coordinate` varchar(255) NOT NULL,
  `picture_path_1` varchar(255) DEFAULT NULL,
  `picture_path_2` varchar(255) DEFAULT NULL,
  `picture_path_3` varchar(255) DEFAULT NULL,
  `capacity_nim` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_category_id` int(11) NOT NULL,
  `open_flag` tinyint(1) NOT NULL DEFAULT '0',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `event_name`, `detail`, `date`, `place_name`, `coordinate`, `picture_path_1`, `picture_path_2`, `picture_path_3`, `capacity_nim`, `organizer_id`, `event_category_id`, `open_flag`, `delete_flag`, `created`, `modified`) VALUES
(2, 'てすと', '普通の文章', '2016-06-08 00:00:00', 'nexseed', '1203912391023, 112391293019309', NULL, NULL, NULL, 500, 1, 1, 0, 0, '2016-06-09 00:00:00', '2016-06-05 08:47:46'),
(3, 'テスト', 'テスト', '2016-06-12 00:00:00', 'どこ', '345345342345, 345234523', NULL, NULL, NULL, 10, 2, 2, 0, 0, '2016-06-05 00:00:00', '2016-06-21 00:58:22'),
(4, 'test', 'テスト\n実験', '2016-06-23 00:00:00', 'cebu', '', NULL, NULL, NULL, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', '2016-06-16 11:28:20');

-- --------------------------------------------------------

--
-- テーブルの構造 `event_categories`
--

CREATE TABLE `event_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_picture_path` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `event_categories`
--

INSERT INTO `event_categories` (`id`, `name`, `category_picture_path`, `delete_flag`, `created`, `modified`) VALUES
(1, 'club', '', 0, '0000-00-00 00:00:00', '2016-06-11 06:26:12'),
(2, 'study', '', 0, '0000-00-00 00:00:00', '2016-06-11 06:26:12');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`user_id`, `event_id`) VALUES
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `nationality`
--

CREATE TABLE `nationality` (
  `nationality_id` int(11) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(4, 1, 1, 4, 1, 0, '2016-06-21 01:01:35', '2016-06-20 16:01:35'),
(5, 1, 1, 4, 1, 0, '2016-06-21 01:01:42', '2016-06-20 16:01:42'),
(6, 1, 1, 4, 1, 0, '2016-06-21 01:04:25', '2016-06-20 16:04:25'),
(7, 1, 1, 4, 1, 0, '2016-06-21 01:04:41', '2016-06-20 16:04:41'),
(8, 1, 1, 4, 1, 0, '2016-06-21 01:05:29', '2016-06-20 16:05:29'),
(9, 2, 1, 3, 1, 0, '2016-06-21 09:59:03', '2016-06-21 00:59:03'),
(10, 2, 1, 3, 1, 0, '2016-06-21 09:59:07', '2016-06-21 00:59:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `notification_topics`
--

CREATE TABLE `notification_topics` (
  `id` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `notification_topics`
--

INSERT INTO `notification_topics` (`id`, `topic`) VALUES
(1, 'posts comment in'),
(2, 'is going to'),
(3, 'editted'),
(4, 'was canceled');

-- --------------------------------------------------------

--
-- テーブルの構造 `participants`
--

CREATE TABLE `participants` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `participants`
--

INSERT INTO `participants` (`user_id`, `event_id`) VALUES
(1, 4),
(2, 4),
(2, 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `pre_users`
--

CREATE TABLE `pre_users` (
  `id` int(11) NOT NULL,
  `urltoken` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `confirmed_flag` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `schools`
--

INSERT INTO `schools` (`id`, `name`, `delete_flag`, `created`, `modified`) VALUES
(1, 'NexSeed', 0, '0000-00-00 00:00:00', '2016-06-11 07:02:46');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nick_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `profile_picture_path` varchar(255) DEFAULT NULL,
  `introduction` varchar(255) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `nick_name`, `email`, `password`, `school_id`, `gender`, `profile_picture_path`, `introduction`, `birthday`, `nationality_id`, `delete_flag`, `created`, `modified`) VALUES
(1, 'yuta', 'ri004078@gmail.com', 'bb2c53df86fdc78ea3c71ee03b438e9191752b85', 1, 'male', '01.jpg', 'hello!!', '1988/4/20', 0, 0, '0000-00-00 00:00:00', '2016-06-16 03:14:22'),
(2, 'yuta2', 'ri004078@email.com', 'bb2c53df86fdc78ea3c71ee03b438e9191752b85', 1, 'male', '02.jpg', 'hello', '2016/04/20', 0, 0, '0000-00-00 00:00:00', '2016-06-16 03:14:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`nationality_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_topics`
--
ALTER TABLE `notification_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_users`
--
ALTER TABLE `pre_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `nationality_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `notification_topics`
--
ALTER TABLE `notification_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pre_users`
--
ALTER TABLE `pre_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
