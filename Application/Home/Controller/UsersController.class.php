<?php
namespace Home\Controller;
use Think\Controller;
class UsersController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 获取所有商家的信息
     * */
    public function getUsersList()
    {
        $Users = M('Users'); // 实例化User对象$User = M('User'); // 实例化User对象
        $count      = $Users->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $list = $Users->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Index/usersList');
    }

    /*
     * 查看用户详情信息
     * */
    public function getUserInfo()
    {
        $where['users_id'] = I('get.id');
        $list['users_integral_num'] = M('users_integral')->where($where)->sum('users_integral_num');//总积分
        $list['users_integral_total_amount'] = M('users_integral')->where($where)->sum('users_integral_total_amount');//总消费金额
        $list['consume_list_use_integral'] = M('consume_list')->where($where)->sum('consume_list_use_integral');//已使用积分
        $this->assign('list',$list);
        $this->display('Index/UserDetaulInfo');
    }
}