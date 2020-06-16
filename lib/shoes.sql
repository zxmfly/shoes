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

 Date: 16/06/2020 18:40:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ch_channel
-- ----------------------------
DROP TABLE IF EXISTS `ch_channel`;
CREATE TABLE `ch_channel`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `channel` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '渠道',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '渠道列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_check
-- ----------------------------
DROP TABLE IF EXISTS `ch_check`;
CREATE TABLE `ch_check`  (
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
-- Table structure for ch_customer
-- ----------------------------
DROP TABLE IF EXISTS `ch_customer`;
CREATE TABLE `ch_customer`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名字',
  `phone_number` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '电话号码',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '地址',
  `postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '邮政编码',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE,
  INDEX `pn`(`phone_number`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '客户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_orders
-- ----------------------------
DROP TABLE IF EXISTS `ch_orders`;
CREATE TABLE `ch_orders`  (
  `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_express` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '客户运单号',
  `customer_id` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '客户ID',
  `order_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '诚和订单号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '新增时间',
  `channel_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '来源ID',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单状态',
  `finish_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单完成时间',
  `prices` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最终价格',
  `repair_order` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '返修对应订单号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `express`(`customer_express`) USING BTREE,
  UNIQUE INDEX `order_id`(`order_id`) USING BTREE,
  INDEX `ct`(`create_time`) USING BTREE,
  INDEX `ft`(`finish_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_task
-- ----------------------------
DROP TABLE IF EXISTS `ch_task`;
CREATE TABLE `ch_task`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id',
  `type` tinyint(255) UNSIGNED NOT NULL DEFAULT 1 COMMENT '任务类型(1维修，2返修)',
  `fix_type` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修理类型',
  `task_explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '任务说明',
  `assess_prices` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '估价',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '师傅ID',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '师傅名称',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '任务创建时间',
  `operator_id` int(11) NOT NULL COMMENT '操作者ID',
  `operator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作者',
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '任务状态',
  `prices` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最终价格',
  `finish_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '完成时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_track
-- ----------------------------
DROP TABLE IF EXISTS `ch_track`;
CREATE TABLE `ch_track`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单状态',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '记录时间',
  `operator_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作者ID',
  `operator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作者',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oid`(`order_id`) USING BTREE,
  INDEX `ut`(`create_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单追踪表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_users
-- ----------------------------
DROP TABLE IF EXISTS `ch_users`;
CREATE TABLE `ch_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '账号',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '密码',
  `number` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '工号',
  `work_id` tinyint(4) UNSIGNED NULL DEFAULT 0 COMMENT '工作类别ID',
  `role_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '角色ID',
  `sex` tinyint(4) UNSIGNED NULL DEFAULT 1 COMMENT '性别(1男2女)',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '姓名',
  `status` tinyint(4) UNSIGNED NULL DEFAULT 0 COMMENT '状态',
  `create_time` int(11) UNSIGNED NULL DEFAULT 0,
  `update_time` int(11) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_work
-- ----------------------------
DROP TABLE IF EXISTS `ch_work`;
CREATE TABLE `ch_work`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `work` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
