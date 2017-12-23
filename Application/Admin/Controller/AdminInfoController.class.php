<?php
namespace Admin\Controller;
use Think\Controller;
class AdminInfoController extends CommonController {

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 首页
     * */
    public function index()
    {
        $this->__isLogin();// 判断是否登录成功
        $res = $this->__userList();
        dump($res);
    }


    /*
     * 获取此点的用户列表
     * */
    public function __userList()
    {

    }

    /*
     * 登陆注册
     * */
    public function login()
    {
        if(empty($_POST)){
            $this->display('Index/Login');
        }else{
            $business = M('business');
            $_POST['business_pass'] = md5(md5($_POST['business_pass']));
            $res = $business->where($_POST)->find();
            if($res){
                $_SESSION['Admin'] = $res;
                $this->success('登陆成功',U('Index/index'));
            }else{
                $this->error('登陆失败');
            }
//            echo $business->getLastSql();

        }

    }


}