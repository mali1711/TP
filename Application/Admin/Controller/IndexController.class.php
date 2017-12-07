<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 首页
     * */
    public function index()
    {
        $this->__isLogin();// 判断是否登录成功
        $business_id = $_SESSION['Admin']['business_id'];
        $this->display('Index/Index');
    }

    /*
     * 获取所有用户的当天的消费信息
     * */
    private function __getUserSpendList($business_id)
    {
        $users_integral_list = M('users_integral_list');
        $timeData = $this->__getTime();
        $timeEnd = $timeData['timeEnd'];
        $timeStart = $timeData['timeStart'];
        $list = $users_integral_list->where("users_integral_addtime <= $timeEnd and users_integral_addtime > $timeStart and business_id = $business_id")->select();
        $users = M('users');
        foreach ($list as $key=>$value){
            $list[$key]['users_id'] =$users->find($value['users_id']);
        }
        return $list;
    }


    /*
     * 登陆注册
     * */
    public function login()
    {
        if(empty($_POST)){
            $this->display('Index/Login');
        }else{
            $business = M('business');
            $_POST['business_pass'] = md5(md5($_POST['business_pass']));
            $res = $business->where($_POST)->find();
            if($res){
                $_SESSION['Admin'] = $res;
                $this->success('登陆成功',U('Index/index'));
            }else{
                $this->error('登陆失败');
            }
//            echo $business->getLastSql();

        }

    }

    /*
     * 获取收益记录
     * */
    public function consumeList(){
        $consume_list = M('consume_list');
        $data['business_id'] = $_SESSION['Admin']['business_id'];
        $res = $consume_list->where($data)->select();
        $data = $this->__doConsumeList($res);
    }

    public function togo()
    {
        $businesss = M('business');
        $this->business_id = $_SESSION['Admin']['business_id'];
        $list = $businesss->field('business_id')->select();
        foreach($list as $v){
            $_SESSION['Admin']['business_id'] = $v['business_id'];
            $this->getIntegral();
        }

    }

    /*
     * 每天晚上11点执行
     * */
    public function getIntegral()
    {
        var_dump($_SESSION);
        $this->returnPointsNewUser();
        $this->getDayincome();
        $this->getBusiness_info();
        $this->__returnPointsOrdUser(); //返回今天以外的积分
        $this->userProportion();
        $this->getUserIntegral();

    }

    /*
     * 积分返还给以前的用户。
     * */
    public function __returnPointsOrdUser()
    {
        $users_integral = M('users_integral');
        $list = $users_integral->select();
        foreach ($list as $key=>$value){
            $list = $this->toDayConsumeData($value['business_id'])['0'];
            $BusList = $this->__getBusiness_info($value['business_id']);
            $value['users_integral_num'] += ($value['users_integral_total_amount']/$BusList['business_info_total'])*$list['b_turnover_in_the_day_integral_ord'];
            $users_integral->save($value);
        }
    }

    /*
     * 获取通过商家id获取具体信息
     * */
    public function __getBusiness_info($id)
    {
        $business_info = M('business_info');
        $list = $business_info->where("business_id = $id")->find();
        return $list;
    }

    /*
     * 将用户当天的收入追加进去
     * */
    public function getBusiness_info($res)
    {
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $business_info = M('business_info');
        $list = $b_turnover_in_the_day->select();
        $array = array();
        foreach ($list as $key=>$value){
            $array['business_info_total'] = $value['b_turnover_in_the_day_money'];
            $array['business_id'] = $value['business_id'];
            $where['business_id'] = $array['business_id'];
            $res = $business_info->where($where)->find();
            if(empty($res)){
                $business_info->add($array);
            }else{
                $res['business_info_total']+=$array['business_info_total'];
                $business_info->save($res);
            }
        }

    }
    /*
     * 处理用户的积分，以及用户的所有金额
     * */
    public function getUserIntegral()
    {
        $users_integral_list = M('users_integral_list');
        $users_integral = M('users_integral');
        $timeData = $this->__getTime();
        $timeEnd = $timeData['timeEnd'];
        $timeStart = $timeData['timeStart'];
        $business_id = $_SESSION['Admin']['business_id'];//商家id
        $list = $users_integral_list->where("users_integral_addtime <= $timeEnd and users_integral_addtime > $timeStart and business_id=$business_id" )->select();
        $array = array();
        foreach($list as $k=>$v){
            $where['business_id'] = $v['business_id'];
            $where['users_id'] = $v['users_id'];
            $data = $where;
            $data['users_integral_num'] = intval($v['users_get_integral']);
            $data['users_integral_total_amount'] = floatval($v['users_integral_num']);
            $res = $users_integral->where($where)->find();
            //如果用户有消费记录，就修改数据，否则就添加数据
            if(empty($res)){
                $this->__addUserIntegral($data,$users_integral);
            }else{
                $this->__updateUserIntegral($data,$res,$users_integral);
            }
        }
    }

    /*
     * 积分返还，返还给当天消费的用户
     * 晚上11点开始执行
     * */
    public function returnPointsNewUser()
    {
        //获取当天在此消费的用户，以及消费的金额！
        $userList = $this->__getConsumeData();
        $total = $userList['total'];
        unset($userList['total']);
        $data = array();
        foreach ($userList as $k=>$v){
            unset($userList[$k]['consume_list_id']);
            $key = $v['users_id'];
            if(array_key_exists($key,$data)){
                $data[$key]['consume_money'] += $v['consume_money'];
            }else{
                $data[$key] = $v;
            }
            unset($data[$key]['consume_list_id']);
        }
        $array = array();
        foreach ($data as $k=>$v){
            $array[$k]['users_id'] = $v['users_id'];
            $array[$k]['business_id'] = $v['business_id'];
            $array[$k]['users_integral_addtime'] = $v['consume_time'];
            $array[$k]['users_integral_num'] = $v['consume_money'];
        }
        $users_integral_list = M('users_integral_list');
        foreach ($array as $v){
            $res = $users_integral_list->add($v);
            if(!$res){
                $info['status'] = 0;
                return $info;
            }
        }
    }

    /*
     * 将用户当天消费金额转换成积分
     *
     * */
    public function userProportion()
    {
        $users_integral_list = M('users_integral_list');
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $business_id = $_SESSION['Admin']['business_id'];
        $where['business_id'] = $business_id;
        $list = $users_integral_list->where($where)->select();
        $CountList =  $b_turnover_in_the_day->where($where)->Field('b_turnover_in_the_day_integral_new,b_turnover_in_the_day_money')->find();
        $arr = array();

        foreach($list as $k=>$v){
            $list[$k]['users_get_integral'] =  $v['users_integral_num']/$CountList['b_turnover_in_the_day_money']*$CountList['b_turnover_in_the_day_integral_new'];

        }
        foreach ($list as $v){
            $users_integral_list->save($v);
        }

    }



    /*
     * 查找需要的数据
     * */
    public function find($users_id)
    {
        $users_integral_list = M('users_integral_list');
        $list = $users_integral_list->where("users_id = $users_id ")->find();
        $array['users_get_integral'] = $list['users_get_integral'];

    }

    /*
     * 处理商家当天的收益
     * */
    public function getDayincome()
    {
        $result = $this->__judgeGetConsumeData();
        if($result){
            $result['0']['info'] = '当天的收益已经计算完毕';
            $result['0']['status'] = 0;
            return $result;
        }else{
            $data = $this->__addInTheDayIncome();
            return $data;
        }
    }

    /*
     * 处理当天收入，以及积分的产生
     * 只能在当天他处理完以后才能操作
     * */
    private function __addInTheDayIncome($Proportion = 0.05,$info = '无' ){
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $data = $this->__getConsumeData();
        $dataTurnover['b_turnover_in_the_day_money'] = $data['total'];
        $dataTurnover['business_id'] = $_SESSION['Admin']['business_id'];
        $dataTurnover['b_turnover_in_the_day_integral_new'] = intval($data['total'] * $Proportion);
        $dataTurnover['b_turnover_in_the_day_integral_ord'] = intval($data['total'] * $Proportion);
        $dataTurnover['business_id'] = $_SESSION['Admin']['business_id'];
        $dataTurnover['b_turnover_in_the_day_time'] = $this->__getTime()['timeEnd'];
        $dataTurnover['b_turnover_in_the_day_info'] = $info;
        $res = $b_turnover_in_the_day->add($dataTurnover);
        $dataTurnover['b_turnover_in_the_day_id'] = $res;
        return $dataTurnover;
    }

    /*
     * 判断当天的收益是否已经生成过
     * */
    private function __judgeGetConsumeData()
    {
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $timeData = $this->__getTime();
        $timeEnd = $timeData['timeEnd'];
        $timeStart = $timeData['timeStart'];
        $business_id = $_SESSION['Admin']['business_id'];//商家id
        $list = $b_turnover_in_the_day->where("b_turnover_in_the_day_time <= $timeEnd and b_turnover_in_the_day_time > $timeStart and business_id=$business_id" )->select();
//        echo $b_turnover_in_the_day->getLastSql();
        return $list;
    }

    /*
     * 获取商家当天的收入信息
     * */
    public function toDayConsumeData($id)
    {
        $b_turnover_in_the_day = M('b_turnover_in_the_day');
        $timeData = $this->__getTime();
        $timeEnd = $timeData['timeEnd'];
        $timeStart = $timeData['timeStart'];
        $list = $b_turnover_in_the_day->where("b_turnover_in_the_day_time <= $timeEnd and b_turnover_in_the_day_time > $timeStart and business_id=$id" )->select();
        return $list;
    }

    /*
     * 给每个用户进行积分的生成
     * */
    public function  produce()
    {

        $timestamp = time();  // 时间戳
        if(date('Ymd', $timestamp) == date('Ymd')) {

        }
    }

    /*
     * 获取当天交易列表
     * 获取此时交易总金额
    * */
    public function __getConsumeData ()
    {
        $consume_list = M('consume_list');
        $timeData = $this->__getTime();
        $timeEnd = $timeData['timeEnd'];
        $timeStart = $timeData['timeStart'];
        $business_id = $_SESSION['Admin']['business_id'];
        $list = $consume_list->where("consume_time < $timeEnd and consume_time > $timeStart and business_id=$business_id" )->select();
        $list['total'] = 0;
        foreach ($list as $k=>$v){
            $list['total'] += $v['consume_money'];
        }

        return $list;
    }

    /*
    * 获取当天开始时间和计算收益时间
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
     * 处理数据，获取具体的用户信息
     * */
    private function __doConsumeList($data)
    {
        foreach ($data as $k=>$v) {
            $data[$k]['users_id'] = M('users')->find($v['users_id']);
        }
        return $data;
    }
    /*
     * 判断是否登录
     * */
    private function __isLogin()
    {
        if(empty($_SESSION['Admin'])){
            $this->display('Index/Login');
            die;
        }
    }

    /*
     * 将数据放入到数据库中
     * */
    private function __addUserIntegral($data,$users_integral)
    {
        $users_integral = M('users_integral');
        $users_integral->add($data);
    }

    /*
     * 追加金额以及积分
     * */
    private function __updateUserIntegral($data,$res,$users_integral)
    {
        $res['users_integral_num'] += $data['users_integral_num'];
        $res['users_integral_total_amount'] += $data['users_integral_total_amount'];
        $users_integral->save($res);
    }
}