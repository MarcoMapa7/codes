-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2016 at 07:48 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crud360`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `title`) VALUES
(1, 'Accounts'),
(3, 'Administration'),
(2, 'Finance');

-- --------------------------------------------------------

--
-- Stand-in structure for view `dmap`
--
CREATE TABLE IF NOT EXISTS `dmap` (
`Name` varchar(128)
,`Department` varchar(128)
,`this_moment` date
);
-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `title`) VALUES
(30, 'Active'),
(10, 'Suspended');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `address1` varchar(128) NOT NULL,
  `address2` varchar(128) NOT NULL,
  `summary` text,
  `dob` date NOT NULL,
  `lastlogin` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `department_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `favorite_color` varchar(32) NOT NULL DEFAULT '#FBFBFB',
  `avatar` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `address1`, `address2`, `summary`, `dob`, `lastlogin`, `timestamp`, `department_id`, `status_id`, `favorite_color`, `avatar`) VALUES
(22, 'Abc', 'http://techslides.com/demos/sample-videos/small.mp4', 'usman@orbit360.net', 'orbit360', 'Suit # 10-12', 'Kohinoor One', 'A system analyst, software engineer and a passionate programmer!', '1984-09-11', '1970-01-01 05:00:00', '0000-00-00 00:00:00', 3, 10, 'pink', ''),
(24, 'Usman', 'Usman', 'usman@usman.com', 'abc', 'hello', 'hello', 'as', '2016-11-09', '2016-11-14 05:05:00', '0000-00-00 00:00:00', 3, 30, '#eee', 'http://assets.worldwildlife.org/photos/946/images/story_full_width/forests-why-matter_63516847.jpg?1345534028'),
(25, 'Malik Usman', 'malikusman', 'malik@gmail.com', 'abc', 'abc', 'lahore', 'Hello', '2016-12-05', '1970-01-01 05:00:00', '0000-00-00 00:00:00', 2, 30, '#FBFBFB', 'ABC');

-- --------------------------------------------------------

--
-- Table structure for table `user_links`
--

CREATE TABLE IF NOT EXISTS `user_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(1024) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_links`
--

INSERT INTO `user_links` (`id`, `link`, `user_id`) VALUES
(1, '', 22),
(2, '', 22),
(3, 'Hello', 24),
(4, 'aaa', 25),
(5, 'aaa', 25),
(6, 'XYZ.com', 25);

-- --------------------------------------------------------

--
-- Table structure for table `user_quotes`
--

CREATE TABLE IF NOT EXISTS `user_quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote` varchar(1024) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_quotes`
--

INSERT INTO `user_quotes` (`id`, `quote`, `user_id`) VALUES
(1, 'Extra', 25),
(2, 'Extra', 25),
(3, 'Extra', 25);

-- --------------------------------------------------------

--
-- Structure for view `dmap`
--
DROP TABLE IF EXISTS `dmap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dmap` AS select `users`.`name` AS `Name`,`departments`.`title` AS `Department`,curdate() AS `this_moment` from (`users` join `departments`) where (`users`.`department_id` = `departments`.`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_status1` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
