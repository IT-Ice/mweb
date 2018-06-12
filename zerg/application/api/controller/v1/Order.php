<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/29
 * Time: 下午7:30
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\UserToken;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder(){
        (new OrderPlace()) -> goCheck();
        $products = input('post.products/a');
        $uid = UserToken::getCurrentUid();

        $order = new OrderService();
        $status = $order ->place($uid,$products);
        return $status;
    }
}