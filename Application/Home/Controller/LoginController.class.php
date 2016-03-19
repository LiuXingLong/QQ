<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function index(){
		$this->display();
	}
    public function login(){
    	if(IS_POST){
    		$post=I('post.');
    		$user=M('user');
			$code=$post['code'];
    		$Ver= new CodeController();
    		if (!$Ver->check_verify($code)) {
    			echo "ErrorCode";
    			die;
    		}
    		$result=$user->query("select *from user where username='%s'",trim($post['username']));  		
    		if($result[0]['password']==trim(md5($post['password']))){  
    			$_SESSION['status']=true;
    			$_SESSION['username']=$post['username'];
    			$id=$user->query("select id from user where username='%s'",trim($post['username']));
    			$_SESSION['id']=$id[0]['id'];
    			$this->redirect("Index/index");
    		}else{
    			echo "Error";
    		}
    	}else{
    		$this->error('非法操作');
    	}
    }
    public function register(){
    	if(IS_POST){
    		$post=I('post.');
    		$user=M('user');
    		$code=$post['code'];
    		$Ver= new CodeController();
    		if (!$Ver->check_verify($code)) {
    			echo "ErrorCode";
    			die;
    		}
    		$result=$user->query("select *from user where username='%s'",trim($post['username']));
    		if(!empty($result[0]['password'])){    			
    			echo "Error"; 	//  该用户名以被注册过
    		}else{
				 $data['username']=trim($_POST['username']);
    			 $data['password']=trim(md5($_POST['password'])); // md5 加密
    			 $data['time']=date('Y-m-d H:i',time());           //获取时间
    			 $data['ip']=$_SERVER['REMOTE_ADDR']; // 获取服务器的 ip地址 ：get_client_ip();
    			 //添加到数据库中
    			 $User=M('user');
    			 $User->field('username,password,time,ip')->create($data);
    			 $User->add();
    			 $_SESSION['status']=true;
    			 $_SESSION['username']=$post['username'];
    			 $id=$user->query("select id from user where username='%s'",trim($post['username']));    			 
    			 $_SESSION['id']=$id[0]['id'];	  
    			 $this->redirect("Index/index");
    		}    	
    	}else{
    		$this->error('非法操作');
    	}
    }
    public function logout(){
    	session_unset();
    	session_destroy();
    	$this->redirect("Login/index");
    } 
}