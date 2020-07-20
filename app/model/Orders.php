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
    public static function getAll($where=true, $page = 1, $limit = 20){
        $data['count'] = Orders::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Orders::where($where)->page($page, $limit)->order('id','desc')->select()->toArray();
        $dict = getDict();
        $channels = Channels::column('channel','id');
        foreach ($lists as &$row){
            $row['channel'] = $channels[$row['channel_id']];
            $row['status_txt'] = $dict['order_status'][$row['status']];
            $row['finish_time'] = $row['finish_time'] ? date('Y-m-d H:is', $row['finish_time']) : '';
            $customer = Customers::find($row['customer_id']);
            $row['customer_info'] = $customer ? $customer : [];
            $row['customer'] = $customer ? $row['customer_info']['name'] : '';
            $row['order_type'] = $row['repair_order'] ? '返修' : '新增';
            $task = Tasks::where(['order_id'=>$row['order_id']])->find();
            $row['task_id'] = $task ? $task['id'] : '';
            $row['send_time'] = $row['finish_time'] ? date('Y-m-d H:i:s', $row['send_time']) : '';
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