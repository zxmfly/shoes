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

class Order extends BaseAdmin
{
    public function index(){

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


    }

    public function addTask(){

    }


}