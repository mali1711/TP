<?php
namespace Users\Controller;
use Think\Controller;
class UsersController extends Controller {

    public $userinfo = '';

    /*
     * 个人中心页
     * */
    public function index()
    {
        if(empty($_SESSION['user']['userinfo'])){
            $this->login();
        }else{
            $this->userinfo =$_SESSION['user']['userinfo'];
            $this->__userinfo();
        }

    }



    /*
     * 获取用户首页的详情信息
     * */
    private function __userinfo()
    {

        $list = $this->__getPayList();
        $this->userinfo = $list;
        //调用微信的Jssdk
        $wxInfo = A('WX/Jssdk')->getSignPackage();
        //获取广告内容
        $where['agent_id'] = $_SESSION['user']['agent'];
        $where['adve_status'] = $map['id']  = array(array('gt',3),array('lt',12),'and'); ;
        $adve['one'] = M('adve')->where($where)->select();
        $where['agent_id'] = $_SESSION['user']['agent'];
        $where['adve_status'] = $map['id']  = array(array('gt',12),array('lt',20),'and'); ;
        $adve['tow'] = M('adve')->where($where)->select();
        $business_name = $this->getBunName($_SESSION['user']['bus']);
        $this->assign('adve',$adve);//广告
        $this->assign('wxInfo',$wxInfo);//微信二维码参数
        $this->assign('list',$list);//数据线索
        $this->assign('bunname',$business_name);//扫描过的店铺名字
        $this->display('fwj.sir6.cn/huiyuan');
    }

    /**
     * @param  $id 店铺id
     * 获取商家名字
     * @return string
     */
    public function getBunName($id)
    {

        if(isset($id)){
            $res = M('business')->find($id)['business_name'];
            return $res;
        }else{
            return "会客系统（您还没有进入店铺)";
        }
    }

