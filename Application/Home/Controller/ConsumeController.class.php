<?php
namespace Home\Controller;
use Think\Controller;
class ConsumeController extends Controller {


    public function __construct()
    {
        parent::__construct();
    }

/*
 * todo：获取用户支付的信息，并且把支付的具体的信息放入到对应的商家中。
 * $resCou 优惠券使用金额
 * $notify_url//回调函数
 * */
    public function getMoney($user_id=false,$buniess_id=false,$money=false,$resCou=0,$inMon)
    {
        //调用支付接口
        $Payment = A('WX/Payment');
        $operator_id = time();//本地的订单号
//        $amount = ($money-$resCou-$inMon)/100;/*支付的实际金额，比原来的小扫10000倍 并且去掉支付的积分和优惠券*/

        $amount = ($money-$resCou-$inMon)*100; //todo 打开就能变成真正的支付
        $notify_url = '';//成功之后执行的回调
        $redirect_url = "http://www.sir6.cn/TP/index.php/Home/Consume/paymentSucess";//成功支付后跳转的地址
        $res =  $Payment->h5ZhiFu($amount=$amount,$operator_id=$operator_id,$notify_url,$redirect_url);
        $res = json_decode($res);
        if($res->resule->success){
            $this->error('支付失败');
        }else{
            $payUrl = $res->data->url;
            $_SESSION['user']['payInfo'] = NULL;
            $_SESSION['user']['payInfo']['users_id'] = $user_id;//用户信息
            $_SESSION['user']['payInfo']['business_id'] = $buniess_id;//支付店铺
            $_SESSION['user']['payInfo']['consume_money'] = $money;//支付金额
            $_SESSION['user']['payInfo']['consume_return_money'] = $money;//改返还的金额
            $_SESSION['user']['payInfo']['consume_time'] = time();//支付时间
            $_SESSION['user']['payInfo']['resCou'] = $resCou;//使用优惠券
            $_SESSION['user']['payInfo']['consume_list_use_integral'] = $inMon;//使用的积分
            $list['money'] =$money;
            $list['inMon'] =$inMon;
            $list['url'] = $payUrl;
            $list['adve'] = $this->adveList();
            $this->assign('list',$list);
            $this->display('Index/subMoney');
            die;

        }
    }



    /*
     * 支付成功
     * */
    public function paymentSucess()
    {
        $users_integral = M('users_integral');
        $where['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $where['buniess_id'] = $_SESSION['user']['userinfo']['buniess_id'];
        //删除使用的积分
        $resCou = $_SESSION['user']['payInfo']['resCou'];
        $users_integral->setDec('users_integral_num',$resCou);
        unset($_SESSION['user']['payInfo']['resCou']);//删除积分使用的字段
        $res = $this->__userSpending($_SESSION['user']['payInfo']);
        if($res){
            $this->success('支付成功',U('Users/Users/index'));
        }else{
            $this->success('支付失败',U('Users/Users/index'));
        }
    }

    /*
     * 用户id，商家id，消费金额，操作时间
     * */
    private function __userSpending($data)
    {
        $consume_list = M('consume_list');
        $res = $consume_list->add($data);
        return $res;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.

    }


    /*
     * 推送广告
     * */
    public function adveList()
    {
        $business_id = $_SESSION['user']['bus'];
        $list = M('adve')->where("adve_status=1 or adve_status=2 or adve_status=3 and business_id=$business_id")->select();
        return $list;
    }
    
}