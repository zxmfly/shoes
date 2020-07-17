<?php
/**
 * User: zengxianmao
 * Date: 2020/7/13
 * Time: 16:57
 */

namespace app\model;


use think\Model;

class SystemLogs extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = SystemLogs::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $data['data'] = SystemLogs::where($where)->page($page, $limit)->order('create_time','desc')->select()->toArray();
        return $data;
    }
}