<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/25
 * Time: 下午9:44
 */

namespace app\api\model;


use think\Db;
use think\Exception;
use think\Model;

class Banner extends BaseModel
{
    //隐藏不需要的字段
    protected $hidden = ['delete_time' ,'update_time'];
    /**
     * @remake Banner表 关联 BannerItem表（一对多的关系：hasMany）
     */
    public function items(){
        return $this ->hasMany('BannerItem','banner_id','id');
    }

    /**
     * @remake 根据id查询banner
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getBannerById($id){
        $result = self::with(['items','items.img'])->find($id);
        return $result;
    }
}