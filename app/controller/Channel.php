<?php
/**
 * User: zengxianmao
 * Date: 2020/7/20
 * Time: 17:41
 */

namespace app\controller;

use app\model\Channels;
use think\facade\Request;
use think\facade\View;

class Channel extends BaseAdmin
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
        $all = Channels::getAll(true, $page, $limit);
        $count = $all['count'];
        $data = $all['data'];
        $code = 0;
        $msg = 'ok';
        $list = compact('code','msg','count','data');

        return json($list);
    }

    public function add(){
        $data = Request::param();
        if(empty($data)) return View::fetch();

        if($data['id']){
            Channels::update($data);
            return json(getRs());
        }else{
            $work = Channels::where('channel', $data['channel'])->find();
            if($work){
                return json(['code'=>2,'msg'=>'该渠道已存在,请勿重复添加']);
            }
            $insert = Channels::insert($data);
            $res = $insert ? ['code'=>0,'msg'=>'添加成功'] : ['code'=>1,'msg'=>'添加失败'];
            return json($res);
        }
    }

    public function del(){
        if(Request::param('id')) {
            $id = Request::param('id');
            Channels::destroy($id);
            $rs = ['code'=>0,'msg'=>'删除成功'];
        }else{
            $rs = ['code'=>3,'msg'=>'操作有误'];
        }
        return json($rs);
    }
}