-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 08:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osmania_esports`
--

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

CREATE TABLE `organizers` (
  `organizerid` int(11) NOT NULL,
  `organizername` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`organizerid`, `organizername`, `email`, `password`) VALUES
(1, 'einstein', 'einsteinellandala@gmail.com', '89');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'srinivas', 'srinivas@gmail.com', 'sri123'),
(3, 'player1', 'player1@gmail.com', 'play12');

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `organizername` varchar(30) NOT NULL,
  `tournament_name` varchar(255) NOT NULL,
  `game_name` varchar(100) NOT NULL,
  `game_mode` varchar(50) NOT NULL,
  `max_slots` int(11) NOT NULL,
  `entry_fee` decimal(10,2) NOT NULL,
  `prize_pool` decimal(10,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `status` enum('upcoming','ongoing','completed') NOT NULL DEFAULT 'upcoming',
  `room_id` varchar(30) NOT NULL,
  `room_password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`id`, `organizername`, `tournament_name`, `game_name`, `game_mode`, `max_slots`, `entry_fee`, `prize_pool`, `start_date`, `start_time`, `status`, `room_id`, `room_password`) VALUES
(6, 'einstein', 'Winter Cup', 'COD MOBILE', 'SOLO', 20, 50.00, 800.00, '2024-12-02', '20:30:00', 'completed', '505632', '123'),
(7, 'einstein', 'New year cup', 'FREE FIRE', 'SQUAD', 24, 100.00, 2000.00, '2024-12-02', '20:25:00', 'completed', '998932', '123'),
(8, 'einstein', 'Intercity cup', 'BGMI', 'SQUAD', 24, 99.00, 9999.00, '2024-12-02', '22:28:00', 'completed', '556677', '11233'),
(9, 'einstein', 'Summer cup', 'VALORANT', 'SQUAD', 50, 100.00, 5000.00, '2025-04-24', '18:00:00', 'upcoming', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tournament_registrations`
--

CREATE TABLE `tournament_registrations` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `player_username` varchar(255) NOT NULL,
  `team_name` varchar(30) NOT NULL,
  `igl_name` varchar(30) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tournament_registrations`
--

INSERT INTO `tournament_registrations` (`id`, `tournament_id`, `player_username`, `team_name`, `igl_name`, `registration_date`) VALUES
(14, 1, 'srinivas', 'Team soul', 'killer ff', '2024-11-27 19:29:29'),
(15, 2, 'srinivas', 'team', 'user', '2024-11-27 19:31:35'),
(17, 2, 'player1', 'team flexo', 'a', '2024-11-28 10:44:54'),
(20, 1, 'player1', 'team flexo', 'da', '2024-11-28 11:59:19'),
(21, 6, 'srinivas', 'team elite', 'pahadi', '2024-11-30 13:52:34'),
(22, 7, 'srinivas', 'team elite', 'Pahadi', '2024-12-02 14:13:30'),
(23, 8, 'srinivas', 'teal lol', 'a11', '2024-12-02 16:37:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`organizerid`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tournament_registrations`
--
ALTER TABLE `tournament_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tournament_id` (`tournament_id`),
  ADD KEY `player_username` (`player_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `organizerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tournament_registrations`
--
ALTER TABLE `tournament_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tournament_registrations`
--
ALTER TABLE `tournament_registrations`
  ADD CONSTRAINT `tournament_registrations_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`),
  ADD CONSTRAINT `tournament_registrations_ibfk_2` FOREIGN KEY (`player_username`) REFERENCES `players` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
