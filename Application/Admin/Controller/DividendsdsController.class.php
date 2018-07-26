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
    }

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
     * 商家目前已经分配的红包总数
     * 目前已经兑换的红包总数
     * 小数点取到后两位
     */
    public function allNum()
    {
        $where['business_id'] = $this->business_id;
        $data['Mysum'] = floor(M('users_integral_list')->where($where)->sum('users_get_integral')*100)/100;//本商家生成的所有的分红
        $data['allSum'] = floor(M('users_integral_list')->sum('users_get_integral')*100)/100;//整个汇客系统产生的所有的分红数量
        $data['useSum'] = M('consume_list')->where($where)->sum('consume_list_use_integral');//本商家已经兑换的积分
        echo json_encode($data);
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
            $data['userExchange'][$k]['consume_list_use_integral'] = M('consume_list')->where($where)->sum('consume_list_use_integral');
            $data['userExchange'][$k]['users_name'] = M('users')->find($v['users_id'])['users_name'];
            $data['userExchange'][$k]['users_id'] = M('users')->find($v['users_id'])['users_id'];
        }
        dump($data);
        echo json_encode($data);
    }

}