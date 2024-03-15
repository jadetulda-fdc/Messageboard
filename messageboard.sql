-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 15, 2024 at 05:52 AM
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
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `first_user_id_in_thread`, `second_user_id_in_thread`, `created_at`, `modified_at`, `deleted_at`) VALUES
(1, 2, 1, '2024-03-12 14:50:07', '2024-03-13 07:43:41', NULL),
(2, 3, 2, '2024-03-12 14:54:06', '2024-03-15 04:41:02', NULL),
(5, 1, 3, '2024-03-12 15:12:19', '2024-03-12 15:12:19', NULL),
(9, 3, 5, '2024-03-12 17:42:51', '2024-03-14 09:44:17', '2024-03-14 09:44:13'),
(13, 2, 4, '2024-03-13 03:33:30', '2024-03-15 04:44:07', '2024-03-15 04:44:07'),
(14, 2, 5, '2024-03-14 08:28:59', '2024-03-14 09:46:41', NULL);

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
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_details`
--

INSERT INTO `message_details` (`id`, `message_id`, `message`, `sender_id`, `recipient_id`, `created_at`, `modified_at`, `deleted_at`) VALUES
(1, 1, 'first message', 1, 2, '2024-03-12 14:50:07', '2024-03-12 17:45:44', NULL),
(2, 1, 'Second Message', 2, 1, '2024-03-12 14:50:17', '2024-03-12 17:45:44', NULL),
(4, 2, '1st message sa 2nd contact', 3, 2, '2024-03-12 14:54:06', '2024-03-12 17:46:07', NULL),
(5, 2, 'second message 2nd contact', 3, 2, '2024-03-12 14:55:55', '2024-03-12 17:46:07', NULL),
(6, 2, '3rd', 2, 3, '2024-03-12 14:57:07', '2024-03-12 17:46:07', NULL),
(7, 5, 'asdfasdf', 1, 3, '2024-03-12 15:29:12', '2024-03-12 17:46:29', NULL),
(8, 1, 'last', 1, 2, '2024-03-12 15:30:28', '2024-03-12 17:45:44', NULL),
(10, 5, 'asdfgadsf', 3, 1, '2024-03-12 15:32:17', '2024-03-12 17:46:29', NULL),
(11, 1, 'asdasdasdasgasdvzxcv', 2, 1, '2024-03-12 15:34:47', '2024-03-12 17:45:44', NULL),
(13, 2, 'id 3 to id 2', 3, 2, '2024-03-12 15:39:52', '2024-03-12 17:46:07', NULL),
(14, 2, 'id 2 to id 3', 2, 3, '2024-03-12 15:40:22', '2024-03-12 17:46:07', NULL),
(15, 9, 'Hi Five!', 3, 5, '2024-03-12 17:42:51', '2024-03-12 17:46:41', NULL),
(16, 9, 'Hi again five!', 3, 5, '2024-03-12 17:43:18', '2024-03-12 17:46:41', NULL),
(17, 9, 'hi there three!', 5, 3, '2024-03-12 17:43:43', '2024-03-12 17:46:41', NULL),
(18, 2, 'this is a new message', 2, 3, '2024-03-13 03:08:37', '2024-03-13 03:08:37', NULL),
(19, 2, 'asdfads', 2, 3, '2024-03-13 03:08:41', '2024-03-13 03:08:41', NULL),
(20, 2, 'gadfasdf', 2, 3, '2024-03-13 03:08:44', '2024-03-13 03:08:44', NULL),
(21, 2, 'adsfadsfasdf', 2, 3, '2024-03-13 03:08:47', '2024-03-13 03:08:47', NULL),
(22, 2, 'hi three!', 2, 3, '2024-03-13 03:12:26', '2024-03-13 03:12:26', NULL),
(23, 2, 'Hi two!', 3, 2, '2024-03-13 03:15:33', '2024-03-13 03:15:33', NULL),
(24, 13, 'hi four!', 2, 4, '2024-03-13 03:33:30', '2024-03-15 04:44:07', '2024-03-15 04:44:07'),
(25, 2, 'dsfsdf', 2, 3, '2024-03-13 05:04:59', '2024-03-13 05:04:59', NULL),
(26, 2, 'asdfadf', 2, 3, '2024-03-13 05:06:22', '2024-03-13 05:06:22', NULL),
(27, 2, 'gasdfasdf', 2, 3, '2024-03-13 05:06:25', '2024-03-13 05:06:25', NULL),
(28, 2, 'adf', 3, 2, '2024-03-13 05:06:55', '2024-03-13 05:06:55', NULL),
(29, 2, 'adf', 2, 3, '2024-03-13 05:07:02', '2024-03-13 05:07:02', NULL),
(30, 2, 'gasdfads', 3, 2, '2024-03-13 05:07:14', '2024-03-13 05:07:14', NULL),
(31, 2, '', 3, 2, '2024-03-13 05:07:16', '2024-03-13 05:07:16', NULL),
(32, 2, '', 3, 2, '2024-03-13 05:07:17', '2024-03-13 05:07:17', NULL),
(84, 2, '&lt;b&gt;b&lt;/b&gt;', 2, 3, '2024-03-13 08:05:44', '2024-03-13 08:05:44', NULL),
(85, 2, '&lt;b&gt;b&lt;/b&gt;', 2, 3, '2024-03-13 08:05:47', '2024-03-13 08:05:47', NULL),
(86, 2, 'rset', 2, 3, '2024-03-13 08:07:52', '2024-03-13 08:07:52', NULL),
(87, 2, 'reset', 2, 3, '2024-03-13 08:08:15', '2024-03-13 08:08:15', NULL),
(88, 2, 'valid', 2, 3, '2024-03-13 08:27:53', '2024-03-13 08:27:53', NULL),
(89, 2, 'tset 1', 2, 3, '2024-03-13 08:38:27', '2024-03-13 08:38:27', NULL),
(91, 1, 'gasdfasd', 2, 1, '2024-03-13 09:20:08', '2024-03-13 09:20:08', NULL),
(92, 1, 'asdfsdf', 2, 1, '2024-03-13 09:20:09', '2024-03-13 09:20:09', NULL),
(95, 1, 'gasdf', 2, 1, '2024-03-13 09:20:52', '2024-03-13 09:20:52', NULL),
(96, 1, 'gasdf', 2, 1, '2024-03-13 09:20:53', '2024-03-13 09:20:53', NULL),
(97, 1, 'gasdfadf', 2, 1, '2024-03-13 09:21:02', '2024-03-13 09:21:02', NULL),
(98, 1, 'gasdfadsf', 2, 1, '2024-03-13 09:21:08', '2024-03-13 09:21:08', NULL),
(99, 1, 'fadfadf', 2, 1, '2024-03-13 09:21:29', '2024-03-13 09:21:29', NULL),
(100, 1, 'asdf', 2, 1, '2024-03-13 09:22:49', '2024-03-13 09:22:49', NULL),
(102, 1, 'sdfasdf', 2, 1, '2024-03-13 09:29:54', '2024-03-13 09:29:54', NULL),
(103, 1, 'sadf', 2, 1, '2024-03-13 09:34:19', '2024-03-13 09:34:19', NULL),
(110, 1, 'asdfasdf', 2, 1, '2024-03-14 02:04:16', '2024-03-14 02:04:16', NULL),
(113, 2, 'testalskjfno asjdfljnasodi jfnoasjnd ofjnaldsjnfo;asjdo; fjnaos;djn fo;iasjndof adsojfoiasjdiofnuaosdfjoasjdfjaoisdjfioasdj;ofja;sdlfjl;asjdf;kajkl;dsjf;adsf klanhsdofhasdfoiasdofuoaidsufoasuodfuao pfidsfoj auso;idfuiaosdfoajdsofj asdflajdsl;fjal;sdjf;lasid nfasiduhfiasduhfsndfai usdhfil', 2, 3, '2024-03-14 03:57:50', '2024-03-14 07:35:01', NULL),
(121, 2, 'testalskjfno asjdfljnasodi jfnoasjnd ofjnaldsjnfo;asjdo; fjnaos;djn fo;iasjndof adsojfoiasjdiofnuaosdfjoasjdfjaoisdjfioasdj;ofja;sdlfjl;asjdf;kajkl;dsjf;adsf klanhsdofhasdfoiasdofuoaidsufoasuodfuao pfidsfoj auso;idfuiaosdfoajdsofj asdflajdsl;fjal;sdjf;lasid nfasiduhfiasduhfsndfai usdhfil ', 2, 3, '2024-03-14 07:36:19', '2024-03-14 07:36:19', NULL),
(122, 2, 'testalskjfno asjdfljnasodi jfnoasjnd ofjnaldsjnfo;asjdo; fjnaos;djn fo;iasjndof adsojfoiasjdiofnuaosdfjoasjdfjaoisdjfioasdj;ofja;sdlfjl;asjdf;kajkl;dsjf;adsf klanhsdofhasdfoiasdofuoaidsufoasuodfuao pfidsfoj auso;idfuiaosdfoajdsofj asdflajdsl;fjal;sdjf;lasid nfasiduhfiasduhfsndfai usdhfil \r\n', 2, 3, '2024-03-14 07:37:44', '2024-03-14 07:37:44', NULL),
(123, 2, 'fasdf', 2, 3, '2024-03-14 07:38:05', '2024-03-14 08:57:37', '2024-03-14 08:57:37'),
(132, 13, 'asdfasdf', 2, 4, '2024-03-14 08:25:16', '2024-03-15 04:44:07', '2024-03-15 04:44:07'),
(133, 13, 'gadfasd', 2, 4, '2024-03-14 08:27:19', '2024-03-15 04:44:07', '2024-03-15 04:44:07'),
(138, 14, 'asdf', 2, 5, '2024-03-14 09:00:02', '2024-03-14 09:07:33', '2024-03-14 09:07:33'),
(139, 14, 'test', 2, 5, '2024-03-14 09:00:13', '2024-03-14 09:07:29', '2024-03-14 09:07:29'),
(140, 14, 'test', 2, 5, '2024-03-14 09:00:21', '2024-03-14 09:07:29', '2024-03-14 09:07:29'),
(141, 14, 'asdfadf', 2, 5, '2024-03-14 09:00:28', '2024-03-14 09:07:27', '2024-03-14 09:07:27'),
(142, 14, 'test', 2, 5, '2024-03-14 09:01:03', '2024-03-14 09:07:27', '2024-03-14 09:07:27'),
(143, 2, 'test', 2, 3, '2024-03-14 09:01:54', '2024-03-15 04:37:02', '2024-03-15 04:37:02'),
(144, 2, 'test', 2, 3, '2024-03-14 09:02:17', '2024-03-15 04:37:01', '2024-03-15 04:37:01'),
(145, 2, 'tstsss', 2, 3, '2024-03-14 09:05:27', '2024-03-15 04:37:00', '2024-03-15 04:37:00'),
(146, 14, 'dfasdf', 2, 5, '2024-03-14 09:05:33', '2024-03-14 09:07:25', '2024-03-14 09:07:25'),
(147, 2, 'new again', 2, 3, '2024-03-14 09:06:55', '2024-03-15 04:36:58', '2024-03-15 04:36:58'),
(148, 14, 'five', 2, 5, '2024-03-14 09:07:09', '2024-03-14 09:07:24', '2024-03-14 09:07:24'),
(149, 14, 'hi two!', 5, 2, '2024-03-14 09:29:49', '2024-03-14 09:29:49', NULL),
(150, 14, 'hi fice', 2, 5, '2024-03-14 09:46:41', '2024-03-14 09:46:41', NULL),
(151, 2, 'got it', 2, 3, '2024-03-15 04:40:40', '2024-03-15 04:41:02', '2024-03-15 04:41:02');

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
(5, 5, 'Jade Test Five', 'profile/profile-5-jade-test-five.png', 'Female', '2024-03-13', 'Just a hobby.', '2024-03-12 17:38:04', '2024-03-14 09:54:55');

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
(2, 'jadetest2@test.com', '$2a$10$IgqIs0z58HhexCEVjXlVnOci/OFq4eSiLRg/tGnFZn2XGCKT/VOBC', '2024-03-15 12:46:03', '2024-03-12 05:56:27', '2024-03-15 04:46:03'),
(3, 'jadetest3@test.com', '$2a$10$Vfti7otH4pFxlUV1dnRxyO/sRNdaHPsk614Gqv9l9PPNa8OxjoCqq', '2024-03-15 09:43:31', '2024-03-12 09:02:42', '2024-03-15 01:43:31'),
(4, 'jadetest4@test.com', '$2a$10$UhxK25G6nu9ladnXvd/a1O4eyMkXSEpamGWaX87sqBba/p8rJLdkq', '2024-03-13 11:33:45', '2024-03-12 17:32:56', '2024-03-13 03:33:45'),
(5, 'jadetest5@test.com', '$2a$10$FnvCOC.4Hp8nyGoFzmWK7.L21ZC8/7NS8fnS9czmKyGkI//00om1C', '2024-03-14 17:20:38', '2024-03-12 17:38:04', '2024-03-14 09:20:38');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `message_details`
--
ALTER TABLE `message_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

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
