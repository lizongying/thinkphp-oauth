/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : db_example

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-03-03 10:48:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for oauth_access_token_scopes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_token_scopes`;
CREATE TABLE `oauth_access_token_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(64) NOT NULL,
  `scope` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `access_token` (`access_token`),
  KEY `scope` (`scope`),
  CONSTRAINT `oauth_access_token_scopes_ibfk_1` FOREIGN KEY (`access_token`) REFERENCES `oauth_access_tokens` (`access_token`) ON DELETE CASCADE,
  CONSTRAINT `oauth_access_token_scopes_ibfk_2` FOREIGN KEY (`access_token`) REFERENCES `oauth_access_tokens` (`access_token`) ON DELETE CASCADE,
  CONSTRAINT `oauth_access_token_scopes_ibfk_3` FOREIGN KEY (`scope`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_access_token_scopes
-- ----------------------------

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(64) NOT NULL,
  `session_id` int(11) NOT NULL,
  `expire_time` int(11) NOT NULL,
  PRIMARY KEY (`access_token`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `oauth_access_tokens_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------
INSERT INTO `oauth_access_tokens` VALUES ('iamgod', '1', '1453965551');
INSERT INTO `oauth_access_tokens` VALUES ('iamhong', '2', '1453965551');
INSERT INTO `oauth_access_tokens` VALUES ('iamming', '2', '1453965551');

-- ----------------------------
-- Table structure for oauth_auth_code_scopes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_code_scopes`;
CREATE TABLE `oauth_auth_code_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_code` varchar(64) NOT NULL,
  `scope` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_code` (`auth_code`),
  KEY `scope` (`scope`),
  CONSTRAINT `oauth_auth_code_scopes_ibfk_1` FOREIGN KEY (`auth_code`) REFERENCES `oauth_auth_codes` (`auth_code`) ON DELETE CASCADE,
  CONSTRAINT `oauth_auth_code_scopes_ibfk_2` FOREIGN KEY (`scope`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_auth_code_scopes
-- ----------------------------
INSERT INTO `oauth_auth_code_scopes` VALUES ('1', 'gYUnc74tEf9AjsWedNgp1qfJE3m897t9F9B3JTFc', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('2', 'sLbmsZiFB4HR3ylTKFZWNtN1RSIW5WFUZbGY6xP3', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('3', 'VKrhrIHvMkBH1NtoEfSpPxFsJYKzZdeyKpdlkQSh', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('4', 'lLXQKLsJlLTsRjzSliApz5oXk24lyfAHgPMxHGUt', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('5', 'xK0zgdO0rd9NoiPcXTqCeu9fbTMJFw9hfhNjHODL', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('6', '7bu2XbMO4qrWgmHlUfBAArJ9RMsCbFXmQYsMcV9X', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('7', 'aRN87Iq7xAp06z2oXfjux6Yh57dJDIgjKs2Bk2pu', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('8', 'DUDXGcfqxB0HQyGHiLgoN0mvIXOyCQcmcE9nsahV', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('9', 'HmNJVtf0DWz4ZR1VzTmg20CU5czbKAv19WjegwCR', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('10', 'uRlOmOOjREpP9ZLApPT0o5PClMmS4U9xxHly7fSI', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('11', 'F5aUttA4gT5u73IvbsKvLc5hgsrqvXhNeRE11VkP', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('12', 'kQzTwFq4yZsDmUHBLYYOvzci3fcy5ErTZceIrkaW', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('13', 'LwXBGcQNSKDlPwk5OUNn01gvjtQe4ZzTYQeaQlnW', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('14', 'EuFSKtEGDxDJesUslt2X4WerFONZ1LqXvpuzxw0S', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('15', '8U6FJrInuRnggqtrTvXw1ZhuB4wi5BJ5TdGBcflI', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('16', 'ggP1uFpPpeLZbEW6s5j0GHK1rgLDUEidIZckeOsY', 'basic');
INSERT INTO `oauth_auth_code_scopes` VALUES ('17', 'zbuqZdxHc435gyvKIvyt8Ayc6LfnYpLGwJ9XRHz1', 'basic');

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `auth_code` varchar(64) NOT NULL,
  `session_id` int(11) NOT NULL,
  `expire_time` int(11) NOT NULL,
  `client_redirect_uri` varchar(255) NOT NULL,
  PRIMARY KEY (`auth_code`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `oauth_auth_codes_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_auth_codes
-- ----------------------------
INSERT INTO `oauth_auth_codes` VALUES ('7bu2XbMO4qrWgmHlUfBAArJ9RMsCbFXmQYsMcV9X', '111', '1453952420', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('8U6FJrInuRnggqtrTvXw1ZhuB4wi5BJ5TdGBcflI', '120', '1454136803', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('aRN87Iq7xAp06z2oXfjux6Yh57dJDIgjKs2Bk2pu', '112', '1453952497', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('DUDXGcfqxB0HQyGHiLgoN0mvIXOyCQcmcE9nsahV', '113', '1453952509', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('EuFSKtEGDxDJesUslt2X4WerFONZ1LqXvpuzxw0S', '119', '1454136803', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('F5aUttA4gT5u73IvbsKvLc5hgsrqvXhNeRE11VkP', '116', '1453953374', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('ggP1uFpPpeLZbEW6s5j0GHK1rgLDUEidIZckeOsY', '121', '1454463993', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('gYUnc74tEf9AjsWedNgp1qfJE3m897t9F9B3JTFc', '106', '1453951445', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('HmNJVtf0DWz4ZR1VzTmg20CU5czbKAv19WjegwCR', '114', '1453952558', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('kQzTwFq4yZsDmUHBLYYOvzci3fcy5ErTZceIrkaW', '117', '1453977531', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('lLXQKLsJlLTsRjzSliApz5oXk24lyfAHgPMxHGUt', '109', '1453951835', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('LwXBGcQNSKDlPwk5OUNn01gvjtQe4ZzTYQeaQlnW', '118', '1454032168', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('sLbmsZiFB4HR3ylTKFZWNtN1RSIW5WFUZbGY6xP3', '107', '1453951804', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('uRlOmOOjREpP9ZLApPT0o5PClMmS4U9xxHly7fSI', '115', '1453952562', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('VKrhrIHvMkBH1NtoEfSpPxFsJYKzZdeyKpdlkQSh', '108', '1453951829', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('xK0zgdO0rd9NoiPcXTqCeu9fbTMJFw9hfhNjHODL', '110', '1453951845', 'http://localhost/redirect');
INSERT INTO `oauth_auth_codes` VALUES ('zbuqZdxHc435gyvKIvyt8Ayc6LfnYpLGwJ9XRHz1', '122', '1454474555', 'http://localhost/redirect');

-- ----------------------------
-- Table structure for oauth_client_redirect_uris
-- ----------------------------
DROP TABLE IF EXISTS `oauth_client_redirect_uris`;
CREATE TABLE `oauth_client_redirect_uris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) NOT NULL,
  `redirect_uri` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_client_redirect_uris
-- ----------------------------
INSERT INTO `oauth_client_redirect_uris` VALUES ('1', 'client', 'http://localhost/redirect');

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` varchar(64) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------
INSERT INTO `oauth_clients` VALUES ('client', 'secret', 'client');

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(64) NOT NULL,
  `expire_time` int(11) NOT NULL,
  `access_token` varchar(64) NOT NULL,
  PRIMARY KEY (`refresh_token`),
  KEY `access_token` (`access_token`),
  CONSTRAINT `oauth_refresh_tokens_ibfk_1` FOREIGN KEY (`access_token`) REFERENCES `oauth_access_tokens` (`access_token`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_refresh_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for oauth_scopes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_scopes`;
CREATE TABLE `oauth_scopes` (
  `id` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_scopes
-- ----------------------------
INSERT INTO `oauth_scopes` VALUES ('basic', 'Basic details about your account');
INSERT INTO `oauth_scopes` VALUES ('email', 'Your email address');
INSERT INTO `oauth_scopes` VALUES ('photo', 'Your photo');

-- ----------------------------
-- Table structure for oauth_session_scopes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_session_scopes`;
CREATE TABLE `oauth_session_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `scope` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `scope` (`scope`),
  CONSTRAINT `oauth_session_scopes_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_session_scopes_ibfk_2` FOREIGN KEY (`scope`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_session_scopes
-- ----------------------------
INSERT INTO `oauth_session_scopes` VALUES ('1', '106', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('2', '107', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('3', '108', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('4', '109', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('5', '110', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('6', '111', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('7', '112', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('8', '113', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('9', '114', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('10', '115', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('11', '116', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('12', '117', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('13', '118', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('14', '119', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('15', '120', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('16', '121', 'basic');
INSERT INTO `oauth_session_scopes` VALUES ('17', '122', 'basic');

-- ----------------------------
-- Table structure for oauth_sessions
-- ----------------------------
DROP TABLE IF EXISTS `oauth_sessions`;
CREATE TABLE `oauth_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_type` varchar(255) NOT NULL,
  `owner_id` varchar(255) NOT NULL,
  `client_id` varchar(64) NOT NULL,
  `client_redirect_uri` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `oauth_sessions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of oauth_sessions
-- ----------------------------
INSERT INTO `oauth_sessions` VALUES ('1', 'client', 'client', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('2', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('3', 'user', '2', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('96', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('97', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('98', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('99', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('100', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('101', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('102', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('103', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('104', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('105', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('106', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('107', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('108', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('109', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('110', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('111', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('112', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('113', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('114', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('115', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('116', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('117', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('118', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('119', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('120', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('121', 'user', '1', 'client', '');
INSERT INTO `oauth_sessions` VALUES ('122', 'user', '1', 'client', '');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `ip` char(32) NOT NULL,
  `type` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `createtime` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type`) REFERENCES `user_type` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`type`) REFERENCES `user_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'xiaoming', '$2y$10$zfVJUP6oErCxlCPK83SFxOVZjh/M6ETHWtuK2CNdcMkqz8gyIH.Je', '小明', 'xiaoming@qq.com', 'user.png', '', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `users` VALUES ('2', 'xiaohong', '$2y$10$kukPu0Hn5tB7TdL81NA6HeB0Oqh7kpdRHZFuJ/6GZBZHkK7XG1bvu', '小红', 'xiaohong@qq.com', 'avatar3.png', '', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `users` VALUES ('5', 'xiaowang', '$2y$10$s0.lt4JoDZIwXSuA.wVJo.W/76HQyhuDDxTtt64uBo/IyKTdx9y.K', '小王', 'xiaowang@qq.com', '', '0.0.0.0', '0', '1', '0000-00-00 00:00:00');
