<?php
/**
 * User: zengxianmao
 * Date: 2020/7/20
 * Time: 17:42
 */

namespace app\model;


use think\Model;

class Channels extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = Channels::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $data['data'] = Channels::where($where)->page($page, $limit)->select()->toArray();
        return $data;
    }
}