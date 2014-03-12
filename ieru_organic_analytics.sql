/*
 Navicat MySQL Data Transfer

 Source Server         : [DEV] Localhost
 Source Server Version : 50527
 Source Host           : localhost
 Source Database       : ieru_organic_analytics

 Target Server Version : 50527
 File Encoding         : utf-8

 Date: 06/27/2013 18:32:25 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `request`
-- ----------------------------
DROP TABLE IF EXISTS `request`;
CREATE TABLE `request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `request_ip` varchar(15) NOT NULL,
  `request_datetime` datetime NOT NULL,
  `request_language` varchar(2) NOT NULL,
  `request_term` text NOT NULL,
  `request_string` text NOT NULL,
  `request_response` text NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `request_id` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
