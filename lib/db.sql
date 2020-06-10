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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ch_work`;
CREATE TABLE `ch_work`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `work` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ch_work
-- ----------------------------
INSERT INTO `ch_work` VALUES (1, '老板');
INSERT INTO `ch_work` VALUES (2, '前台');
INSERT INTO `ch_work` VALUES (3, '客服');

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
-- Table structure for ch_customer
-- ----------------------------
DROP TABLE IF EXISTS `ch_customer`;
CREATE TABLE `ch_customer`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名字',
  `phone_number` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '电话号码',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '地址',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE,
  INDEX `pn`(`phone_number`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '客户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_order
-- ----------------------------
DROP TABLE IF EXISTS `ch_order`;
CREATE TABLE `ch_order`  (
  `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_express` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '客户运单号',
  `customer_id` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '客户ID',
  `order_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '诚和订单号',
  `creat_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '新增时间',
  `channel_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '来源ID',
  `task_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '生成订单',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单状态',
  `finish_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单完成时间',
  `send_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发货ID',
  `prices` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最终价格',
  `operator_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作者ID',
  `operator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '操作者',
  `track_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '追踪ID',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `express`(`customer_express`) USING BTREE,
  UNIQUE INDEX `order_id`(`order_id`) USING BTREE,
  INDEX `ct`(`creat_time`) USING BTREE,
  INDEX `ft`(`finish_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_task
-- ----------------------------
DROP TABLE IF EXISTS `ch_task`;
CREATE TABLE `ch_task`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id',
  `type` tinyint(255) UNSIGNED NOT NULL DEFAULT 1 COMMENT '任务类型(1维修，2返修)',
  `repair_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '维修ID',
  `assess_prices` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '估价',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '师傅ID',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '师傅名称',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '任务创建时间',
  `operator_id` int(11) NOT NULL COMMENT '操作者ID',
  `operator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ch_track
-- ----------------------------
DROP TABLE IF EXISTS `ch_track`;
CREATE TABLE `ch_track`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `type` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '类型1，客服新增，2入库并分配，3安排给师傅，4师傅收到，5完成，6寄出',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '记录时间',
  `operator_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作者ID',
  `operator` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作者',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oid`(`order_id`) USING BTREE,
  INDEX `ut`(`create_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单追踪表' ROW_FORMAT = Dynamic;

