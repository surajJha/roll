-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2015 at 09:32 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shout`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_name`, `city_name`) VALUES
(1, 'Malad', 'Mumbai'),
(2, 'Goregaon', 'Mumbai'),
(3, 'Jogeshwari', 'Mumbai'),
(4, 'Andheri', 'Mumbai'),
(5, 'Vile Parle', 'Mumbai'),
(6, 'Santacruz', 'Mumbai'),
(7, 'Khar', 'Mumbai'),
(8, 'Bandra', 'Mumbai'),
(9, 'Mahim', 'Mumbai'),
(10, 'Matunga', 'Mumbai'),
(11, 'Dadar', 'Mumbai'),
(12, 'Elphinstone', 'Mumbai'),
(13, 'Lower Parel', 'Mumbai'),
(14, 'Mahalakshmi', 'Mumbai'),
(15, 'Mumbai Central', 'Mumbai'),
(16, 'Grant Road', 'Mumbai'),
(17, 'Charni Road', 'Mumbai'),
(18, 'Marine Lines', 'Mumbai'),
(19, 'Churchgate', 'Mumbai'),
(20, 'Kandivali', 'Mumbai'),
(21, 'Oshiwara', 'Mumbai'),
(22, 'Versova', 'Mumbai'),
(23, 'Juhu', 'Mumbai'),
(24, 'Andheri', 'Bangalore');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Comedy'),
(2, 'Culture'),
(3, 'Food + Drinks'),
(4, 'Music'),
(5, 'Nightlife'),
(6, 'Sports'),
(7, 'Theatre');

-- --------------------------------------------------------

--
-- Table structure for table `event_detail`
--

