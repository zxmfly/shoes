<?php
/**
 * User: zengxianmao
 * Date: 2020/7/7
 * Time: 15:59
 */

namespace app\controller;


use think\facade\View;

class Notice extends BaseAdmin
{
    public function index(){
        $data = [];
        View::assign($data);
        return View::fetch();
    }
}