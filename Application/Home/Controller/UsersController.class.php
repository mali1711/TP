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
     * 查找用户
     * */
    public function findUsers()
    {
        if(I('post.users_phone')){
            $where['users_phone'] = I('post.users_phone');
        }
        $list = M('Users')->where($where)->select();
        $this->assign('list',$list);// 赋值数据集
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

    /*
     * 初始化用户的密码为123456
     * */
    public function upUsersPass()
    {
        $where['users_id'] = I('get.id');
        $data['users_pass'] = md5('123456');
        $res = M('users')->where($where)->save($data);
        if($res){
            $this->success('改用户此刻密码初始化成了123456');
        }else{
            $this->success('位置错误');
        }
    }
}