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
        $consume_list = M('consume_list');
        $users_integral_list = M('users_integral_list');
        $users_integral = M('users_integral');
        $where['users_id']= $_SESSION['user']['userinfo']['users_id'];
        $list['users_money_total'] = $consume_list->where($where)->sum("consume_money");
        $list['consume_return_money_total'] = $consume_list->where($where)->sum("consume_return_money");
        $list['users_integral_total_amount']= $users_integral->where($where)->sum("users_integral_num");
        $list['userDetail'] = M('users')->find($where['users_id']);
        $this->userinfo = $list;
        //调用微信的Jssdk
        $wxInfo = A('WX/Jssdk')->getSignPackage();
        //获取广告内容
        $where['agent_id'] = $_SESSION['user']['agent'];
        $where['adve_status'] = 4;
        $adve = M('adve')->where($where)->find();
        $this->assign('adve',$adve);
        $this->assign('wxInfo',$wxInfo);
        $this->assign('list',$list);
        $this->display('Index/personal');
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
        $users = M('users');
        $data = array();
        if(I('post.agen_users_pass') != I('post.users_pass')){
            $this->error('两次密码不一致');
            die;
        }
        if(empty($_POST['users_name']) or empty($_POST['users_sex']) or empty($_POST['users_phone'])){
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
                ->limit($Page->firstRow.','.$Page->listRows)
                ->select();
        foreach($list as $k=>$v){
            $string = $v['consume_money'];
            $list[$k]['consume_money'] = preg_replace('/^0*/', '', $string);
        }
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display('Index/pay');
    }
    
    /*
     * 用户收益详情记录
     * 记录用户每笔收益
     * */
    public function income()
    {
        $users_integral = M('users_integral');
        $where['users_id'] = $_SESSION['user']['userinfo']['users_id'];
        $res = $users_integral->field('business_name,users_integral_num,business.business_id')
            ->where($where)->join("business ON users_integral.business_id = business.business_id")
               ->select();
        $list['count']=0;
        foreach ($res as $k=>$v){
            $list['count'] += $v['users_integral_num'];

            if($_SESSION['user']['bus']==$v['business_id']){
                $list['person'] = $res[$k];
                unset($res[$k]);
            }
        }

        $list['list'] = $res;
        $this->assign('list',$list);
        $this->display('Index/income');
    }

    /*
     * 收益分红的具体详情
     * */
    public function incomeDetail()
    {
        $users_integral_list = M('users_integral_list');
        $where['users_integral_list.users_id'] = $_SESSION['user']['userinfo']['users_id'];
        $count      = $users_integral_list->where($where)->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        $list = $users_integral_list->where($where)
                            ->field('consume_list.consume_time,consume_list.consume_money,users_integral_list.users_integral_addtime,users_integral_list.users_get_integral')
                            ->join('consume_list ON consume_list.consume_list_id = users_integral_list.consume_list_id')
                            ->order('users_integral_list.users_integral_addtime desc')
                            ->limit($Page->firstRow.','.$Page->listRows)
                            ->select();
        foreach ($list as $k=>$v){
            $string = $v['consume_money'];
            $list[$k]['consume_money'] = preg_replace('/^0*/', '', $string);
        }
        $this->assign('page',$show);
        $this->assign('list',$list);
        $this->display('Index/IncomeDetail');
/*  直接输出了
    foreach($list as $v){
            $time1 = date('Y-m-d',$v['consume_time']);
            $mon1 = $v['consume_money'];
            $time2 = date('Y-m-d',$v['users_integral_addtime']);
            $mon2 = $v['users_get_integral'];
            $str = sprintf("您%s,消费的%s,于%s,返还了%s",$time1,$mon1,$time2,$mon2);
            echo $str.'<br/>';
        }*/
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
}