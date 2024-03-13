-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 13, 2024 at 11:02 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `FDCJadeMarthy-NC-Web`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `first_user_id_in_thread` int(11) NOT NULL,
  `second_user_id_in_thread` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `first_user_id_in_thread`, `second_user_id_in_thread`, `created_at`, `modified_at`) VALUES
(1, 2, 1, '2024-03-12 14:50:07', '2024-03-13 07:43:41'),
(2, 3, 2, '2024-03-12 14:54:06', '2024-03-13 05:34:33'),
(5, 1, 3, '2024-03-12 15:12:19', '2024-03-12 15:12:19'),
(9, 3, 5, '2024-03-12 17:42:51', '2024-03-12 17:43:43'),
(13, 2, 4, '2024-03-13 03:33:30', '2024-03-13 03:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `message_details`
--

CREATE TABLE `message_details` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_details`
--

INSERT INTO `message_details` (`id`, `message_id`, `message`, `sender_id`, `recipient_id`, `created_at`, `modified_at`) VALUES
(1, 1, 'first message', 1, 2, '2024-03-12 14:50:07', '2024-03-12 17:45:44'),
(2, 1, 'Second Message', 2, 1, '2024-03-12 14:50:17', '2024-03-12 17:45:44'),
(4, 2, '1st message sa 2nd contact', 3, 2, '2024-03-12 14:54:06', '2024-03-12 17:46:07'),
(5, 2, 'second message 2nd contact', 3, 2, '2024-03-12 14:55:55', '2024-03-12 17:46:07'),
(6, 2, '3rd', 2, 3, '2024-03-12 14:57:07', '2024-03-12 17:46:07'),
(7, 5, 'asdfasdf', 1, 3, '2024-03-12 15:29:12', '2024-03-12 17:46:29'),
(8, 1, 'last', 1, 2, '2024-03-12 15:30:28', '2024-03-12 17:45:44'),
(10, 5, 'asdfgadsf', 3, 1, '2024-03-12 15:32:17', '2024-03-12 17:46:29'),
(11, 1, 'asdasdasdasgasdvzxcv', 2, 1, '2024-03-12 15:34:47', '2024-03-12 17:45:44'),
(13, 2, 'id 3 to id 2', 3, 2, '2024-03-12 15:39:52', '2024-03-12 17:46:07'),
(14, 2, 'id 2 to id 3', 2, 3, '2024-03-12 15:40:22', '2024-03-12 17:46:07'),
(15, 9, 'Hi Five!', 3, 5, '2024-03-12 17:42:51', '2024-03-12 17:46:41'),
(16, 9, 'Hi again five!', 3, 5, '2024-03-12 17:43:18', '2024-03-12 17:46:41'),
(17, 9, 'hi there three!', 5, 3, '2024-03-12 17:43:43', '2024-03-12 17:46:41'),
(18, 2, 'this is a new message', 2, 3, '2024-03-13 03:08:37', '2024-03-13 03:08:37'),
(19, 2, 'asdfads', 2, 3, '2024-03-13 03:08:41', '2024-03-13 03:08:41'),
(20, 2, 'gadfasdf', 2, 3, '2024-03-13 03:08:44', '2024-03-13 03:08:44'),
(21, 2, 'adsfadsfasdf', 2, 3, '2024-03-13 03:08:47', '2024-03-13 03:08:47'),
(22, 2, 'hi three!', 2, 3, '2024-03-13 03:12:26', '2024-03-13 03:12:26'),
(23, 2, 'Hi two!', 3, 2, '2024-03-13 03:15:33', '2024-03-13 03:15:33'),
(24, 13, 'hi four!', 2, 4, '2024-03-13 03:33:30', '2024-03-13 03:33:30'),
(25, 2, 'dsfsdf', 2, 3, '2024-03-13 05:04:59', '2024-03-13 05:04:59'),
(26, 2, 'asdfadf', 2, 3, '2024-03-13 05:06:22', '2024-03-13 05:06:22'),
(27, 2, 'gasdfasdf', 2, 3, '2024-03-13 05:06:25', '2024-03-13 05:06:25'),
(28, 2, 'adf', 3, 2, '2024-03-13 05:06:55', '2024-03-13 05:06:55'),
(29, 2, 'adf', 2, 3, '2024-03-13 05:07:02', '2024-03-13 05:07:02'),
(30, 2, 'gasdfads', 3, 2, '2024-03-13 05:07:14', '2024-03-13 05:07:14'),
(31, 2, '', 3, 2, '2024-03-13 05:07:16', '2024-03-13 05:07:16'),
(32, 2, '', 3, 2, '2024-03-13 05:07:17', '2024-03-13 05:07:17'),
(69, 2, 'gasdf', 2, 3, '2024-03-13 07:47:35', '2024-03-13 07:47:35'),
(70, 2, ' asdf', 2, 3, '2024-03-13 07:52:55', '2024-03-13 07:52:55'),
(84, 2, '&lt;b&gt;b&lt;/b&gt;', 2, 3, '2024-03-13 08:05:44', '2024-03-13 08:05:44'),
(85, 2, '&lt;b&gt;b&lt;/b&gt;', 2, 3, '2024-03-13 08:05:47', '2024-03-13 08:05:47'),
(86, 2, 'rset', 2, 3, '2024-03-13 08:07:52', '2024-03-13 08:07:52'),
(87, 2, 'reset', 2, 3, '2024-03-13 08:08:15', '2024-03-13 08:08:15'),
(88, 2, 'valid', 2, 3, '2024-03-13 08:27:53', '2024-03-13 08:27:53'),
(89, 2, 'tset 1', 2, 3, '2024-03-13 08:38:27', '2024-03-13 08:38:27'),
(91, 1, 'gasdfasd', 2, 1, '2024-03-13 09:20:08', '2024-03-13 09:20:08'),
(92, 1, 'asdfsdf', 2, 1, '2024-03-13 09:20:09', '2024-03-13 09:20:09'),
(95, 1, 'gasdf', 2, 1, '2024-03-13 09:20:52', '2024-03-13 09:20:52'),
(96, 1, 'gasdf', 2, 1, '2024-03-13 09:20:53', '2024-03-13 09:20:53'),
(97, 1, 'gasdfadf', 2, 1, '2024-03-13 09:21:02', '2024-03-13 09:21:02'),
(98, 1, 'gasdfadsf', 2, 1, '2024-03-13 09:21:08', '2024-03-13 09:21:08'),
(99, 1, 'fadfadf', 2, 1, '2024-03-13 09:21:29', '2024-03-13 09:21:29'),
(100, 1, 'asdf', 2, 1, '2024-03-13 09:22:49', '2024-03-13 09:22:49'),
(101, 1, 'gasdf', 2, 1, '2024-03-13 09:23:12', '2024-03-13 09:23:12'),
(102, 1, 'sdfasdf', 2, 1, '2024-03-13 09:29:54', '2024-03-13 09:29:54'),
(103, 1, 'sadf', 2, 1, '2024-03-13 09:34:19', '2024-03-13 09:34:19'),
(104, 1, 'sdfasdf', 2, 1, '2024-03-13 09:38:59', '2024-03-13 09:38:59');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `profile_picture` text DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `hubby` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `name`, `profile_picture`, `gender`, `birthdate`, `hubby`, `created_at`, `modified_at`) VALUES
(1, 1, 'Jade Test First', 'profile/profile-1-jade-test-first.png', 'Male', '2000-03-12', 'asdf ', '2024-03-12 08:07:41', '2024-03-12 08:07:41'),
(2, 2, 'jade test update', 'profile/profile-2-jade-test-update.png', 'Male', '2000-03-12', 'My Hubby', '2024-03-12 08:07:41', '2024-03-13 01:07:49'),
(3, 3, 'Jade Test Three', 'profile/profile-pic.png', NULL, NULL, NULL, '2024-03-12 09:02:42', '2024-03-12 09:02:42'),
(4, 4, 'Jade Test Four', 'profile/profile-pic.png', NULL, NULL, NULL, '2024-03-12 17:32:56', '2024-03-12 17:32:56'),
(5, 5, 'Jade Test Five', 'profile/profile-5-jade-test-five.jpg', 'Male', '2024-03-13', 'Just a hobby.', '2024-03-12 17:38:04', '2024-03-12 17:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `last_login_time`, `created_at`, `modified_at`) VALUES
(1, 'jadetest@test.com', '$2a$10$S4qqxo2GuNpHDqqIXvS.Ge5D2EawIDflHCQuxYB1JS22KmApF0F/G', NULL, '2024-03-12 05:06:44', '2024-03-12 05:06:44'),
(2, 'jadetest2@test.com', '$2a$10$IgqIs0z58HhexCEVjXlVnOci/OFq4eSiLRg/tGnFZn2XGCKT/VOBC', '2024-03-13 17:14:10', '2024-03-12 05:56:27', '2024-03-13 09:14:10'),
(3, 'jadetest3@test.com', '$2a$10$Vfti7otH4pFxlUV1dnRxyO/sRNdaHPsk614Gqv9l9PPNa8OxjoCqq', '2024-03-13 13:06:44', '2024-03-12 09:02:42', '2024-03-13 05:06:44'),
(4, 'jadetest4@test.com', '$2a$10$UhxK25G6nu9ladnXvd/a1O4eyMkXSEpamGWaX87sqBba/p8rJLdkq', '2024-03-13 11:33:45', '2024-03-12 17:32:56', '2024-03-13 03:33:45'),
(5, 'jadetest5@test.com', '$2a$10$S5tcSREzH6DlVQ36Ne3IAuaJp2vIW1lNMyg0rx8hz/ln6HStipS92', NULL, '2024-03-12 17:38:04', '2024-03-12 17:38:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_details`
--
ALTER TABLE `message_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `message_details`
--
ALTER TABLE `message_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
