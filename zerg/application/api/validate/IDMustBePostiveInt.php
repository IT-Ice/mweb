<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/25
 * Time: 下午8:26
 */

namespace app\api\validate;


use think\Validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPostiveInteger'
    ];

    protected $message = [
        'id' => 'id必须是正整数'
    ];

}