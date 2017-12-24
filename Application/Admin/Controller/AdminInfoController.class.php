<?php
namespace Admin\Controller;
use Think\Controller;
class AdminInfoController extends CommonController {

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
        $list = $this->indexInfo();
//        判断商家是用电脑登录还是手机登录
        if($this->isMobile()){
            $this->iphonePage($list);
        }else{
            $this->computePage($list);
        }

    }

    /*
     * 手机登录页面
     * */
    public function iphonePage($list='')
    {
        $this->assign('list',$list);
        $this->display('Phone/BunsinessInfo');
    }

    /*
     * 电脑登录页面
     * */
    public function computePage($list='')
    {
        $this->assign('list',$list);
        $this->display('Index/ComIndex');

    }

    /*
     * 首页需要加载的数据
     * */
    public function indexInfo()
    {
        $business_id = $_SESSION['Admin']['business_id'];
        $list['orderInfo'] = $this->__allOrder($business_id);//统计订单信息
        $list['userNumber'] = $this->usersInfo($list['orderInfo']);//统计用户信息
        //保存订单数量，去掉多余数据
        foreach ($list['orderInfo'] as $key=>$val){
            unset($list['orderInfo'][$key]);
            $list['orderInfo'][$key]['count'] = count($val);
        }
        //保存用户数量，去掉多余数据
        foreach ($list['userNumber'] as $key=>$val){
            unset($list['userNumber'][$key]);
            $list['userNumber'][$key]['count'] = count($val);
        }
        $list['Admin'] = $_SESSION['Admin'];//当前商家的信息
        $list['dayProfit'] = $this->getProfitInfo();//统计用户当天收益
        return $list;
    }

    /*
     * 查看本店铺一共有多少会员
     * 根据实施消费的订单来统计会员信息
     *
     * */
    public function usersInfo($orderInfo)
    {
        foreach($orderInfo as $key=>$vale){
            foreach ($orderInfo[$key] as $k=>$v){
                $id = $v['users_id'];
                unset($orderInfo[$key][$k]);//去掉之前的数据
                $orderInfo[$key][$id]=$v['users_id'];
            }
        }
        return $orderInfo;
    }
    
    /*
     * 获取今日成交的总金额，实时更新
     * */
    public function getProfitInfo()
    {
        $consume_list = M('consume_list');
        $dayTime = strtotime(date('Y-m-d'));//获取今天凌晨时间戳
        $where['business_id'] = $_SESSION['Admin']['business_id'];
        $where['consume_time'] = array('gt',$dayTime);
        $data = $consume_list->where($where)->Sum('consume_money');
        return $data;

    }
    
    /*
     * 判断是手机登录还是电脑登录
     * */
    public function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    /*
    * 查看商家一共有多少单子
    * allOrder 所有的单子
    * dayOrder 今天的单子
    * yesterdayOrder 昨天的单子
    * */
    protected function __allOrder($business_id)
    {
        $consume_list = M('consume_list');
        $dayTime = strtotime(date('Y-m-d'));//获取今天凌晨时间戳
        $yesterdayTime = $dayTime -(60*60*24);
        $dataTime = strtotime(date('Y-m-d'));//获取今天凌晨时间戳
        $where['business_id'] = $business_id;
        $data['allOrder'] = $consume_list->where($where)->select();//所有的单子
        $where['consume_time'] = array('gt',$dataTime);
        $data['dayOrder'] = $consume_list->where($where)->select();//今天所有的单子
        $where['consume_time'] = array(array('gt',$yesterdayTime),array('lt',$dayTime),'and') ;
        $data['yesterdayOrder'] = $consume_list->where($where)->select();//昨天所有的单子
        return $data;
    }


    /*
    * 判断是否登录
    * */
    protected function __isLogin()
    {
        if(empty($_SESSION['Admin'])){
            $this->display('Index/Login');
            die;
        }else{

        }
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

}