<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/4
 * Time: 9:44
 */

namespace app\common\model;

use think\Model;

class Menu extends Model
{
    public function getNavMenus()
    {
        $data = array(
            'status' => array('neq', -1),
            'type' => 1,
        );

        return $menu = self::where($data)
            ->order('listorder desc,menu_id desc')
            ->select();
    }

    public static function updateListorderById($menuId, $v)
    {
        return self::where('menu_id', $menuId)
            ->update(['listorder' => $v]);
    }
}