<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/12 0012
 * Time: 13:08
 */

namespace app\admin\model;


use think\Model;

class Title extends Model
{
    protected $table = "title";

    function updateTitle($newTitle){
        $title = new Title();
        // save方法第二个参数为更新条件
        //这里姑且认为只会有一条is_delete=0的记录
        $isOk = $title->save([
            'title'  => $newTitle,
        ],['is_delete' => 0]);
        return $isOk;
    }
}