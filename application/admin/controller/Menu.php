<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/3
 * Time: 22:13
 */

namespace app\admin\controller;

use app\common\model\Menu as MenuModel;
use think\Db;

class Menu extends Base
{
    public function index()
    {
//        $navs = model("Menu")->getNavMenus();
        return $this->fetch('');
    }

    public function add()
    {
        $parentMenu = Db::table('cms_menu')->where('parentid',0)->select();
        return $this->fetch('',['parentMenu'=>$parentMenu]);
    }

    public function edit()
    {
        if($_GET['id']){
            $id = $_GET['id'];
            $result = MenuModel::get($id);
            return $this->fetch('',['menu'=>$result]);
        }
        return show(0, '操作失败');
    }

}

