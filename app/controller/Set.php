<?php
/**
 * User: zengxianmao
 * Date: 2020/7/17
 * Time: 15:35
 */

namespace app\controller;


use app\model\Sets;
use think\facade\Request;
use think\facade\Config;
use think\facade\View;

class Set extends BaseAdmin
{
    public function index(){
        $sets = Sets::column('values','id');
        $keys = Config::get('set');

        $data = compact('sets','keys');
        View::assign($data);
        return View::fetch();

    }

    public function edit(){
        $all = Request::param();
        $keys = Config::get('set');
        $sets = Sets::column('values','id');

        foreach ($all as $key => $values){
            $id = intval($key);
            if(!isset($keys[$id])){
                continue;
            }
            if($keys[$id]['rule'] == 'int'){
                $values = intval($values);
            }
            if($sets[$id] == $values) {
                continue;
            }

            Sets::update(compact('id','values'));
        }

        return json(getRs(0,'保存成功'));
    }
}