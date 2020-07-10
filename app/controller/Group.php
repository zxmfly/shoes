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
        $gid = $this->_admin['role_id'];
        $uid = $this->_admin['id'];
        $where = "( `id` = {$gid} OR `uid` = {$uid} )";

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
        $param = Request::param();
        if(Request::isGet()) {
            $lists = [];
            if(isset($param['id']) && intval($param['id'])){
                $id = intval($param['id']);
                $group = Groups::find($id);
                $lists = explode(',', $group['lists']);
            }
            $data = [
                'menu' => $this->_menu,
                'lists' => $lists,
            ];
            View::assign($data);
            return View::fetch();
        }else{
            $id = intval($param['id']);
            $menu = $param['menu'];
            unset($param['menu']);
            $param['lists'] = implode(',', $menu);
            if($id){
                Groups::update($param);
            }else {
                unset($param['id']);
                $admin = $this->_admin;
                $param['uid'] = $admin['id'];
                Groups::insert($param);
            }

            return json(getRs(0,'保存成功'));
        }
    }

    public function del(){
        if(Request::param('id')) {
            $id = Request::param('id');
            $delete = Groups::destroy($id);
            if($delete){
                $rs = ['code'=>0,'msg'=>'删除成功'];
            }else{
                $rs = ['code'=>1,'msg'=>'删除失败'];
            }
        }else{
            $rs = ['code'=>3,'msg'=>'操作有误'];
        }
        return json($rs);
    }
}