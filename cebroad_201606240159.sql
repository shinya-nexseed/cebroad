-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016 年 6 月 24 日 01:58
-- サーバのバージョン： 5.6.29
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `event_id`, `comment`, `delete_flag`, `created`, `modified`) VALUES
(1, 1, 2, '保存実験', 0, '2016-06-16 23:30:34', '2016-06-16 14:30:34'),
(2, 2, 2, '保存実験', 0, '2016-06-16 23:30:45', '2016-06-22 02:31:12'),
(3, 1, 2, '保存実験', 0, '2016-06-16 23:31:40', '2016-06-16 14:31:40'),
(4, 2, 2, '保存', 0, '2016-06-16 23:32:21', '2016-06-22 02:31:08'),
(5, 1, 2, '保存', 0, '2016-06-16 23:57:07', '2016-06-16 14:57:07'),
(6, 1, 2, '保存', 0, '2016-06-17 11:06:35', '2016-06-17 02:06:35'),
(7, 2, 4, '保存', 0, '2016-06-20 19:52:40', '2016-06-20 10:52:40'),
(8, 2, 4, '保存', 0, '2016-06-20 19:52:46', '2016-06-20 10:52:46'),
(9, 2, 4, '保存', 0, '2016-06-20 19:53:26', '2016-06-20 10:53:26'),
(10, 2, 4, '保存', 0, '2016-06-20 20:21:21', '2016-06-20 11:21:21'),
(11, 2, 4, '保存', 0, '2016-06-20 20:22:14', '2016-06-20 11:22:14'),
(12, 1, 4, '保存', 0, '2016-06-21 01:01:35', '2016-06-20 16:01:35'),
(13, 2, 4, '保存', 0, '2016-06-21 01:01:41', '2016-06-22 02:31:17'),
(14, 1, 4, '保存', 0, '2016-06-21 01:04:25', '2016-06-20 16:04:25'),
(15, 3, 4, '保存', 0, '2016-06-21 01:04:41', '2016-06-22 02:31:19'),
(16, 1, 4, '保存', 0, '2016-06-21 01:05:29', '2016-06-20 16:05:29'),
(17, 3, 3, 'To yuta2', 0, '2016-06-21 09:59:03', '2016-06-22 02:36:15'),
(18, 1, 3, 'hogehoge', 0, '2016-06-21 09:59:07', '2016-06-22 02:36:17'),
(19, 1, 3, 'ほげほげ', 0, '2016-06-22 11:46:38', '2016-06-22 02:46:38'),
(20, 1, 3, 'ふがふが', 0, '2016-06-22 11:52:37', '2016-06-22 02:52:37');

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `detail` varchar(511) NOT NULL,
  `date` date NOT NULL,
  `starting_time` varchar(255) NOT NULL,
  `closing_time` varchar(255) NOT NULL,
  `place_name` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `picture_path_0` varchar(255) NOT NULL,
  `picture_path_1` varchar(255) DEFAULT NULL,
  `picture_path_2` varchar(255) DEFAULT NULL,
  `picture_path_3` varchar(255) DEFAULT NULL,
  `capacity_num` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_category_id` int(11) NOT NULL,
  `open_flag` tinyint(1) NOT NULL DEFAULT '0',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `title`, `detail`, `date`, `starting_time`, `closing_time`, `place_name`, `latitude`, `longitude`, `picture_path_0`, `picture_path_1`, `picture_path_2`, `picture_path_3`, `capacity_num`, `organizer_id`, `event_category_id`, `open_flag`, `delete_flag`, `created`, `modified`) VALUES
(98, 'Hello world!', 'yehaaaaaaa', '2016-08-22', '10:00', '', 'Liv Super Club', '10.3265784', '123.93233329999998', '/portfolio/cebroad/views/events/events_pictures/e8ed2e11966937f0f2b615b50f4f1592904ee782.jpg', '', '', '', 20, 6, 1, 0, 0, '2016-06-24 02:48:35', '2016-06-23 17:48:35');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
-- テーブルの構造 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `sender_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `message`
--

