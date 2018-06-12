<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/13
 * Time: 下午11:02
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code=''){
        (new TokenGet()) ->goCheck();
        $ut = new UserToken($code);
        $token = $ut ->get();
        return [
            'token' => $token
        ];
    }
}