<?php
namespace app\index\controller;
use think\Controller;
class Login extends Controller{
  public function index(){
    return $this->fetch();
  }
  public function register(){
    return $this->fetch();
  }
  public function ccb(){
    return $this->fetch();
  }
   public function studentloan(){
    return $this->fetch();
  }
     public function weather(){
    return $this->fetch();
  }
  // 处理登录逻辑
  public function doLogin(){
    if(isset($_POST['dl'])){
      $param = input('post.');
      if(empty($param['user_name'])){
        $this->error('用户名不能为空');
      }
      if(empty($param['user_pwd'])){
        $this->error('密码不能为空');
      }
      //echo ($param['user_name']);
      //echo ($param['user_pwd']);
      // 验证用户名
      $has = db('users')->where('user_name', $param['user_name'])->find();
      if(empty($has)){
        $this->error('用户名密码错误');
      }
      // 验证密码
      if($has['user_pwd'] != md5($param['user_pwd'])){
        $this->error('用户名密码错误');
      }
      // 记录用户登录信息
      cookie('user_id', $has['id'], 3600);  // 一个小时有效期
      cookie('user_name', $has['user_name'], 3600);
      $this->redirect(url('index/index'));
    }
    else if(isset($_POST['zc'])){
      $this->redirect(url('login/register'),'',3,'前往用户注册中心!...页面跳转中...');
    }
  }
  public function doRegister(){
    //$this->redirect(url('login/register'));
    if(isset($_POST['reg'])){
      $param = input('post.');
      if(empty($param['user_name'])){
        $this->error('用户名不能为空');
      }
      if(empty($param['user_pwd'])){
        $this->error('密码不能为空');
      }
      // 验证用户名
      $has = db('users')->where('user_name', $param['user_name'])->find();
      if($has){
        $this->error('用户名已存在');
      }
      // 注册
      $data=array(
        'id'=>NULL,
        'user_name'=>$param['user_name'],
        'user_pwd'=>md5($param['user_pwd']),
      );
      if(db('users') -> insert($data)){		//添加数据
				$this->redirect(url('login/index'));
      }
      else{
				echo "<script>alert('注册失败！');</script>";
      }
      // if($insert){   // 如果注册成功
      
      //}
     //else{
       // echo "<script>alert('注册失败！');</script>";
      //}
    }
  }
  public function loginOut(){
    cookie('user_id', null);
    cookie('user_name', null);
    $this->redirect(url('login/index'));
  }
}