<?php
namespace Rgent\Controller;
use Think\Controller;
class LoginController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {

        if(empty(I('post.'))){
            $this->display('Index/Login');
            die;
        }else{
            $agent = M('agent');
            $where['agent_email'] = I('post.agent_email');
            $where['agent_pass'] = md5(md5(I('post.agent_pass')));
            $res = $agent->where($where)->find();
            if($res){
                $_SESSION['Rgent'] = $res;
                A('Index')->index();
            }else{
                $this->error('密码错误，请重新登录');
            }

        }
    }
}