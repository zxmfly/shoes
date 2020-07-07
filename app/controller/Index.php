<?php
namespace app\controller;

use think\facade\View;

class Index extends BaseAdmin
{
    public function index()
    {
        $user = $this->_admin;
        $data = [
            'admin' => $user['name'],
            'uid' => $user['id'],
            'is_unlock' => $user['lock_screen'] ? 'lock' : '',
        ];
        View::assign($data);
        return View::fetch();
    }

    public function admin(){
        return View::fetch();
    }

    public function welcome(){
        $user = $this->_admin;
        $data = [
            'admin' => $user['name'],
        ];
        View::assign($data);
        return View::fetch();
    }

}
