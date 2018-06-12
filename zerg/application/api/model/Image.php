<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/8
 * Time: 下午7:40
 */

namespace app\api\model;


use think\Model;

class Image extends BaseModel
{
    //设置隐藏字段
    protected $hidden = ['id','from','delete_time','update_time'];

    public function getUrlAttr($value,$data){
       return $this ->prefixImgUrl($value,$data);
    }

}