<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/3
 * Time: 22:13
 */

namespace app\admin\controller;

use app\common\model\Menu as MenuModel;

class Menu extends Base
{
    public function index()
    {
//        $navs = model("Menu")->getNavMenus();
        return $this->fetch('');
    }

    public function add()
    {
        if ($_POST) {
            $data = $this->request->post();
            $Menu = new MenuModel();
            $result = $Menu->data($data)->save();
            if ($result) {
                return show(1, '添加成功');
            } else {
                return show(0, '添加失败');
            }
        }
        return $this->fetch();
    }

    public function edit()
    {
        print_r($_GET);exit;
        return $this->fetch();
    }

    public function listorder()
    {
        $listorder = $_POST['listorder'];
        if ($listorder) {
            foreach ($listorder as $menuId => $v) {
                // 执行更新
                $Menu = new MenuModel();
                $result = $Menu::updateListorderById($menuId, $v);
            }
            return show(1, '排序成功');
        }
        return show(0, '排序数据失败');
    }

}

