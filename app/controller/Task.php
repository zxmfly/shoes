<?php
/**
 * User: zengxianmao
 * Date: 2020/6/23
 * Time: 17:22
 */

namespace app\controller;


use app\model\Fixs;
use app\model\Orders;
use app\model\Tasks;
use app\model\Users;
use think\facade\Request;
use think\facade\View;

class Task extends BaseAdmin
{
    public function index(){
        $status_arr = getDict('order_status');
        $page_defult = $this->_pageDefault;
        $page_list = json_encode($this->_pageArr);
        $data = compact('page_defult','page_list','status_arr');
        $admin = $this->_admin;
        $data['admin'] = $admin['name'];
        View::assign($data);
        if(empty($param)) return View::fetch();
    }

    public function getList(){
        $param = Request::param();
        $where = [];
        if(isset($param['status']) && $param['status']!= ''){
            $where[] = ['status', '=', $param['status']];
        }
        if(isset($param['order_id']) && $param['order_id']){
            $where[] = ['order_id', '=', $param['order_id']];
        }
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : $this->_pageDefault;
        $all = Tasks::getAll($where, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function add(){
        if(Request::method() == 'GET') {
            $order_id = Request::param('oid');
            $repair_order = Request::param('rep_oid');
            $type_arr = [1=>'新增', 2=>'返修'];
            $fix = Fixs::select()->toArray();
            $users = Users::getTaskAll();
            $data = compact('order_id', 'repair_order', 'type_arr', 'fix', 'users');
            View::assign($data);
            return View::fetch();
        }elseif(Request::method() == 'POST'){
            $all = Request::param();
            $task = Tasks::where('order_id', $all['order_id'])->find();
            if($task) return json(getRs(5, '订单任务已创建，请勿重复操作'));
            if($all['type'] == 2 && empty($all['repair_order'])){
                return json(getRs(1,'缺少返修订单号'));
            }
            $user = explode('|', $all['user']);
            $all['uid'] = $user[0];
            $all['user_name'] = $user[1];
            unset($all['user']);
            $all['status'] = $all['repair_order'] ? 11 : 1;
            $all['create_time'] = time();
            $result = Tasks::insertGetId($all);
            if($result) {
                if (!$this->addTrack($all)) {
                    Orders::destroy($result);
                    $rs = getRs(4, '入库失败:追踪记录失败');
                } else {
                    if ($all['repair_order']) {//返修追踪
                        $all['order_id'] = $all['repair_order'];
                        $this->addTrack($all);
                    }
                    $rs = getRs(0, '入库成功');
                }
            }
            Orders::where('order_id', $all['order_id'])->update([
                'status' => $all['status'],
                'prices' => $all['assess_prices']
            ]);
            return json($rs);
        }
    }

    public function fix(){
        $page_defult = $this->_pageDefault;
        $page_list = json_encode($this->_pageArr);
        $data = compact('page_defult','page_list');
        View::assign($data);
        return View::fetch();
    }

    public function getFix(){
        $param = Request::param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 20;
        $all = Fixs::getAll(true, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function addFix(){
        $data = Request::param();
        if(empty($data)) return View::fetch();

        if($data['id']){
            $update = Fixs::updateFix($data);
            if($update){
                $rs = ['code'=>0,'msg'=>'修改成功'];
            }else{
                $rs = ['code'=>1,'msg'=>'修改失败'];
            }
            return json($rs);
        }else{
            $work = Fixs::where('name', $data['name'])->find();
            if($work){
                return json(['code'=>2,'msg'=>'该维修类别已存在,请勿重复添加']);
            }
            $insert = Fixs::insert($data);
            $res = $insert ? ['code'=>0,'msg'=>'添加成功'] : ['code'=>1,'msg'=>'添加失败'];
            return json($res);
        }
    }

    public function delFix(){
        if(Request::param('id')) {
            $id = Request::param('id');
            $delete = Fixs::destroy($id);
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

    public function assignTask(){
        if(Request::param('id') && Request::param('order_id')) {
            $all = Request::param();
            $task['id'] = $all['id'];
            $task['status'] = 2;
            Tasks::updateById($task);
            Orders::where('order_id', $all['order_id'])->update(['status' => 2]);
            $all['status'] = 2;
            $this->addTrack($all);
            $rs = ['code'=>0,'msg'=>'操作成功'];
        }else{
            $rs = ['code'=>3,'msg'=>'操作有误'];
        }
        return json($rs);
    }
}