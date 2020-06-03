<?php
/**
 * User: zengxianmao
 * Date: 2020/5/30
 * Time: 11:04
 */

namespace app\model;

use think\Model;

class Users extends Model
{
    public function getWorkIdAttr($value)
    {
        $workArr = [1=>'客服',2=>'采购',3=>'财务'];
        return $workArr[$value];
    }
    public function getStatusAttr($value)
    {
        $status = [0=>'正常',1=>'禁用',2=>'离职'];
        return $status[$value];
    }
}