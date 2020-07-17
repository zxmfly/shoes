<?php
/**
 * User: zengxianmao
 * Date: 2020/7/7
 * Time: 15:59
 */

namespace app\controller;


use app\model\Notices;
use think\facade\Request;
use think\facade\View;

class Notice extends BaseAdmin
{
    public function index(){
        $page_defult = $this->_pageDefault;
        $page_list = json_encode($this->_pageArr);
        $data = compact('page_defult','page_list');
        View::assign($data);
        return View::fetch();
    }

    public function getNotice(){
        $min_time = strtotime(date('Y-m-d'));
        $max_time = time();
        $where[] = ['is_show' , '=', 1];
        $where[] = ['start_time', '<=', $min_time];
        $where[] = ['end_time', '>', $max_time];

        if(Request::Get('action') == 'checkNotice'){
            $c = Notices::where($where)->count();
            return json(getRs($c));
        }

        $notices = Notices::where($where)->select()->toArray();
        $data = compact('notices');
        View::assign($data);
        return View::fetch();
    }

    public function getList(){
        $param = Request::param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 20;
        $all = Notices::getAll(true, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function add(){
        $data = Request::param();
        if(empty($data)){
            $start_time = date('Y-m-d');
            $end_time = date("Y-m-d",strtotime("+1 day"));
            $data = compact('start_time','end_time');
            View::assign($data);
            return View::fetch();
        }
        if($data['id']){
            if(isset($data['action']) && $data['action'] == 'switch'){
                $data['is_show'] = $data['is_show'] == 'true' ? 1 : 0;
                unset($data['action']);
            }else {
                $data['is_show'] = isset($data['is_show']) ? 1 : 0;
                $data['start_time'] = strtotime($data['start_time']);
                $data['end_time'] = strtotime($data['end_time']) + 86400 - 1;
            }
            Notices::update($data);
            $rs = ['code'=>0,'msg'=>'修改成功'];
            return json($rs);
        }else{
            $data['is_show'] = isset($data['is_show']) ? 1 : 0;
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']) + 86400 - 1;
            $data['operator'] = $this->_admin['name'];
            $data['create_time'] = time();
            Notices::insert($data);
            $res = ['code'=>0,'msg'=>'添加成功'];
            return json($res);
        }
    }

    public function del(){
        if(Request::param('id')) {
            $id = Request::param('id');
            $delete = Notices::destroy($id);
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