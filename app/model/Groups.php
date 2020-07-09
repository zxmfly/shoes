<?php
/**
 * User: zengxianmao
 * Date: 2020/7/9
 * Time: 16:25
 */

namespace app\model;


use think\facade\Config;
use think\Model;

class Groups extends Model
{
    public static function getAll($where=true, $page = 1, $limit = 20){
        $data['count'] = Groups::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Groups::where($where)->page($page, $limit)->select()->toArray();
        $menu = Config::get('menu');

        foreach ($lists as &$row){

        }
        $data['data'] = $lists;
        return $data;
    }
}