<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
/**
 * 公用的方法
 */
function  show($status, $message,$data=array()) {
    $reuslt = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
    );

    exit(json_encode($reuslt));
}

function menuTree($menus, $level = 0)
{
    $tree = [];
    foreach ($menus as $menu) {
        if ($menu['pid'] == $level) {
            $tree[] = $menu;
            $tree = array_merge($tree, menuTree($menus, $menu['id']));
        }
    }
    return $tree;
}

function getList($pid=0,&$result=array(),$spac=0){

}

function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

function getMenuUrl($nav) {
    $url = '/admin/'.$nav['c'].'/'.$nav['a'];
    if($nav['f']=='index') {
        $url = '/admin.php?c='.$nav['c'];
    }
    return $url;
}

function showKind($status,$data) {
    header('Content-type:application/json;charset=UTF-8');
    if($status===0) {
        exit(json_encode(array('error'=>0,'url'=>$data)));
    }
    exit(json_encode(array('error'=>1,'message'=>'上传失败')));
}
