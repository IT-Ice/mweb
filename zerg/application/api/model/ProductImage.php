<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/15
 * Time: 下午8:11
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'product_id', 'delete_time'];

    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }
}