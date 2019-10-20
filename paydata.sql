/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : paydata

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-10-20 15:51:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for activity
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `activity_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_name` char(20) DEFAULT '' COMMENT '活动名',
  `activity_money` char(15) DEFAULT '' COMMENT '活动金额',
  `activity_status` tinyint(7) DEFAULT '1' COMMENT '1 开启 2 关闭',
  `desc` varchar(255) DEFAULT '' COMMENT '描述',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity
-- ----------------------------
INSERT INTO `activity` VALUES ('22', '神秘彩金', '38', '1', null, '2019-10-18 19:32:26', null, '2019-10-18 19:32:26');
INSERT INTO `activity` VALUES ('23', '注册彩金', '33', '1', null, '2019-10-18 19:32:43', null, '2019-10-18 19:32:43');
INSERT INTO `activity` VALUES ('24', 'vip彩金疯狂送', '58', '1', null, '2019-10-18 19:33:11', null, '2019-10-18 19:33:11');
INSERT INTO `activity` VALUES ('25', 'YY彩金', '88', '1', null, '2019-10-18 20:39:38', null, '2019-10-19 12:49:12');

-- ----------------------------
-- Table structure for apply
-- ----------------------------
DROP TABLE IF EXISTS `apply`;
CREATE TABLE `apply` (
  `apply_id` bigint(20) NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `platform_id` int(11) NOT NULL DEFAULT '0',
  `activity_id` int(11) NOT NULL DEFAULT '0',
  `is_success` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `apply_3_phone_platform_id_index` (`phone`,`platform_id`)
) ENGINE=MRG_MyISAM DEFAULT CHARSET=utf8mb4 UNION=(`apply_1`,`apply_3`);

