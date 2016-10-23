-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2016 at 01:04 AM
-- Server version: 5.5.52-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `balaji`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `last_login` datetime NOT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0->inactive,1->active,2->delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `created_on`, `created_by`, `updated_on`, `updated_by`, `last_login`, `status`) VALUES
(1, 'admin@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'manu saxena', '2016-09-17 02:39:55', 1, '2016-09-17 02:40:00', 1, '2016-10-19 11:28:26', '1');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `mobile`, `message`, `created_on`, `status`) VALUES
(1, 'jelkx', '888888888', 'lxlksxsw', '2016-10-19 19:22:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lordid` int(11) NOT NULL,
  `event_title` varchar(200) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text NOT NULL,
  `organizer_name` varchar(15) NOT NULL,
  `organizer_contact` varchar(15) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `lordid`, `event_title`, `start_date`, `end_date`, `description`, `organizer_name`, `organizer_contact`, `created_on`, `created_by`, `updated_by`, `updated_on`, `status`) VALUES
(1, 1, 'This is the event', '2016-10-10', '2016-10-16', 'lipdum dummy text lipdum dummy text lipdum dummy text lipdum dummy text', 'Ravinder', '98988998', '2016-10-02 14:48:16', 1, 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_gallery`
--

CREATE TABLE IF NOT EXISTS `event_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `gallery_type` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `video_url` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `event_gallery`
--

INSERT INTO `event_gallery` (`id`, `event_id`, `gallery_type`, `image`, `video_url`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, 1, 'photo', 'untitled-1475403649.bmp', 'youtubelinkexxxxadfadfad', '2016-10-02 15:50:49', 1, '2016-10-02 16:04:34', 1, 0),
(2, 1, 'video', '', 'Testing new98Testing', '2016-10-02 21:20:06', 1, '2016-10-02 21:30:12', 1, 1),
(3, 1, 'photo', '', '', '2016-10-07 00:28:04', 1, '0000-00-00 00:00:00', 0, 0),
(4, 1, 'photo', '090ab948288b3b6573f9867952e95e7f-1475780421.jpg', '', '2016-10-07 00:30:21', 1, '2016-10-07 00:32:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `file_type` enum('1','2') NOT NULL COMMENT '1->image,2->video',
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` enum('1','2','3') NOT NULL COMMENT '0->ininactive,1->active,2->delete',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `home_setting`
--

CREATE TABLE IF NOT EXISTS `home_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '0',
  `url` varchar(100) NOT NULL DEFAULT '0',
  `image` varchar(100) NOT NULL DEFAULT '0',
  `created_on` date NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updated_on` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `home_setting`
--

INSERT INTO `home_setting` (`id`, `name`, `url`, `image`, `created_on`, `created_by`, `updated_by`, `updated_on`, `status`) VALUES
(1, 'Story', 'cstory.php', 'demo-pic-1476638405.jpg', '2016-10-16', 1, 1, '2016-10-19', 1),
(2, 'hwllo test', 'yahooooo.com', 'demo-pic-1476898828.jpg', '2016-10-19', 1, 1, '2016-10-19', 1),
(3, 'test3', 'text3.php', 'demo-pic-1476899951.jpg', '2016-10-19', 1, 1, '0000-00-20', 1),
(4, 'text4', 'text4.php', 'demo-pic-1476899981.jpg', '2016-10-19', 1, 1, '2016-10-19', 1),
(5, 'text 5', 'text5.php', 'demo-pic-1476900019.jpg', '2016-10-19', 1, 1, '2016-10-19', 1),
(6, 'text 6', 'text6.php', 'demo-pic-1476900039.jpg', '2016-10-19', 1, 1, '2016-10-19', 1),
(7, 'text 7', 'text7.php', 'demo-pic-1476900518.jpg', '2016-10-19', 1, 1, '2016-10-19', 1),
(8, 'text 8', 'text8.php', 'demo-pic-1476900039.jpg', '2016-10-20', 1, 1, '2016-10-20', 1),
(9, 'text 9', 'text9.php', 'demo-pic-1476900039.jpg', '2016-10-20', 1, 1, '2016-10-20', 1),
(10, 'text 10', 'text10.php', 'demo-pic-1476900039.jpg', '2016-10-20', 1, 1, '2016-10-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lords`
--

CREATE TABLE IF NOT EXISTS `lords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `lords`
--

INSERT INTO `lords` (`id`, `name`, `image`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(2, 'Ram', 'Water lilies-1475312932.jpg', '2016-10-01 14:38:52', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(3, 'Shiva', 'Sunset-1475313052.jpg', '2016-10-01 14:40:52', 1, '2016-10-01 18:41:54', '0000-00-00 00:00:00', 1),
(55, 'Kalka', 'Sunset-1475327552.jpg', '2016-10-01 18:42:32', 1, '2016-10-01 18:42:40', '0000-00-00 00:00:00', 0),
(56, 'hello', '', '2016-10-07 00:08:41', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lords_aarti`
--

CREATE TABLE IF NOT EXISTS `lords_aarti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lordid` int(11) NOT NULL,
  `aarti_audio` varchar(100) NOT NULL,
  `youtube_url` varchar(200) NOT NULL,
  `aarti_text` text NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `lords_aarti`
--

INSERT INTO `lords_aarti` (`id`, `lordid`, `aarti_audio`, `youtube_url`, `aarti_text`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(2, 2, 'audcity-1475396040.bmp', 'youtube urltext', 'lipsum dummy text lipsum dummy text lipsum dummy text lipsum dummy text ', '2016-10-02 13:31:23', 1, '2016-10-02 13:55:45', '0000-00-00 00:00:00', 0),
(3, 1, '', 'youtube urltext', 'test', '2016-10-02 13:54:33', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(4, 3, '', 'youtube urltext', '<p>lipsum dummy text&nbsp;lipsum dummy text&nbsp;lipsum dummy text&nbsp;lipsum dummy text&nbsp;lipsum dummy text&nbsp;</p>\r\n', '2016-10-02 14:05:16', 1, '2016-10-02 14:05:34', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '0',
  `url` varchar(100) NOT NULL DEFAULT '0',
  `created_on` date NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updated_on` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `url`, `created_on`, `created_by`, `updated_by`, `updated_on`, `status`) VALUES
(2, 'Home', 'index.php', '2016-10-16', 1, 0, '0000-00-00', 1),
(3, 'Lord Story', 'cstory.php', '2016-10-16', 1, 0, '0000-00-00', 1),
(4, 'Sabhamani', 'sabhamani.php', '2016-10-16', 1, 0, '0000-00-00', 1),
(5, 'Gallery', 'gallery.php', '2016-10-16', 0, 0, '0000-00-00', 1),
(6, 'Contact Us', 'contact.php', '2016-10-16', 1, 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `miracle`
--

CREATE TABLE IF NOT EXISTS `miracle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_teller` varchar(100) NOT NULL,
  `story_title` varchar(250) NOT NULL,
  `miracle_story` text NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `miracle`
--

INSERT INTO `miracle` (`id`, `story_teller`, `story_title`, `miracle_story`, `created_on`, `created_by`, `status`) VALUES
(1, 'hello', '', '', '2016-10-09 02:07:32', 1, 1),
(2, 'nsxxs', 'yo o', 'kjsxhskxsxskxs', '2016-10-09 02:28:53', 1, 1),
(3, 'nsxxs', 'yo o', 'kjsxhskxsxskxs', '2016-10-09 02:28:53', 1, 1),
(4, 'hello', '', '', '2016-10-09 02:07:32', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prayer`
--

CREATE TABLE IF NOT EXISTS `prayer` (
  `lord_id` int(11) NOT NULL AUTO_INCREMENT,
  `prayer_name` varchar(50) NOT NULL,
  `prayer_image` varchar(50) NOT NULL,
  `prayer_url` varchar(100) NOT NULL,
  `prayer_text` text NOT NULL,
  `prayer_file` varchar(100) NOT NULL,
  `created_on` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lord_id`),
  UNIQUE KEY `lord_id` (`lord_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sabamani`
--

CREATE TABLE IF NOT EXISTS `sabamani` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sr_number` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` varchar(250) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sabamani`
--

INSERT INTO `sabamani` (`id`, `sr_number`, `name`, `father_name`, `city`, `date`, `mobile`, `address`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(1, 'check', 'jsnxjsxsj', 'axskjx', 'axkjsxs', '2016-10-10', '9654978709', 's,mxns,xnc', '2016-10-09 21:10:41', 1, '2016-10-09 21:10:50', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sidemenu`
--

CREATE TABLE IF NOT EXISTS `sidemenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '0',
  `url` varchar(100) NOT NULL DEFAULT '0',
  `created_on` date NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updated_on` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sidemenu`
--

INSERT INTO `sidemenu` (`id`, `name`, `url`, `created_on`, `created_by`, `updated_by`, `updated_on`, `status`) VALUES
(1, 'test', 'test.php', '2016-10-16', 0, 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE IF NOT EXISTS `story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lord_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `story`
--

INSERT INTO `story` (`id`, `lord_id`, `title`, `text`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(2, 1, 'hello 1', 'lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy ', '2016-10-01 18:17:53', 1, '2016-10-01 18:48:42', 1, 1),
(4, 2, 'hello 2', 'lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy lipsum dummy ', '2016-10-01 18:31:18', 1, '2016-10-01 18:50:29', 1, 0),
(5, 55, 'hello 3', 'Test msg Test msg Test msg Test msg Test msg Test msg ', '2016-10-01 18:51:02', 1, '2016-10-01 18:51:29', 1, 1),
(6, 56, 'hello 4', 'jhhjgjhjfjf', '2016-10-07 00:09:25', 1, '0000-00-00 00:00:00', 0, 1),
(8, 1, 'eccc', 'DCDDCDDFDCFD', '2016-10-16 18:01:21', 1, '0000-00-00 00:00:00', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
