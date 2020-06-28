<?php
/**
 * User: zengxianmao
 * Date: 2020/5/15
 * Time: 16:57
 */

namespace app\controller;


use app\BaseController;
use app\model\Users;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Login extends BaseController
{
    public function index(){
        $shoesAdmin = Session::get('shoesAdmin');
        if(!empty($shoesAdmin)){
            return redirect('/');
        }
        return View::fetch('login');
    }

    public function loginAction(){
        $all = Request::param();

        if(empty($all['user_name'])){
            return json(getRs(1,'用户名不能为空'));
        }
        if(empty($all['password'])){
            return json(getRs(1,'密码不能为空'));
        }
        if(empty($all['code'])){
            return json(getRs(1,'验证码不能为空'));
        }
        if(!captcha_check($all['code'])){
            return json(getRs(2,'验证码错误'));
        }
        $app = Config::get('app');
        if($all['user_name'] != $app['ROOT']) {
            $admin = Users::where('user_name', $all['user_name'])->find();
            if (empty($admin)) {
                return json(getRs(1, '账号不存在'));
            } elseif ($admin['password'] != md5($all['user_name'] . $all['password'])) {
                return json(getRs(3, '账号或密码错误'));
            } elseif ($admin['status'] != 0) {
                return json(getRs(6, '账号已被禁用'));
            }
        }elseif($all['password'] == $app['PASSWORD']) {
            $admin = [
                'id' => 0,
                'user_name' => $app['ROOT'],
                'name' => '超级管理员',
                'role_id' => 0,
            ];
        }else{
            return json(getRs(3, '账号或密码错误'));
        }


        Session::Set('shoesAdmin', $all['user_name']);
        Session::set('adminInfo', $admin);

        return json(getRs(0,'登录成功'));
    }
}