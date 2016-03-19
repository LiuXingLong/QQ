<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{
	// 调用控制器初始方法
    public function _initialize(){
		if(empty($_SESSION['status'])){
			$this->redirect("Login/index");
			exit();
		}
	}
}