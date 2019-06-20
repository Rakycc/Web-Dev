<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/12 0012
 * Time: 13:56
 */

namespace app\admin\controller;


use app\common\controller\Common;
use app\admin\model\Title as TitleM;

class Title extends Common
{
    function updateTitle(){
        $title = new TitleM();
        $newTitle = request()->post("title");//获取到post传来的值
        //echo $newTitle;
        $res = $title->updateTitle($newTitle);
        if($res){
            return json(["msg"=>"修改成功"]);
        }
        else{
            return json(["msg"=>"修改失败"]);
        }
    }
}