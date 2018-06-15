<?php
namespace Users\Controller;
use Think\Controller;
class InfoController extends Controller {

    /*
     * 显示信息
     * */
    public function index()
    {
        $mail =  M('mail');
        $list = $mail->order('mail_addtime desc')->limit(5)->select();
        $this->assign('list',$list);
        $this->display('Index/showMages');
    }

    public function _empty()
    {
        $this->error("页面出现问题，请稍后");
    }
}