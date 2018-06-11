<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/9
 * Time: 13:58
 */

namespace app\common\Model;
use think\Model;

class Rules extends Model
{
    protected $table = 'cms_auth_rule';
    public function childTree(){
        return $this->hasMany('Rules','id','pid');
    }

    public static function ruleTree(){
        $ruleList =  self::select();
        $ruleList = collection($ruleList)->toArray();
        $tree = self::getTree($ruleList);
        return $tree;
    }

    public static function getTree($menus, $pid = 0)
    {
        $tree = [];
        foreach ($menus as $menu) {
            if ($menu['pid'] == $pid) {
                $tree[] = $menu;
                $tree = array_merge($tree, self::getTree($menus, $menu['id']));
            }
        }
        return $tree;
    }
}