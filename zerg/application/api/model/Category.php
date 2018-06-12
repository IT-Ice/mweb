<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/13
 * Time: 下午8:47
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time','update_time','create_time'];

    public function img(){
        return $this ->belongsTo('Image','topic_img_id','id');
    }

    public static function getAllCategories(){
        $categories = self::all([],'img');
        return $categories;
    }
}