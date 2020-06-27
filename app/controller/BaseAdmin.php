<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/5/1
 * Time: 11:37
 */

namespace app\controller;


use app\BaseController;
use app\model\Tracks;
use app\model\Users;
use think\App;
use think\facade\Session;

class BaseAdmin extends BaseController
{
    public $shoesAdmin;
    public $_admin = [];
    public $_pageArr = [];
    public $_pageDefault = 20;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_pageArr = getDict('page');
        $this->shoesAdmin = Session::get('shoesAdmin');
        if(empty($this->shoesAdmin)){
            header('location:/login');
            exit;
        }
        $this->_admin = Session::get('adminInfo');
        if(empty($this->_admin)) {
            $admin = Users::where('user_name', $this->shoesAdmin)->find();
            Session::set('adminInfo', $admin);
        }

    }
    //订单追踪
    public function addTrack($param){
        $admin = $this->_admin;
        $track = [
            'order_id'  => $param['order_id'],
            'status'    => $param['status'],
            'create_time' => isset($param['create_time']) ? $param['create_time'] : time(),
            'operator_id' => $admin['id'],
            'operator'  => $admin['name'],
        ];
        $rs = Tracks::insert($track);
        return $rs;
    }

    public function loginOut(){
        Session::clear();
        return redirect('/login');
    }
}