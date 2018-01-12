<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['Home'])){
            A('Login')->login('Index/Index');
            die;
        }
    }
    
    public function index()
    {
        $business = M('business'); // 实例化User对象$User = M('User'); // 实例化User对象
        $count      = $business->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $list['url'] = $_SERVER['SERVER_NAME'].__ROOT__.'/Admin/AdminInfo/login/'.'id/'.$_SESSION['Rgent']['agent_id'];
        $list['data1'] = $business->limit($Page->firstRow.','. $Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Index/Index');
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
 * 
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