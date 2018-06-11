<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/9
 * Time: 11:52
 */

namespace app\admin\controller;
use app\common\Model\Admin as AdminModel;

class Admin extends Base
{
    public function index(){
        $list = AdminModel::all(['status'=>1]);
        return $this->fetch('',['list'=>$list]);
    }

    public function add(){
        return $this->fetch('');
    }

    public function edit()
    {
        if($_GET['id']){
            $id = $_GET['id'];
            $result = AdminModel::get($id);
            return $this->fetch('',['admin'=>$result]);
        }
        return show(0, '操作失败');
    }
}