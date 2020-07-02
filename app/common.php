<?php
// 应用公共文件
//数据字典
if(!function_exists('getDict')) {
    function getDict($key = '') : array
    {
        $dict = [
            'page' => [20, 50, 100, 200],
            'status' => [
                0 => '正常',
                1 => '封禁'
            ],
            'sex' => [
                1 => '男',
                2 => '女'
            ],
            'role' => [
                1 => '普通员工',
                2 => '系统管理员'
            ],
            'channel' => [
                1 => '淘宝',
                2 => '微信',
                3 => '百度',
            ],
            'order_status' => [
                0 => '已下单',
                1 => '已入库',
                2 => '已派单',
                3 => '已修复',
                4 => '已审核',
                5 => '审核失败',
                6 => '打包发货',
            ],
            'order_action' => [
                0 => '添加到管理系统',
                1 => '入库分配',
                2 => '仓库派单',
                3 => '维修完成',
                4 => '审核通过',
                5 => '审核失败',
                6 => '打包发货',
            ],
        ];
        return $key ? $dict[$key] : $dict;
    }
}

if(!function_exists('getRs')) {
    function getRs($code=0,$msg='操作成功',$data=[]) : array
    {
        return compact('code','msg', 'data');
    }
}

if(!function_exists('getDateTime')) {
    function getDateTime($date_time = '') : array
    {
        if(!$date_time) return [];

        $date_time = urldecode($date_time);
        $date_arr = explode(' - ', $date_time);
        $start_time = strtotime($date_arr[0]);
        $end_time = strtotime($date_arr[1]);

        return compact('start_time', 'end_time');
    }
}

if(!function_exists('getByIndex')){
    function getByIndex($lists, $index, $key = '') : array
    {
        if(!$lists){
            return [];
        }
        $results = [];
        foreach ($lists as $value) {
            $results[$value[$index]] = $key ? $value[$key] : $value;
        }
        return $results;
    }
}
