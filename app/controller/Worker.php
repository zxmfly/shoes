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
        $data = Users::select()->toArray();
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function work(){

    }
}