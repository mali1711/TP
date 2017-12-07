<?php
namespace Users\Controller;
use Think\Controller;
class IndexController extends Controller {



    public function __construct()
    {
        parent::__construct();
        $_SESSION['user']['bus'] = 2;//初始化用户默认访问的商家
    }

    public function index()
    {
        $users = A('Users');
        $users->index();

    }
    

    /*
     * 进入商家列表页
     * */
    public function BunsinessList()
    {
        $business = M('business');
        $where['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $list['business'] = $business->where($where)->select();
        $list['user'] = $_SESSION['user']['userinfo'];
        $list['BunsinessInfo'] = $this->BunsinessDetail($_SESSION['user']['bus']);
        foreach($list['business'] as $k=>$v){
            $id = $v['business_id'];
            if($this->BunsinessDetail($id)){
                $list['business'][$k]['BunsinessInfo'] = $this->BunsinessDetail($id);
            }else{
                unset($list['business'][$k]);
            }
        }
        $this->assign('list',$list);
        $this->display('Index/BunsinessList');
    }


    /*
     * 统计收益
     * */
    public function intgral()
    {
        $this->display('Index/countIncome');
    }

    /*
     * 获取商家相关信息
     * Business_id(商品id)
     * return array
     * */
    public function BunsinessDetail($id)
    {
        $users_integral = M('users_integral');
        $where['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $where['business_id'] = $id;
        $res = $users_integral->field('users_integral_num')->where($where)->find();
        return $res;
    }

    /*
     * 付款
     * */
    public function payment()
    {
        //获取测试信息
        $mod = M('business');
        $conCoupons = A('Coupons');
        $list = $mod->select();
        $list['integral'] = $conCoupons->getIntegral()['users_integral_num'];
        $this->assign('list',$list);
        $this->display('Index/payment');
    }
}