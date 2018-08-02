<?php
namespace Admin\Controller;
use Think\Controller;
class DividendsdsController extends CommonController {

    /**
     * 正在使用的商家id
     */
    public $business_id = '';


    public function __construct()
    {
        $this->business_id = $_SESSION['Admin']['business_id'];
        parent::__construct();
    }

    /*
     * 商家兑换页
     * */
    public function jiaoyi()
    {
        $this->display('Phone/jiaoyi');
    }

    /**
     *
     * 兑换详情（日，年，月账单）
     */
    public function duihuan()
    {
        $this->display('Phone/duihuan');
    }

    /**
     *兑换详情
     *
     **/
    public function xiangqing()
    {
        $today=strtotime(date('Y-m-d 00:00:00'));
        $where['consume_time'] = array('egt',$today);
        $where['business_id'] = $this->business_id;
        $count = M('consume_list')->where($where)->count('distinct(users_id)');
        $count = ceil($count/6);
        $this->assign('count',$count); 
        $this->display('Phone/xiangqing');
    }

    /*
     * 查询当天任意一个用户的
     * */

    /**
     * 查看所有用户列表
     */
    public function userList()
    {
        $where['business_id'] = $this->business_id;
        $list = M('users_integral')->field('users.users_id,users.users_name,users.users_phone,users.sex')->join('users on users_integral.users_id = users.users_id')->where($where)->select();
        $data = json_encode($list);
        echo $data;
    }

    /**
     * 商家所有
     * 商家目前已经分配的红包总数红包详情
     * 目前已经兑换的红包总数
     * 小数点取到后两位
     */
    public function allNum()
    {
        $where['business_id'] = $this->business_id;
        $data['allSum'] = floor(M('users_integral')->sum('users_integral_num')*100)/100;//整个汇客系统产生的所有的分红数量
        $data['useSum'] = M('consume_list')->where($where)->sum('consume_list_use_integral');//本商家已经兑换的积分
        $data['Mysum'] = $data['useSum']+floor(M('users_integral')->where($where)->sum('users_integral_num')*100)/100;//本商家生成的所有的分红
        $TodayIncome = $this->__TodayIncome();
        $data['TodayIncome'] = $TodayIncome['cash']+$TodayIncome['RedEn'];//今日收入（红包+现金）
        echo json_encode($data);
    }


    /**
     * 今日现金数和红包数
     * 今日总的消费详情
     * @return ajax
     * */
    public function DetOFCon()
    {
        $TodayIncome =  $this->__TodayIncome();
        echo json_encode($TodayIncome);
    }
    
    /**
     * 今日收入
     * @return $data['cash'] 现金
     * @return $data['RedEn'] 红包
     * */
    private function __TodayIncome()
    {
        $today=strtotime(date('Y-m-d 00:00:00'));
        $where['consume_time'] = array('egt',$today);
        $where['business_id'] = $this->business_id;
        $data['cash'] = M('consume_list')->where($where)->sum('consume_money');//当日商家已经被兑换的积分
        $data['RedEn'] = M('consume_list')->where($where)->sum('consume_list_use_integral');//会员使用的红包数
        return $data;
    }
    
    /**
     * 按天、月、年查询订单
     *
     */
    public function find_createtime()
    {
        if(I('get.day')){
            $time = I('get.day');
            $sta = strtotime("$time 00:00:00");
            $end = strtotime("$time 23:59:59");
        }elseif (I('get.month')){
            $time = I('get.month');
            $sta = strtotime("$time 00:00:00");
            $end  = strtotime("$time"."-".date('t',strtotime($time))."23:59:59");
        }elseif (I('get.year')){
            $time = I('get.year');
            $sta = strtotime("$time-01-01 00:00:00");
            $end = strtotime("$time-12-31 23:59:59");
        }

        $data = $this->findOrderOfTime($sta,$end);
        echo json_encode($data);
    }

