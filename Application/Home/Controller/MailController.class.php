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

    public function MailList()
    {
        $mail =  M('mail');
        $count      = $mail->count();
        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $list = $mail->where('mail_status=1')->order('mail_addtime')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display('Index/MailList');
    }

    public function delMail()
    {
        $id = I('get.id');
        $mail = M('mail');
        $res = $mail->delete($id);
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}