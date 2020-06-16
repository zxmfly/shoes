<?php
/**
 * User: zengxianmao
 * Date: 2020/6/15
 * Time: 11:38
 */

namespace app\model;


use think\facade\Db;
use think\Model;

class Orders extends Model
{
    public static function getAll($where=true, $page, $limit){
        $data['count'] = Orders::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Orders::where($where)->page($page, $limit)->order('id','desc')->select()->toArray();
        $dict = getDict();
        foreach ($lists as &$row){
            $row['channel'] = $dict['channel'][$row['channel_id']];
            $row['status_txt'] = $dict['order_status'][$row['status']];
            $row['finish_time'] = $row['finish_time'] ? date('Y-m-d H:is', $row['finish_time']) : '';
            $row['customer_info'] = Db::name('customer')->find($row['customer_id']);
            $row['customer'] = $row['customer_info']['name'];
        }
        $data['data'] = $lists;
        return $data;
    }

    public static function getOne($where = true){
        return Orders::where($where)->find();
    }

    public static function updateById($all){
        return Orders::where('id',$all['id'])->update($all);
    }
}