<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/29
 * Time: 下午8:06
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPostiveInteger',
        'count' => 'require|isPostiveInteger'
    ];

    protected function checkProducts($value){
        if (!is_array($value)){
            throw new ParameterException([
                'msg' => '参数不合法'
            ]);
        }

        if (empty($value)){
            throw new ParameterException([
                'mag' => '商品列表不能为空'
            ]);
        }

        foreach ($value as $product){
            $this->checkProduct($product);
        }

        return true;
    }

    protected function checkProduct($product){
        $validate = new BaseValidate($this-> singleRule);
        $result = $validate -> check($product);
        if (!$result){
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}