    /*
     * 收支记录
     * */
    public function __getPayList()
    {
        $consume_list = M('consume_list');
        $users_integral_list = M('users_integral_list');
        $users_integral = M('users_integral');
        $where['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $wheremon['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $wheremon['business_id']= $_SESSION['user']['bus'];
        $list['users_money_total'] = $consume_list->where($wheremon)->sum("consume_money");
        $list['consume_return_money_total'] = floor($consume_list->where($wheremon)->sum("consume_return_money")*1000)/1000;
        $list['users_integral_total_amount']= floor($users_integral->where($wheremon)->sum("users_integral_num")*1000)/1000;
        $list['userDetail'] = M('users')->find($where['users_id']);
        $list['business_name'] = $this->__business_name();
        return $list;
    }

    /*
     * 获取用户此刻访问的商家账号
     * */
    private function __business_name(){
        $id = $_SESSION['user']['bus'];
        if($id){
            $business_name = M('business')->field('business_title')->find($id);
            return $business_name['business_title'];
        }else{
            return NULL;
        }

    }


    /*
     * 注册
     * */
    public function register()
    {
        $this->display('Index/register');
    }

    /*
     * 登陆
     * */
    public function login()
    {
        $this->display("Index/login");
    }

    /*
     * 执行登陆
     * */
    public function dologin()
    {
        $usrs = M('users');
        $data['users_pass'] = md5($_POST['users_pass']);
        $data['users_phone'] = $_POST['users_phone'];
        $res = $usrs->where($data)->find();
        if($res){
            $_SESSION['user']['userinfo'] = $res;
            $this->index();
        }else{
            $this->error('账号或者密码错误');
        }
    }

    /*
     * 用户注册
     * */
    public function doRegister()
    {
        $this->__fieldValidation(I('post.'));
        $users = M('users');
        $data = array();
        if(I('post.agen_users_pass') != I('post.users_pass')){
            $this->error('两次密码不一致');
            die;
        }

        if(empty($_POST['users_name']) and empty($_POST['users_sex']) and empty($_POST['users_phone'])){
            $data['status'] = false;
            $this->error('请完善你的信息');
            die;
        }else{
            //判断用户是否已经注册过
            $data['users_phone'] = $_POST['users_phone'];
            $list = $users->where($data)->find();
            if($list){
                $data['status'] = false;
                $this->error('手机号已经被注册');
                die;
            }else{
                $_POST['users_pass'] = md5($_POST['users_pass']);
                $res = $users->data($_POST)->add();
                if($res){
                    $data['status'] = true;
                    unset($_SESSION['users']);
                    $this->success('注册成功,请再次扫码登录',U('Users/Users/index'));
                }else{
                    $data['status'] = false;
                    $data['info'] = '注册失败';
                    $this->error('注册注册失败');
                }
            }
        }

    }


    /*
     * 查看以及修改用户信息
     * */
    public function userInfo()
    {
        //判断用户是否提交过来的数据
        if(!empty(I('post.'))){
            $users = M('users');
            $where['users_id'] = $_SESSION['user']["userinfo"]['users_id'];
            if($_FILES['users_pic']['name']!=''){
                $data['users_pic'] = $this->__uploadFile('users_pic','UserInfo/',125,130);
            }
            if(I('post.users_pass')!=''){
                //执行修改密码
                $data['users_pass'] = md5(I('post.users_pass'));
                $where['users_pass'] = md5(I('post.aginUsers_pass'));
            }
            $da = $users->where($where)->find();
            if($da){
                $users->where($where)->save($data);
            }else{
                $this->error('您输入的旧密码不正确');
            }
            $this->index();
            die;
        }
       $this->display('Index/userInfo');
    }

    /*
  * 统计用户一共还剩下多少积分
  * */
    public function sumIntegral()
    {
        $where['users_id']= 11;//$_SESSION['user']['userinfo']['users_id'];
        $users_integral_list = M('users_integral_list');
        $sum = $users_integral_list->where($where)->Sum('users_get_integral');
        if($sum){
            return 0;
        }else{
            return $sum;
        }
    }

    /*
     *
     * 用户支出记录
     * */
        public function pay()
    {

        $where['users_id'] = $_SESSION['user']['userinfo']['users_id'];
        $consume_list = M('consume_list');
        $count      = $consume_list->where($where)->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        $list = $consume_list->field('business_name,consume_money,consume_time')
                ->join("business ON consume_list.business_id = business.business_id")
                ->where($where)
                ->order('consume_time desc')
                ->limit($Page->firstRow.','.$Page->listRows)
                ->select();
        foreach($list as $k=>$v){
            $string = $v['consume_money'];
            $list[$k]['consume_money'] = preg_replace('/^0*/', '', $string);
        }
        $this->assign('page',$show);
        $this->assign('list',$list);
//        $this->display('Index/pay');
        $this->display('fwj.sir6.cn/fenhong');
    }

    /*
     * 用户收益详情记录
     * 记录用户每笔收益
     * */
    public function income()
    {
        $users_integral = M('users_integral');
        $where['users_id'] = $_SESSION['user']['userinfo']['users_id'];
        //其他店铺收益详情
        $res = $users_integral->field('business_name,users_integral_num,business.business_id')
            ->where($where)->join("business ON users_integral.business_id = business.business_id")
               ->select();
        $where['users_id'] = $_SESSION['user']['userinfo']['users_id'];
        $where['business_id'] =  $_SESSION['user']['bus'];
        //店铺现有红包
        $list['useIntegral'] = M('users_integral')->field('users_integral_num')->where($where)->find()['users_integral_num'];
        $list['useIntegral'] = floor($list['useIntegral'] * 100) / 100;
        //本店铺所有收益
        $list['conut'] = M('users_integral')->where($where)->find()['users_integral_num'];
        $list['conut'] = floor($list['conut'] * 100) / 100;
        //汇客所有收益
        unset($where['business_id']);
        $list['hkcount'] = $this->allCount();
        $list['hkcount'] = floor($list['hkcount'] * 100) / 100;
        foreach ($res as $k=>$v){
            $res[$k]['users_integral_num'] = floor($v['users_integral_num']*100)/100;//我的收益列表保留小数点后两位
        }
        $list['list'] = $res;
        $this->assign('list',$list);
        $this->display('fwj.sir6.cn/shouyi');
    }


    /*
     * 汇客总收益
     * @return fool
     * */
    public function allCount()
    {
        $where['users_id'] = $_SESSION['user']['userinfo']['users_id'];
        $users_integral_num = M('users_integral')->where($where)->sum('users_integral_num');//已经使用的所有积分
        $consume_list_use_integral = M('consume_list')->where($where)->sum('consume_list_use_integral');//拥有积分
        return $consume_list_use_integral+$users_integral_num;
    }

    /*
     * 用户支付成功。跳转次页面
     * 商家互推广告页面
     * */
    public function showAdve()
    {
        $list['adve'] = $this->adveList();
        $id = $_SESSION['user']['bus'];
        $this->assign('id',$id);
        $this->assign('list',$list);
        $this->display('Index/showAdve');
    }

    /*
     * 将图片变成圆的
     * */
    function yuan_img($imgpath = '') {
        $ext     = pathinfo($imgpath);
        $src_img = null;
        switch ($ext['extension']) {
            case 'jpg':
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 'png':
                $src_img = imagecreatefrompng($imgpath);
                break;
        }
        $wh  = getimagesize($imgpath);
        $w   = $wh[0];
        $h   = $wh[1];
        $w   = min($w, $h);
        $h   = $w;
        $img = imagecreatetruecolor($w, $h);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $bg);
        $r   = $w / 2; //圆半径
        $y_x = $r; //圆心X坐标
        $y_y = $r; //圆心Y坐标
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
            }
        }
        return $img;
/*        header("content-type:image/png");
//        $imgg = yuan_img();
        imagepng($img);
        imagedestroy($img);*/
    }



    /*
 * 图片上传
 * 定义的图片名 上传位置 宽度 高度
 *
 **/
    protected function __uploadFile($picName,$src,$width,$height)
    {
        $config = array(
            'maxSize'    =>    3145728,
            'savePath'   =>    "$src",
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES["$picName"]);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{
            $image = new \Think\Image();
            $src = "./Uploads/".$info['savepath'].$info['savename'];
            $image->open($src);
            $image->thumb($width,$height)->save('./Uploads/'.$info['savepath'].$info['savename']);
            return $info['savepath'].$info['savename'];
        }
    }

    /*
     * 验证用户输入的字段
     * */
    private function __fieldValidation($data){
        if(!preg_match('/^1([0-9]{9})/',$data['users_phone'])){
            $this->error('手机号不符合规则');
            die;
        }
    }

    /*
 * 推送广告
 * */
    private function adveList()
    {
        $business_id = $_SESSION['user']['bus'];
        $list = M('adve')->where("adve_status=1 or adve_status=2 or adve_status=3 and business_id=$business_id")->select();
        return $list;
    }

    public function _empty()
    {
        $this->error("页面出现问题，请稍后");
    }
}