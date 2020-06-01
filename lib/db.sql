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