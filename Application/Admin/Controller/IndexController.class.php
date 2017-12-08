<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function togo()
    {
        $this->BusinessShouYesterday();
    }
    
    /*积分返还机制 start*/
    /*
     * 商家昨天所有的收益记录
     * */
    public function BusinessShouYesterday()
    {
        $bonus = 0.1;//商家默认分红
        $list = $this->UsersYesterdayIsConsumption($bonus);
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $b_turnover_in_the_day->addAll($list);
    }
    
    /*
     * 所有用户昨天的消费的金额的统计
     * 当天消费的数据的的处理
     *
     * */
    public function UsersYesterdayIsConsumption($bonus=0)
    {
        $consume_list = M('consume_list');
//      $yesTime = strtotime("-1 day");
        $yesTime = time();
        $time = $this->__startAndOverTime($yesTime);
        $where['consume_time'] = array(array('EGT',$time['start']),array('ELT',$time['end']));
        $list = $consume_list->field('business_id,sum(consume_money) as b_turnover_in_the_day_money')->where($where)->group('business_id')->select();
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
     * 返还积分昨天给昨天的用户
     * */
    public function returnIntegralToyesterdaySUsers()
    {
        
    }

 /********************************公用函数********************************************/
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

}