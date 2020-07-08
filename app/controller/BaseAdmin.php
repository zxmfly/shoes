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
use think\facade\Config;
use think\facade\Session;
use think\facade\View;

class BaseAdmin extends BaseController
{
    public $shoesAdmin;
    public $_admin = [];
    public $_pageArr = [];
    public $_pageDefault = 20;
    public $_menu = [];
    public $checkArr = [];
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
            $app = Config::get('app');
            if($this->shoesAdmin != $app['ROOT']) {
                $admin = Users::where('user_name', $this->shoesAdmin)->find();
            }else{
                $admin = [
                    'id' => 0,
                    'user_name' => $app['ROOT'],
                    'name' => '超级管理员',
                    'role_id' => 0,
                ];
            }
            $this->_admin = $admin;
            Session::set('adminInfo', $admin);
        }
        $this->_menu = Session::get('adminMenu');
        $this->checkArr = Session::get('adminCheckArr');
        if(empty($this->_menu) || empty($this->checkArr)) self::getMenu();
        $data = [
            'role_id' => $this->_admin['role_id'],
        ];
        View::assign($data);

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

    //权限设置
    private function getMenu(){
        $list = [];
        $checkArr = [];
        $menu = Config::get('menu');
        foreach ($menu as $pid => $row){
            $checkArr[$row['url']] = $pid;
            isset($row['title_class']) && $list[$row['title']]['title_class'] = $row['title_class'];
            isset($row['title_icon']) && $list[$row['title']]['title_icon'] = $row['title_icon'];
            $list[$row['title']]['lists'][] = $row;
        }
        $this->_menu = $list;
        $this->checkArr = $checkArr;
        Session::set('adminMenu', $list);
        Session::set('adminCheckArr', $checkArr);
    }
}