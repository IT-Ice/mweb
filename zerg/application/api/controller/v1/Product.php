<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/9
 * Time: 下午11:47
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePostiveInt;

class Product
{
    public function getRecent($count = 15){
        (new Count()) -> goCheck();
        $products = ProductModel::getMostRecent($count);
        $products = $products -> hidden(['summary']);

        return $products;
    }

    public function getAllInCategory($id){
        (new IDMustBePostiveInt()) ->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        $products = $products -> hidden(['summary']);

        return $products;
    }

    public function getOne($id){
        (new IDMustBePostiveInt()) ->goCheck();
        $product = ProductModel::getProductDetail($id);

        return$product;
    }
}