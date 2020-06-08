<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/6/8
 * Time: 22:30
 */

namespace app\model;


use think\Model;

class Work extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = Work::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $data['data'] = Work::where($where)->page($page, $limit)->select()->toArray();
        return $data;
    }

    public static function updateUsers($all){
        return Work::where('id',$all['id'])->update($all);
    }
}