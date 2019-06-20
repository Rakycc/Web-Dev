<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/12 0012
 * Time: 10:16
 */

namespace app\admin\controller;


use app\admin\model\User;
use app\common\controller\Common;
use think\Session;

//管理界面的主界面
class Index extends Common
{
    /**
     * 主界面
     */
    public function index(){
        $name = session("username");
        $this->assign("username",$name);
        return $this->fetch();
    }

    /**
     * 修改标题
     */
    function title(){
        return $this->fetch();
    }

    /**
     * 用户列表
     */
    function userInfo(){
        $user = new User();
        $data = $user->getAllUser();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 占位内容1
     */
    function place_one(){
        return $this->fetch();
    }

    /**
     * 占位内容2
     */
    function place_two(){
        return $this->fetch();
    }
}