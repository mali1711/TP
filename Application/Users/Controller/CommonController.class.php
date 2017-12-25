<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 22:43
 */
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct()
    {
        parent::__construct();
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

}