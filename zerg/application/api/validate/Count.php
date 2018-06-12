<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/9
 * Time: 下午11:49
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPostiveInteger|between:1,15'
    ];

}