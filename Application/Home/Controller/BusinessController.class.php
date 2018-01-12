<?php
namespace Home\Controller;
use Think\Controller;
class BusinessController extends Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['Home'])){
            A('Login')->login();
            die;
        }
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
        $list = $business->find(I('get.id'));
        $where['business_id'] = I('get.id');
        $list['userCount'] = M('users_integral')->where($where)->count();//统计用户数量
        $this->assign('list',$list);
        $this->display('Index/businessDetailInfo');
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
     * 忽略切删除激活用户
     * */
    public function del_bun()
    {
        $id = I('get.business_id');
        $business = M('business');
        $res = $business->delete($id);
        if($res){
            $this->success('已经被成功忽略');
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
     * 添加商家Operator_id
     * */
    public function getOperator_id()
    {
        if(I('post.operator_id')==''){
            $this->error('您没有填写operator_id');
        }
        $data['operator_id'] = I('post.operator_id');
        $where['business_id'] = I('post.business_id');
        $res = M('business')->where($where)->save($data);
        if($res){
            $this->success('operator_id添加成功');
        }
    }
}