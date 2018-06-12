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
     * 添加店铺以及完善店铺详情
     * */
    public function BunDetail()
    {
        //如果没有传修改的值的话，就查看
        $business = M('business');
        $id = $_SESSION['Admin']['business_id'];
        $list = $business->find($id);
        if(empty(I('post.'))){
            $this->assign('list',$list);
        }else{//执行修改
            $res = $business->where('business_id='.$id)->save(I('post.'));
            if($res){
                $this->success('修改完成');
                die;
            }
        }
        $this->display('Index/BunDetail');

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
        //保存订单数量，去掉多余数据
        foreach ($list['orderInfo'] as $key=>$val){
            unset($list['orderInfo'][$key]);
            $list['orderInfo'][$key]['count'] = count($val);
        }
        $list['ordNum'] = count($this->userNum());//所有用户
        $list['newNum'] = count($this->DayuserNum());//新增用户
        $list['dayProfit'] = $this->getProfitInfo();//统计用户当天收益
        return $list;
    }

    /*
 * 统计用总户数量
 * */
    public function userNum($where)
    {
        $con_where['business_id'] = $_SESSION['Admin']['business_id'];
        $users_integral = M('users_integral');
        $array = $users_integral->where($con_where)->select();//所有用户
        return $array;
    }

    /*
     * 统计用户今日新增数量
     * */
    public function DayuserNum()
    {
        $consume_list = M('consume_list');
        $dayTime = strtotime(date('Y-m-d'));//获取今天凌晨时间戳
        $con_where['business_id'] = $this->business_id;
        $whereAll['consume_time'] = array('gt',$dayTime);
        $whereOrd['consume_time'] = array('lt',$dayTime);
        $allUsers = $consume_list->field('users_id')->select();//所有的订单
        $orderUsers = $consume_list->field('users_id')->where($whereOrd)->select();//以前的所有的订单
        foreach ($allUsers as $k=>$v){
            $allUsers[$k] = $v['users_id'];
        }
        foreach ($orderUsers as $k=>$v){
            $orderUsers[$k] = $v['users_id'];
        }

        $array = array_diff($allUsers,$orderUsers);
        $array = array_unique($array);
        return $array;
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
            $_POST['business_status'] = 2;
            $res = $business->where($_POST)->find();

            if($res){
                $_SESSION['Admin'] = $res;
                A('Index')->index();
            }else{
                $this->error('登陆失败');
            }
//            echo $business->getLastSql();

        }

    }

    /*
     * 退出登录
     * */
    public function logout()
    {
        unset($_SESSION['Admin']);
        $this->display('Index/Login');
    }
    
    /*
     * 获取当前分红比例
     * */
    public function bonusInfo()
    {
        $id = $_SESSION['Admin']['business_id'];
        $business = M('business');
        if(I('post.buniess_bonus')==''){
            $list = $business->find($id );
            $data = $list['buniess_bonus'];
            $this->assign('data',$data);
            $this->display('Index/bonusInfo');
        }else{
            $data = I('post.');
            $where['business_id'] =  $id;
            $res = $business->where($where)->save($data);
            if($res){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }

    }
    
    /*
     * 注册
     * */
    public function registerAdmin()
    {
        $_POST['business_addtime'] = time();
        if(I('post.business_pass') != I('post.agin_business_pass')){
            $this->error('两次提交密码不一致');

        }
        $_POST['business_pass'] = md5(md5($_POST['business_pass']));
        $business = M('business');
        $data = $_POST;
        $data['business_addtime'] = time();
        $this->yanz($data);//验证部分字段是否重复
        $res = $business->add($data);
        if($res){
            $this->success('注册成功');
        }else{
            $this->error('注册失败');
        }
    }

    /*
     * 验证注册信息
     * $Model->where("id=%d and username='%s' and xx='%f'",$id,$username,$xx)->select();
     * */
    public function yanz($data)
    {
        $business_name['business_name'] = $data['business_name'];
        $business_phone['business_phone'] = $data['business_phone'];
        $business_email['business_email'] = $data['business_email'];
        if(M('business')->where($business_name)->find()){
            $this->error('商户名重复');die;
        }elseif (M('business')->where($business_phone)->find()){
            $this->error('手机号重复');die;
        }else{
            return true;
        }

    }

}