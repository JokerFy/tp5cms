<?php

namespace app\admin\controller;

use app\admin\controller\Base;
use app\common\Model\Common as Common;
use app\common\Model\Rules as RulesModel;

class Index extends Base
{
    /*    protected $beforeActionList = [
            'checkSuperScope' => ['only' => 'index']
        ];*/

    public function welcome()
    {
        return $this->fetch();
    }

    public function index()
    {
        $admin = session('adminUser');
        $uid = $admin['id'];

        if ($uid === 1) {
            $navMenu = model('rules')->where('level', 2)->order('id asc')->select();
            foreach ($navMenu as $item) {
                $item['son'] = model('rules')->where('pid', $item['id'])->select();
                if(!isset($item['son'])){
                    $items['son'][]='';
                }
            }
//            print_r($navMenu);exit;
            $this->assign('navMenu', $navMenu);
        } else {
            $navMenu = Common::getMenuByUser($uid);
            $nav = [];
            foreach ($navMenu as $item) {
                if ($item['level'] == 2) {
                    $nav[] = $item;
                }
            }
            foreach ($nav as &$items) {
                foreach ($navMenu as $item){
                    if($item['level']==3 && $item['pid']==$items['id']){
                        $items['son'][] = $item;
                    }
                }
                if(!isset($items['son'])){
                    $items['son'][]='';
                }
            }
            $this->assign('navMenu', $nav);
        }

        return $this->fetch('', ['admin' => $admin]);
    }

    public function navMenu()
    {
        $res = session('adminUser');
        $uid = $res['id'];
        if ($uid === 1) {
            $tree = RulesModel::ruleTree();
            return $this->fetch('public/nav', ['navMenu' => $tree]);
        }
    }
}