INSERT INTO `message` (`id`, `message`, `sender_id`, `room_id`, `created`, `modified`) VALUES
(1, 'today is wednesday', 1, 1, '2016-06-22 00:00:00', '2016-06-22 11:06:29'),
(2, 'test sender1 room2 ', 1, 2, '2016-06-23 00:00:00', '2016-06-22 11:07:56'),
(3, 'test sender 2 room1', 2, 1, '2016-06-22 00:00:00', '2016-06-22 11:08:17'),
(4, 'test sender2 room2', 2, 2, '2016-06-24 00:00:00', '2016-06-22 11:08:46'),
(5, 'hello world!!!', 1, 1, '2016-06-23 01:50:45', '2016-06-22 16:50:45'),
(6, 'hogehoge', 1, 1, '2016-06-23 02:37:08', '2016-06-22 17:37:08'),
(7, 'hogehoge', 1, 0, '2016-06-23 02:37:16', '2016-06-22 17:37:16'),
(8, 'hogehoge', 1, 1, '2016-06-23 02:38:27', '2016-06-22 17:38:27'),
(9, 'hogehoge', 1, 0, '2016-06-23 02:41:50', '2016-06-22 17:41:50'),
(10, 'hogehoge', 1, 1, '2016-06-23 03:08:20', '2016-06-22 18:08:20'),
(11, 'hogehoge', 1, 1, '2016-06-23 03:09:41', '2016-06-22 18:09:41'),
(12, 'hogehoge', 1, 1, '2016-06-23 03:10:05', '2016-06-22 18:10:05'),
(13, 'ahahaha', 1, 1, '2016-06-23 03:11:58', '2016-06-22 18:11:58'),
(14, 'ohoho', 1, 1, '2016-06-23 03:17:48', '2016-06-22 18:17:48'),
(15, 'ehehe', 1, 1, '2016-06-23 03:18:36', '2016-06-22 18:18:36'),
(16, 'mumu?', 1, 2, '2016-06-23 03:18:42', '2016-06-22 18:18:42'),
(17, 'aaa', 1, 2, '2016-06-23 03:21:23', '2016-06-22 18:21:23'),
(18, 'yahhaaaa', 1, 2, '2016-06-23 03:35:25', '2016-06-22 18:35:25'),
(19, '.....', 1, 2, '2016-06-23 03:36:03', '2016-06-22 18:36:03'),
(20, 'ljkhjfgdxgf', 1, 2, '2016-06-23 03:39:06', '2016-06-22 18:39:06'),
(21, 'aaaaaaaaa', 1, 1, '2016-06-23 03:39:14', '2016-06-22 18:39:14'),
(22, 'mumumu', 1, 2, '2016-06-23 03:51:34', '2016-06-22 18:51:34'),
(23, 'ほげ', 1, 1, '2016-06-23 03:54:22', '2016-06-22 18:54:22'),
(24, 'ふが', 2, 1, '2016-06-23 03:54:48', '2016-06-22 18:54:48'),
(25, 'gggggg', 2, 1, '2016-06-23 03:55:06', '2016-06-22 18:55:06'),
(26, 'aaaaa', 1, 1, '2016-06-23 03:55:37', '2016-06-22 18:55:37'),
(27, 'hahahh', 1, 1, '2016-06-23 09:30:54', '2016-06-23 00:30:54'),
(28, 'hahahhhhhh', 1, 1, '2016-06-23 09:31:01', '2016-06-23 00:31:01');

-- --------------------------------------------------------

--
-- テーブルの構造 `nationalities`
--

