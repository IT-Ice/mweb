<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/13
 * Time: 下午11:03
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '无效的Code'
    ];
}