<?php
namespace app\index\controller;
use think\Controller;
class Index
{
    public function index()
    {
      //if(cookie('user_name'))
    	echo "您好： " . cookie('user_name') . ', <a href="' . url('login/loginout') . '">退出</a>';
      //else url('login/index');
     // else $this->redirect(url('index/index'));
    }
  }