CREATE TABLE `nationalities` (
  `nationality_id` int(11) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `nationalities`
--

INSERT INTO `nationalities` (`nationality_id`, `nationality`, `delete_flag`, `created`, `modified`) VALUES
(1, 'Japan', 0, '2016-06-21 12:37:54', '2016-06-21 03:37:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
(2, 3),
(1, 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `pre_users`
--

CREATE TABLE `pre_users` (
  `id` int(11) NOT NULL,
  `urltoken` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `confirmed_flag` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `pre_users`
--

INSERT INTO `pre_users` (`id`, `urltoken`, `email`, `confirmed_flag`, `created`) VALUES
(1, '50ad0e0723a667cbce4c719ae738784faf8c5783111ff7ac77f4eb9a48149466', 'hogehoge@gmail.com', 1, '2016-06-22 00:21:54'),
(3, '87d8499c27b59e74b865e18b0d81439d9331f5f8f10a9fdbea04c25b0a05b400', '908.shinya@gmail.com', 0, '2016-06-23 16:30:09'),
(4, 'c68603cb21804a4a99c7d395ec47bf24f5d0429d5864e93099efd23f03c0e628', 'huga@gmail.com', 1, '2016-06-24 01:05:54'),
(5, '3f838f8fa3957a2a3af975625a929481c061e072babc7bdac867d7ab87a24ade', 'hooo@gmail.com', 1, '2016-06-24 01:30:42'),
(6, 'c204710042d14573e9836b47bb409ab2f6144abb8d60253401f12fb75fb4508a', 'fooo@gmail.com', 1, '2016-06-24 02:11:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `rooms`
--

INSERT INTO `rooms` (`id`, `event_id`, `organizer_id`, `participant_id`, `updated`) VALUES
(1, 2, 1, 2, '2016-06-22 00:00:00'),
(2, 2, 2, 1, '2016-06-22 00:00:00'),
(3, 2, 3, 4, '2016-06-22 00:00:00'),
(4, 2, 3, 2, '2016-06-23 00:00:00'),
(5, 2, 5, 6, NULL),
(6, 0, 2, 3, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `nick_name`, `email`, `password`, `school_id`, `gender`, `profile_picture_path`, `introduction`, `birthday`, `nationality_id`, `delete_flag`, `created`, `modified`) VALUES
(1, 'hoge', 'ri004078@gmail.com', 'bb2c53df86fdc78ea3c71ee03b438e9191752b85', 1, 'male', '20160621222824shinya.jpg', 'hello!!', '1988/4/20', 1, 0, '0000-00-00 00:00:00', '2016-06-22 03:02:02'),
(2, 'yuta2', 'ri004078@email.com', 'bb2c53df86fdc78ea3c71ee03b438e9191752b85', 1, 'male', 'protein.jpg', 'hello', '2016/04/20', 0, 0, '0000-00-00 00:00:00', '2016-06-22 03:03:50'),
(3, 'shinyahirai', 'hogehoge@gmail.com', '3b2c6c10d0e78072d14e02cc4c587814d0f10f3a', 1, NULL, 'muaithay002.jpg', NULL, NULL, NULL, 0, '2016-06-22 00:31:47', '2016-06-22 03:02:32'),
(4, 'hugabayshi', 'huga@gmail.com', '5b3f74590ad9bf13ebc1e9c41a49caad3a11c18e', 1, '1', '20160624002526muaithay002.jpg', NULL, '1990-06-12', 0, 0, '2016-06-24 01:23:23', '2016-06-23 16:25:26'),
(5, 'hooo', 'hooo@gmail.com', '413e40d71bc0715907b65b2c212c5adb50cb41b6', 1, '0', 'profile_cropped_picture5', NULL, '', 0, 0, '2016-06-24 01:31:12', '2016-06-23 16:58:49'),
(6, 'fooo', 'fooo@gmail.com', '520d41b29f891bbaccf31d9fcfa72e82ea20fcf0', 1, '1', '20160624014435shinya_web.jpg', 'hello world', '1990-06-12', 1, 0, '2016-06-24 02:12:33', '2016-06-23 17:44:35');

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
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
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
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `nationality_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `notification_topics`
--
ALTER TABLE `notification_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pre_users`
--
ALTER TABLE `pre_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
