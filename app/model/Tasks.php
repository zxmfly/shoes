<?php
/**
 * User: zengxianmao
 * Date: 2020/6/24
 * Time: 16:56
 */

namespace app\model;


use think\facade\Session;
use think\Model;

class Tasks extends Model
{
    public static function getAll($where=true, $page = 1, $limit = 20){
        $data['count'] = Tasks::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Tasks::where($where)->page($page, $limit)->order('id','desc')->select()->toArray();
        $dict = getDict();
        $fix = Fixs::select()->toArray();
        $fixArr = getByIndex($fix, 'id', 'name');
        $admin = Session::get('adminInfo');
        foreach ($lists as &$row){
            $row['type_txt'] = $row['type'] == 1 ? '维修' : '返修';
            $row['fix'] = isset($fixArr[$row['fix_type']]) ? $fixArr[$row['fix_type']] : '';
            $row['status_txt'] = $dict['order_status'][$row['status']];
            $row['is_ok'] = $row['status'] >= 3 && $row['status'] != 5 ? 1 : 0;
            $row['admin'] = $admin['name'];
            $row['is_assign'] = $row['status'] >= 2 ? 1 : 0; //是否派单
            $row['finish_time'] = $row['finish_time'] ? date('Y-m-d H:is', $row['finish_time']) : '';
        }
        $data['data'] = $lists;
        return $data;
    }

    public static function updateById($all){
        return Tasks::where('id',$all['id'])->update($all);
    }
}