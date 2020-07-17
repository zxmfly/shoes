<?php
/**
 * User: zengxianmao
 * Date: 2020/7/8
 * Time: 17:55
 */

namespace app\controller;


use app\BaseController;
use app\model\SystemLogs;
use think\facade\Request;
use think\facade\View;

class Log extends BaseAdmin
{
    public function sysLogs(){

        return View::fetch();
    }

    public function getListSys(){
        $param = Request::param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 20;
        $all = SystemLogs::getAll(true, $page, $limit);

        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }
}