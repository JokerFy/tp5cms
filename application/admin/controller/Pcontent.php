<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/8
 * Time: 14:25
 */

namespace app\admin\controller;
use think\Db;
use app\common\model\Menu as Menu;

class Pcontent extends Base
{
    public function index(){
        $positions = Db::table('cms_position')
            ->select();
        // 获取推荐位里面的内容
        $data['status'] = array('neq', -1);

        if($this->request->get('position_id')){
            $data['position_id'] = $this->request->get('position_id');
            $this->assign(['positionId'=>$data['position_id']]);
        }else{
            $this->assign(['positionId'=>0]);
        }


        if($this->request->get('title')){
            $data['title'] = $this->request->get('title');
            $this->assign(['artTitle'=>$data['title']]);
        }else{
            $this->assign(['artTitle'=>'']);
        }

        if(!empty($data['title'])){
            $data['title'] =  array('like', '%'.$data['title'].'%');
        }
        $contents = Db::table('cms_position_content')
            ->where($data)
            ->order('listorder desc,id desc')
            ->paginate(5);

        $pages = $contents->render();
        return $this->fetch('',
            ['position'=>$positions,
                'contents'=>$contents,
                'pages'=>$pages,

            ]
        );
    }

    public function add(){
        $positions = Db::table('cms_position')
            ->select();
        return $this->fetch('',['positions'=>$positions]);
    }

}