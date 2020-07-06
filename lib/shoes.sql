/*
 Navicat Premium Data Transfer

 Source Server         : 本机3306
 Source Server Type    : MySQL
 Source Server Version : 100410
 Source Host           : localhost:3306
 Source Schema         : shoes

 Target Server Type    : MySQL
 Target Server Version : 100410
 File Encoding         : 65001

 Date: 24/06/2020 16:59:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ch_channels
-- ----------------------------
DROP TABLE IF EXISTS `ch_channels`;
CREATE TABLE `ch_channels`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `channel` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '渠道',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '渠道列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_checks
-- ----------------------------
DROP TABLE IF EXISTS `ch_checks`;
CREATE TABLE `ch_checks`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `type` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '审核类型',
  `crate_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '审核时间',
  `operator_id` int(11) NOT NULL COMMENT '审核人ID',
  `operator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '审核人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oid`(`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '审核记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_configs
-- ----------------------------
DROP TABLE IF EXISTS `ch_configs`;
CREATE TABLE `ch_configs`  (
  `key` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_customers
-- ----------------------------
DROP TABLE IF EXISTS `ch_customers`;
CREATE TABLE `ch_customers`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名字',
  `phone_number` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '电话号码',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '地址',
  `postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '邮政编码',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE,
  INDEX `pn`(`phone_number`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '客户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_fixs
-- ----------------------------
DROP TABLE IF EXISTS `ch_fixs`;
CREATE TABLE `ch_fixs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '维修类型' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_orders
-- ----------------------------
DROP TABLE IF EXISTS `ch_orders`;
CREATE TABLE `ch_orders` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `customer_express` varchar(50) NOT NULL DEFAULT '' COMMENT '客户运单号',
  `customer_id` int(1) unsigned NOT NULL DEFAULT 0 COMMENT '客户ID',
  `order_id` varchar(50) NOT NULL DEFAULT '' COMMENT '诚和订单号',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '新增时间',
  `channel_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '来源ID',
  `status` tinyint(4) unsigned NOT NULL DEFAULT 0 COMMENT '订单状态',
  `finish_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '订单完成时间',
  `prices` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最终价格',
  `repair_order` varchar(50) DEFAULT '' COMMENT '返修对应订单号',
  `order_desc` varchar(255) DEFAULT '' COMMENT '订单描述',
  `send_id` varchar(50) DEFAULT '' COMMENT '运单号',
  `send_time` int(11) unsigned DEFAULT 0 COMMENT '发货时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `express` (`customer_express`),
  UNIQUE KEY `order_id` (`order_id`),
  KEY `ct` (`create_time`),
  KEY `ft` (`finish_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单列表';
-- ----------------------------
-- Table structure for ch_tasks
-- ----------------------------
DROP TABLE IF EXISTS `ch_tasks`;
CREATE TABLE `ch_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '订单id',
  `type` tinyint(255) unsigned NOT NULL DEFAULT 1 COMMENT '任务类型(1维修，2返修)',
  `fix_type` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '修理类型',
  `task_explain` varchar(255) NOT NULL DEFAULT '' COMMENT '任务说明',
  `assess_prices` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '估价',
  `uid` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '师傅ID',
  `user_name` varchar(255) NOT NULL COMMENT '师傅名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '任务创建时间',
  `status` tinyint(4) unsigned NOT NULL COMMENT '任务状态',
  `prices` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最终价格',
  `finish_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '完成时间',
  `repair_order` varchar(50) DEFAULT '' COMMENT '返修订单',
  PRIMARY KEY (`id`),
  KEY `oid` (`order_id`),
  KEY `rep_oid` (`repair_order`),
  KEY `ct` (`create_time`),
  KEY `ft` (`finish_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- Table structure for ch_tracks
-- ----------------------------
DROP TABLE IF EXISTS `ch_tracks`;
CREATE TABLE `ch_tracks`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单状态',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '记录时间',
  `operator_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作者ID',
  `operator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作者',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oid`(`order_id`) USING BTREE,
  INDEX `ut`(`create_time`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单追踪表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_users
-- ----------------------------
DROP TABLE IF EXISTS `ch_users`;
CREATE TABLE `ch_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT '' COMMENT '账号',
  `password` char(32) DEFAULT '' COMMENT '密码',
  `number` int(11) unsigned DEFAULT 0 COMMENT '工号',
  `work_id` tinyint(4) unsigned DEFAULT 0 COMMENT '工作类别ID',
  `role_id` int(11) unsigned DEFAULT 0 COMMENT '角色ID',
  `sex` tinyint(4) unsigned DEFAULT 1 COMMENT '性别(1男2女)',
  `name` varchar(20) DEFAULT '' COMMENT '姓名',
  `status` tinyint(4) unsigned DEFAULT 0 COMMENT '状态',
  `create_time` int(11) unsigned DEFAULT 0,
  `update_time` int(11) unsigned DEFAULT 0,
  `id_card` varchar(20) DEFAULT NULL COMMENT '身份证',
  `phone_number` varchar(20) DEFAULT NULL COMMENT '电话',
  `address` varchar(255) DEFAULT NULL COMMENT '住址',
  `urgent_contact` varchar(20) DEFAULT NULL COMMENT '紧急联系人',
  `urgent_phone` varchar(20) DEFAULT NULL COMMENT '紧急联系电话',
  `lock_screen` varchar(50) DEFAULT '' COMMENT '锁屏密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ch_works
-- ----------------------------
DROP TABLE IF EXISTS `ch_works`;
CREATE TABLE `ch_works`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `work` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
