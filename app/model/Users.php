<?php
/**
 * User: zengxianmao
 * Date: 2020/5/30
 * Time: 11:04
 */

namespace app\model;

use think\Model;

class Users extends Model
{

    public static function getAll($where=true, $page = 1, $limit = 20){
        $data['count'] = Users::where($where)->count();
        if (!$data['count']) return ['count'=>0,'data'=>[]];
        $lists = Users::where($where)->page($page, $limit)->select()->toArray();
        $dict = getDict();
        $work = Works::select()->toArray();
        $workArr = getByIndex($work, 'id', 'work');
        $groups = Groups::select()->toArray();
        $group = getByIndex($groups,'id', 'name');
        foreach ($lists as &$row){
            $row['sex_text'] = $dict['sex'][$row['sex']];
            $row['work_text'] = $workArr[$row['work_id']];
            $row['role_text'] = isset($group[$row['role_id']]) ? $group[$row['role_id']] : '';
            $row['status_text'] = $dict['status'][$row['status']];
        }
        $data['data'] = $lists;
        return $data;
    }

    public static function getTaskCount($count = 1){
        $users = Users::where(['work_id'=>1])->select()->toArray();
        if($users && $count){
            foreach ($users as &$row){
                $row['task_on'] = Tasks::where(['uid'=>$row['id']])->where('status','not in', [7,9])->count();
            }
        }
        return $users ? $users : [];
    }

    public static function updateUsers($all){
        return Users::where('id',$all['id'])->update($all);
    }

}