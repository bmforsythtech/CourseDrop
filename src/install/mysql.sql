-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 19, 2014 at 10:38 AM
-- Server version: 5.1.73-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `coursedrop`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `ckey` varchar(32) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `ckey` (`ckey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `semester` varchar(8) CHARACTER SET latin1 NOT NULL,
  `course` varchar(32) CHARACTER SET latin1 NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `available` char(1) CHARACTER SET latin1 NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  UNIQUE KEY `semester` (`semester`,`course`),
  KEY `course` (`course`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE IF NOT EXISTS `divisions` (
  `semester` varchar(8) NOT NULL,
  `course` varchar(32) NOT NULL,
  `division` varchar(8) NOT NULL,
  UNIQUE KEY `semester` (`semester`,`course`),
  KEY `course` (`course`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_data` text NOT NULL,
  `sent` tinyint(1) NOT NULL,
  `tosend` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `errorlogs`
--

CREATE TABLE IF NOT EXISTS `errorlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `time` int(11) NOT NULL,
  `pid` varchar(8) NOT NULL,
  `name` varchar(128) NOT NULL,
  `ip` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(64) NOT NULL,
  `status_code` tinyint(4) NOT NULL,
  `semester` varchar(8) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `studentemail` varchar(64) NOT NULL,
  `studentid` varchar(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `veteran` varchar(8) NOT NULL,
  `course` varchar(32) NOT NULL,
  `course_name` varchar(64) NOT NULL,
  `division` varchar(8) NOT NULL,
  `reasons` text NOT NULL,
  `grade` varchar(4) NOT NULL,
  `lastdate` varchar(16) NOT NULL,
  `comments` text NOT NULL,
  `instructorid` varchar(16) NOT NULL,
  `instructorname` varchar(64) NOT NULL,
  `instructoremail` varchar(64) NOT NULL,
  `officialwithdrawal` int(11) NOT NULL,
  `tuid` varchar(32) NOT NULL,
  `idue` int(11) NOT NULL,
  `rdue` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Form Search` (`semester`,`course`,`studentid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE IF NOT EXISTS `instructors` (
  `semester` varchar(8) CHARACTER SET latin1 NOT NULL,
  `course` varchar(32) CHARACTER SET latin1 NOT NULL,
  `user_id` varchar(16) CHARACTER SET latin1 NOT NULL,
  `role` varchar(16) CHARACTER SET latin1 NOT NULL,
  UNIQUE KEY `semester` (`semester`,`course`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `pid` varchar(16) NOT NULL,
  `name` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nodrop`
--

CREATE TABLE IF NOT EXISTS `nodrop` (
  `user_id` varchar(16) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentid` varchar(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  `action` varchar(32) NOT NULL,
  `time` int(11) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `semester` varchar(8) CHARACTER SET latin1 NOT NULL,
  `course` varchar(32) CHARACTER SET latin1 NOT NULL,
  `user_id` varchar(16) CHARACTER SET latin1 NOT NULL,
  `available` char(1) CHARACTER SET latin1 NOT NULL,
  `role` varchar(16) CHARACTER SET latin1 NOT NULL,
  UNIQUE KEY `semester` (`semester`,`course`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `course` (`course`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(16) CHARACTER SET latin1 NOT NULL,
  `username` varchar(32) CHARACTER SET latin1 NOT NULL,
  `firstname` varchar(64) CHARACTER SET latin1 NOT NULL,
  `lastname` varchar(64) CHARACTER SET latin1 NOT NULL,
  `email` varchar(64) CHARACTER SET latin1 NOT NULL,
  `role` varchar(16) CHARACTER SET latin1 NOT NULL,
  `gender` varchar(4) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`ckey`, `value`) VALUES
('open', '08/28/2014'),
('close', '12/03/2014'),
('wpcutoff', '10/20/2014'),
('wfcutoff', '10/20/2014'),
('closedMessage', ''),
('deanforetd', ''),
('deanforbit', ''),
('deanforhss', ''),
('deanforhtd', ''),
('deanformst', ''),
('studentservicesemail', ''),
('veteransemail', ''),
('recordsemail', ''),
('year', '2014'),
('iopen', '08/28/2014'),
('iclose', '12/18/2014'),
('semester', 'FA');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
