-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 23, 2014 at 03:48 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `app_atom`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileno` varchar(15) NOT NULL,
  `ed` varchar(10) NOT NULL,
  `doa` varchar(10) NOT NULL,
  `macno` varchar(20) NOT NULL,
  `vehicleno` varchar(50) NOT NULL,
  `firno` varchar(50) NOT NULL,
  `firdate` varchar(10) NOT NULL,
  `firps` varchar(50) NOT NULL,
  `court` varchar(20) NOT NULL,
  `advocate` varchar(50) NOT NULL,
  `investigator` varchar(50) NOT NULL,
  `claimant` varchar(50) NOT NULL,
  `policyno` varchar(50) NOT NULL,
  `hcai` varchar(50) NOT NULL,
  `insadd` text NOT NULL,
  `note` text NOT NULL,
  `claimno` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  `rate` float NOT NULL,
  `ra` float NOT NULL,
  `total` float NOT NULL,
  `awardtype` varchar(15) NOT NULL,
  `casetype` varchar(10) NOT NULL,
  `insperiod` varchar(55) NOT NULL,
  `preproc` varchar(10) NOT NULL,
  `proc` varchar(10) NOT NULL,
  `branch` int(11) NOT NULL,
  `lastuser` int(11) NOT NULL DEFAULT '1',
  `last` varchar(20) NOT NULL,
  `s` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `branch`
--


-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `value_1` varchar(50) NOT NULL,
  `value_2` varchar(100) NOT NULL,
  `value_3` text NOT NULL,
  `s` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `terms`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `date` varchar(15) NOT NULL,
  `type` varchar(15) NOT NULL,
  `branch` int(11) NOT NULL,
  `url` text NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone`, `address`, `date`, `type`, `branch`, `url`, `status`) VALUES
(1, 'System', '', '', '', '', '', 'admin', 0, '', 1),
(2, 'Admin', 'admin@admin.com', '9ce21d8f3992d89a325aa9dcf520a591', '0000000000', 'NA', '23.11.2014', 'admin', 1, '', 1);
