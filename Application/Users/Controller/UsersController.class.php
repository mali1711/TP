<?php
namespace Users\Controller;
use Think\Controller;
class UsersController extends Controller {

    public $userinfo = '';

    /*
     * 个人中心页
     * */
    public function index()
    {
        if(empty($_SESSION['user']['userinfo'])){
            $this->login();
        }else{
            $this->userinfo =$_SESSION['user']['userinfo'];
            $this->__userinfo();
        }

    }



    /*
     * 获取用户首页的详情信息
     * */
    private function __userinfo()
    {
        $consume_list = M('consume_list');
        $users_integral_list = M('users_integral_list');
        $where['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $list['users_money_total'] = $consume_list->where($where)->sum("consume_money");
        $list['users_integral_total_amount'] = $users_integral_list->where($where)->sum("users_get_integral");
        $list['users_name'] = $_SESSION['user']['userinfo']['users_name'];
        $list['users_phone'] = $_SESSION['user']['userinfo']['users_phone'];
        $this->userinfo = $list;
        //获取sdk
        $wxInfo = A('WX/Jssdk')->getSignPackage();
        $this->assign('wxInfo',$wxInfo);
        $this->assign('list',$list);
        $this->display('Index/personal');
    }

    /*
     * 注册
     * */
    public function register()
    {
        $this->display('Index/register');
    }

    /*
     * 登陆
     * */
    public function login()
    {
        $this->display("Index/login");
    }

    /*
     * 执行登陆
     * */
    public function dologin()
    {
        $usrs = M('users');
        $data['users_pass'] = md5($_POST['users_pass']);
        $data['users_phone'] = $_POST['users_phone'];
        $res = $usrs->where($data)->find();
        if($res){
            $_SESSION['user']['userinfo'] = $res;
            $this->index();
        }else{
            $this->error('账号或者密码错误');
        }
    }

    /*
     * 用户注册
     * */
    public function doRegister()
    {
        $users = M('users');
        $data = array();
        if(empty($_POST['users_name']) or empty($_POST['users_sex']) or empty($_POST['users_phone'])){
            $data['status'] = false;
            $data['info'] = '请写完整你的信息';
        }else{
            //判断用户是否已经注册过
            $data['users_phone'] = $_POST['users_phone'];
            $list = $users->where($data)->find();
            if($list){
                $data['status'] = false;
                $data['info'] = '手机号已经被注册';
            }else{
                $_POST['users_pass'] = md5($_POST['users_pass']);
                $res = $users->data($_POST)->add();
                if($res){
                    $data['status'] = true;
                    $this->success('注册成功',U('Users/index'));
                }else{
                    $data['status'] = false;
                    $data['info'] = '注册失败';
                    $this->success('注册注册失败');
                }
            }
        }
        
    }

    /*
  * 统计用户一共还剩下多少积分
  * */
    public function sumIntegral()
    {
        $where['users_id']= 11;//$_SESSION['user']['userinfo']['users_id'];
        $users_integral_list = M('users_integral_list');
        $sum = $users_integral_list->where($where)->Sum('users_get_integral');
        if($sum){
            return 0;
        }else{
            return $sum;
        }
    }

    
    
}