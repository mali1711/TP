<?php
namespace Home\Controller;
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
        $count      = $business->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $list = $business->limit($Page->firstRow.','.$Page->listRows)->select();
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

}