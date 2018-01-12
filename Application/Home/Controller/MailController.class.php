<?php
namespace Home\Controller;
use Think\Controller;
class MailController extends Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['Home'])){
            A('Login')->login('Index/Index');
            die;
        }
    }


    public function addMail()
    {
        if(empty(I('post.'))){
            $this->display('Index/addMail');
        }else{
            $data = I('post.');
            $data['mail_addtime'] = time();
            $data['admin_id'] = $_SESSION['Home']['admin_id'];
            $mali =  M('mail');
            $res = $mali->add($data);
            if($res){
                $this->success('公告已经成功发布',U('Mail/addMail'));
            }else{
                $this->success('公告发布出现问题');
            }
        }
    }
}