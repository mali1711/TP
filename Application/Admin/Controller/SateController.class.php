<?php
namespace Admin\Controller;
use Think\Controller;
class SateController extends Controller {


    /*
     * 修改密码
     * */
    public function updatePass()
    {
        if(empty(I('post.'))){
            $this->display('Sate/updatePass');
        }else{
            //如果用户填写了修改新密码
            if(I('post.new_pass')!=''){
                $admin = M('business');
                $where['business_pass'] = md5(md5(I('post.ord_pass')));
                $where['business_id'] = $_SESSION['Admin']['business_id'];
                $res = $admin->where($where)->find();
                if($res){
                    $data['business_pass'] = md5(md5(I('post.new_pass')));
                    $res1 = $admin->where($where)->save($data);
                    if($res1){
                        $this->success('密码修改正确');
                    }else{
                        $this->error('网络延迟');
                    }

                }else{
                    $this->error('请输出正确的旧密码');
                }
            }else{
                $this->error('您输入的密码是空的');
            }
        }
    }

    public function doUpdatePass()
    {

    }

}