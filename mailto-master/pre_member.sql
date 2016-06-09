-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:8080
-- Generation Time: 2016 年 6 朁E08 日 12:11
-- サーバのバージョン： 10.1.10-MariaDB
-- PHP Version: 5.5.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pre_member`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `pre_member`
--

CREATE TABLE `pre_member` (
  `id` int(11) NOT NULL,
  `urltoken` varchar(128) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `pre_member`
--

INSERT INTO `pre_member` (`id`, `urltoken`, `mail`, `date`, `flag`) VALUES
(1, 'c1a825f6746615ae62757c1a3bc54392c7c13e0288b0acabe8f067efb8811120', 'ri004078@gmail.com', '2016-06-08 19:08:50', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pre_member`
--
ALTER TABLE `pre_member`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pre_member`
--
ALTER TABLE `pre_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
