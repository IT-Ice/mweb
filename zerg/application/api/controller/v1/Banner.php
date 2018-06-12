<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/18
 * Time: 下午10:21
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{
    /**
     * @remake 根据id获取指定banner
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     */
    public function getBanner($id){
        //参数验证
        (new IDMustBePostiveInt()) ->goCheck();
        //调用业务层处理业务逻辑
        $banner = BannerModel::getBannerById($id);
        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}