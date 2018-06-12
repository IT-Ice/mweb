<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/9
 * Time: 下午7:26
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;

class Theme
{
    /**
     * @param string $ids
     * @url themt?ids=id1,id2,id3.....
     * @return 一组theme模型
     */
    public function getSimpleList($ids = ''){
        (new IDCollection()) ->goCheck();
        $theme = ThemeModel::getThemeByIDs($ids);
        return $theme;
    }

    /**
     * @param $id
     * @url theme/:id
     * @return 指定id的theme模型
     */
    public function getComplexOne($id){
        (new IDMustBePostiveInt()) -> goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        return $theme;
    }
}