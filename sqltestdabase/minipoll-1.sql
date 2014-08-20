-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 20, 2014 at 10:52 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `minipoll`
--

-- --------------------------------------------------------

--
-- Table structure for table `mipo_answers`
--

CREATE TABLE IF NOT EXISTS `mipo_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ques_id` int(11) NOT NULL,
  `minipoll_id` int(11) NOT NULL,
  `ans_name` varchar(250) NOT NULL DEFAULT '',
  `ans_text` varchar(250) NOT NULL DEFAULT '',
  `tags` varchar(250) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mipo_answers`
--

INSERT INTO `mipo_answers` (`id`, `ques_id`, `minipoll_id`, `ans_name`, `ans_text`, `tags`, `order`) VALUES
(1, 1, 1, 'vraag1', 'antwoord1', 'eerste', 1),
(2, 1, 1, 'vraag2', 'antwoord2', 'tweede', 2),
(3, 1, 1, 'vraag3', 'antwoord3', 'derde', 3),
(4, 1, 1, 'vraag4', 'antwoord4', 'vierde', 4);

-- --------------------------------------------------------

--
-- Table structure for table `mipo_minipolls`
--

CREATE TABLE IF NOT EXISTS `mipo_minipolls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minipoll_name` varchar(250) NOT NULL COMMENT 'identifying name',
  `minipoll_headtext` varchar(250) NOT NULL DEFAULT '' COMMENT 'some text',
  `minipoll_tags` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated',
  `minipoll_starttime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `minipoll_endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mipo_minipolls`
--

INSERT INTO `mipo_minipolls` (`id`, `minipoll_name`, `minipoll_headtext`, `minipoll_tags`, `minipoll_starttime`, `minipoll_endtime`) VALUES
(1, 'testeen', 'Een eerste poll', 'eerste, poll', '2014-08-15 22:00:00', '2014-08-27 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mipo_questions`
--

CREATE TABLE IF NOT EXISTS `mipo_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minipoll_id` int(11) NOT NULL,
  `ques_name` varchar(250) NOT NULL COMMENT 'the question',
  `ques_comment` varchar(250) NOT NULL COMMENT 'extra info',
  `tags` varchar(250) NOT NULL COMMENT 'comma separated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mipo_questions`
--

INSERT INTO `mipo_questions` (`id`, `minipoll_id`, `ques_name`, `ques_comment`, `tags`) VALUES
(1, 1, 'vraag 1', 'de eerste vraag: wat is 1?', 'eerste, vraag, poll');

-- --------------------------------------------------------

--
-- Table structure for table `mipo_votes`
--

CREATE TABLE IF NOT EXISTS `mipo_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minpoll_id` int(11) NOT NULL,
  `minpoll_ques_id` int(11) NOT NULL,
  `minpoll_answ_id` int(11) NOT NULL,
  `answ_value` varchar(250) NOT NULL,
  `minipoll_text` varchar(250) NOT NULL COMMENT 'just for ease of table reading',
  `user_id` int(11) DEFAULT NULL,
  `timstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `mipo_votes`
--

INSERT INTO `mipo_votes` (`id`, `minpoll_id`, `minpoll_ques_id`, `minpoll_answ_id`, `answ_value`, `minipoll_text`, `user_id`, `timstamp`) VALUES
(1, 1, 1, 1, 'een1', '', NULL, '2014-08-16 09:25:48'),
(2, 1, 1, 2, 'twee2', '', NULL, '2014-08-16 09:25:48'),
(3, 1, 1, 3, 'drie3', '', NULL, '2014-08-16 09:26:28'),
(4, 1, 1, 4, 'vier4', '', NULL, '2014-08-16 09:26:28'),
(5, 1, 1, 1, 'een1', '', NULL, '2014-08-16 10:05:48'),
(6, 1, 1, 1, 'een1', '', NULL, '2014-08-16 10:17:51'),
(7, 1, 1, 2, 'twee2', '', NULL, '2014-08-16 10:18:10'),
(8, 1, 1, 2, 'twee2', '', NULL, '2014-08-16 10:18:10'),
(9, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 10:21:07'),
(10, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 11:20:43'),
(11, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 11:21:49'),
(12, 1, 1, 4, 'ans4_ques1_mipo1', 'antwoord4', NULL, '2014-08-19 11:30:39'),
(13, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 11:50:35'),
(14, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 11:55:22'),
(15, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 11:57:39'),
(16, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 12:05:48'),
(17, 1, 1, 4, 'ans4_ques1_mipo1', 'antwoord4', NULL, '2014-08-19 12:15:02'),
(18, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 12:15:47'),
(19, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 12:21:55'),
(20, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 12:29:47'),
(21, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 12:32:54'),
(22, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 12:35:50'),
(23, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 12:37:01'),
(24, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 12:38:52'),
(25, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 12:39:12'),
(26, 1, 1, 4, 'ans4_ques1_mipo1', 'antwoord4', NULL, '2014-08-19 13:10:22'),
(27, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 13:39:40'),
(28, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 13:40:50'),
(29, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 13:41:48'),
(30, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 13:43:23'),
(31, 1, 1, 4, 'ans4_ques1_mipo1', 'antwoord4', NULL, '2014-08-19 13:43:43'),
(32, 1, 1, 1, 'ans1_ques1_mipo1', 'antwoord1', NULL, '2014-08-19 13:43:48'),
(33, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 13:44:03'),
(34, 1, 1, 4, 'ans4_ques1_mipo1', 'antwoord4', NULL, '2014-08-19 13:45:30'),
(35, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 13:45:35'),
(36, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 13:51:17'),
(37, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 13:53:34'),
(38, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 13:54:43'),
(39, 1, 1, 4, 'ans4_ques1_mipo1', 'antwoord4', NULL, '2014-08-19 13:54:45'),
(40, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 14:00:09'),
(41, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 14:02:26'),
(42, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 14:03:20'),
(43, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 14:04:55'),
(44, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 14:05:19'),
(45, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 15:00:30'),
(46, 1, 1, 2, 'ans2_ques1_mipo1', 'antwoord2', NULL, '2014-08-19 15:01:44'),
(47, 1, 1, 4, 'ans4_ques1_mipo1', 'antwoord4', NULL, '2014-08-19 15:02:49'),
(48, 1, 1, 3, 'ans3_ques1_mipo1', 'antwoord3', NULL, '2014-08-19 15:04:06');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
