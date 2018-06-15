<?php
namespace Users\Controller;
use Think\Controller;
class CouponsController extends Controller {

    /*
     * 优惠券列表
     * */
    public function index()
    {
        $get_coupons = M('get_coupons');
        $where['users_id'] =$_SESSION['user']['userinfo']['users_id'];
        $list = $get_coupons->where($where)->select();
        $coupons = M('coupons');
        foreach ($list as $k=>$v){
            $couponslist[$k] = $coupons->find($v['coupons_id']);
        }
        $this->assign('couponslist',$couponslist);
//        $this->display('Index/CouponsList');
        $this->display('fwj.sir6.cn/quan');
    }
    
    /*
     * 使用优惠券,根据优惠券跳转到对应的商城
     * */
    public function useCoupons()
    {
        $where = I('get.');
        $bun_goods = M("bun_goods");
        $list = $bun_goods->where($where)->select();
        if(empty($list)){
            echo "<script>alert('此商家还没有商家积分能兑换的商品')</script>";
            $this->index();
        }else{
            $this->assign('goodList',$list);
            $this->display('Index/GoodList');
        }
    }

    
    /*
     * 支付时候，自动获取优惠券，用最实惠的优惠券
     * $whe 满足金额
     * return 优惠券金额、优惠券id
     * */
    public function getCoupons($whe=null)
    {
        $coupons = M('coupons');
        $where['a.business_id'] = $_SESSION['user']['bus'];
        $where['get_coupons.users_id'] = $_SESSION['user']['userinfo']['users_id'];
        $where['a.coupons_satisfy'] = array(array('egt',$whe));
        //获取最优惠的优惠券
        $list = $coupons->field('a.coupons_money,get_coupons.get_coupons_id')->alias('a')->where($where)->join('get_coupons ON get_coupons.coupons_id= a.coupons_id')
                ->order('a.coupons_satisfy desc')->limit(1)->select()[0];
        if($list){
            return $list;   
        }else{
            return 0;
        }
        

    }

    /*
     * 积分扣除
     * */
    public function dedCoupons($business_id=0,$users_id=0,$integral=0)
    {
        echo $business_id.'<br/>';
        echo $users_id.'<br/>';
        echo $integral.'<br/>';
        $users_integral = M('users_integral');
        $where['business_id']=$business_id;
        $where['users_id']=$users_id;
        $ordIntegral = $users_integral->field('users_integral_num')->where($where)->find();
        $ordIntegral = intval($ordIntegral['users_integral_num']);
        $res = intval($ordIntegral)-(intval($integral));
        $data['users_integral_num'] = $res;
        return $users_integral->where($where)->save($data);

    }

    /*
   * 获取再本商家有多少积分
   * */
    public function getIntegral()
    {
        $users_integral = M('users_integral');
        $where['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $where['business_id'] = $_SESSION['user']['bus'];
        $res = $users_integral->field('users_integral_num')->where($where)->find();
        return $res;
    }

    public function _empty()
    {
        $this->error("页面出现问题，请稍后");
    }
    
}