-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2021 at 02:22 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `andypost`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `accountId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accountId`, `username`, `email`, `password`, `date`) VALUES
(1, 'Andy', 'andy@post.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-06-24 03:14:37'),
(2, 'aabb', 'aabb@post.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-06-24 03:18:29'),
(3, 'aaa', 'aaa@post.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-06-24 03:22:10'),
(4, 'admin', 'admin@andy.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-06-25 00:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postId` int(11) NOT NULL,
  `postAuthorId` int(11) NOT NULL,
  `postTitle` varchar(100) NOT NULL,
  `postContent` text CHARACTER SET utf8mb4 NOT NULL,
  `postDate` varchar(255) DEFAULT NULL,
  `postUpdate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postId`, `postAuthorId`, `postTitle`, `postContent`, `postDate`, `postUpdate`) VALUES
(2, 3, 'Post One', 'This is Post content one', '2021-06-24 05:44:17', '2021-06-25 01:37:23'),
(4, 1, 'Post Threee', 'This is Content three', '2021-06-24 08:23:15', '2021-06-24 08:29:01'),
(5, 2, 'Post Four', 'This is Post Content Four. Try Posting and Editing your Andy Post.', '2021-06-25 00:42:10', '2021-06-25 00:51:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accountId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
