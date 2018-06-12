<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/9/6
 * Time: 下午9:24
 */

namespace app\api\validate;


use think\Validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPostiveInteger'
    ];

    protected $message = [
        'id' => 'ID必须是正整数'
    ];

    protected function isPostiveInteger($value,$rule = '',$data = '',$field = ''){
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }else{
            return false;
        }
    }
}