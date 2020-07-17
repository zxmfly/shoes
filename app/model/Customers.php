<?php
/**
 * User: zengxianmao
 * Date: 2020/6/24
 * Time: 17:38
 */

namespace app\model;


use think\Model;

class Customers extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = Customers::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Customers::where($where)->page($page, $limit)->select()->toArray();
        $data['data'] = $lists;
        return $data;
    }
}