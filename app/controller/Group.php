<?php
/**
 * User: zengxianmao
 * Date: 2020/7/9
 * Time: 16:20
 */

namespace app\controller;


use app\model\Groups;
use think\facade\Request;
use think\facade\View;

class Group extends BaseAdmin
{
    public function index(){
        $page_defult = $this->_pageDefault;
        $page_list = json_encode($this->_pageArr);
        $data = compact('page_defult','page_list');

        View::assign($data);
        return View::fetch();
    }

    public function getList(){
        $param = Request::param();
        $where = [];

        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : $this->_pageDefault;
        $all = Groups::getAll($where, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function add(){

        $data = [
            'menu' => $this->_menu,
        ];

        View::assign($data);
        return View::fetch();
    }
}