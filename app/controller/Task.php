<?php
/**
 * User: zengxianmao
 * Date: 2020/6/23
 * Time: 17:22
 */

namespace app\controller;


use app\model\Fixs;
use think\facade\Request;
use think\facade\View;

class Task extends BaseAdmin
{
    public function index(){
        echo "任务列表";
    }

    public function add(){
        if(Request::method() == 'GET' && Request::param('oid')){
            $data = ['order_id'=> Request::param('oid'),'repair_order'=>Request::param('rep_oid')];
            View::assign($data);
        }
        return View::fetch();
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
}