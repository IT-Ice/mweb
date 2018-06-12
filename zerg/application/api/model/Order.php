<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/30
 * Time: 下午5:52
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

}