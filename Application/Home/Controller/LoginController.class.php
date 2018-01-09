<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    /*
 * 跳转到登陆页
 * */
    public function login($url)
    {
        if(empty($_POST)){
            $this->display('Index/Login');
        }else{
            $admin = M('admin');
            $_POST['admin_password'] = md5(md5($_POST['admin_password']));
            $res = $admin->where($_POST)->find();
            if($res){
                $_SESSION['Home'] = $res;
                $this->display($url);
            }else{
                $this->error('您输入有误',U('Index/Login'));
            }
        }

    }

}