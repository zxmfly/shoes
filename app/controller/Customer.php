<?php
/**
 * User: zengxianmao
 * Date: 2020/7/16
 * Time: 15:59
 */

namespace app\controller;


use app\model\Customers;
use app\model\Orders;
use think\facade\Request;
use think\facade\View;

class Customer extends BaseAdmin
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
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 20;
        $all = Customers::getAll(true, $page, $limit);
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
            return View::fetch();
        }
        if($data['id']){
            Customers::update($data);
            return json(getRs(0, '添加成功'));
        }else{
            unset($data['id']);

            $data['create_time'] = time();
            Customers::insert($data);
            return json(getRs(0, '修改成功'));
        }
    }

    public function del(){
        $id = Request::Get('id');
        if($id) {
            if(Orders::where('customer_id',$id)->find()){
                return json(getRs(3,'删除失败，需要先删除关联订单'));
            }
            $delete = Customers::destroy($id);
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