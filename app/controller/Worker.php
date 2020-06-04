<?php
/**
 * User: zengxianmao
 * Date: 2020/6/2
 * Time: 11:07
 */

namespace app\controller;


use think\facade\Request;
use think\facade\View;
use app\model\Users;

class Worker extends BaseAdmin
{
    public function index(){

        return View::fetch();
    }

    public function getList(){
        $keywords = Request::get('keywords');
        $count = Users::count();
        $data = [];
        if($count) {
            $data = Users::select()->toArray();
        }
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function addWorker(){
        if(Request::method() == 'POST'){
            $data = Request::param();
            $user = Users::where('user_name', $data['user_name'])
                ->whereOr('name', $data['name'])
                ->whereOr('number', $data['number'])
                ->find();
            if($user){
                return json($data);
            }
            $data['update_time'] = 0;
            $data['create_time'] = time();
            $data['password'] = $data['password'] ? $data['password'] : '123';
            $data['password'] = md5($data['user_name'].$data['password']);
            $insert = Users::insert($data);
            $res = $insert ? ['code'=>0,'msg'=>'添加成功'] : ['code'=>1,'msg'=>'添加失败'];
            return json($res);
        }

        return View::fetch();
    }

    public function work(){

    }
}