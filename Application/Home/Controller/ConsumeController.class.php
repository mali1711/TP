<?php
namespace Home\Controller;
use Think\Controller;
class ConsumeController extends Controller {

    public function __construct()
    {

    }

/*
 * todo：获取用户支付的信息，并且把支付的具体的信息放入到对应的商家中。
 * $resCou 优惠券使用金额
 * */
    public function getMoney($user_id=false,$buniess_id=false,$money=false,$resCou=0)
    {
        //调用支付接口
        $Payment = A('WX/Payment');
        $operator_id = time();
        $amount = $money*100;
        $res =  $Payment->barcode($amount=$amount,$channel=2,$operator_id=$operator_id);
        $res = json_decode($res);
        if($res->data->qrCode==''){
            $this->success('支付失败');
        }else{
            //扣除使用的积分
            $users_integral = M('users_integral');
            $where['user_id'] = $user_id;
            $where['buniess_id'] = $buniess_id;
            $users_integral->setDec('users_integral_num',$resCou);
            //初始化时间
            $time = time();
            $res = $this->__userSpending($user_id,$buniess_id,$money,$time );
        }

    }

    /*
     * 用户id，商家id，消费金额，操作时间
     * */
    private function __userSpending($user,$business,$money,$time)
    {
        $data['users_id'] = $user;
        $data['business_id'] = $business;
        $data['consume_money'] = $money;
        $data['consume_return_money'] = $money;
        $data['consume_time'] = $time;
        $consume_list = M('consume_list');
        $res = $consume_list->add($data);
        return $res;
    }


}