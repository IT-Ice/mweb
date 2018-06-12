<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/9
 * Time: 下午7:26
 */

namespace app\api\model;


use app\lib\exception\ProductException;

class Product extends BaseModel
{
    protected $hidden = ['delete_time','create_time','update_time','summary','img_id','pivot','category_id','from'];

    public function getMainImgUrlAttr($value,$data){
       return $this ->prefixImgUrl($value,$data);
    }

    public function imgs(){
        return $this->hasMany('productImage','product_id','id');
    }

    public function properties(){
        return $this->hasMany('productProperty','product_id','id');
    }
    /**
     * @param $count
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ProductException
     * @remake 根据数量获取最近新品
     */
    public static function getMostRecent($count){
        $products = self::limit($count) -> order('create_time desc') -> select();
        if($products -> isEmpty()){
            throw new ProductException();
        }
        return $products;
    }

    /**
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ProductException
     * @remake 根据商品类型ID获取相关商品
     */
    public static function getProductByCategoryID($id){
        $products = self::where('category_id','=',$id) ->select();
        if($products->isEmpty()){
            throw new ProductException();
        }
        return $products;
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws ProductException
     * @remake 根据商品ID获取商品详情
     */
    public static function getProductDetail($id){
        $product = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])->order('order','asc');
            }
        ])->with(['properties'])->find($id);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }
}