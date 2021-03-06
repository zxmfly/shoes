<?php
/**
 * User: zengxianmao
 * Date: 2020/6/2
 * Time: 11:07
 */

namespace app\controller;


use app\model\Groups;
use app\model\Works;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;
use app\model\Users;

class Worker extends BaseAdmin
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
        $keywords = isset($param['keywords']) && $param['keywords'] ? $param['keywords'] : '';
        $where = [];
        if($keywords){
            if(is_numeric($keywords)){
                $where = ['number' => $keywords];
            }else{
                 $where = "(`name` like '%{$keywords}%' OR `user_name` like '%{$keywords}%' )";
            }
        }
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : $this->_pageDefault;;
        $all = Users::getAll($where, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function addWorker(){
        $data = Request::param();
        if(empty($data)){
            $work = Works::select()->toArray();
            $groups = Groups::select()->toArray();
            $data = compact('work','groups');
            View::assign($data);
            return View::fetch();
        }
        $action = $data['action'];
        $edit_id = $data['edit_id'];
        unset($data['edit_id'],$data['action']);
        if($action == 'add'){
            $user = Users::where('user_name', $data['user_name'])
                ->whereOr('name', $data['name'])
                ->whereOr('number', $data['number'])
                ->find();
            if($user){
                return json(['code'=>2,'msg'=>'该员工已存在,请勿重复添加']);
            }
            $data['create_time'] = time();
            $data['password'] = $data['password'] ? $data['password'] : $data['user_name'].'123';
            $data['password'] = md5($data['user_name'].$data['password']);
            $insert = Users::insert($data);
            $res = $insert ? ['code'=>0,'msg'=>'添加成功'] : ['code'=>1,'msg'=>'添加失败'];
            return json($res);
        }elseif ($action == 'edit_user' && $edit_id){
            $data['id'] = $edit_id;
            if($data['password']) {
                $data['password'] = md5($data['user_name'] . $data['password']);
            }else{
                unset($data['password']);
            }
            $update = Users::updateUsers($data);
            if($update){
                $rs = ['code'=>0,'msg'=>'修改成功'];
            }else{
                $rs = ['code'=>1,'msg'=>'修改失败'];
            }
            return json($rs);
        }

        return json(['code'=>3,'msg'=>'未知错误,请联系开发人员']);
    }

    public function delWorker(){
        if(Request::param('id')) {
            $id = Request::param('id');
            $delete = Users::destroy($id);
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

    public function work(){
        $page_defult = $this->_pageDefault;
        $page_list = json_encode($this->_pageArr);
        $data = compact('page_defult','page_list');
        View::assign($data);
        return View::fetch();
    }

    public function getWork(){
        $param = Request::param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 20;
        $all = Works::getAll(true, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function addWork(){
        $data = Request::param();
        if(empty($data)) return View::fetch();
        if($data['id']){
            $update = Works::updateWork($data);
            if($update){
                $rs = ['code'=>0,'msg'=>'修改成功'];
            }else{
                $rs = ['code'=>1,'msg'=>'修改失败'];
            }
            return json($rs);
        }else{
            $work = Works::where('work', $data['work'])->find();
            if($work){
                return json(['code'=>2,'msg'=>'该工作类别已存在,请勿重复添加']);
            }
            $insert = Works::insert($data);
            $res = $insert ? ['code'=>0,'msg'=>'添加成功'] : ['code'=>1,'msg'=>'添加失败'];
            return json($res);
        }
    }

    public function delWork(){
        if(Request::param('id')) {
            $id = Request::param('id');
            $delete = Works::destroy($id);
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

    public function info()
    {
        $admin = $this->_admin;
        if(Request::isGet()) {
            $id = $admin['id'];
            if($id) {
                $data = Users::getAll(['id' => $id]);
                $info = $data['data'][0];
            }else{
                return '超级管理员';
            }
            View::assign($info);
            return View::fetch();
        }elseif(Request::isPost()){
            $all = Request::param();
            if($all['lock_screen']){
                $all['lock_screen'] = md5($admin['user_name'] . $all['lock_screen']);
            }else{
                unset($all['lock_screen']);
            }
            Users::updateUsers($all);
            $rs = getRs(0, '修改成功');
            return json($rs);
        }
    }

    public function password(){
        $admin = $this->_admin;
        if($admin['id'] == 0){
            return '超级管理员密码，不可修改';
        }
        if(Request::isGet()) {
            $data = [
                'admin' => $admin['user_name'],
            ];
            View::assign($data);
            return View::fetch();
        }elseif(Request::isPost()){
            $d = Request::param();
            $oldPwd = $d['oldPwd'];
            $newPwd = $d['newPwd'];
            $confirmPwd = $d['confirmPwd'];
            if(strlen($newPwd) < 6){
                $rs = getRs(1, '密码长度不能小于6');
            }elseif($newPwd != $confirmPwd){
                $rs = getRs(1, '两次输入密码不一样');
            }elseif($admin['password'] != md5($admin['user_name'] . $oldPwd)){
                $rs = getRs(1, '旧密码错误');
            }elseif($admin['password'] == md5($admin['user_name'] . $newPwd)){
                $rs = getRs(1, '新密码不能和旧密码一样');
            }else{
                $update = [
                    'id' => $admin['id'],
                    'password' => md5($admin['user_name'] . $newPwd),
                ];
                Users::updateUsers($update);
                $rs = getRs(0, '修改成功');
            }
            return json($rs);
        }
    }

    public function unlock(){
        if(Request::param('pwd')){
            $admin = $this->_admin;
            $pwd = Request::param('pwd');
            if(md5($admin['user_name'].$pwd) == $admin['lock_screen']){
                $rs = getRs(0, '已解锁');
            }else{
                $rs = getRs(2, '锁屏密码错误');
            }
        }else{
            $rs = getRs(1, '锁屏密码错误');
        }

        return json($rs);
    }
}