<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    //设置url字段的完整路径地址
    protected function prefixImgUrl($value,$data){
        $finalUrl = $value;
        if($data['from'] == 1){
            $finalUrl = config('setting.img_path').$value;
        }
        return $finalUrl;
    }
}
