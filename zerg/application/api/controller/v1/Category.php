<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/13
 * Time: 下午8:46
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategories(){
        $categories = CategoryModel::getAllCategories();
        if($categories -> isEmpty()){
            throw new CategoryException();
        }

        return $categories;
    }

}