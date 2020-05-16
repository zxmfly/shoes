<?php
/**
 * User: zengxianmao
 * Date: 2020/5/15
 * Time: 16:57
 */

namespace app\controller;


use app\BaseController;
use think\facade\View;

class Login extends BaseController
{
    public function index(){


        return View::fetch('login');
    }
}