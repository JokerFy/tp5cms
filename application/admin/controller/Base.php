<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/3
 * Time: 11:34
 */

namespace app\admin\controller;
use app\api\service\Token;
use think\Controller;
use think\Request;
use \app\common\model\Menu as MenuModel;
class Base extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $res = session('adminUser');
        if(empty($res)){
            $this->redirect('Login/index');
        }
    }

    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }

    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }

    protected function checkSuperScope()
    {
        Token::needSuperScope();
    }
}