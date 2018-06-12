<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/13
 * Time: 下午11:12
 */

namespace app\api\model;


class User extends BaseModel
{
    /**
     * @return \think\model\relation\HasOne
     * @remake 用户表和用户地址表 关联
     */
    public function address(){
        return $this -> hasOne('UserAddress','user_id','id');
    }
    /**
     * @param $openid
     * @return $this
     * @remake 根据openid查找记录
     */
    public static function getByOpenID($openid){
        $user = self::where('openid','=',$openid)->find();
        return $user;
    }

    /**
     * @param $openid
     * @return $this
     * @remake 新增一条user记录
     */
    public static function newUser($openid){
        $user = self::create([
            'openid' => $openid
        ]);

        return $user;
    }
}