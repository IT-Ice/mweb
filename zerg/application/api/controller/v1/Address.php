<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/29
 * Time: 下午3:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    /**
     * @return \think\response\Json
     * @throws UserException
     * @remake 创建或更新用户地址信息
     */
    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate -> goCheck();
        //根据token获取用户的uid
        $uid = TokenService::getCurrentUid();

        //根据uid来查找用户数据，判断用户是否存在，不存在就跑出异常
        $user = UserModel::get($uid);
        if (!$user){
            throw new UserException();
        }

        //获取用户从客户端提交过来的数据
        $dataArray = $validate -> getDataByRule(input('post.'));

        //根据用户地址信息是否存在，来判断是添加地址还是更新地址
        $userAddress = $user -> address;
        if (!$userAddress) {
            $user -> address() -> save($dataArray);
        }else{
            $user -> address -> save($dataArray);
        }

        return json(new SuccessMessage(),200);
    }

}