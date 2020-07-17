<?php
/**
 * User: zengxianmao
 * Date: 2020/7/14
 * Time: 10:40
 */

namespace app\model;


use think\Model;

class Notices extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = Notices::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Notices::where($where)->page($page, $limit)->select()->toArray();
        foreach ($lists as &$row){
            $row['start_time'] = date('Y-m-d', $row['start_time']);
            $row['end_time'] = date('Y-m-d', $row['end_time']);
        }
        $data['data'] = $lists;
        return $data;
    }
}