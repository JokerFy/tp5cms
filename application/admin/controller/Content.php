<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/6
 * Time: 9:44
 */

namespace app\admin\controller;
use app\common\model\Menu as Menu;
use app\common\Model\Common as Common;
use app\common\Model\Curd as Curd;
use think\Db;
use think\Exception;

class Content extends Base
{
    public function index(){
        //推荐位选择列表
        $positions = Db::table('cms_position')
            ->select();

        //文章列表
        $articleList = Db::table('cms_news')->where(['status'=>1])
                ->order('listorder desc,id desc')
                ->paginate(10);

        $pages = $articleList->render();
        return $this->fetch('',['list'=>$articleList,'position'=>$positions,'pages'=>$pages]);
    }

    public function add(){
        $webSiteMenu = Menu::getBarMenus();
        return $this->fetch('',['webSiteMenu'=>$webSiteMenu]);
    }

    public function edit(){
        if($_GET['id']){
            $id = $_GET['id'];
            $webSiteMenu = Menu::getBarMenus();
            $result = Db::table('cms_news')->where('id',$id)->find();
            return $this->fetch('',['menu'=>$result,'webSiteMenu'=>$webSiteMenu]);
        }
        return show(0, '操作失败');
    }

    public function push() {
        $jumpUrl = '';
        $positonId = intval($_POST['position_id']);
        $newsId = $_POST['push'];
        $table = $_POST['model'];

        if(!$newsId || !is_array($newsId)) {
            return show(0, '请选择推荐的文章ID进行推荐');

        }
        if(!$positonId) {
            return show(0, '没有选择推荐位');
        }
        try {
            $commonModel = new Common();
            $news = $commonModel->getNewsByNewsIdIn('news',$newsId);
            if (!$news) {
                return show(0, '没有相关内容');
            }

            foreach ($news as $new) {
                $data = array(
                    'position_id' => $positonId,
                    'title' => $new['title'],
                    'thumb' => $new['thumb'],
                    'news_id' => $new['id'],
                    'status' => 1,
                    'create_time' => $new['create_time'],
                    'methodType'=>'add'
                );
                $Curd = new Curd($table);
                $position = $Curd->TableCRUD($data);
            }
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }

        return show(1, '推荐成功',array('jump_url'=>$jumpUrl));


    }
}