<?php
namespace app\controller;

use think\facade\View;

class Index extends BaseAdmin
{
    public function index()
    {
        $user = $this->_admin;
        $data = [
            'admin' => $user['user_name'],
        ];
        View::assign($data);
        return View::fetch();
    }

    public function admin(){
        return View::fetch();
    }

    public function welcome(){
        return View::fetch();
    }

}
