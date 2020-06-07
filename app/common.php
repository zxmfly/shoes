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
        ];
        return $key ? $dict[$key] : $dict;
    }
}