CREATE TABLE IF NOT EXISTS `event_detail` (
  `event_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_overview` text COLLATE utf8_unicode_ci NOT NULL,
  `event_hashtags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location` text COLLATE utf8_unicode_ci NOT NULL,
  `event_area_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_cost` int(11) NOT NULL,
  `viewer_count` int(11) NOT NULL DEFAULT '0',
  `priority_count` int(11) NOT NULL DEFAULT '0',
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_id` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`event_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `event_detail`
--

INSERT INTO `event_detail` (`event_detail_id`, `venue_name`, `event_name`, `event_overview`, `event_hashtags`, `event_location`, `event_area_id`, `event_cost`, `viewer_count`, `priority_count`, `category_name`, `event_organizer_id`, `approved`, `is_active`) VALUES
(15, 'fghjkl', 'testing', 'dfghjkl;''', 'fghjkl gthjkl; ghjkl;', 'fghjkl', '11', 12345, 0, 0, 'Comedy', 1, 0, 0),
(16, 'ertyuiop', 'testing', 'ertyu', 'qwerty  ', 'ertyu', '4', 411, 0, 0, 'Comedy', 1, 0, 0),
(17, 'andheri', 'final testing', 'wedfgh', 'qwerty  ', 'andheri', '4', 1234, 0, 0, 'Culture', 1, 0, 0),
(18, 'zxczxcz', 'zxzzxc', 'zxczxczc', 'dsc zxczxc ', 'czxczczc', '17', 1, 0, 0, 'Comedy', 1, 0, 1),
(19, 'zxczcz', 'dfsfs', 'fsdfsdfsd', 'zcxzcz czxczc ', 'czxczc', '15', 34, 0, 0, 'Culture', 1, 0, 1),
(20, 'sdfsf', 'dvfsfsd', 'fsdfsdf', 'dfdsf sdfsf ', 'sdfsdf', '17', 42, 0, 0, 'Culture', 1, 0, 1),
(21, 'sfsafa', 'afsaf', 'afasfasf', 'asfa fafaf afasf', 'fafasf', '2', 24, 0, 0, 'Comedy', 1, 0, 1),
(22, 'asfaf', 'sdfasf', 'asfsaf', 'sfaa  ', 'afasfasf', '2', 24, 0, 0, 'Comedy', 1, 0, 0),
(23, 'afsd', 'sfafafasf', 'asfsaf', 'safasf safasf afafaf', 'afadsfsfasf', '5', 35, 0, 0, 'Food + Drinks', 1, 0, 1),
(24, 'zxczc', 'safaf', 'fassfasf', '  ', 'zczczxc', '17', 23, 0, 0, 'Comedy', 1, 0, 0),
(25, 'afsasf', 'sfafa', 'sfafaf', 'saf  ', 'afafaf', '3', 24, 0, 0, 'Comedy', 1, 0, 1),
(26, 'asfafsaf', 'asfasf', 'afafafs', '  ', 'afsafafsa', '3', 38, 0, 0, 'Culture', 1, 0, 0),
(27, 'safsafa', 'asfaf', 'afafafsa', '  ', 'asfafaf', '2', 23, 0, 0, 'Culture', 1, 0, 1),
(28, 'fasfaf', 'asfsafa', 'fasfasfasf', '  ', 'afasfasf', '1', 18, 0, 0, 'Comedy', 1, 0, 1),
(29, 'fsgdfg', 'fghrh', 'dsfgf', '  ', 'sfgdfb', '1', 234, 0, 0, 'Comedy', 1, 0, 0),
(30, 'xbcbxbx', 'safafas', 'esgdasgsdagag', 'vxzv zxvzxvz zvxzvzvzxv', 'xbxcbxcbxcbxcb', '16', 134, 0, 0, 'Culture', 1, 0, 1),
(31, 'vjhgyg', 'hgyg', 'hgig', 'iggiu', 'iiuhj', '24', 133, 0, 0, 'Culture', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_image`
--

CREATE TABLE IF NOT EXISTS `event_image` (
  `event_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_detail_id` int(11) NOT NULL,
  `event_image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `primary_image` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`event_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `event_image`
--

INSERT INTO `event_image` (`event_image_id`, `event_detail_id`, `event_image_name`, `primary_image`) VALUES
(1, 4, '/var/www/html/shout/server/client_images/1/download.0.69788800 1421330789.png', 0),
(2, 4, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_173354.0.70302200 1421330789.jpg', 1),
(3, 4, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_180830.0.71521000 1421330789.jpg', 0),
(4, 5, '/var/www/html/shout/server/client_images/1/download.0.95761500 1421331164.png', 0),
(5, 5, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_173354.0.96686000 1421331164.jpg', 0),
(6, 5, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_180830.0.96686200 1421331164.jpg', 1),
(7, 13, '/var/www/html/shout/server/client_images/1/mockup_AdTag_Admin.0.83411400 1421763505.png', 0),
(8, 13, '/var/www/html/shout/server/client_images/1/mockup_1.0.83592200 1421763505.png', 1),
(9, 13, '/var/www/html/shout/server/client_images/1/Angular.0.83394400 1421763505.png', 0),
(10, 15, '/var/www/html/shout/server/client_images/1/Angular.0.75520800 1421986885.png', 1),
(11, 15, '/var/www/html/shout/server/client_images/1/mockup_AdTag_Admin.0.75988400 1421986885.png', 0),
(12, 15, '/var/www/html/shout/server/client_images/1/mockup_1.0.76073700 1421986885.png', 0),
(13, 16, '/var/www/html/shout/server/client_images/1/Angular.0.78638900 1422356352.png', 1),
(14, 16, '/var/www/html/shout/server/client_images/1/new.0.68501200 1422356302.jpg', 0),
(15, 16, '/var/www/html/shout/server/client_images/1/mockup_1.0.42970200 1422336981.png', 0),
(16, 17, '/var/www/html/shout/server/client_images/1/Angular.0.87174500 1422426051.png', 1),
(17, 17, '/var/www/html/shout/server/client_images/1/mockup_1.0.16293900 1422427375.png', 0),
(18, 17, '/var/www/html/shout/server/client_images/1/mockup_AdTag_Admin.0.87247800 1422426051.png', 0),
(19, 22, '/var/www/html/shout/server/client_images/1/images (3).0.06431400 1423194252.jpg', 1),
(20, 23, '/var/www/html/shout/server/client_images/1/images (2).0.91535200 1423194412.jpg', 1),
(21, 23, '/var/www/html/shout/server/client_images/1/download.0.81536600 1423194339.jpg', 0),
(22, 23, '/var/www/html/shout/server/client_images/1/images (3).0.81768200 1423194339.jpg', 0),
(23, 24, '/var/www/html/shout/server/client_images/1/images (3).0.49747600 1423198596.jpg', 1),
(24, 25, '/var/www/html/shout/server/client_images/1/images (2).0.59660300 1423198765.jpg', 1),
(25, 26, '/var/www/html/shout/server/client_images/1/images (3).0.43799200 1423198861.jpg', 1),
(26, 27, '/var/www/html/shout/server/client_images/1/images (3).0.84706200 1423198912.jpg', 1),
(27, 28, '/var/www/html/shout/server/client_images/1/images (2).0.47553800 1423198959.jpg', 1),
(28, 29, '/var/www/html/shout/server/client_images/1/images.0.53878600 1423199148.jpg', 1),
(29, 30, '/var/www/html/shout/server/client_images/1/download.0.38530700 1423237752.jpg', 1),
(30, 30, '/var/www/html/shout/server/client_images/1/images (1).0.38759700 1423237752.jpg', 0),
(31, 30, '/var/www/html/shout/server/client_images/1/images (1).0.38884000 1423237752.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_organizer`
--

CREATE TABLE IF NOT EXISTS `event_organizer` (
  `event_organizer_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_organizer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_phone` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_organizer_id`),
  UNIQUE KEY `event_organizer_email` (`event_organizer_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `event_organizer`
--

INSERT INTO `event_organizer` (`event_organizer_id`, `event_organizer_name`, `event_organizer_email`, `event_organizer_password`, `event_organizer_phone`, `verified`) VALUES
(1, 'Arun', 'arun@gmail.com', '123456', 1234567890, 1),
(2, 'Rishabh', 'rishabh@gmail.com', '123456', 1234567890, 1),
(3, 'Vishal', 'vishal@gmail.com', '123456', 1234567890, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_schedule`
--

CREATE TABLE IF NOT EXISTS `event_schedule` (
  `event_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_detail_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_start_time` time NOT NULL,
  `event_end_time` time DEFAULT NULL,
  PRIMARY KEY (`event_schedule_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `event_schedule`
--

INSERT INTO `event_schedule` (`event_schedule_id`, `event_detail_id`, `event_date`, `event_start_time`, `event_end_time`) VALUES
(1, 1, '2015-01-16', '03:34:00', '03:34:00'),
(2, 1, '2015-02-16', '03:34:00', '03:34:00'),
(3, 1, '2015-01-19', '03:34:00', '03:34:00'),
(4, 1, '2015-02-19', '03:34:00', '03:34:00'),
(5, 2, '2015-01-20', '03:36:00', '03:36:00'),
(6, 2, '2015-01-27', '03:36:00', '03:36:00'),
(7, 2, '2015-02-03', '03:36:00', '03:36:00'),
(8, 2, '2015-02-10', '03:36:00', '03:36:00'),
(9, 2, '2015-02-17', '03:36:00', '03:36:00'),
(10, 4, '2015-01-05', '03:42:00', '03:42:00'),
(11, 4, '2015-01-09', '07:36:00', '07:36:00'),
(12, 5, '2015-01-23', '00:00:00', '00:00:00'),
(13, 7, '2015-01-28', '16:15:00', '00:00:00'),
(14, 9, '2015-01-21', '20:45:00', '20:00:00'),
(15, 11, '2015-01-21', '20:45:00', '20:00:00'),
(16, 11, '2015-01-21', '20:45:00', '20:00:00'),
(17, 13, '2015-01-22', '05:30:00', '19:48:00'),
(18, 15, '2015-01-28', '05:30:00', '09:51:00'),
(19, 16, '2015-01-29', '05:30:00', '11:06:00'),
(20, 17, '2015-01-30', '05:30:00', '11:50:00'),
(21, 17, '2015-01-29', '05:30:00', '11:50:00'),
(22, 18, '2015-02-19', '05:30:00', '09:08:00'),
(23, 18, '2015-02-26', '05:30:00', '09:08:00'),
(24, 18, '2015-03-05', '05:30:00', '09:08:00'),
(25, 19, '2015-02-12', '05:30:00', '09:10:00'),
(26, 19, '2015-02-16', '05:30:00', '09:10:00'),
(27, 20, '2015-02-13', '05:30:00', '09:11:00'),
(28, 21, '2015-02-11', '05:30:00', '09:12:00'),
(29, 22, '2015-02-27', '05:30:00', '09:14:00'),
(30, 23, '2015-02-19', '05:15:00', '04:15:00'),
(31, 23, '2015-02-09', '13:15:00', '15:15:00'),
(32, 24, '2015-02-18', '05:30:00', '10:26:00'),
(33, 25, '2015-02-19', '05:30:00', '10:29:00'),
(34, 25, '2015-02-16', '05:30:00', '10:29:00'),
(36, 27, '2015-02-11', '05:30:00', '10:31:00'),
(37, 28, '2015-02-12', '05:30:00', '03:32:00'),
(38, 28, '2015-02-19', '05:30:00', '03:32:00'),
(39, 28, '2015-02-26', '05:30:00', '03:32:00'),
(40, 28, '2015-03-05', '05:30:00', '03:32:00'),
(41, 28, '2015-02-25', '18:32:00', '10:32:00'),
(42, 28, '2015-03-04', '18:32:00', '10:32:00'),
(43, 28, '2015-03-11', '18:32:00', '10:32:00'),
(44, 28, '2015-03-18', '18:32:00', '10:32:00'),
(45, 29, '2015-02-10', '05:30:00', '10:35:00'),
(46, 29, '2015-02-17', '05:30:00', '10:35:00'),
(47, 29, '2015-02-10', '05:30:00', '10:35:00'),
(48, 29, '2015-02-17', '05:30:00', '10:35:00'),
(49, 30, '2015-02-26', '06:02:00', '04:17:00'),
(50, 30, '2015-03-26', '06:02:00', '04:17:00'),
(51, 30, '2015-02-12', '19:17:00', '23:17:00'),
(52, 30, '2015-03-12', '19:17:00', '23:17:00'),
(53, 30, '2015-02-11', '05:30:00', '21:17:00'),
(54, 30, '2015-03-11', '05:30:00', '21:17:00'),
(55, 26, '2015-02-12', '20:05:00', '21:20:00'),
(56, 26, '2015-02-19', '20:05:00', '21:20:00'),
(57, 26, '2015-02-26', '20:05:00', '21:20:00'),
(58, 26, '2015-02-20', '21:05:00', '21:20:00'),
(59, 26, '2015-02-27', '21:05:00', '21:20:00'),
(60, 26, '2015-03-06', '21:05:00', '21:20:00'),
(61, 26, '2015-02-10', '18:20:00', '21:20:00'),
(62, 26, '2015-02-17', '18:20:00', '21:20:00'),
(63, 26, '2015-02-24', '18:20:00', '21:20:00'),
(64, 26, '2015-02-20', '05:30:00', '21:20:00'),
(65, 26, '2015-02-27', '05:30:00', '21:20:00'),
(66, 26, '2015-03-06', '05:30:00', '21:20:00'),
(67, 26, '2015-02-09', '00:20:00', '21:20:00'),
(68, 26, '2015-02-16', '00:20:00', '21:20:00'),
(69, 26, '2015-02-23', '00:20:00', '21:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE IF NOT EXISTS `hashtag` (
  `hashtag_id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hashtag_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`hashtag_id`),
  UNIQUE KEY `hashtag_name` (`hashtag_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`hashtag_id`, `hashtag_name`, `hashtag_count`) VALUES
(1, 'music', 1),
(2, 'karaoke', 1),
(3, 'newyears', 1),
(4, 'party', 2),
(5, 'hot', 1),
(6, 'drinks', 1),
(7, '', 28),
(8, 'oghjkl', 1),
(9, 'fghjkfghjk', 1),
(10, 'ghjkl;''', 1),
(11, 'vbn', 2),
(12, 'fghj', 2),
(13, 'ghj', 1),
(14, 'fvgbnjh', 1),
(15, 'dfghj', 1),
(16, 'fghjkl', 1),
(17, 'gthjkl;', 1),
(18, 'ghjkl;', 1),
(19, 'qwerty', 1),
(20, 'dsc', 1),
(21, 'zxczxc', 1),
(22, 'zcxzcz', 1),
(23, 'czxczc', 1),
(24, 'dfdsf', 1),
(25, 'sdfsf', 1),
(26, 'asfa', 1),
(27, 'fafaf', 1),
(28, 'afasf', 1),
(29, 'sfaa', 1),
(30, 'safasf', 3),
(31, 'afafaf', 1),
(32, 'saf', 1),
(33, 'vxzv', 1),
(34, 'zxvzxvz', 1),
(35, 'zvxzvzvzxv', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
