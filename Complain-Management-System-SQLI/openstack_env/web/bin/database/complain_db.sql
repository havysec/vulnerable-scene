-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 29, 2013 at 04:32 AM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `complain_db`
--

CREATE Database complain_db;

use complain_db; 

-- --------------------------------------------------------

--
-- Table structure for table `tbl_complains`
--

CREATE TABLE IF NOT EXISTS `tbl_complains` (
  `cid` int(10) NOT NULL auto_increment,
  `cust_id` int(10) NOT NULL,
  `cust_name` varchar(40) NOT NULL,
  `comp_type` varchar(40) NOT NULL,
  `comp_title` varchar(200) NOT NULL,
  `comp_desc` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `eng_id` int(10) NOT NULL,
  `eng_name` varchar(40) NOT NULL,
  `eng_comment` varchar(240) NOT NULL,
  `create_date` datetime NOT NULL,
  `close_date` datetime NOT NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_complains`
--

INSERT INTO `tbl_complains` (`cid`, `cust_id`, `cust_name`, `comp_type`, `comp_title`, `comp_desc`, `status`, `eng_id`, `eng_name`, `eng_comment`, `create_date`, `close_date`) VALUES
(2, 2, 'ayesha khan', 'hardware', 'my machine is making noice.', 'Hi.\r\n\r\nMy machine is making to much noice, will u plz assist.\r\n\r\nthanks', 'close', 1, 'Prashant Kumar', 'working on it.', '2010-11-27 18:59:12', '0000-00-00 00:00:00'),
(3, 2, 'ayesha khan', 'software', 'MS Office is not working', 'Hi.\r\n\r\nMS Office is not working. i think its a problem of virus.\r\nplease help.\r\n\r\nThanks', 'close', 2, 'Aijaz Aslam', 'poblem of virus. working on it.\r\nwill need some time', '2010-11-27 19:04:14', '0000-00-00 00:00:00'),
(4, 1, 'rizwan khatik', 'network', 'Unable to connect', 'Hello.\r\n\r\nI am unable to connect to 10.88.29.098. their is a problem in LAN. Please do needful.\r\n\r\nRegards\r\nRizwan', 'assigned', 5, 'Ramiz Khan', '', '2010-11-27 19:30:10', '0000-00-00 00:00:00'),
(6, 1, 'rizwan khatik', 'network', 'Internet is very slow', 'Hi. \r\nMy internate connection is very slow.\r\n', 'working', 1, 'Prashant Kumar', 'Working on it', '2010-11-28 09:26:36', '0000-00-00 00:00:00'),
(7, 3, 'heena', 'software', 'MS Office is not working', 'hi,\r\nms office is not working fine. may be a problem of virus,\r\n\r\nplz assist.\r\n\r\nheena', 'close', 3, 'Atul Nigade', 'complain is resloved', '2010-11-28 14:08:49', '0000-00-00 00:00:00'),
(8, 1, 'rizwan khatik', 'hardware', 'My monitor is not getting display', 'Hello.\r\n\r\nI have problem in my monitor\r\nplz assist\r\n\r\nrizwan', 'working', 3, 'Atul Nigade', 'i am working on it', '2010-12-07 21:49:38', '0000-00-00 00:00:00'),
(9, 6, 'asif', 'software', 'My setup box is not working', 'hello,\r\n\r\nmy setup box is not working well. please assist.\r\n\r\nThanks', 'open', 0, '', '', '2012-02-05 17:35:36', '0000-00-00 00:00:00'),
(10, 6, 'asif', 'hardware', '', '', 'open', 0, '', '', '2012-03-24 10:02:18', '0000-00-00 00:00:00'),
(11, 1, 'rizwan khatik', 'software', 'problem in installation', 'Facing problem in installation of WLAN. Pls assist.', 'assigned', 5, 'Ramiz Khan', '', '2013-11-29 09:48:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `cid` int(10) NOT NULL auto_increment,
  `cname` varchar(40) NOT NULL,
  `cpass` varchar(40) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(30) NOT NULL,
  `c_mobile` varchar(15) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`cid`, `cname`, `cpass`, `address`, `email`, `c_mobile`, `date_time`) VALUES
(1, 'rizwan khatik', 'riz123', '			  3, Hill side, Bhaguday Nagar, Kondwa			  ', 'riz1.a@gmail.com', '9089789876', '2010-11-27 12:55:39'),
(4, 'Manmohan Singh', 'mansingh', '10, raj bhavan', 'man.mohan@yo.com', '9652525252', '2011-02-02 23:52:36'),
(5, 'Sardar', 'sar1', '11, ashoka heights, kondwa, pune', 'sardar.p@yahoo.com', '9521425425', '2011-02-03 07:45:47'),
(6, 'asif', 'asif123', '290, shani peth, jalgaon', 'asif@gmail.com', '9524254254', '2012-02-05 17:34:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_engineer`
--

CREATE TABLE IF NOT EXISTS `tbl_engineer` (
  `eid` int(10) NOT NULL auto_increment,
  `ename` varchar(40) NOT NULL,
  `epass` varchar(40) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(40) NOT NULL,
  `e_mobile` varchar(20) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY  (`eid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_engineer`
--

INSERT INTO `tbl_engineer` (`eid`, `ename`, `epass`, `address`, `email`, `e_mobile`, `date_time`) VALUES
(6, 'Amol sarode', 'amol', '			  12/c, camp, pune			  ', 'amol.sarode@gmail.co', '2541258452', '2011-02-02 23:36:51'),
(5, 'Ramiz Khan', 'ramiz', '10, merta tower', 'ramiz@gmail.com', '9854251425', '2011-02-02 23:36:09'),
(4, 'Mubarak Bahesti', 'mubarak', '290, asif nagar, pune', 'mubarak@gmail.com', '9856323568', '2011-02-02 23:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plans`
--

CREATE TABLE IF NOT EXISTS `tbl_plans` (
  `id` int(10) NOT NULL auto_increment,
  `cid` int(10) NOT NULL,
  `plans` varchar(255) NOT NULL,
  `amt` double NOT NULL,
  `plan_date` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_plans`
--

INSERT INTO `tbl_plans` (`id`, `cid`, `plans`, `amt`, `plan_date`) VALUES
(3, 5, 'Basic Plan, Music Plan, ', 150, '13'),
(4, 6, 'Basic Plan, ', 120, '05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE IF NOT EXISTS `tbl_supplier` (
  `sid` int(11) NOT NULL auto_increment,
  `sname` varchar(40) NOT NULL,
  `spass` varchar(40) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(40) NOT NULL,
  `s_mobile` varchar(15) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`sid`, `sname`, `spass`, `address`, `email`, `s_mobile`, `date_time`) VALUES
(1, 'maryam afifa', 'marry123', '290, shani peth, pune', 'maryam.afifa@gmail.com', '9987876765', '2010-11-27 17:29:05');


CREATE TABLE IF NOT EXISTS `flag` (
  `sid` int(11) NOT NULL auto_increment,
  `sname` varchar(40) NOT NULL,
  `spass` varchar(40) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(40) NOT NULL,
  `s_mobile` varchar(15) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `flag` (`sid`, `sname`, `spass`, `address`, `email`, `s_mobile`, `date_time`) VALUES
(1, 'xxxxxx', 'marry123', '290, shani peth, pune', 'maryam.afifa@gmail.com', '9987876765', '2010-11-27 17:29:05');