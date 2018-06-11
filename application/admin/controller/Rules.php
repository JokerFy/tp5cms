<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/9
 * Time: 13:58
 */

namespace app\admin\controller;

use app\common\Model\Rules as RulesModel;
use think\Tree;

class Rules extends Base
{
    public function index()
    {
        $tree = RulesModel::ruleTree();
        $treeList = $this->setPrefix($tree);
        return $this->fetch('', ['field' => $treeList]);
    }

    public function add(){
        $tree = RulesModel::ruleTree();
        $treeList = $this->setPrefix($tree);
        return $this->fetch('', ['field' => $treeList]);
    }

    public function edit()
    {
        if ($_GET['id']) {
            $id = $_GET['id'];
            $result = RulesModel::get($id);
            $tree = RulesModel::ruleTree();
            $treeList = $this->setPrefix($tree);
            return $this->fetch('', ['selectlist' => $treeList,'rule'=>$result]);
        }
        return show(0, '操作失败');

    }

    public function setPrefix($data, $p = '|---')
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while ($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                if ($data[$key - 1]['pid'] != $val['pid']) {
                    $num++;
                }
            }
            if (array_key_exists($val['pid'], $prefix)) {
                $num = $prefix[$val['pid']];
            }
            $val['title'] = str_repeat($p, $num) . $val['title'];
            $prefix[$val['pid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }


}