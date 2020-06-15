<?php
/**
 * User: zengxianmao
 * Date: 2020/6/15
 * Time: 11:38
 */

namespace app\model;


use think\Model;

class Orders extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = Orders::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Users::where($where)->page($page, $limit)->select()->toArray();
        $dict = getDict();
        foreach ($lists as &$row){

        }
        $data['data'] = $lists;
        return $data;
    }

    public static function updateById($all){
        return Orders::where('id',$all['id'])->update($all);
    }
}