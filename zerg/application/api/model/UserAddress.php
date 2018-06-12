<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/29
 * Time: 下午5:01
 */

namespace app\api\model;



class UserAddress extends BaseModel
{
    protected $hidden = ['user_id','delete_time','id'];
}