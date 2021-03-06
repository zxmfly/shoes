<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/5/1
 * Time: 11:37
 */

namespace app\controller;


use app\BaseController;
use app\model\Groups;
use app\model\SystemLogs;
use app\model\Tracks;
use app\model\Users;
use think\App;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class BaseAdmin extends BaseController
{
    public $shoesAdmin;
    public $_admin = [];
    public $_pageArr = [];
    public $_pageDefault = 18;
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
                    'lock_screen' => 'root123'
                ];
            }
            $this->_admin = $admin;
            Session::set('adminInfo', $admin);
        }
        $this->_menu = Session::get('adminMenu');
        $this->checkArr = Session::get('adminCheckArr');
        if(empty($this->_menu) || empty($this->checkArr)) self::getMenu($this->_admin['role_id']);

        $this->setSysLog();

        $data = [
            'page_defult' => $this->_pageDefault,
            'page_list' => json_encode($this->_pageArr),
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
    private function getMenu($gid){
        if($gid > 0) {
            $my_menus = Groups::find($gid);
            if(empty($my_menus)){
                echo  '没有使用权限，请找系统管理员';
                die;
            }
            $my_lists = explode(',', $my_menus['lists']);
        }
        $list = [];
        $checkArr = [];
        $menu = Config::get('menu');
        $titleArr = [];
        foreach ($menu as $pid => $row){
            isset($row['title_class']) && $titleArr[$row['title']]['title_class'] = $row['title_class'];
            isset($row['title_icon']) && $titleArr[$row['title']]['title_icon'] = $row['title_icon'];
            if($gid > 0 && !in_array($pid, $my_lists)) continue;
            $checkArr[$row['url']] = $pid;
            $list[$row['title']]['lists'][$pid] = $row;
        }
        if(empty($list)){
            echo  '没有使用权限，请找系统管理员';
            die;
        }else{
            foreach ($list as $key=>&$val){
                isset($titleArr[$key]['title_class']) && $val['title_class'] = $titleArr[$key]['title_class'];
                $val['title_icon'] = $titleArr[$key]['title_icon'];
            }
        }

        $this->_menu = $list;
        $this->checkArr = $checkArr;
        Session::set('adminMenu', $list);
        Session::set('adminCheckArr', $checkArr);
    }
    //操作记录
    public function setSysLog(){
        $un_c = ['Index', 'Barcode'];
        $un_a = ['index', 'getNotice', 'getList','sysLogs','getListSys','getCustomer','orderTrack','fix','getFix'];
        $admin = $this->_admin;
        $control = Request::controller();
        $action = Request::action();
        $operator_id = $admin['id'];
        $operator  = $admin['name'];
        $url = Request::url(true);//true 获取完整的url
        $ip = Request::ip();

        if($action != 'loginOut' && (in_array($control, $un_c) || in_array($action, $un_a) || $operator_id == 0)) return ;
        if(($action == 'check' && Request::Get('action') != 'pass_task') ||
            ($action == 'send' && Request::Get('action') != 'send')){
            return ;
        }

        $create_time = time();

        $data = compact('url', 'ip', 'operator_id', 'operator', 'create_time','control','action');
        SystemLogs::insert($data);
    }
}