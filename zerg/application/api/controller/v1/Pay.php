<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/30
 * Time: 下午8:17
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder(){

    }
}