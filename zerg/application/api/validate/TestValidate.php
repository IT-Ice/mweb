<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/18
 * Time: 下午10:48
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'email' => 'email'
    ];

}