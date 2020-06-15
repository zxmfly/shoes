<?php
/**
 * User: zengxianmao
 * Date: 2020/6/9
 * Time: 17:59
 */

namespace app\controller;


use think\facade\Db;
use think\facade\Request;
use think\facade\View;
use app\model\Orders;

class Order extends BaseAdmin
{
    public function index(){
        $status_arr = getDict('order_status');
        $page_defult = $this->_pageDefault;
        $page_list = json_encode($this->_pageArr);
        $data = compact('page_defult','page_list','status_arr');

        View::assign($data);
        if(empty($param)) return View::fetch();
    }

    public function getList(){
        $param = Request::param();
        $where = [];
        if(isset($param['customer_express']) && $param['customer_express']){
            $where[] = ['customer_express','=',$param['customer_express']];
        }
        if(isset($param['status']) && $param['status']!= ''){
            $where[] = ['status', '=', $param['status']];
        }
        if(isset($param['order_id']) && $param['order_id']){
            $where[] = ['order_id', '=', $param['order_id']];
        }
        if(isset($param['date_time']) && $param['date_time']){
            $time_arr = getDateTime($param['date_time']);
            $where[] = ['create_time','between',[$time_arr['start_time'], $time_arr['end_time']]];
        }
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : $this->_pageDefault;
        $all = Orders::getAll($where, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function getCustomer(){
        $param = Request::param();
        $keywords = isset($param['keywords']) && $param['keywords'] ? $param['keywords'] : '';
        $where = [];
        if($keywords){
            $where[] = is_numeric($keywords) ? ['phone_number', 'like',"%{$keywords}"] : ['name', 'like', "%{$keywords}%"];
            $customer = Db::name('customer')->where($where)->select()->toArray();
            $data = [];
            if($customer){
                foreach ($customer as $row){
                    $key = $row['name'] .' | '.$row['phone_number'];
                    $data[$key] = $row['name'] .'|'.$row['phone_number'] .'|'.$row['address'].'|'.$row['postal_code'].'|'.$row['id'];
                }
                $rs = getRs(0, '操作成功', $data);
            }else{
                $rs = getRs(1, '操作成功', $data);
            }
            return json($rs);
        }else{
            return json(getRs(1, '关键词为空'));
        }
    }

    public function addOrder(){
        $param = Request::param();
        $channel = getDict('channel');
        $data = compact('channel');
        View::assign($data);
        if(empty($param)) return View::fetch();
        $customer_id = intval($param['customer_id']);
        if(empty($param['customer_express']) || empty($param['channel_id'])){
            return json(getRs(1,'缺少必要的参数'));
        }
        if(empty($customer_id)){//新增客户信息
            if(empty($param['name']) || empty($param['phone_number']) || empty($param['address'])){
                return json(getRs(1, '客户信息不全'));
            }
            $customer = [
                'name'      => $param['name'],
                'phone_number' => $param['phone_number'],
                'address'   => $param['address'],
                ];
            $customer_id = Db::name('customer')->insertGetId($customer);
            $param['customer_id'] = $customer_id;
        }
        $order_info = Orders::where('customer_express','=', $param['customer_express'])->find();
        if(!empty($order_info)){
            return json(getRs(3,'操作失败:运单号已存在,请勿重新添加'));
        }
        unset($param['customer_keywords'],$param['name'],$param['phone_number'],$param['address'],$param['postal_code']);
        $param['order_id'] = 'ch'.date('YmdHis').rand(1000, 9999);
        $param['create_time'] = time();
        $admin = $this->_admin;
        $param['operator_id'] = $admin['id'];
        $param['operator'] = $admin['name'];
        $result = Orders::insert($param);
        if($result){
            $rs = getRs();
            //新增追踪
            $track = [
                'order_id'  => $param['order_id'],
                'status'    => 0,
                'create_time' => $param['create_time'],
                'operator_id' => $param['operator_id'],
                'operator'  => $param['operator'],
            ];
            Db::name('track')->insert($track);
        }else{
            $rs = getRs(2,'新增失败');
        }
        return json($rs);
    }

    public function addTask(){

    }


}