-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 02, 2016 at 03:29 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.6.20-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forms`
--

-- --------------------------------------------------------

--
-- Table structure for table `pref_users`
--

CREATE TABLE `pref_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `city` varchar(60) NOT NULL,
  `mob_number` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL COMMENT '1 - male; 0 - female',
  `education` text NOT NULL,
  `work_exp` text NOT NULL,
  `add_info` text NOT NULL,
  `birth_date` varchar(15) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pref_user_session`
--

CREATE TABLE `pref_user_session` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code_sess` varchar(255) NOT NULL,
  `user_agent_sess` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pref_users`
--
ALTER TABLE `pref_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pref_user_session`
--
ALTER TABLE `pref_user_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pref_users`
--
ALTER TABLE `pref_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pref_user_session`
--
ALTER TABLE `pref_user_session`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `pref_user_session`
--
ALTER TABLE `pref_user_session`
  ADD CONSTRAINT `pref_user_session_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `pref_users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
