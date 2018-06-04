<?php
namespace app\common\Model;
use think\Model;

class Admin extends Model{

    public function getAdminByUsername($username, $password){
        $admin=  self::where('username',$username)
            ->where('password',md5($password.config('secure.MD5_PRE')))
            ->find();
        return $admin;
    }

}