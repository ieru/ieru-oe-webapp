/*
 Navicat MySQL Data Transfer

 Source Server         : [DEV] Localhost
 Source Server Version : 50527
 Source Host           : localhost
 Source Database       : ieru_organic_oauth

 Target Server Version : 50527
 File Encoding         : utf-8

 Date: 06/26/2013 23:58:06 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `tokens`
-- ----------------------------
DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token_active` tinyint(4) NOT NULL,
  `token_chars` char(80) NOT NULL,
  `token_expire` datetime NOT NULL,
  `token_ip` char(15) NOT NULL,
  PRIMARY KEY (`token_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `user_username` varchar(20) NOT NULL DEFAULT '',
  `user_active` tinyint(1) DEFAULT NULL,
  `user_password` varchar(100) NOT NULL DEFAULT '',
  `user_password_joomla` varchar(65) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL DEFAULT '',
  `user_creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_hash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`user_username`) USING BTREE,
  UNIQUE KEY `id` (`user_id`) USING BTREE,
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
