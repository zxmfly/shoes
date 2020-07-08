<?php
/**
 * User: zengxianmao
 * Date: 2020/7/8
 * Time: 17:55
 */

namespace app\controller;


use app\BaseController;
use think\facade\View;

class Log extends BaseController
{
    public function index(){
        
        return View::fetch();
    }
}