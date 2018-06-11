<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/7
 * Time: 10:19
 */

namespace app\admin\controller;

use think\Db;

class Position extends Base
{

    public function index(){
        $list = Db::table('cms_position')
                ->select();
        return $this->fetch('',['list'=>$list]);
    }

    public function add(){
        return $this->fetch('');
    }

    public function edit(){
        if($_GET['id']){
            $id = $_GET['id'];
            $result = Db::table('cms_position')->where('id',$id)->find();
            return $this->fetch('',['position'=>$result]);
        }
        return show(0, '操作失败');
    }

}