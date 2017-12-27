<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
    	$this->display('Index/Index');
    }

    /*
     * 跳转到登陆页
     * */
    public function login($value='')
    {
        if(empty($_POST)){
            $this->display('Index/Login');
        }else{
            $admin = M('admin');
            $_POST['admin_password'] = md5(md5($_POST['admin_password']));
            $res = $admin->where($_POST)->find();
            if($res){
                $_SESSION['admin'] = $res;
                $this->index();
            }else{
                $this->error('您输入有误',U('Index/Login'));
            }
        }

    }
/*
 *积分生成
 *用户id，商家id，具体消费金额
 *
*/
    public function getIntgral($user,$business,$money)
    {
        # code...
    }
/*
 * 管理员注册
 * */
    public function registerAdmin()
    {
        $admin = M('admin');
        if(I(post.admin_password)!=I(post.agin_admin_password)){
            $this->error('两次输入的密码不一致');
            return false;
        }else{
            $_POST['admin_password'] = md5(md5($_POST['admin_password']));
            if($admin->add($_POST)){
                $this->success('新的管理员户注册成功',U('Index/login'));

            }else{
                $this->error('注册失败');
            }


        }
    }

    public function businessList()
    {
        $this->display('Index/businessList');
    }
}