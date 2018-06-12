<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/8
 * Time: 下午7:28
 */

namespace app\api\model;


use think\Model;

class BannerItem extends BaseModel
{
    //隐藏字段
    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];
    /**
     * @remake BannerItem表通过img_id关联Image表 （一对一的关系：belongsTo）
     */
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}