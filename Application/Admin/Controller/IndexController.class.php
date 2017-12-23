<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    private $tday = '';//今天时间
    private $yesterday = '';//昨天时间

    public function __construct()
    {
        $this->tday = time();
        $this->yesterday = strtotime("-1 day");
        parent::__construct();
    }

    public function index()
    {
        $AdminInfo = A('AdminInfo');
        $AdminInfo->index();
    }
    
    /*积分返还机制 start*/
    /*
     * 计算商家昨天所有的收益记录
     * 返还昨天消费用户的积分
     * */
    public function BusinessShouYesterday()
    {
        //写入商家当天的获取收益信息
        $bonus = 0.1;//商家默认分红
        $list = $this->UsersYesterdayIsConsumption($bonus);
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $b_turnover_in_the_day->addAll($list);
        //将今天所有的收入统计出来
        $this->returnBusinessTotal();

        //返还给当天消费的用户
        $integral_list = $this->returnIntegralToyesterdaySUsers();
        $this->__Integraldeduction($integral_list);//用户返还积分扣除
        M('users_integral_list')->addAll($integral_list);
        //返还给老用户
        $order_inte = $this->returnIntegralToOrder();
        $this->__Integraldeduction($order_inte);//用户返还积分扣除
        M('users_integral_list')->addAll($order_inte);
        //将积分追加到用户账户中
        $this->UsersTotalIntegral();
    }

    
    /*
     * 所有用户昨天的消费的金额的统计
     * 当天消费的数据的的处理
     *
     * */
    public function UsersYesterdayIsConsumption($bonus=0)
    {
        $consume_list = M('consume_list');
        $yesTime = $this->tday;
        $time = $this->__startAndOverTime($yesTime);
        $where['consume_time'] = array(array('EGT',$time['start']),array('ELT',$time['end']));
        $list = $consume_list->field('business_id,sum(consume_money) as b_turnover_in_the_day_money')
            ->where($where)->group('business_id')->select();
//        $list = $consume_list->where($where)->group('business_id')->sum('consume_money');
//        echo $consume_list->getLastSql();
        foreach($list as $k=>$v){
            $list[$k]['b_turnover_in_the_day_integral_new'] = $v['b_turnover_in_the_day_money']*$bonus/2;
            $list[$k]['b_turnover_in_the_day_integral_ord'] = $v['b_turnover_in_the_day_money']*$bonus/2;
            $list[$k]['b_turnover_in_the_day_time'] = $yesTime;
        }
        return $list;
    }
    /*
      * 将商家今天的金额追加到店铺总收入去
      * */
    public function returnBusinessTotal()
    {
        $business_info = M('business_info');
        $data['business_id'] = 2;
        $data['business_info_total'] = 2;
        //获取所有商家当天的营业额
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $yesTime = $this->tday;
        $time = $this->__startAndOverTime($yesTime);
        $where['b_turnover_in_the_day_time'] = array(array('EGT',$time['start']),array('ELT',$time['end']));
        $data = $b_turnover_in_the_day
            ->field('b_turnover_in_the_day_money,business_id,b_turnover_in_the_day_integral_new')
            ->where($where)->select();
        foreach($data as $k=>$v){
            $bunWhere['business_id'] = $v['business_id'];
            if($res = $business_info->where($bunWhere)->find()){
                $res['business_info_total'] += $v['b_turnover_in_the_day_money'];
                $business_info->save($res);
            }else{
                $data['business_id'] = $v['business_id'];
                $data['business_info_total'] += $v['b_turnover_in_the_day_money'];
                $business_info->add($data);
                $data = array();
            }
        }
    }
    /*
     * return 今天用户产生的所有的积分。
     * */
    public function returnIntegralToyesterdaySUsers()
    {
        //获取当天所有营业的商家的总金额
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $yesTime = $this->tday;
        $time = $this->__startAndOverTime($yesTime);
        $where['b_turnover_in_the_day_time'] = array(array('EGT',$time['start']),array('ELT',$time['end']));
        $data = $b_turnover_in_the_day
                ->field('b_turnover_in_the_day_money,business_id,b_turnover_in_the_day_integral_new')
                ->where($where)->select();
        //后去所有用户的消费信息
        $consume_list = M('consume_list');
        $where['consume_time'] = array(array('EGT',$time['start']),array('ELT',$time['end']));
        $list = $consume_list->where($where)->select();
        foreach ($data as $k=>$v){
            $data[$v['business_id']] = $data[$k];
            unset($data[$k]);
        }
        $users_integral_list  = array();
        foreach ($list as $key=>$value){
            $business_id = $value['business_id'];//商家所在id
            $ress = floor($value['consume_money']/$data[$business_id]['b_turnover_in_the_day_money']*100)/100;
            echo $ress.'*'.$data[$business_id]['b_turnover_in_the_day_integral_new'].'-->'.$ress*$data[$business_id]['b_turnover_in_the_day_integral_new'];
            echo '<br/>';
            $users_integral_list[$key]['users_id'] = $value['users_id'];
            $users_integral_list[$key]['consume_list_id'] = $value['consume_list_id'];
            $users_integral_list[$key]['consume_return_money'] = $value['consume_return_money'];
            $users_integral_list[$key]['users_spend_num'] = $value['consume_money'];
            $users_integral_list[$key]['business_id'] = $value['business_id'];
            $users_integral_list[$key]['users_get_integral'] = $ress*$data[$business_id]['b_turnover_in_the_day_integral_new'];
            $users_integral_list[$key]['users_integral_addtime'] = time();
        }
        return $users_integral_list;
        //循环查找所有再此商家消费的用户，并且计算积分
    }


    public function returnIntegralToOrder()
    {
        //获取店铺所有的用户
        $consume_list = M('consume_list');
        $alluser = $consume_list->select();
        //获取店铺总收益
        $allBun = M('business_info')->select();
        foreach ($allBun as $k=>$v){
            unset($allBun[$k]);
            $k = $v['business_id'];
            $allBun[$k ] = $v;
        }
        //获取所有店铺的总收益
        $dayData = $this->__inTheDayGeTMon();
        $data = array();
        foreach ($alluser as $key=>$val){
            //商家信息
            $bun_id = $val['business_id'];
            //用户每单消费占总金额的比例，去除两位小数以后的小数
            $bili = floor($val['consume_money']/$allBun[$bun_id]['business_info_total']*100)/100;
            $data[$key]['business_id'] = $val['business_id'];
            $data[$key]['users_get_integral'] = $bili*$dayData[$bun_id]['b_turnover_in_the_day_integral_new']; //老用户积分的比例
            $data[$key]['users_id'] = $val['users_id'];
            $data[$key]['consume_list_id'] = $val['consume_list_id'];
            $data[$key]['users_integral_addtime'] = time();
        }

        return $data;

    }

    /*
     * ord 版本，因为需求被改变
     * 返还之前用户所有的消费积分
     *
    public function returnIntegralToOrder()
    {
        //获取除了今天以外所有的用户
        $consume_list = M('consume_list');
        $yesTime = $this->tday;
        $time = $this->__startAndOverTime($yesTime);
        $where['consume_time'] = array('ELT',$time['start']);
        $list = $consume_list->where($where)->select();//除了今天消费的所有用户的消费信息
//        所有店铺今天盈利的信息
        $data = $this->__inTheDayGeTMon();
        //获取所有店铺的总收益
        $allBun = M('business_info')->select();
        foreach ($allBun as $k=>$v){
            $allBun[$v['business_id']] = $allBun[$k];
            unset($allBun[$k]);
        }

        //获取二次分红的数据
        $array = array();
        foreach($list as $k=>$v){
            $business_id = $v['business_id'];
            //初始化比例
            $ress = floor($v['consume_money']/($allBun[$business_id]['business_info_total']-$data[$business_id]['b_turnover_in_the_day_money'])*100)/100;
            $array[$k]['business_id'] = $v['business_id'];
            $array[$k]['users_id'] = $v['users_id'];
            $array[$k]['users_integral_addtime'] = time();
            $array[$k]['users_get_integral'] =  $ress*$data[$business_id]['b_turnover_in_the_day_integral_new'];

        }
        return $array;

    }
    */


    /*
     * 将用户当天获取的积追加到用户总积分表中，以便于以后的消费
     * 在程序中，应该是最后执行的
     * */
    public function UsersTotalIntegral()
    {
        //获取用户当天获取的积分列表
        $yesTime = $this->tday;
        $time = $this->__startAndOverTime($yesTime);
        $where['users_integral_addtime'] = array(array('EGT',$time['start']),array('ELT',$time['end']));
        $users_integral_list = M('users_integral_list');
        //获取今天的消费记录
        $list = $users_integral_list->where($where)->select();
        $users_integral = M('users_integral');
        foreach ($list as $v){
            $usersIntegraWhere['users_id'] = $v['users_id'];
            $usersIntegraWhere['business_id'] = $v['business_id'];
            $data['users_integral_num'] =   $v['users_get_integral'];
            $data['users_integral_total_amount'] = $v['users_spend_num'];
            $data['business_id'] = $v['business_id'];
            $data['users_id'] = $v['users_id'];
//            dump($data);
            //当前用户在当前商家有消费记录，继续追加数据
            if($res = $users_integral->where($usersIntegraWhere)->find()){
                $res['users_integral_total_amount']+=$v['users_spend_num'];
                $res['users_integral_num'] += $data['users_integral_num'];
                $users_integral->save($res);
            }else{
                $users_integral->add($data);
            }
        }
    }
    

 /********************************公用函数********************************************/
