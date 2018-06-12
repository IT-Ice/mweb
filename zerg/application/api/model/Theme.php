<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/9
 * Time: 下午7:26
 */

namespace app\api\model;


use app\lib\exception\ThemeException;

class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];
    //Theme 表关联 Image表
    public function topicImg(){
        return $this -> belongsTo('Image','topic_img_id','id');
    }

    //Theme 表关联 Image表
    public function headImg(){
        return $this -> belongsTo('Image','head_img_id','id');
    }

    //Theme 表关联 Product表
    public function products(){
        return $this -> belongsToMany('Product','theme_product','product_id','theme_id');
    }

    /**
     * @param $ids
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ThemeException
     * @remake 根据一组id获取一组theme 模型
     */
    public static function getThemeByIDs($ids){
        $ids = explode(',',$ids);
        $theme = self::with('topicImg,headImg') -> select($ids);
        if($theme ->isEmpty()){
            throw new ThemeException();
        }
        return $theme;
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws ThemeException
     * @remake 根据一个id获取一个包含商品的主题信息
     */
    public static function getThemeWithProducts($id){
        $theme = self::with('products,topicImg,headImg')->find($id);
        if(!$theme){
            throw new ThemeException();
        }
        return $theme;
    }
}