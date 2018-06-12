<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/15
 * Time: 下午8:14
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_time', 'update_time'];

}