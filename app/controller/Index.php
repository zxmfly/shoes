<?php
namespace app\controller;

use think\facade\View;

class Index extends BaseAdmin
{
    public function index()
    {
        return View::fetch();
    }

    public function admin(){
        return View::fetch();
    }

    public function welcome(){
        return View::fetch();
    }

}
