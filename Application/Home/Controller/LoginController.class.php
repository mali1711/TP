<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    /*
 * 跳转到登陆页
 * */
    public function login($url='')
    {

        if(empty($_POST)){
            $this->display('Index/Login');
        }else{
            $admin = M('admin');
            $_POST['admin_password'] = md5(md5($_POST['admin_password']));
            $res = $admin->where($_POST)->find();
            if($res){
                $_SESSION['Home'] = $res;
                $this->success('登录成功',U('Index/index'));
            }else{
                $this->error('您输入有误',U('Index/Login'));
            }
        }

    }

    /*
 * 管理员注册
 *
 * */
    public function registerAdmin()
    {
        $admin = M('admin');
        $condition['admin_email'] = I('post.admin_email');
        $condition['admin_name'] = I('post.admin_name');
        $condition['_logic'] = 'OR';
        $resinfo = M('admin')->where($condition)->select();
        if($resinfo){
            $this->error('您写的信息已经存在');
        }
        if(I('post.admin_name')=='' or I('post.admin_name')){
            $this->error('请将信息填写完整');
            die;
        }
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

}