    /**
     * 按照时间区间统计查询
     * $staTime 开始时间
     * $endTime 结束时间
     * @return json
     */
    public function findOrderOfTime($staTime=0,$endTime=0)
    {
        $where['business_id'] = $this->business_id;
        $where['users_integral_addtime'] = array(array('EGT',$staTime),array('ELT',$endTime),'and');
        $data['Mysum'] = floor(M('users_integral_list')->where($where)->sum('users_get_integral')*100)/100;//本商家生成的所有的分红
        //$data['allSum'] = floor(M('users_integral_list')->sum('users_get_integral')*100)/100;//整个汇客系统产生的所有的分红数量
        $whereCon['business_id'] = $this->business_id;
        $whereCon['consume_time'] = array(array('EGT',$staTime),array('ELT',$endTime),'and');
        $data['useSum'] = M('consume_list')->where($whereCon)->sum('consume_list_use_integral');//本商家已经兑换的积分
        return $data;
    }


    /**
     * 红包当日兑换以及产生详情
     */
    public function dayNum()
    {
        $today=strtotime(date('Y-m-d 00:00:00'));
        $where['consume_time'] = array('egt',$today);
        $where['business_id'] = $this->business_id;
        $data['busExchange'] = M('consume_list')->where($where)->sum('consume_list_use_integral');//当日商家已经被兑换的积分
        $data['userExchange'] = array();//分组统计用户已经兑换的积分
        $data['everytimeExchange'] = array();//统计用当天户每次使用积分，按最新时间
        $userList = M('consume_list')->distinct(true)->field('users_id')->where($where)->select();
        $data['everytimeExchange'] = M('consume_list')
             ->field('users.users_id,consume_list.consume_list_use_integral,consume_list.consume_time,users.users_name')
            ->join('users ON consume_list.users_id = users.users_id')
            ->where($where)->order('consume_time desc')->select();
        foreach ($userList as $k=>$v) {
            $where['users_id'] = $v['users_id'];
            echo $v['users_id'];
            echo '<br/>';
            $data['userExchange'][$k]['consume_list_use_integral'] = M('consume_list')->where($where)->sum('consume_list_use_integral');
            $data['userExchange'][$k]['users_name'] = M('users')->find($v['users_id'])['users_name'];
            $data['userExchange'][$k]['users_id'] = M('users')->find($v['users_id'])['users_id'];
        }
        echo json_encode($data);
    }

    /*
     * 当日红包使用详情
     * */
    public function xiangQingData()
    {

        $page = $_GET['page']?$_GET['page']:1;
        $sta = ($page-1)*6;
        $today=strtotime(date('Y-m-d 00:00:00'));
        $where['consume_time'] = array('egt',$today);
        $where['business_id'] = $this->business_id;
        $userList = M('consume_list')->distinct(true)->field('users_id')->where($where)->limit($sta,6)->select();    $xiangQingData = array();
        foreach ($userList as $k=>$v) {
            $where['users_id'] = $v['users_id'];
            $xiangQingData[$k]['consume_list_use_integral'] = M('consume_list')->where($where)->sum('consume_list_use_integral');
            $xiangQingData[$k]['users_name'] = M('users')->find($v['users_id'])['users_phone'];
            $xiangQingData[$k]['users_id'] = M('users')->find($v['users_id'])['users_id'];
        }
//        dump($json);
        echo json_encode($xiangQingData);
    }

    /**
     * @param users_id
     * 当日用户使用红包详情
     * @return json
     * */
    public function toDayUser()
    {
        $today=strtotime(date('Y-m-d 00:00:00'));
        $where['users_id'] = $_GET['users_id'];
        $where['consume_time'] = array('egt',$today);
        $where['business_id'] = $this->business_id;
        $userList = M('consume_list')->where($where)->select();
        foreach ($userList as $k=>$v) {
            $where['users_id'] = $v['users_id'];
            $userList[$k]['users_name'] = M('users')->find($v['users_id'])['users_phone'];
            $userList[$k]['consume_time'] = date("Y-m-d H:i:s",$v['consume_time']);
            $xiangQingData[$k]['users_id'] = M('users')->find($v['users_id'])['users_id'];
        }
        echo json_encode($userList);
    }


}