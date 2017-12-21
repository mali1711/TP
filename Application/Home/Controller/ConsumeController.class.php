<?php
namespace Home\Controller;
use Think\Controller;
class ConsumeController extends Controller {

    static $user_id;
    static $buniess_id;
    static $resCou;
    static $money;

    public function __construct()
    {
        parent::__construct();
    }

/*
 * todo：获取用户支付的信息，并且把支付的具体的信息放入到对应的商家中。
 * $resCou 优惠券使用金额
 * $notify_url//回调函数
 * */
    public function getMoney($user_id=false,$buniess_id=false,$money=false,$resCou=0)
    {
        //调用支付接口
        $Payment = A('WX/Payment');
        $operator_id = time();
        $amount = $money;/*支付的实际金额，比原来的小扫100倍*/
//        $amount = $money*100; //todo 打开就能变成真正的支付
        $notify_url = U('Admin/Consume/paymentSucess');
        $res =  $Payment->h5ZhiFu($amount=$amount,$operator_id=$operator_id,$notify_url);
        $res = json_decode($res);
        if($res->resule->success){
            self::$user_id = '';
            self::$buniess_id = '';
            self::$money = '';
            self::$resCou = '';
            $this->error('支付失败');
        }else{
            self::$user_id = $user_id;
            self::$buniess_id = $buniess_id;
            self::$resCou = $money;
            self::$money = $resCou;
            $payUrl = $res->data->url;
            dump($payUrl);
            echo "<a href=\"$payUrl\"> 点击确认支付 </a>";
            die;
            header("Location: $payUrl");
        }
    }



    /*
     * 支付成功
     * */
    public function paymentSucess()
    {
        echo 111111111;
        die();
        //扣除使用的积分
        $users_integral = M('users_integral');
        $where['user_id'] = self::$user_id;
        $where['buniess_id'] = self::$buniess_id;
        $users_integral->setDec('users_integral_num',self::$resCou);
        //初始化时间
        $time = time();
        $this->__userSpending(self::$user_id,self::$buniess_id,self::$money,$time);
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
        self::$user_id = '';
        self::$buniess_id = '';
        self::$money = '';
        self::$resCou = '';
        return $res;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.

    }


}