<?php
namespace Admin\Controller;
use Think\Controller;
class CouponsController extends Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['Admin'])){
            $this->display('Index/Login');
            die;
        }
    }

    /*
     * 添加优惠券
     * */
    public function addCoupons()
    {
        $this->display('Index/addCoupons');
    }

    public function doAddCoupons()
    {
        //初始化数据
        $_POST['business_id'] = $_SESSION['Admin']['business_id'];
        $_POST['coupons_addtime'] = time();
        $str = $_POST['coupons_overtime'];
        $_POST['coupons_overtime'] = strtotime(str_replace('T', ' ', $str));
        $_POST['coupons_image'] = $this->__uploadFile();
        //实例化表，添加数据
        $coupons = M('coupons');
        if($coupons->create()){
            $result = $coupons->add(); // 写入数据到数据库
            if($result){
                // 如果主键是自动增长型 成功后返回值就是最新插入的值
                $this->success('优惠券添加成功',U('Coupons/couponsList'));
            }
        }
    }
    
    /*
     * 查看优惠券列表
     * */
    public function couponsList()
    {
        $coupons = M('coupons');
        $where['business_id'] = $_SESSION['Admin']['business_id'];
        $list = $coupons->where($where)->select();
        foreach ($list as $k=>$v){
            $list[$k]['coupons_overtime'] = date("Y-m-d H:i",$v['coupons_overtime']);
            $list[$k]['coupons_addtime'] = date("Y-m-d H:i",$v['coupons_addtime']);
        }
        $this->assign('list',$list);
        $this->display('Index/CouponsList');
     }

    /*
     * 删除优惠券
     * */
    public function delCoupons()
    {
        $id = I('get.id');
        $coupons = M('coupons');
        $list = $coupons->find($id);
        $pic =$list['coupons_image'];
        if($coupons->delete($id)){
            $img = './Uploads'.$pic;
            @unlink($img);
            $this->success('删除成功',U('Coupons/couponsList'));
        }else{
            $this->error('优惠券删除出现问题');
        }
    }


    /*
     * 修改优惠券页面
     * */
    public function updateCoupons()
    {
        $id = I('get.id');
        $coupons = M('coupons');
        $list = $coupons->find($id);
        $list['coupons_desc'] = html_entity_decode($list['coupons_desc']);
        $list['coupons_overtime'] = date('Y-m-d H:i',$list['coupons_overtime']);
        $list['coupons_overtime'] = str_replace(' ', 'T', $list['coupons_overtime']);
        $this->assign('list',$list);
        $this->display('Index/updateCoupons');
    }

    /*
     * 修改优惠券
     * */
    public function doUpdateCoupons()
    {
        $coupons = M('coupons');
        //初始化数据
        $str = $_POST['coupons_overtime'];
        $_POST['coupons_overtime'] = strtotime(str_replace('T', ' ', $str));
        $info = $coupons->find($_POST['coupons_id']);
        $pic = $info['coupons_image'];
        //没有图片上传,生成新的图片名字
        if($_FILES['coupons_image']['name']!=''){
            $_POST['coupons_image'] = $this->__uploadFile();
        }
          $res =  $coupons->save($_POST);
          if($res){
              $img = './Uploads'.$pic;
              @unlink($img);
              $this->success('修改成功',U('Coupons/couponsList'));
          }else{
              $this->success('修改失败');
          }
        }
            //判断有没有图片上传
//        没有图片上传直接执行修改
        //有图片上传，上传图片，获取图片名，执行修改，再删除老的图片
    

    /*
 * 图片上传
 * */
    private function __uploadFile()
    {
        $config = array(
            'maxSize'    =>    3145728,
            'savePath'   =>    '/CouponsImages/',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['coupons_image']);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            /* $image = new \Think\Image();
             $src = "./Uploads".$info['savepath'].$info['savename'];
             $image->open($src);
             $image->thumb(164,164)->save('./Uploads'.$info['savepath'].$info['savename']);*/
            $image = new \Think\Image();
            $src = "./Uploads".$info['savepath'].$info['savename'];
            $image->open($src);
            $image->thumb(164,164)->save('./Uploads'.$info['savepath'].$info['savename']);
            return $info['savepath'].$info['savename'];
        }
    }

}