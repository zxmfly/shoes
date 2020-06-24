<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/6/8
 * Time: 22:30
 */

namespace app\model;


use think\Model;

class Fixs extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = Fixs::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $data['data'] = Fixs::where($where)->page($page, $limit)->select()->toArray();
        return $data;
    }

    public static function updateFix($all){
        return Fixs::where('id',$all['id'])->update($all);
    }
}