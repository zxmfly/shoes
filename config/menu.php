<?php
/**
 * User: zengxianmao
 * Date: 2020/7/8
 * Time: 15:47
 */

return [
    1 => ['title'=>'订单管理', 'name'=>'维修类别', 'icon'=>'layui-icon-link','url'=>'task/fix','title_icon'=>'layui-icon-form'],
    2 => ['title'=>'订单管理', 'name'=>'添加订单', 'icon'=>'layui-icon-add-circle','url'=>'order/addOrder'],
    3 => ['title'=>'订单管理', 'name'=>'订单列表', 'icon'=>'icon-text','url'=>'order','class'=>'seraph'],
    4 => ['title'=>'订单管理', 'name'=>'任务列表', 'icon'=>'layui-icon-util','url'=>'task'],
    5 => ['title'=>'订单管理', 'name'=>'待审列表', 'icon'=>'layui-icon-util','url'=>'task/check'],
    6 => ['title'=>'订单管理', 'name'=>'待发列表', 'icon'=>'layui-icon-util','url'=>'task/send'],

    10 => ['title'=>'员工中心', 'name'=>'我的任务', 'icon'=>'icon-caidan','url'=>'task/index?action=myTask', 'class'=>'seraph', 'title_icon'=>'layui-icon-friends'],
    11 => ['title'=>'员工中心', 'name'=>'个人资料', 'icon'=>'icon-ziliao','url'=>'worker/info', 'class'=>'seraph'],
    12 => ['title'=>'员工中心', 'name'=>'修改密码', 'icon'=>'icon-xiugai','url'=>'worker/password', 'class'=>'seraph'],

    21 => ['title'=>'员工管理', 'name'=>'员工列表', 'icon'=>'layui-icon-user','url'=>'worker','title_icon'=>'icon-icon10','title_class'=>'seraph'],
    22 => ['title'=>'员工管理', 'name'=>'工作部门', 'icon'=>'layui-icon-template-1','url'=>'worker/work'],

    31 => ['title'=>'系统设置', 'name'=>'权限列表', 'icon'=>'layui-icon-auz','url'=>'group','title_icon'=>'layui-icon-set'],
    32 => ['title'=>'系统设置', 'name'=>'公告设置', 'icon'=>'layui-icon-notice','url'=>'notice'],
    33 => ['title'=>'系统设置', 'name'=>'参数配置', 'icon'=>'layui-icon-notice','url'=>'notice'],
    34 => ['title'=>'系统设置', 'name'=>'系统日志', 'icon'=>'icon-log','url'=>'log','class'=>'seraph'],
];