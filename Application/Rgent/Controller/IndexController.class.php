<?php
namespace Rgent\Controller;
use Think\Controller;
class IndexController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['Rgent'])){
            A('Login')->login();
        }
    }

    /*
     * 首页
     * */
    public function index()
    {

    }

    /*
     * 互推广告
     * 再支付页面显示
     * */
    public function adveList()
    {
        $where['agent_id'] =  $_SESSION['Rgent']['agent_id'];
        $where['business_id'] =  0;
        $list = M('adve')->where($where)->order('adve_status desc')->select();
        $this->assign('list',$list);
        $this->display('Index/adveList');
    }

    public function addAdve()
    {
       if(empty(I('post.'))){
           $this->display('Index/addAdve');
       }else{
            $res = $this->__uploadFile();
            $data['adve_pic'] = $res[0]['savepath'].$res[0]['savename'];
            $data['adve_name'] = I('post.adve_name');
            $data['adve_url'] = I('post.adve_url');
            $data['adve_status'] = I('post.adve_status');
            $data['agent_id'] =  $_SESSION['Rgent']['agent_id'];
            $data['adve_addtime'] =  time();
            $where['agent_id'] = $data['agent_id'];
            $where['adve_status'] = $data['adve_status'];
            $this->updateStatus($where,0);
            $res = M('adve')->add($data);
           if($res){
               $this->success('添加成功',U('Index/adveList'));
           }else{
               $this->error('添加失败');
           }
       }
    }

    /*
     * 修改状态
     * */
    public function updateAdve()
    {   $id = $_GET['id'];
        if(empty(I('post.'))){
            $list = M('adve')->find($id);
            $this->assign('list',$list);
            $this->display('Index/updateAdve');
        }else{
            $where['agent_id'] = $_SESSION['Rgent']['agent_id'];
            $where['adve_status'] = I('post.adve_status');
            $this->updateStatus($where,0);
            $res = M('adve')->save(I('post.'));
            if($res){
                $this->success('修改成功',U('Index/adveList'));
            }else{
                $this->error('修改失败');
            }
        }
    }
    
    /*
     * 删除广告
     * */
    public function deleteAdve()
    {
        $id = $_GET['id'];
        $pic =  M('adve')->find($id)['adve_pic'];
        $imgurl = __ROOT__.'/Uploads'.$pic;
        $aa = unlink($imgurl);
        echo $imgurl;
        echo 11;
        dump($aa);
        die;
        $res = M('adve')->delete($id);
        if($res){
        $aa = unlink('/Uploads/'.$pic);
        dump($aa);
         $this->success('删除成功');

        }else{
         $this->error('删除失败');
        }

    }

    /*
     * 非普通广告，会将已经设置好的变成普通广告
     * $status 修改的状态
     * */
    public function updateStatus($where,$status)
    {
        $data['adve_status'] = $status;
        $res = M('adve')->where($where)->save($data);
        return $res;
    }

    private function __uploadFile()
    {
        $config = array(
            'maxSize'    =>    3145728,
            'savePath'   =>    '/Adve/',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            return $info;
        }
    }

    /*
     * 商家列表
     * */
    public function businessList()
    {
        //生成商家注册的url地址
        $list['url'] = $_SERVER['SERVER_NAME'].__ROOT__.'/Admin/AdminInfo/login/'.'id/'.$_SESSION['Rgent']['agent_id'];
        $where['agent_id'] = $_SESSION['Rgent']['agent_id'];
        $list['data1'] =  M('business')->where($where)->select();
        $this->assign('list',$list);
        $this->display('Index/businessList');
    }
}