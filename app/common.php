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
            'work' => [
                1 => '客服',
                2 => '财务',
                3 => '师傅',
                4 => '学徒',
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
                6 => '打包寄出',
                7 => '订单完成',
                8 => '返修中',
                9 => '返修完成',
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
