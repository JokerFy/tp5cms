<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/5
 * Time: 13:14
 */

namespace app\common\Model;
use think\Db;
use think\Model;

class Curd extends Model
{
    protected $autoWriteTimestamp = true;
    public function __construct($table)
    {
        $this->table = 'cms_'.$table;
        parent::__construct($table);
//        $this->table = 'cms_'.$table;
    }

    public function listUpdate($id,$listid)
    {
        return  Db::table($this->table)->where('id',$id)->update(['listorder'=>$listid]);
    }

    /*  return  Db::table($this->table)->insert($data);
                  return  Db::table($this->table)->where('id',$id)->update($data);
                  return  Db::table($this->table)->where('id',$id)->update(['status'=>-1]);*/
    public function TableCRUD($data){
        $methodType = $data['methodType'];
        switch ($methodType){
            case 'add':
                $this->dataUnset($data);
                return self::data($data)->save();
                break;
            case 'update':
                $id = $data['id'];
                $this->dataUnset($data);
                return self::where('id',$id)
                        ->update($data);
                break;
            case 'delete':
                $id = $data['id'];
                return self::where('id',$id)
                    ->update(['status'=>-1]);
                break;
            case 'realDelete':
                $id = $data['id'];
                return self::where('id','=',$id)->delete();
                break;
        }
        return '';
    }

    private function dataUnset(&$data){
        unset($data['table']);
        unset($data['methodType']);
    }

}