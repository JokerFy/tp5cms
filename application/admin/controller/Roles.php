<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/9
 * Time: 19:38
 */

namespace app\admin\controller;

use app\common\Model\Rules as RulesModel;
use think\Db;
use think\Exception;

class Roles extends Base
{
    public function index()
    {
        $roleList = Db::table('cms_auth_group')->where('status', 1)->select();
        return $this->fetch('', ['roleList' => $roleList]);
    }

    public function add()
    {
        $RuleList = RulesModel::ruleTree();
        return $this->fetch('', ['ruleList' => $RuleList]);
    }

    public function edit()
    {
        $id = $this->request->get('id');
        if ($id) {
            $RuleList = RulesModel::ruleTree();
            $result = Db::table('cms_auth_group')->where('id', $id)->find();
            return $this->fetch('', ['ruleList' => $RuleList, 'rolesInfo' => $result]);
        }
        return show(0, '操作失败');

    }

    public function store()
    {
        $data = $this->request->post();
        if ($data) {
            if (!$data['title']) {
                return show(0, '请填写角色名');
            }
            $data['rules'] = implode(',', $data['rules']);
            if ($data['id']) {
                $res = Db::table('cms_auth_group')->where('id',$data['id'])->update($data);
                if ($res) {
                    return show(1, '修改成功');
                }
                return show(0, '修改失败');
            } else {
                $res = Db::table('cms_auth_group')->insert($data);
                if ($res) {
                    return show(1, '添加成功');
                }
                return show(0, '添加失败');
            }
        }
        return show(0, '操作失败');
    }

}