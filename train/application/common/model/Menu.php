<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/12 0012
 * Time: 12:08
 */

namespace app\common\model;


use think\Exception;
use think\Model;

class Menu extends Model
{
    protected $table = 'menu';

    /**
     * 返回排序好的菜单数组
     */
    function getAllByOrder(){
        $menu = new Menu();
        try{
            $data = $menu->where('is_delete',0)->order('number')->select();
        }catch (Exception $e){
        }
        return $data;
    }
    /**
     * 根据模块/控制器/方法返回相应的菜单id
     */
    function getIdByMvc($module,$controller,$action){
        $menu = new Menu();
        try{
            $data = $menu->where(['module'=>$module,'controller'=>$controller,'action'=>$action,'is_delete'=>0])
                ->field('id')->find();
        }catch (Exception $e){

        }
        return $data['id'];
    }
}