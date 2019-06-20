<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/12 0012
 * Time: 9:18
 */
namespace app\common\controller;
use app\common\model\Menu;
use think\Controller;
use think\Exception;
use think\Session;


//作为所有类的公共父类
class Common extends Controller{
    //初始化函数,获取公用菜单和标题
    public function _initialize()
    {
        //获取模块/控制器/方法名
        $module = request()->module();
        $controller = request()->controller();
        $action = request()->action();
        //查询到当前高亮菜单id
        $menu = new Menu();
        $menu_id = $menu->getIdByMvc($module,$controller,$action);
        $all_menu = $menu->getAllByOrder();
        if($menu_id){
            $this->assign('menu_id',$menu_id);
        }
        $this->assign('all_menu',$all_menu);

        try{
            $title = db('title')->where('is_delete',0)->field('title')->find();
        }catch (Exception $e){
        }
        $this->assign('title',$title['title']);
    }
}