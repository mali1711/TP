<?php
namespace Home\Controller;
use Think\Controller;
class ConsumeController extends Controller {

    public function __construct()
    {

    }

/*
 * todo：获取用户支付的信息，并且把支付的具体的信息放入到对应的商家中。
 * */
    public function getMoney($user_id=false,$buniess_id=false,$money=false)
    {
        $time = time("Y-m-d",strtotime("-1 day"));
//        $time = time();
        $res = $this->__userSpending($user_id,$buniess_id,$money,$time );


    }

    /*
     * 用户id，商家id，消费金额，操作时间
     * */
    private function __userSpending($user,$business,$money,$time)
    {
        $data['users_id'] = $user;
        $data['business_id'] = $business;
        $data['consume_money'] = $money;
        $data['consume_time'] = time();
        $consume_list = M('consume_list');
        $res = $consume_list->add($data);
        return $res;
    }


}