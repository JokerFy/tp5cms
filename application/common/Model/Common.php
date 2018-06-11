<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/8
 * Time: 11:17
 */

namespace app\common\Model;
use think\Db;
use think\Model;

class Common extends Model
{


    public static function getMenuByUser($uid){

        $group = Db::table('cms_auth_group_access')->where('uid',$uid)->find();
        $rules = Db::table('cms_auth_group')->where('id',$group['group_id'])->find();
        $rules = explode(',',$rules['rules']);

        $authMenu = [];
        foreach ($rules as $item){
            $authMenu[] = Db::table('cms_auth_rule')->where('id',$item)->find();
        }
        return $authMenu;
    }

    public function getNewsByNewsIdIn($table,$newsIds) {
        if(!is_array($newsIds)) {
            throw exception("参数不合法");
        }
        $data = array(

            'id' => array('in',implode(',', $newsIds)),
        );

        return Db::table('cms_'.$table)->where($data)->select();
    }


}