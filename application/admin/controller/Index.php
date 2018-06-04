<?php
namespace app\admin\controller;

use app\admin\controller\Base;

class Index extends Base
{
/*    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'index']
    ];*/

    public function welcome(){
        return $this->fetch();
    }

    public function index()
    {
        return $this->fetch();
    }
}
