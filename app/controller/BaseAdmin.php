<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/5/1
 * Time: 11:37
 */

namespace app\controller;


use app\BaseController;
use app\model\Users;
use think\App;
use think\facade\Session;

class BaseAdmin extends BaseController
{
    public $shoesAdmin;
    public $_admin;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->shoesAdmin = Session::get('shoesAdmin');
        $this->_admin = Users::where('user_name', $this->shoesAdmin)->find();
        if(empty($this->learntTpAdmin)){
            //header('location:/login');
            //exit;
        }
    }

    //判断权限

    public function loginOut(){
        Session::clear();
        return redirect('/login');
    }
}