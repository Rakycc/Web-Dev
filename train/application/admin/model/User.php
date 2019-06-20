<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/13 0013
 * Time: 11:08
 */

namespace app\admin\model;


use think\Exception;
use think\Model;

class User extends Model
{
    protected $table = "user";

    /**
     * 返回所有用户信息
     */
    function getAllUser(){
        $user = new User();
        try{
            $data = $user->where('is_delete',0)->select();
        }catch (Exception $e){
        }
        return $data;
    }
    /**
     * 根据用户名密码查找用户
     */
    function findUser($name,$pwd){
        $user = new User();
        try{
            $has = $user->where(["username"=>$name,"password"=>md5($pwd),"is_delete"=>0])->find();
        }catch (Exception $e){
        }
        return $has;
    }

    /**
     * 新增用户数据
     */
    function addNewUser($name,$pwd){
        $user = new User();
        try{
            $has = $user->where(["username"=>$name,"is_delete"=>0])->find();
            if(!$has){
                $res = $user->data(["username"=>$name,"password"=>md5($pwd),"is_delete"=>0])->save();
            }
            else return null;
        }catch (Exception $e){
        }
        return $res;
    }
}