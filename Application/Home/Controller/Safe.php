<?php
namespace Home\Controller;
use Think\Controller;
class SateController extends Controller {


    /*
     * 修改密码
     * */
    public function updatePass()
    {
        dump(I('post.'));

        if(!empty(I('post.'))){
            $this->display('Sate/updatePass');
        }else{
            //如果用户填写了修改新密码
            $admin = M('Admin');
            if(I('post.newpass')!=''){
                dump($_POST);
            }
        }
        dump($_POST);
    }

    public function doUpdatePass()
    {
        dump($_POST);
    }
}