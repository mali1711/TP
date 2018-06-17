<?php
namespace Users\Controller;
use Think\Controller;
class IndexController extends Controller {



    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = A('Users');
        $_SESSION['user']['bus'] = $_GET['business_id'];
        $id = $_SESSION['user']['bus'];
        $_SESSION['user']['agent'] = M('business')->find($id)['agent_id'];
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

//        $this->display('Index/payment');
        $this->display('fwj.sir6.cn/fukuan');
    }

    public function incomeDetail()
    {
        $users_integral_list = M('users_integral_list');
        $where['users_integral_list.users_id'] = $_SESSION['user']['userinfo']['users_id'];
        $where['users_integral_list.users_get_integral'] = array('neq',0);
        $count      = $users_integral_list->where($where)->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        $list = $users_integral_list->where($where)
            ->field('consume_list.consume_time,consume_list.consume_money,users_integral_list.users_integral_addtime,users_integral_list.users_get_integral')
            ->join('consume_list ON consume_list.consume_list_id = users_integral_list.consume_list_id')
            ->order('users_integral_list.users_integral_addtime desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();

        foreach ($list as $k=>$v){
            $string = $v['consume_money'];
            $list[$k]['consume_money'] = preg_replace('/^0*/', '', $string);
        }

        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display('Index/IncomeDetail');

    }

    public function _empty()
    {
        $this->error("网络延时，请稍后");
    }
}