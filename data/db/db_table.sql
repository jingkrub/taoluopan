-- phpMyAdmin SQL Dump
-- version 3.4.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2012 at 04:11 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `taoRanking`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_url` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `num_iid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `is_xinpin` tinyint(1) DEFAULT NULL,
  `cid` int(11) NOT NULL,
  `approve_status` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `delist_time` datetime NOT NULL,
  `list_time` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `num` int(11) NOT NULL,
  `pic_url` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `valid_thru` int(11) NOT NULL,
  `has_showcase` tinyint(1) NOT NULL,
  `is_timing` tinyint(1) DEFAULT NULL,
  `second_kill` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `violation` tinyint(1) DEFAULT NULL,
  `locked_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_history`
--

CREATE TABLE IF NOT EXISTS `item_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `function` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `item_detail` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `sid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `pic_path` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `all_count` int(11) NOT NULL,
  `remain_count` int(11) NOT NULL,
  `used_count` int(11) NOT NULL,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `showcase`
--

CREATE TABLE IF NOT EXISTS `showcase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `in_black_list` tinyint(1) NOT NULL,
  `in_white_list` tinyint(1) NOT NULL,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `showcase_history`
--

CREATE TABLE IF NOT EXISTS `showcase_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `function` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `item_details` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `update_queue`
--

CREATE TABLE IF NOT EXISTS `update_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `function` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `session_key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `expires_time` int(11) NOT NULL,
  `re_expires_time` int(11) NOT NULL,
  `signin_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sex` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `last_visit` datetime NOT NULL,
  `type` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `has_shop` tinyint(1) NOT NULL,
  `is_lightning_consignment` tinyint(1) NOT NULL,
  `is_golden_seller` tinyint(1) NOT NULL,
  `vip_info` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_actived` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_item`
--

CREATE TABLE IF NOT EXISTS `user_item` (
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
