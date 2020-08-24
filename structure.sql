SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `chess` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `chess`;

CREATE TABLE `games` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `alpha_num_id` varchar(16) UNIQUE NOT NULL,
  `player_a_key` varchar(16) NOT NULL,
  `player_b_key` varchar(16) NOT NULL,
  `player_a_name` varchar(50) NOT NULL,
  `player_b_name` varchar(50) NOT NULL,
  `current_game_position_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `game_positions` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `pgn` text NOT NULL,
  `half_move_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
