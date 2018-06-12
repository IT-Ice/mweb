<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/29
 * Time: 下午8:34
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\User;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
use think\Db;
use think\Exception;

class Order
{
    protected $uid;
    protected $oProducts;
    protected $products;

    public function place($uid,$oProducts){
        $this -> uid = $uid;
        $this -> oProducts = $oProducts;
        $this -> products = $this->getProducesByOrder($oProducts);
        $status = $this->getOrderStatus();
        if (!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }

        //创建订单快照
        $orderSnap = $this->snapOrder($status);

        //创建订单，写入数据库
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    private function createOrder($snap){
        Db::startTrans(); //开启事务
        try{
            $orderNo = self::makeOrderNo();
            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();

            $orderID = $order->id;
            $create_time = $order->create_time;
            foreach ($this->oProducts as &$p){
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit(); //提交事务
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        }catch (Exception $e){
            Db::rollback(); //事务回滚
            throw $e;
        }
    }

    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

    private function snapOrder($status){
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => ''
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        $count = count($this->products);
        if ($count>1){
            $snap['snapName'] = $this->products[0]['name'].$count.'个等';
        }
        return $snap;
    }

    private function getUserAddress(){
        $userAddress = UserAddress::where('user_id','=',$this->uid)->find();
        if (!$userAddress){
            throw new UserException([
               'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => '60001'
            ]);
        }
        return $userAddress -> toArray();
    }

    private function getOrderStatus(){
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];

        foreach ($this ->oProducts as $oProduct){
            $pStatus = $this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);
            if (!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products){
        $pIndex = -1;

        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];

        for ($i = 0;$i<count($products);$i++){
            if ($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }

        if($pIndex==-1){
            throw new OrderException([
                'msg' => 'id为'.$oPID.'的商品不存在，创建订单失败'
            ]);
        }else{
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $oCount * $product['price'];
            if ($product['stock'] - $oCount >= 0){
                $pStatus['haveStock'] = true;
            }

        }
        return $pStatus;
    }

    private function getProducesByOrder($oProducts){
        $oPIDs = [];
        foreach ($oProducts as $oProduct) {
            array_push($oPIDs,$oProduct['product_id']);
        }

        $products = Product::all($oPIDs) -> visible(['id','price','stock','name','main_img_url'])->toArray();
        return $products;
    }
}