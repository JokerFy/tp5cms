<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/3
 * Time: 13:31
 */

namespace app\admin\controller;
use app\common\Model\Admin;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if (session('adminUser')) {
            $this->redirect('index/index');
        }
        return $this->fetch();
    }

    public function check($ac = '', $se = '')
    {
        $ret = new Admin();
        $result = $ret->getAdminByUsername($ac, $se);
        if ($result) {
            session('adminUser', $result);
            return show(1, '登录成功', $ret);
        }
        return show(0, '账号不存在', $ret);

    }

    public function loginout()
    {
        session('adminUser', null);
        $this->redirect('index');
    }
}