/*
 * 积分扣除
 * */
    public function __Integraldeduction($list=0)
    {
        $consume_list = M('consume_list');
        foreach ($list as $k => $v){
            $where['consume_list_id'] = $v['consume_list_id'];
            $consume_list->where($where)->setDec('consume_return_money',$v['users_get_integral']);
        }

    }

    /*
     * 获取所有店铺当天的盈利
     * */
    public function __inTheDayGeTMon()
    {
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $yesTime = $this->tday;
        $time = $this->__startAndOverTime($yesTime);
        $where['b_turnover_in_the_day_time'] = array(array('EGT',$time['start']),array('ELT',$time['end']));
        $data = $b_turnover_in_the_day
            ->field('b_turnover_in_the_day_money,business_id,b_turnover_in_the_day_integral_new')
            ->where($where)->select();
        //将商家的id变成下表
        foreach ($data as $k=>$v){
            $data[$v['business_id']] = $data[$k];
            unset($data[$k]);
        }
        return $data;
    }

    /*
     * 判断时间是否是某一天
     * $time 是否在 $ordTime内
     * */
    public function __timeIsToday($timestamp=0,$ordTime=0)
    {
        $timestamp = time();  // 时间戳
        $ordTime = time();
        if(date('Ymd', $timestamp) == date('Ymd',$ordTime)) {

            return true;

        }else{
            return false;
        }
    }

    /*
     * 获取某一天的开始时间和结束时间
     * */
    public function __startAndOverTime($t){
        $arr['start'] = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $arr['end'] = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        return $arr;
    }

    /*积分返还机制 end*/
    /*
     * 定时执行，没天晚上11点58
     * 脚本调用
     * */
    public function togo()
    {
        $this->BusinessShouYesterday();
    }

}