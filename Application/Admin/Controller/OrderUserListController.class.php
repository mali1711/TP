<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 22:43
 */
namespace Admin\Controller;
use Think\Controller;
class OrderUserListController extends AdminInfoController{

    public $business_id = 0;

    public function __construct()
    {
        parent::__construct();
        $this->business_id = $_SESSION['Admin']['business_id'];
    }

    /*
     * 今日订单
     * */
    public function DayOrder()
    {
        $consume_list = M('consume_list');
        $dayTime = strtotime(date('Y-m-d'));
        $where['business_id'] = $this->business_id;
        $where['consume_time'] = array('gt',$dayTime);
        if(I('post.')){
            $where['users_phone'] = I('post.users_phone');
        }
        $list = $consume_list->order('consume_time')
            ->field('users_phone,consume_time,consume_money,consume_list_use_integral')
            ->where($where)
            ->join('users on consume_list.users_id = users.users_id')
            ->page($_GET['p'].',10')
            ->select();
        foreach($list as $k=>$v){
            $string = $v['consume_money'];
            $list[$k]['consume_money'] = preg_replace('/^0*/', '', $string);
        }
        $count      = $consume_list
            ->join('users on consume_list.users_id = users.users_id')
            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header','个会员');
        $Page->setConfig('first','第一页');
        $Page->setConfig('end','最后一页');
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('list',$list);
        $this->display('Phone/DayOrder');
    }

    /*
     * 以前的订单
     * */
    public function OrdOrder()
    {
        $consume_list = M('consume_list');
        $dayTime = strtotime(date('Y-m-d'));
        $where['business_id'] = $this->business_id;
        $where['consume_time'] = array('LT',$dayTime);
        if(I('post.')){
            $where['users_phone'] = I('post.users_phone');
        }

        $count  = $consume_list->where($where)
            ->join('users on consume_list.users_id = users.users_id')
            ->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $list = $consume_list->order('consume_time')
            ->field('users_phone,consume_time,consume_money,consume_list_use_integral')
            ->where($where)
            ->join('users on consume_list.users_id = users.users_id')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        foreach($list as $k=>$v){
            $string = $v['consume_money'];
            $list[$k]['consume_money'] = preg_replace('/^0*/', '', $string);
        }
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('list',$list);
        $this->display('Phone/OrdOrder');
    }


    public function UserInfo()
    {
        $this->display('Phone/UserInfo');
    }

    public function newUserInfo()
    {
        $this->display('Phone/newUserInfo');
    }

}