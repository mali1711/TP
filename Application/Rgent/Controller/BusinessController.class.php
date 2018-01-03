<?php
namespace Rgent\Controller;
use Think\Controller;
class BusinessController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 获取所有商家的信息
     * */
    public function getBusinessList()
    {
        $business = M('business'); // 实例化User对象$User = M('User'); // 实例化User对象
        $where['agent_id'] = $_SESSION['Rgent']['agent_id'];
        $count      = $business->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $list['url'] = $_SERVER['SERVER_NAME'].__ROOT__.'/Admin/AdminInfo/login/'.'id/'.$_SESSION['Rgent']['agent_id'];
        $list['data1'] = $business->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Index/businessList');
    }

    /*
     * todo 管理员修改商家信息
     * */
    public function updateBusiness()
    {
        $this->display('Index/updateBusiness');
    }

    /*
     * 查看商家详情信息
     * */
    public function getBusinessDetailInfo()
    {
        $business = M('business');
        $list = $business->find($_GET['id']);
        dump($list);
    }

    /*
     * 激活商家
     * */
    public function activation_bun()
    {
        $where = I('get.');
        $data['business_status'] = 2;
        $business = M('business');
        $res = $business->where($where)->save($data);
        if($res){
            $this->success('成功被激活');
        }else{
            $this->error('操作失误');
        }
    }

    /*
     * 商家禁用
     * */
    public function disable()
    {
        $where = I('get.');
        $data['business_status'] = 3;
        $business = M('business');
        $res = $business->where($where)->save($data);
        if($res){
            $this->success('商家已经被禁用');
        }else{
            $this->error('操作失误');
        }
    }

    /*
     * 查看商家所拥有的互推广告位
     * */
    public function bunAdveList()
    {
        $where['business_id'] = I('get.business_id');
        $where['agent_id'] = $_SESSION['Rgent']['agent_id'];
        $list = M('adve')->where($where)->order('adve_status desc')->select();
        $this->assign('list',$list);
        $this->display('Index/bunAdveList');
    }

    /*
     * 针对商家添加互推广告
     * */
    public function bunAddAdve()
    {
        if(empty(I('post.'))){
            $this->display('Index/bunAddAdve');
        }else{
            $res = $this->__uploadFile();
            $data['adve_pic'] = $res[0]['savepath'].$res[0]['savename'];
            $data['business_id'] = I('post.business_id');
            $data['adve_name'] = I('post.adve_name');
            $data['adve_url'] = I('post.adve_url');
            $data['adve_status'] = I('post.adve_status');
            $data['agent_id'] =  $_SESSION['Rgent']['agent_id'];
            $data['adve_addtime'] =  time();
            $where['agent_id'] = $data['agent_id'];
            $where['adve_status'] = $data['adve_status'];
            $where['business_id'] = $data['business_id'];
            $this->updateStatus($where,0);
            $res = M('adve')->add($data);
            if($res){
                $this->success('添加成功',U('Business/getBusinessList'));
            }else{
                $this->error('添加失败');
            }
        }
    }

    /*
     * 将其他广告模式设置为0
     * */
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
    
    /*
     * 修改广告位置
     * */
    public function updateBunAdve()
    {
        $this->display('Index/updateBunAdve');
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
}