<?php
namespace Users\Controller;
use Think\Controller;
class BunsinessController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }


    /*
     * 获取商家的具体信息
     * */
    public function index()
    {
        if(empty($_SESSION['Admin'])){
            $this->login();
            exit();
        }else{
            $this->bunsinessInfo();
        }

    }

    public function bunsinessInfo()
    {

        $where['business_id'] = $_SESSION['Admin']['business_id'];
        $list['business_name'] = $_SESSION['Admin']['business_name'];
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $timeData = $this->__getTime();
        $timeEnd = $timeData['timeEnd'];
        $timeStart = $timeData['timeStart'];
        $red = $b_turnover_in_the_day->where("b_turnover_in_the_day_time < $timeEnd and b_turnover_in_the_day_time > $timeStart")->select();
        echo $b_turnover_in_the_day->getLastSql();
        echo '<hr/>';
//        dump($red);
//        die;
        $this->assign('list',$list);
        $this->display('Index/BunsinessInfo');
    }

    /*
     * 商家登陆
     * */
    public function doLogin()
    {
        if(empty($_POST)){
            $this->index();
        }else{
            $business = M('business');
            $_POST['business_pass'] = md5(md5($_POST['business_pass']));
            $res = $business->where($_POST)->find();
            if($res){
                $_SESSION['Admin'] = $res;
                $this->success('登陆成功',U('Bunsiness/index'));
            }else{
                $this->error('登陆失败');
            }
//            echo $business->getLastSql();

        }
    }

    public function login(){
        $this->display('Index/BunsinessLogin');
    }

    /*
     * 获取金额
     * todo
     * */
    public function getMoney()
    {
        //使用后台模块来处理金额
        $HomeBun = A("Home/Consume");
        $conCoupons = A("Coupons");
        $users_id = $_SESSION['user']['userinfo']['users_id'];
        $business_id = $_SESSION['user']['bus'];
        $money = I('post.money');
        //获取在本商家拥有的积分
        $integral = $this->getIntegral()['users_integral_num'];
        //获取可以使用的优惠券，
        $data = A('Coupons')->getCoupons(I('post.money/d'));
        $resCou = $data['coupons_money'];//优惠券能扣除的金额
        //支付判断
        if(I('post.integral/d')>I('post.money/d')){
            $this->error('支付积分不能大于实际金额');
        }elseif(I('post.integral/d')<1 && I('post.integral/d')!=''){
            $this->error('支付积分不能是小数');
        }elseif (I('post.money/f')<=0){
            $this->error('支付金额必须大于0');
        }elseif(I('post.integral/f')>$integral){
            $this->error('您的积分不够');
        }else{
        $inMon = I('post.integral/f');//积分金额
        $HomeBun->getMoney($users_id,$business_id,$money,$resCou,$inMon);
        die;
       if($result=ture){
           $id = $data['get_coupons_id'];//被使用的优惠券的id
           $conCoupons->dedCoupons($business_id,$users_id,I('post.integral/d'));
           $this->delCoupons($id);
       }else{
           $this->success('出现问题',u('Users/index'));
       }
        }

    }

    /*
     * 优惠券使用完，自动删除
     * */
    public function delCoupons($id)
    {
        $get_coupons = M('get_coupons');
        return $get_coupons->delete($id);
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

    /*
     * 计算当天开始和结束的时间
     * */
    private function __getTime()
    {
        $today = strtotime(date("Y-m-d"),time());
        $end = $today+60*60*23;
        $start = $today+60*60*0;
        $data['timeEnd']=  strtotime(date("Y-m-d H:i:s", $end)); //当天结束的时间
        $data['timeStart'] = strtotime(date("Y-m-d H:i:s", $start)); //当天开始的时间
        return $data;
    }

    /*
     * 商品列表
     * */
    public function goodslist()
    {
        $where['business_id'] = $_SESSION['user']['bus'];
        $bun_goods = M("bun_goods");
        $list = $bun_goods->where($where)->select();
        $this->assign('goodList',$list);
        $this->display('Index/GoodList');
    }
    /*
     * 商品详情
     * */
    public function GoodDetail()
    {
        $id = $_GET['id'];
        $bun_goods = M('bun_goods');
        $list = $bun_goods->find($id);
        $list['bun_goods_desc'] =  html_entity_decode($list['bun_goods_desc']);
        if($list['bun_goods_desc']==NULL){
            $this->error('商家还没有添加商品详情');
        }
        $this->assign('list',$list);
        $this->display('Index/GoodDetail');
    }


    
    /*
     * 推广模块
     * */
    public function extension()
    {
        $share = M('share');
        $list = $share->select();
        $this->assign('list',$list);
//        $this->display('Index/Extension');
        $this->display('fwj.sir6.cn/share');
    }

    public function _empty()
    {
        $this->error("页面出现问题，请稍后");
    }
}