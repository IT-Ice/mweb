<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/29
 * Time: 下午6:54
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }
}