-- ----------------------------
-- Records of apply
-- ----------------------------
INSERT INTO `apply` VALUES ('331', '15684698987', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('332', '15684698988', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('333', '15684698989', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('334', '15684698990', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('335', '15684698991', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('336', '15684698992', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('337', '15684698993', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('338', '15684698994', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('339', '15684698995', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('340', '15684698996', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply` VALUES ('301', '15684698987', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('302', '15684698988', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('303', '15684698989', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('304', '15684698990', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('305', '15684698991', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('306', '15684698992', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('307', '15684698993', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('308', '15684698994', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('309', '15684698995', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply` VALUES ('310', '15684698996', '', '3', '3', '0', '2019-10-17 17:07:05', null);

-- ----------------------------
-- Table structure for apply_1
-- ----------------------------
DROP TABLE IF EXISTS `apply_1`;
CREATE TABLE `apply_1` (
  `apply_id` bigint(20) NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `platform_id` int(11) NOT NULL DEFAULT '0',
  `activity_id` int(11) NOT NULL DEFAULT '0',
  `is_success` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `apply_1_phone_platform_id_index` (`phone`,`platform_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of apply_1
-- ----------------------------
INSERT INTO `apply_1` VALUES ('331', '15684698987', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('332', '15684698988', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('333', '15684698989', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('334', '15684698990', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('335', '15684698991', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('336', '15684698992', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('337', '15684698993', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('338', '15684698994', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('339', '15684698995', '', '1', '9', '0', '2019-10-17 17:08:44', null);
INSERT INTO `apply_1` VALUES ('340', '15684698996', '', '1', '9', '0', '2019-10-17 17:08:44', null);

-- ----------------------------
-- Table structure for apply_3
-- ----------------------------
DROP TABLE IF EXISTS `apply_3`;
CREATE TABLE `apply_3` (
  `apply_id` bigint(20) NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `platform_id` int(11) NOT NULL DEFAULT '0',
  `activity_id` int(11) NOT NULL DEFAULT '0',
  `is_success` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `apply_3_phone_platform_id_index` (`phone`,`platform_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of apply_3
-- ----------------------------
INSERT INTO `apply_3` VALUES ('301', '15684698987', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('302', '15684698988', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('303', '15684698989', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('304', '15684698990', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('305', '15684698991', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('306', '15684698992', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('307', '15684698993', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('308', '15684698994', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('309', '15684698995', '', '3', '3', '0', '2019-10-17 17:07:05', null);
INSERT INTO `apply_3` VALUES ('310', '15684698996', '', '3', '3', '0', '2019-10-17 17:07:05', null);

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `bank_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bankCode` char(20) DEFAULT '' COMMENT '银行编码',
  `bankAccountNo` char(50) DEFAULT '' COMMENT '银行账号',
  `bankAccountName` char(8) DEFAULT '' COMMENT '持卡人名字',
  `bank_status` tinyint(7) DEFAULT '0' COMMENT '1启用 2停用',
  `remarks` varchar(255) DEFAULT '' COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bank_id`),
  UNIQUE KEY `bankAccountNo` (`bankAccountNo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES ('10', 'ABC', '6228430779542075379', '刘文山', '1', '凯凯给的测试使用-下发卡', '2019-08-28 16:20:09', null, '2019-08-30 13:11:41');
INSERT INTO `bank` VALUES ('11', 'CCB', '6236682830006225253', '汪世勇', '1', '凯凯提供的下发银行卡信息', '2019-08-30 13:12:37', null, '2019-08-30 13:12:53');
INSERT INTO `bank` VALUES ('12', 'CCB', '6217001830039778306', '王尚华', '1', '凯凯提供下发银行卡信息', '2019-08-30 13:13:22', null, null);

-- ----------------------------
-- Table structure for empty
-- ----------------------------
DROP TABLE IF EXISTS `empty`;
CREATE TABLE `empty` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empty
-- ----------------------------

-- ----------------------------
-- Table structure for handsel
-- ----------------------------
DROP TABLE IF EXISTS `handsel`;
CREATE TABLE `handsel` (
  `handsel_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(150) DEFAULT '' COMMENT 'md5加密',
  `username` varchar(50) DEFAULT '' COMMENT '会员账号',
  `phone` char(12) DEFAULT '' COMMENT '手机号码',
  `type` int(11) DEFAULT '0' COMMENT '彩金金额,,easyswoole 添加一个配置',
  `status` tinyint(7) DEFAULT '0' COMMENT '活动状态 1,申请中 2,',
  `platform_id` int(11) DEFAULT '0' COMMENT '平台id',
  `desc` varchar(255) DEFAULT '' COMMENT '错误信息',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`handsel_id`),
  KEY `phone` (`phone`,`platform_id`) USING BTREE,
  KEY `order_no` (`order_no`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of handsel
-- ----------------------------
INSERT INTO `handsel` VALUES ('1', null, 'qwe123', '15836020238', '1', '1', '1', '手动补单', '2019-10-02 21:13:10', null, '2019-10-07 12:10:36');
INSERT INTO `handsel` VALUES ('2', null, 'qweasd', '15836020237', '1', '2', '2', '123123123', '2019-10-02 21:13:12', null, '2019-10-07 12:11:16');
INSERT INTO `handsel` VALUES ('3', null, 'qwe111', '1583602021', '1', '3', '3', '', '2019-10-02 21:13:16', null, null);
INSERT INTO `handsel` VALUES ('4', null, 'qwe222', '1583602023', '1', '4', '4', '12312qweqwe', '2019-10-02 21:13:18', null, '2019-10-16 13:00:34');

-- ----------------------------
-- Table structure for handsel_
-- ----------------------------
DROP TABLE IF EXISTS `handsel_`;
CREATE TABLE `handsel_` (
  `handsel_id` bigint(20) NOT NULL,
  `order_no` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `platform_id` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `handsel_1_phone_platform_id_index` (`phone`,`platform_id`),
  KEY `handsel_1_order_no_index` (`order_no`),
  KEY `handsel_1_username_index` (`username`)
) ENGINE=MRG_MyISAM DEFAULT CHARSET=utf8mb4 UNION=(`handsel_1`,`handsel_3`);

-- ----------------------------
-- Records of handsel_
-- ----------------------------
INSERT INTO `handsel_` VALUES ('1', '123123', '123123', '123123', '3', '0', '1', '', null, null);
INSERT INTO `handsel_` VALUES ('2', '123123', '123123', '12312312', '5', '0', '3', '', null, null);
INSERT INTO `handsel_` VALUES ('3', '23423', '234', '23412', '5', '0', '3', '', null, null);

-- ----------------------------
-- Table structure for handsel_1
-- ----------------------------
DROP TABLE IF EXISTS `handsel_1`;
CREATE TABLE `handsel_1` (
  `handsel_id` bigint(20) NOT NULL,
  `order_no` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `platform_id` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `handsel_1_phone_platform_id_index` (`phone`,`platform_id`),
  KEY `handsel_1_order_no_index` (`order_no`),
  KEY `handsel_1_username_index` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of handsel_1
-- ----------------------------
INSERT INTO `handsel_1` VALUES ('1', '123123', '123123', '123123', '3', '0', '1', '', null, null);

-- ----------------------------
-- Table structure for handsel_3
-- ----------------------------
DROP TABLE IF EXISTS `handsel_3`;
CREATE TABLE `handsel_3` (
  `handsel_id` bigint(20) NOT NULL,
  `order_no` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `platform_id` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `handsel_3_phone_platform_id_index` (`phone`,`platform_id`),
  KEY `handsel_3_order_no_index` (`order_no`),
  KEY `handsel_3_username_index` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of handsel_3
-- ----------------------------
INSERT INTO `handsel_3` VALUES ('2', '123123', '123123', '12312312', '5', '0', '3', '', null, null);
INSERT INTO `handsel_3` VALUES ('3', '23423', '234', '23412', '5', '0', '3', '', null, null);

-- ----------------------------
-- Table structure for manager
-- ----------------------------
DROP TABLE IF EXISTS `manager`;
CREATE TABLE `manager` (
  `mg_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mg_name` char(20) DEFAULT '' COMMENT '管理员名称',
  `password` char(100) DEFAULT '' COMMENT '哈希加密密码',
  `mg_status` tinyint(7) DEFAULT '1' COMMENT '1启用 2停用',
  `mg_email` char(100) DEFAULT '' COMMENT '邮箱',
  `login_count` int(7) DEFAULT '0' COMMENT '管理员登陆次数',
  `last_login_time` timestamp NULL DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` char(20) DEFAULT '' COMMENT '最后登录ip',
  `google_token` varchar(255) DEFAULT '',
  `session_id` char(150) DEFAULT '' COMMENT 'session_id',
  `is_send_email` tinyint(7) DEFAULT '2' COMMENT '1 发送 2,不发送',
  `platform_id` int(11) DEFAULT '0' COMMENT '平台id',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mg_id`),
  UNIQUE KEY `name_email` (`mg_name`,`mg_email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manager
-- ----------------------------
INSERT INTO `manager` VALUES ('1', 'root', '$2y$10$uS/u1NRvCw1L0IUMwaXS3ebnzgWkQ62LRv3wPVUbStUl2XTAq6VJy', '1', '15836020218@163.com', '93', '2019-10-20 13:37:00', '127.0.0.1', 'UXBZ25OJ7DJPJDF7NQ7D5UP4P3UVSTRATOB27S4XW5P5EP33SWIMTMHCFHCFSDAB', 'kDnwPAmpLxK7uVqqJeepK68jY6Z6G2VNocBmGpuc', '1', null, '2019-08-16 15:53:35', null, '2019-10-20 13:37:00');
INSERT INTO `manager` VALUES ('10', 'TianChao1', '$2y$10$2RSJFgwHfVrVh.oO.0ltROiH/DLk3VSSFLH1SztzL5eOzn40qL8ZO', '1', '15836020238@163.com', '29', '2019-10-20 13:39:12', '127.0.0.1', '', 'SRLNy7W4ccZxf3vaiueqMFe70yypfALhquYxR0cq', '1', '33', '2019-08-18 13:47:13', null, '2019-10-20 13:39:12');
INSERT INTO `manager` VALUES ('13', 'TianChao3', '$2y$10$LkjyTuKzJCRm4g9i7p6HYOIhjAABTEi7G9/VptuTYhFWmoKn0jsFu', '1', '158360202311@163.com', '11', '2019-10-20 13:38:34', '127.0.0.1', '', '0qVLQE9Anh4SILXhlkNde0QnMUteupMXMJRCPewk', '1', '34', '2019-08-18 13:48:51', null, '2019-10-20 13:38:35');
INSERT INTO `manager` VALUES ('14', 'ezn', '$2y$10$qr58.sBtSa68BedLMHLdfe5AAsvwYafHf/XrW6dp4hzju48JyLqUu', '1', '15836020238@163.com', '0', null, '', '', '', '1', '35', '2019-10-16 14:17:21', null, '2019-10-18 19:38:58');

-- ----------------------------
-- Table structure for manager_role
-- ----------------------------
DROP TABLE IF EXISTS `manager_role`;
CREATE TABLE `manager_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mg_id` int(11) DEFAULT NULL COMMENT '管理员id',
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manager_role
-- ----------------------------
INSERT INTO `manager_role` VALUES ('8', '10', '2', null, '2019-08-18 13:47:13', '2019-08-18 13:47:13');
INSERT INTO `manager_role` VALUES ('16', '1', '2', null, '2019-08-26 19:04:07', '2019-08-26 19:04:07');
INSERT INTO `manager_role` VALUES ('17', '1', '3', null, '2019-08-26 19:04:07', '2019-08-26 19:04:07');
INSERT INTO `manager_role` VALUES ('20', '13', '2', null, '2019-10-16 20:40:21', '2019-10-16 20:40:21');
INSERT INTO `manager_role` VALUES ('21', '14', '3', null, '2019-10-16 20:40:30', '2019-10-16 20:40:30');

-- ----------------------------
-- Table structure for merchant
-- ----------------------------
DROP TABLE IF EXISTS `merchant`;
CREATE TABLE `merchant` (
  `mer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mer_name` char(20) NOT NULL DEFAULT '' COMMENT '商户名称',
  `merchant_id` char(30) DEFAULT '' COMMENT '商户编号 merId',
  `remit_public_key` text COMMENT '代付商户分配公钥',
  `remit_private_key` text COMMENT '代付商户分配私钥',
  `sign` char(50) DEFAULT '' COMMENT '代付商户md5加密字符串',
  `version` char(7) DEFAULT '1.1' COMMENT '版本号 1.1',
  `mer_status` tinyint(7) DEFAULT '1' COMMENT '1,启用 2,停用',
  `desc` varchar(255) DEFAULT '' COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of merchant
-- ----------------------------
INSERT INTO `merchant` VALUES ('2', '亨鑫-21910208-辉煌', '21910208', '-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDKjbWFwVU7vfyld9hd7RGEMwVvT1ZtiEXk+uXWRFI7as279Z8zSwt278O4R9PPxyIf7jriNPzPIJzGVsh1081fIPIornY1F+VM5lcZ1CpgBVkVwp/YVAyoILLZsLwP+l8QY5COtWcWwm9m7nnTlspFnAWHlXTkG/9xexpjqYGH6QIDAQAB\n-----END PUBLIC KEY-----', '-----BEGIN RSA PRIVATE KEY-----\nMIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAKQL4FauLquemFz6mFt7+Rzh0NY7QO+mWuBUsXSQaRlRTsNv8h7TCkhk2PCshOF9BRmKob793t03jHl6P06GnL2hsw4Qth01M6ulZwwfyYAq95+s3Jo/+lyjkSvfPJChlMp9mkZjocLGly71A5ul1EQIejL1xntz3n9CU/jnQ3lbAgMBAAECgYBCcfEHCvwqVU2fc30cqQVI1opRC6UMrJPog0VxUkDPmWhOrtwh8hcbJYXdTfNwpcPYCZfkFU4cyjAi0AouU0XOvVoYtnErYpJR1Ulz+yousd3LAUaSdk10s4z0a52eqpuGAKup7GPB+bc0W8LPmhMuy2JXOON+W1A7uz3WDTKn0QJBAO9QJtXEO2UIFZSNk5LQJ7w3ZRAnyClF5zFNAZIhK40RvqDk4HBNQ7kX/7ndOBpMnZK0TqMXH1/q9LTmW6oF6+kCQQCvfC32u+WJyota6aQslxztvQdETclkGUvhchSioS7vv0RppjQF42DX2HLa6SzEqbu/oB7A94X7pIv5pc6WVaSjAkEAlgZcYjSju4Gm7bsXobkmv+LGU6ts2xr8hbat3ms2/zf5lqoFXcHCS/4UjfN2IV6YhgjNJ4buX1ZPVDz5iAwwSQJAfYfmVWbJ50ylbU5PK7qZbhNXfGvskZdq6YWy7zdAHS6EYNMMyd2CrETgvGoqpTAJ5yVCeqVWCdIGc3pBktcG4wJBANNMCu4s6N892VCCTvfPq4x6vrnOlRL4kv/DGTORpHUZ5K2P3yEdRwm4X4viAvVwbB3TwmWGxTn/kb4aelxYoKA=\n-----END RSA PRIVATE KEY-----', '56cd5e494bd4435b929c2268d607f197', '1.1', '1', '亨鑫-21910206-开心彩', '2019-09-01 20:02:04', '2019-09-03 15:48:13', null);
INSERT INTO `merchant` VALUES ('3', '亨鑫-21910206-开心彩', '21910206', '-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCAmWUMwpOTGi7v6bI13RtKtR2afitKHsDote7JfTGVNB0mh9VrFXjnqp1ddRgUSjWFBCUExUIVCzheK9bE1ElZfhXzLUC7l6QllbdXuEqFa7leldarh2alzN8iyGu7dLdc6v5DyhfhF1l0yEfgZ32qfzBXG+RZxTuNGUDTV8EYLwIDAQAB\n-----END PUBLIC KEY-----', '-----BEGIN RSA PRIVATE KEY-----\nMIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAIkFjOlEXojkT4srQNgKVTJPlmcVX7l7RFav2xa0b00noDWxbjVzWqLiM5r2oHPT/i2Wad5ASvbn4RczBMD63HVVbPJqYrBu1SWdML52bbElngMsXeTNXimkiFZbzEvn+u+pY/c321ntL5P+j4Y9zuUIltk+9t/820bzQD7Bv/YrAgMBAAECgYAYjcYShw3pugAHEFkuXaumuFxbXJkqw8wbPKgmCW9ohBFRjdoR+fnj9mUI/+kA2JxTzwBps1u7oxHS9nGDo3Cd0tznk0M7o2tHCb/8SPx3f+7hiObRJbPX8wAVrVhAn32OlO4UGboIFpV1ZDYVuq3K1qNWj/kHgz1NKVyYpz9SAQJBAMSexcPaldNJsuEYmBOUdu0f2bcoepcNL0m2E7e8ZtEuO9Hp7h1UGtn4ec3Pf5nyfPAqfa0JDCC6iWk3ANrAroMCQQCyZw8AR5rPtcVI2IqjLlFRdyeLWR6ap4ZppLsGHNgEAWjNFhbiapt8mTILh6gbEJo45iQK9mI9rfwsWh0Ip4k5AkA0mHA4mvE3KuDB2+1aV32Uos9/ckGQxIMgyabuoGQ0kpSH63a5u7TPF+ulRVtR2A7Zw9QIhIINAzkcvwzod2B3AkEAok/VfCGpnhT421/4MqLvZTkNh2Cb0YVdazxu1A7mEi7eFMlmJLVtpZ0TxR21OnqOdfodDMRBeXCUIB4UkE0tMQJAJZIgI6sBw8Zoxff48R35PrKZ5sALPShwXf2nUq98cevMF93dLg4WBz9EYX6HsChtgqW7rXsltdEYWfUKZCxSHg==\n-----END RSA PRIVATE KEY-----', 'bfcb423439d16760d5e3c8ae65eea5f4', '1.1', '1', '亨鑫-21910206-开心彩', '2019-09-01 20:02:59', '2019-09-03 20:04:43', null);

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `merOrderNo` varchar(64) DEFAULT '' COMMENT '下发订单号',
  `amount` decimal(12,2) DEFAULT NULL COMMENT '下发金额',
  `remarks` varchar(255) DEFAULT '' COMMENT '备注',
  `operator` char(20) DEFAULT '' COMMENT '操作人',
  `bank_info` varchar(255) DEFAULT '' COMMENT '银行信息json',
  `merchant_id` tinyint(11) DEFAULT '0' COMMENT '下发给商户id',
  `order_status` tinyint(7) DEFAULT '0' COMMENT '订单状态 ,1下发提交, 2维护中 3,下发成功 4,下发失败, 5,24小时无处理(失效过期) 6,下发处理中',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('33', '2019090416241057957855', '2.00', '及时备注', '1', '{\"bankCode\":\"ABC\",\"bankAccountNo\":\"6228430779542075379\",\"bankAccountName\":\"刘文山\",\"mer_name\":\"亨鑫-21910208-辉煌\"}', '2', '1', '2019-09-04 16:24:10', '2019-09-04 16:24:10', null);
INSERT INTO `order` VALUES ('34', '2019090416241858668389', '2.00', '及时备注', '1', '{\"bankCode\":\"CCB\",\"bankAccountNo\":\"6236682830006225253\",\"bankAccountName\":\"汪世勇\",\"mer_name\":\"亨鑫-21910206-开心彩\"}', '3', '1', '2019-09-04 16:24:18', '2019-09-04 16:24:18', null);
INSERT INTO `order` VALUES ('35', '2019090416303823776877', '122.00', '及时备注', '1', '{\"bankCode\":\"ABC\",\"bankAccountNo\":\"6228430779542075379\",\"bankAccountName\":\"刘文山\",\"mer_name\":\"亨鑫-21910208-辉煌\"}', '2', '1', '2019-09-04 16:30:38', '2019-09-04 16:30:38', null);

-- ----------------------------
-- Table structure for platform
-- ----------------------------
DROP TABLE IF EXISTS `platform`;
CREATE TABLE `platform` (
  `platform_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pf_name` char(20) DEFAULT '' COMMENT '平台名称',
  `mark` char(15) DEFAULT '' COMMENT '平台标记',
  `token` varchar(255) DEFAULT '' COMMENT '令牌',
  `platform_status` tinyint(7) DEFAULT '1' COMMENT '1 启动 2 关闭',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`platform_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of platform
-- ----------------------------
INSERT INTO `platform` VALUES ('33', '天朝1棋牌', 'TianChao1', 'werqwerqrqwer2421421werqwer3424124qwerrtdsfgdsfg', '1', '2019-10-18 19:30:26', null, '2019-10-18 19:30:26');
INSERT INTO `platform` VALUES ('34', '天朝3棋牌', 'TianChao3', 'sdfasdfawerwerqwerqwerasdfsafsadf214123412431234', '1', '2019-10-18 19:31:03', null, '2019-10-18 19:31:03');
INSERT INTO `platform` VALUES ('35', '809棋牌', 'ezn', 'wrqwerqwer214321qwer213412qrqw454213', '1', '2019-10-18 19:31:43', null, '2019-10-18 19:31:43');

-- ----------------------------
-- Table structure for platform_activity
-- ----------------------------
DROP TABLE IF EXISTS `platform_activity`;
CREATE TABLE `platform_activity` (
  `platform_activity_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) DEFAULT '0' COMMENT '平台id',
  `activity_id` int(11) DEFAULT '0' COMMENT '活动id',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`platform_activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of platform_activity
-- ----------------------------
INSERT INTO `platform_activity` VALUES ('90', '35', '22', '2019-10-18 19:32:26', null, '2019-10-18 19:32:26');
INSERT INTO `platform_activity` VALUES ('91', '34', '22', '2019-10-18 19:32:26', null, '2019-10-18 19:32:26');
INSERT INTO `platform_activity` VALUES ('92', '33', '22', '2019-10-18 19:32:26', null, '2019-10-18 19:32:26');
INSERT INTO `platform_activity` VALUES ('93', '33', '23', '2019-10-18 19:32:43', null, '2019-10-18 19:32:43');
INSERT INTO `platform_activity` VALUES ('94', '35', '24', '2019-10-18 19:33:11', null, '2019-10-18 19:33:11');
INSERT INTO `platform_activity` VALUES ('95', '35', '25', '2019-10-18 20:39:38', null, '2019-10-18 20:39:38');
INSERT INTO `platform_activity` VALUES ('96', '34', '25', '2019-10-18 20:39:38', null, '2019-10-18 20:39:38');

-- ----------------------------
-- Table structure for recheck
-- ----------------------------
DROP TABLE IF EXISTS `recheck`;
CREATE TABLE `recheck` (
  `recheck_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT '0' COMMENT '下发订单',
  `merchant_id` tinyint(11) DEFAULT '0' COMMENT '商户id',
  `desc` varchar(255) DEFAULT '' COMMENT '复审信息',
  `recheck_status` tinyint(7) DEFAULT '2' COMMENT '复审状态 1,审核 2,无审核 3,第三方问题',
  `re_operator` char(20) DEFAULT '' COMMENT '复审人',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`recheck_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of recheck
-- ----------------------------
INSERT INTO `recheck` VALUES ('20', '33', '2', '', '2', '', '2019-09-04 16:24:10', null, null);
INSERT INTO `recheck` VALUES ('21', '34', '3', '', '2', '', '2019-09-04 16:24:18', null, null);
INSERT INTO `recheck` VALUES ('22', '35', '2', '', '2', '', '2019-09-04 16:30:38', null, null);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `r_name` char(100) NOT NULL DEFAULT '' COMMENT '角色名称',
  `role_status` tinyint(7) DEFAULT '1' COMMENT '1 启用 2停用',
  `remark` varchar(254) DEFAULT '' COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('2', '观察者', '1', '查看权限', '2019-08-15 08:47:32', '2019-10-15 13:25:49', null);
INSERT INTO `role` VALUES ('3', '执行者', '1', '操作权限', '2019-08-17 08:47:41', '2019-10-15 13:26:05', null);
INSERT INTO `role` VALUES ('4', '观察||执行者', '2', '观察执行权限', '2019-08-17 08:47:46', '2019-10-15 14:39:16', null);

-- ----------------------------
-- Table structure for role_rule
-- ----------------------------
DROP TABLE IF EXISTS `role_rule`;
CREATE TABLE `role_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `rule_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_rule
-- ----------------------------
INSERT INTO `role_rule` VALUES ('106', '3', '131', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('105', '3', '129', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('104', '3', '128', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('103', '3', '130', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('102', '3', '143', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('101', '3', '142', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('48', '3', '117', '2019-08-26 19:15:09', '2019-08-26 19:15:09', null);
INSERT INTO `role_rule` VALUES ('47', '3', '116', '2019-08-26 19:15:09', '2019-08-26 19:15:09', null);
INSERT INTO `role_rule` VALUES ('46', '3', '115', '2019-08-26 19:15:09', '2019-08-26 19:15:09', null);
INSERT INTO `role_rule` VALUES ('45', '3', '114', '2019-08-26 19:15:09', '2019-08-26 19:15:09', null);
INSERT INTO `role_rule` VALUES ('44', '3', '113', '2019-08-26 19:15:09', '2019-08-26 19:15:09', null);
INSERT INTO `role_rule` VALUES ('43', '3', '103', '2019-08-26 19:15:09', '2019-08-26 19:15:09', null);
INSERT INTO `role_rule` VALUES ('42', '3', '112', '2019-08-26 19:15:09', '2019-08-26 19:15:09', null);
INSERT INTO `role_rule` VALUES ('100', '3', '141', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('99', '3', '140', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('98', '3', '139', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('97', '3', '138', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('96', '3', '137', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('95', '3', '125', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('94', '3', '127', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('93', '3', '123', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('92', '3', '122', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('91', '3', '121', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('90', '3', '120', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('89', '3', '119', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('88', '3', '118', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('87', '3', '111', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('86', '3', '110', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('85', '3', '109', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('149', '2', '107', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('148', '2', '106', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('147', '2', '105', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('146', '2', '181', '2019-10-16 13:35:53', '2019-10-16 13:35:53', null);
INSERT INTO `role_rule` VALUES ('145', '2', '180', '2019-10-16 13:35:53', '2019-10-16 13:35:53', null);
INSERT INTO `role_rule` VALUES ('84', '3', '108', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('83', '3', '107', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('82', '3', '106', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('81', '3', '105', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('144', '2', '179', '2019-10-16 13:35:53', '2019-10-16 13:35:53', null);
INSERT INTO `role_rule` VALUES ('143', '2', '178', '2019-10-16 13:35:53', '2019-10-16 13:35:53', null);
INSERT INTO `role_rule` VALUES ('142', '2', '177', '2019-10-16 13:35:53', '2019-10-16 13:35:53', null);
INSERT INTO `role_rule` VALUES ('141', '2', '176', '2019-10-16 13:35:53', '2019-10-16 13:35:53', null);
INSERT INTO `role_rule` VALUES ('140', '2', '175', '2019-10-16 13:35:53', '2019-10-16 13:35:53', null);
INSERT INTO `role_rule` VALUES ('139', '2', '173', '2019-10-16 13:23:34', '2019-10-16 13:23:34', null);
INSERT INTO `role_rule` VALUES ('138', '2', '172', '2019-10-16 13:23:34', '2019-10-16 13:23:34', null);
INSERT INTO `role_rule` VALUES ('137', '2', '171', '2019-10-16 13:23:34', '2019-10-16 13:23:34', null);
INSERT INTO `role_rule` VALUES ('107', '3', '132', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('108', '3', '133', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('109', '3', '134', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('110', '3', '135', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('111', '3', '136', '2019-08-31 19:29:37', '2019-08-31 19:29:37', null);
INSERT INTO `role_rule` VALUES ('112', '3', '126', '2019-08-31 19:29:45', '2019-08-31 19:29:45', null);
INSERT INTO `role_rule` VALUES ('136', '2', '170', '2019-10-16 13:23:34', '2019-10-16 13:23:34', null);
INSERT INTO `role_rule` VALUES ('135', '2', '169', '2019-10-16 13:23:34', '2019-10-16 13:23:34', null);
INSERT INTO `role_rule` VALUES ('134', '2', '168', '2019-10-16 13:23:34', '2019-10-16 13:23:34', null);
INSERT INTO `role_rule` VALUES ('133', '2', '167', '2019-10-16 13:23:34', '2019-10-16 13:23:34', null);
INSERT INTO `role_rule` VALUES ('132', '2', '165', '2019-10-16 12:47:26', '2019-10-16 12:47:26', null);
INSERT INTO `role_rule` VALUES ('131', '2', '164', '2019-10-16 12:42:47', '2019-10-16 12:42:47', null);
INSERT INTO `role_rule` VALUES ('130', '2', '163', '2019-10-16 12:42:47', '2019-10-16 12:42:47', null);
INSERT INTO `role_rule` VALUES ('129', '2', '161', '2019-10-16 11:37:35', '2019-10-16 11:37:35', null);
INSERT INTO `role_rule` VALUES ('126', '2', '157', '2019-10-16 11:33:50', '2019-10-16 11:33:50', null);
INSERT INTO `role_rule` VALUES ('122', '3', '157', '2019-09-16 15:20:54', '2019-09-16 15:20:54', null);
INSERT INTO `role_rule` VALUES ('123', '3', '158', '2019-09-16 15:51:12', '2019-09-16 15:51:12', null);
INSERT INTO `role_rule` VALUES ('124', '3', '159', '2019-09-16 16:02:22', '2019-09-16 16:02:22', null);
INSERT INTO `role_rule` VALUES ('125', '3', '160', '2019-09-16 18:57:12', '2019-09-16 18:57:12', null);
INSERT INTO `role_rule` VALUES ('150', '2', '108', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('151', '2', '109', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('152', '2', '110', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('153', '2', '111', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('154', '2', '144', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('155', '2', '145', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('156', '2', '112', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('157', '2', '103', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('158', '2', '113', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('159', '2', '114', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('160', '2', '115', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('161', '2', '116', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('162', '2', '117', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('163', '2', '126', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('164', '2', '118', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('165', '2', '119', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('166', '2', '120', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('167', '2', '121', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('168', '2', '122', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('169', '2', '123', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('170', '2', '127', '2019-10-16 13:37:36', '2019-10-16 13:37:36', null);
INSERT INTO `role_rule` VALUES ('171', '2', '182', '2019-10-18 19:52:32', '2019-10-18 19:52:32', null);

-- ----------------------------
-- Table structure for rule
-- ----------------------------
DROP TABLE IF EXISTS `rule`;
CREATE TABLE `rule` (
  `rule_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rule_name` char(50) DEFAULT '' COMMENT '权限名称',
  `route` varchar(100) DEFAULT '' COMMENT '路由',
  `rule_c` varchar(50) DEFAULT '' COMMENT '控制器',
  `rule_a` varchar(50) DEFAULT '' COMMENT '方法',
  `level` tinyint(7) DEFAULT '0',
  `is_show` tinyint(7) DEFAULT '1' COMMENT '状态;1:显示,2:不显示',
  `is_verify` tinyint(7) DEFAULT '1' COMMENT '是否验证 1, 验证 2,不验证',
  `pid` int(11) DEFAULT NULL,
  `remark` char(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rule
-- ----------------------------
INSERT INTO `rule` VALUES ('100', 'RBAC管理', null, null, null, '0', '2', '2', '0', null, '2019-08-19 14:09:47', null, '2019-08-27 11:33:29');
INSERT INTO `rule` VALUES ('101', '下发管理', null, null, null, '0', '1', '1', '0', null, '2019-08-19 14:10:06', null, '2019-08-27 11:56:43');
INSERT INTO `rule` VALUES ('102', '订单审核', null, null, null, '0', '1', '1', '0', null, '2019-08-19 14:10:24', null, '2019-08-27 11:56:28');
INSERT INTO `rule` VALUES ('103', '创建角色', '/admin/role', 'role', 'store', '2', '1', '1', '112', '111', '2019-08-19 14:41:57', null, '2019-08-19 19:15:02');
INSERT INTO `rule` VALUES ('105', '管理员列表', '/admin/manager', 'manager', 'index', '1', '1', '1', '100', null, '2019-08-19 16:12:27', null, '2019-08-21 11:04:39');
INSERT INTO `rule` VALUES ('106', '创建管理员', '/admin/manager', 'manager', 'store', '2', '1', '1', '105', null, '2019-08-19 18:22:22', null, '2019-08-21 11:02:49');
INSERT INTO `rule` VALUES ('107', '创建管理员view', '/admin/manager/create', 'manager', 'create', '2', '1', '1', '105', null, '2019-08-19 18:23:24', null, '2019-08-19 19:12:38');
INSERT INTO `rule` VALUES ('108', '切换管理员状态', '/admin/manager/{manager}', 'manager', 'status', '2', '1', '1', '105', null, '2019-08-19 18:24:19', null, null);
INSERT INTO `rule` VALUES ('109', '删除管理员', '/admin/manager/{manager}', 'manager', 'destroy', '2', '1', '1', '105', '111', '2019-08-19 18:25:30', null, '2019-08-19 19:13:28');
INSERT INTO `rule` VALUES ('110', '更新管理员', '/admin/manager/{manager}', 'manager', 'update', '2', '1', '1', '105', null, '2019-08-19 18:39:54', null, null);
INSERT INTO `rule` VALUES ('111', '更新管理员view', '/admin/manager/{manager}/edit', 'manager', 'edit', '2', '1', '1', '105', null, '2019-08-19 18:40:37', null, null);
INSERT INTO `rule` VALUES ('112', '角色管理', '/admin/role', 'role', 'index', '1', '1', '1', '100', null, '2019-08-19 18:41:12', null, null);
INSERT INTO `rule` VALUES ('113', '创建角色view', '/admin/role/create', 'role', 'create', '2', '1', '1', '112', null, '2019-08-19 18:41:41', null, '2019-08-19 19:12:12');
INSERT INTO `rule` VALUES ('114', '切换角色状态', '/admin/role/{role}', 'role', 'status', '2', '1', '1', '112', null, '2019-08-19 19:16:07', null, null);
INSERT INTO `rule` VALUES ('115', '更新角色', '/admin/role/{role}', 'role', 'update', '2', '1', '1', '112', null, '2019-08-19 19:16:42', null, null);
INSERT INTO `rule` VALUES ('116', '更新角色view', '/admin/role/{role}/edit', 'role', 'edit', '2', '1', '1', '112', null, '2019-08-19 19:17:24', null, null);
INSERT INTO `rule` VALUES ('117', '删除角色', '/admin/role/{role}', 'role', 'destroy', '2', '1', '1', '112', null, '2019-08-19 19:18:09', null, null);
INSERT INTO `rule` VALUES ('118', '权限管理', '/admin/rule', 'rule', 'index', '1', '1', '1', '100', null, '2019-08-19 19:27:28', null, null);
INSERT INTO `rule` VALUES ('119', '创建权限', '/admin/rule', 'rule', 'store', '2', '1', '1', '118', null, '2019-08-19 19:28:01', null, null);
INSERT INTO `rule` VALUES ('120', '创建权限view', '/admin/rule/create', 'rule', 'create', '2', '1', '1', '118', null, '2019-08-19 19:28:36', null, null);
INSERT INTO `rule` VALUES ('121', '更新权限', '/admin/rule/{rule}', 'rule', 'update', '2', '1', '1', '118', null, '2019-08-19 19:29:30', null, null);
INSERT INTO `rule` VALUES ('122', '更新权限view', '/admin/rule/{rule}/edit', 'rule', 'edit', '2', '1', '1', '118', null, '2019-08-19 19:29:57', null, null);
INSERT INTO `rule` VALUES ('123', '删除权限', '/admin/rule/{rule}', 'rule', 'destroy', '2', '1', '1', '118', null, '2019-08-19 19:34:40', null, null);
INSERT INTO `rule` VALUES ('124', '银行管理', null, null, null, '0', '1', '1', '0', null, '2019-08-26 19:42:13', null, null);
INSERT INTO `rule` VALUES ('125', '银行列表', '/admin/bank', 'bank', 'index', '1', '1', '1', '124', null, '2019-08-26 19:43:25', null, '2019-08-27 11:32:47');
INSERT INTO `rule` VALUES ('126', '角色分配权限', '/admin/role/{role}/assign', 'role', 'assign', '2', '1', '1', '112', null, '2019-08-27 11:43:40', null, null);
INSERT INTO `rule` VALUES ('127', '切换状态权限', '/admin/rule/switch/{param}', 'rule', 'switch', '2', '1', '1', '118', null, '2019-08-27 11:44:52', null, null);
INSERT INTO `rule` VALUES ('128', '查看审核订单详情', '/admin/order/recheck/{id}', 'order', 'recheck', '2', '1', '1', '130', null, '2019-08-27 11:45:56', null, '2019-08-27 11:50:25');
INSERT INTO `rule` VALUES ('129', '查看下发订单详情', '/admin/order/check/{id}', 'order', 'check', '2', '1', '1', '130', null, '2019-08-27 11:46:33', null, '2019-08-27 11:50:33');
INSERT INTO `rule` VALUES ('130', '订单列表', '/admin/order', 'order', 'index', '1', '1', '1', '101', null, '2019-08-27 11:49:10', null, null);
INSERT INTO `rule` VALUES ('131', '提交下发订单view', '/admin/order/create', 'order', 'create', '2', '1', '1', '130', null, '2019-08-27 11:52:27', null, '2019-08-27 11:59:00');
INSERT INTO `rule` VALUES ('132', '提交下发订单', '/admin/order', 'order', 'store', '2', '1', '1', '130', null, '2019-08-27 11:53:33', null, null);
INSERT INTO `rule` VALUES ('133', '审核列表', '/admin/recheck', 'recheck', 'index', '1', '1', '1', '102', null, '2019-08-27 11:57:52', null, null);
INSERT INTO `rule` VALUES ('134', '确认下发view', '/admin/recheck/{recheck}', 'recheck', 'show', '2', '1', '1', '133', null, '2019-08-27 11:59:37', null, null);
INSERT INTO `rule` VALUES ('135', '请求下发接口', '/admin/recheck/{recheck}', 'recheck', 'update', '2', '1', '1', '133', null, '2019-08-27 12:00:34', null, null);
INSERT INTO `rule` VALUES ('136', '审核未处理提醒', '/admin/recheck/notice', 'recheck', 'notice', '2', '1', '1', '133', null, '2019-08-27 12:01:16', null, null);
INSERT INTO `rule` VALUES ('137', '创建银行信息view', '/admin/bank/create', 'bank', 'create', '2', '1', '1', '125', null, '2019-08-27 12:08:33', null, null);
INSERT INTO `rule` VALUES ('138', '创建银行信息', '/admin/bank', 'bank', 'store', '2', '1', '1', '125', null, '2019-08-27 12:09:02', null, null);
INSERT INTO `rule` VALUES ('139', '获取到指定银行信息', '/admin/bank/getOne/{bank}', 'bank', 'getOne', '2', '1', '1', '125', null, '2019-08-27 12:09:31', null, null);
INSERT INTO `rule` VALUES ('140', '切换银行状态', '/admin/bank/{bank}', 'bank', 'show', '2', '1', '1', '125', null, '2019-08-27 12:10:10', null, null);
INSERT INTO `rule` VALUES ('141', '删除银行信息', '/admin/bank/{bank}', 'bank', 'destroy', '2', '1', '1', '125', null, '2019-08-27 12:10:42', null, null);
INSERT INTO `rule` VALUES ('142', '更新银行信息', '/admin/bank/{bank}', 'bank', 'update', '2', '1', '1', '125', null, '2019-08-27 12:11:09', null, null);
INSERT INTO `rule` VALUES ('143', '更新银行信息view', '/admin/bank/{bank}/edit', 'bank', 'edit', '2', '1', '1', '125', null, '2019-08-27 12:11:43', null, null);
INSERT INTO `rule` VALUES ('144', '重绑二次验证', '/admin/manager/unbound', 'manager', 'unbound', '2', '1', '1', '105', null, '2019-09-01 12:20:52', null, null);
INSERT INTO `rule` VALUES ('145', '管理员密码重置', '/admin/manager/reset', 'manager', 'reset', '2', '1', '1', '105', null, '2019-09-01 12:21:21', null, null);
INSERT INTO `rule` VALUES ('146', '商户管理', null, null, null, '0', '1', '1', '0', '商户管理', '2019-09-03 16:08:03', null, null);
INSERT INTO `rule` VALUES ('147', '商户列表', '/admin/merchant', 'merchant', 'index', '1', '1', '1', '146', null, '2019-09-03 16:10:36', null, null);
INSERT INTO `rule` VALUES ('148', '创建商户view', '/admin/merchant/create', 'merchant', 'create', '2', '1', '1', '147', null, '2019-09-03 16:11:07', null, null);
INSERT INTO `rule` VALUES ('149', '配置公私钥', '/admin/merchant/deploy/{merid}', 'merchant', 'deploy', '2', '1', '1', '147', null, '2019-09-03 16:11:42', null, null);
INSERT INTO `rule` VALUES ('150', '配置公私钥do', '/admin/merchant/doDeploy', 'merchant', 'doDeploy', '2', '1', '1', '147', null, '2019-09-03 16:12:12', null, null);
INSERT INTO `rule` VALUES ('151', '删除商户', '/admin/merchant/{merchant}', 'merchant', 'destroy', '2', '1', '1', '147', null, '2019-09-03 16:12:37', null, null);
INSERT INTO `rule` VALUES ('152', '修改商户状态', '/admin/merchant/{merchant}', 'merchant', 'show', '2', '1', '1', '147', null, '2019-09-03 16:13:04', null, null);
INSERT INTO `rule` VALUES ('153', '更新商户', '/admin/merchant/{merchant}', 'merchant', 'update', '2', '1', '1', '147', null, '2019-09-03 16:13:28', null, null);
INSERT INTO `rule` VALUES ('154', '编辑商户', '/admin/merchant/{merchant}/edit', 'merchant', 'edit', '2', '1', '1', '147', null, '2019-09-03 16:13:52', null, null);
INSERT INTO `rule` VALUES ('155', '创建商户store', '/admin/merchant', 'merchant', 'store', '2', '1', '1', '147', null, '2019-09-03 16:22:25', null, null);
INSERT INTO `rule` VALUES ('156', '会员管理', null, null, null, '0', '1', '1', '0', null, '2019-09-16 15:19:48', null, null);
INSERT INTO `rule` VALUES ('157', '会员列表', '/admin/user', 'user', 'index', '1', '1', '1', '156', null, '2019-09-16 15:20:36', null, '2019-09-16 18:55:52');
INSERT INTO `rule` VALUES ('158', '短信邀请页面', '/admin/sms/invite', 'sms', 'invite', '2', '1', '1', '157', null, '2019-09-16 15:51:03', null, null);
INSERT INTO `rule` VALUES ('159', '发送短信', '/admin/sms/sendSMS', 'sms', 'sendSMS', '2', '1', '1', '157', null, '2019-09-16 16:01:47', null, null);
INSERT INTO `rule` VALUES ('160', '邀请列表', '/admin/smslog', 'smslog', 'index', '1', '1', '1', '156', null, '2019-09-16 18:57:00', null, null);
INSERT INTO `rule` VALUES ('161', '导入csv格式', '/server/upload/import', 'upload', 'import', '2', '1', '1', '157', null, '2019-10-16 11:37:06', null, null);
INSERT INTO `rule` VALUES ('162', '申请彩金', null, null, null, '0', '1', '1', '0', null, '2019-10-16 11:56:15', null, '2019-10-16 11:56:26');
INSERT INTO `rule` VALUES ('163', '彩金列表', '/admin/handsel', 'handsel', 'index', '1', '1', '1', '162', null, '2019-10-16 11:57:29', null, null);
INSERT INTO `rule` VALUES ('164', '更新彩金view', '/admin/handsel/{handsel}/edit', 'handsel', 'edit', '2', '1', '1', '163', null, '2019-10-16 11:59:32', null, '2019-10-16 13:17:43');
INSERT INTO `rule` VALUES ('165', '更新彩金', '/admin/handsel/{handsel}', 'handsel', 'update', '2', '1', '1', '163', null, '2019-10-16 12:47:14', null, null);
INSERT INTO `rule` VALUES ('166', '活动管理', null, null, null, '0', '1', '1', '0', null, '2019-10-16 13:15:21', null, null);
INSERT INTO `rule` VALUES ('167', '活动列表', '/admin/activity', 'activity', 'index', '1', '1', '1', '166', null, '2019-10-16 13:15:55', null, '2019-10-16 13:17:37');
INSERT INTO `rule` VALUES ('168', '创建活动', '/admin/activity', 'activity', 'store', '2', '1', '1', '167', null, '2019-10-16 13:16:54', null, '2019-10-16 13:17:50');
INSERT INTO `rule` VALUES ('169', '创建活动view', '/admin/activity/create', 'activity', 'create', '2', '1', '1', '167', null, '2019-10-16 13:17:25', null, null);
INSERT INTO `rule` VALUES ('170', '活动删除', '/admin/activity/{activity}', 'activity', 'destroy', '2', '1', '1', '167', null, '2019-10-16 13:18:26', null, '2019-10-16 13:18:37');
INSERT INTO `rule` VALUES ('171', '切换活动状态', '/admin/activity/{activity}', 'activity', 'show', '2', '1', '1', '167', null, '2019-10-16 13:19:24', null, null);
INSERT INTO `rule` VALUES ('172', '更新活动', '/admin/activity/{activity}', 'activity', 'update', '2', '1', '1', '167', null, '2019-10-16 13:21:16', null, null);
INSERT INTO `rule` VALUES ('173', '更新活动view', '/admin/activity/{activity}/edit', 'activity', 'edit', '2', '1', '1', '167', null, '2019-10-16 13:21:38', null, '2019-10-16 13:22:03');
INSERT INTO `rule` VALUES ('174', '平台管理', null, null, null, '0', '1', '1', '0', null, '2019-10-16 13:31:29', null, null);
INSERT INTO `rule` VALUES ('175', '平台列表', '/admin/platform', 'platform', 'index', '1', '1', '1', '174', null, '2019-10-16 13:32:05', null, null);
INSERT INTO `rule` VALUES ('176', '创建平台view', '/admin/platform/create', 'platform', 'create', '2', '1', '1', '175', null, '2019-10-16 13:32:42', null, '2019-10-16 13:33:08');
INSERT INTO `rule` VALUES ('177', '创建平台', '/admin/platform', 'platform', 'store', '2', '1', '1', '175', null, '2019-10-16 13:33:37', null, null);
INSERT INTO `rule` VALUES ('178', '删除平台', '/admin/platform/{platform}', 'platform', 'destroy', '2', '1', '1', '175', null, '2019-10-16 13:34:12', null, null);
INSERT INTO `rule` VALUES ('179', '更新平台', '/admin/platform/{platform}', 'platform', 'update', '2', '1', '1', '175', null, '2019-10-16 13:34:43', null, null);
INSERT INTO `rule` VALUES ('180', '切换平台状态', '/admin/platform/{platform}', 'platform', 'show', '2', '1', '1', '175', null, '2019-10-16 13:35:08', null, null);
INSERT INTO `rule` VALUES ('181', '更新平台view', '/admin/platform/{platform}/edit', 'platform', 'edit', '2', '1', '1', '175', null, '2019-10-16 13:35:37', null, null);
INSERT INTO `rule` VALUES ('182', '手动生成关系表', '/admin/create/relation', 'platform', 'relation', '2', '1', '1', '175', null, '2019-10-18 19:52:19', null, null);

-- ----------------------------
-- Table structure for sms_log
-- ----------------------------
DROP TABLE IF EXISTS `sms_log`;
CREATE TABLE `sms_log` (
  `sms_log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `phone` char(15) DEFAULT '' COMMENT '手机号码',
  `code` int(6) DEFAULT '0' COMMENT '验证码',
  `content` varchar(50) DEFAULT '' COMMENT '发送短信内容',
  `handlers` int(50) DEFAULT '0' COMMENT '操作者',
  `type` tinyint(7) DEFAULT '1' COMMENT '1,短信邀请 2,彩金通知',
  `sms_status` tinyint(7) DEFAULT '1' COMMENT '1, ok  2, ng',
  `desc` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sms_log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sms_log
-- ----------------------------
INSERT INTO `sms_log` VALUES ('1', '18669025140', '937179', '您的验证码为937179,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '1', '', '2019-09-16 18:21:55', '2019-09-16 18:21:55', null);
INSERT INTO `sms_log` VALUES ('2', '18669025140', '906562', '您的验证码为906562,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '2', '验证码超出同模板同号码天发送上限', '2019-09-16 18:24:49', '2019-09-16 18:24:53', null);
INSERT INTO `sms_log` VALUES ('3', '18584467140', '810634', '您的验证码为810634,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '1', '短信发送成功,请不要重复发送哦!', '2019-09-16 18:31:35', '2019-09-16 18:31:36', null);
INSERT INTO `sms_log` VALUES ('4', '18584467140', '475546', '您的验证码为475546,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '1', '短信发送成功,请不要重复发送哦!', '2019-09-16 18:38:58', '2019-09-16 18:38:59', null);
INSERT INTO `sms_log` VALUES ('5', '18584467140', '392906', '您的验证码为392906,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '2', '短信验证码发送过频繁', '2019-09-16 18:39:10', '2019-09-16 18:39:12', null);
INSERT INTO `sms_log` VALUES ('6', '18584467140', '870480', '您的验证码为870480,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '1', '短信发送成功,请不要重复发送哦!', '2019-09-16 18:39:53', '2019-09-16 18:40:00', null);
INSERT INTO `sms_log` VALUES ('7', '18584467140', '722053', '您的验证码为722053,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '1', '短信发送成功,请不要重复发送哦!', '2019-09-16 18:41:00', '2019-09-16 18:41:01', null);
INSERT INTO `sms_log` VALUES ('8', '18584467140', '918932', '您的验证码为918932,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '1', '短信发送成功,请不要重复发送哦!', '2019-09-16 20:17:26', '2019-09-16 20:17:27', null);
INSERT INTO `sms_log` VALUES ('9', '18584467140', '279345', '您的验证码为279345,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '2', '短信验证码发送过频繁', '2019-09-16 20:17:37', '2019-09-16 20:17:38', null);
INSERT INTO `sms_log` VALUES ('10', '18530724681', '503283', '您的验证码为503283,请于5内正确输入,打死都不要告诉别人哦!', '10', '1', '1', '短信发送成功,请不要重复发送哦!', '2019-09-16 20:17:54', '2019-09-16 20:17:55', null);

-- ----------------------------
-- Table structure for video
-- ----------------------------
DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `cat_id` smallint(4) unsigned DEFAULT NULL,
  `image` varchar(200) DEFAULT '',
  `url` varchar(200) DEFAULT NULL,
  `type` tinyint(4) unsigned DEFAULT NULL,
  `content` text,
  `uploader` varchar(200) DEFAULT NULL,
  `status` tinyint(4) unsigned DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of video
-- ----------------------------
INSERT INTO `video` VALUES ('1', '地狱男爵', null, '', null, null, '地狱男爵', null, null, null, null);
