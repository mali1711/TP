<?php
/**
 * Created by PhpStorm.
 * User: Mali
 * Date: 2017/12/2
 * Time: 20:48
 */
namespace Admin\Controller;
use Think\Controller;
class RqCodeController extends Controller {


    /*
     * 创建二维码
     * */
    public function CreateRq($matrixPointSize=3)
    {
        $bid = $_SESSION['Admin']['business_id'];
        $url = $_SERVER['SERVER_NAME'].__ROOT__.'/Users?business_id='.$bid;
        $picName = md5("business_id=$bid");
        $qrcodeName='Uploads/BusinessQrCode/'."{$picName}.png";
        $errorCorrectionLevel = 'L';
        return CreateRq($url,$qrcodeName,$errorCorrectionLevel,$matrixPointSize);
    }
    
    
    /*
     * 显示二维码
     * */
    public function showRq()
    {
        $matrixPointSize = $_POST['size'];
        $imgSrc =  $this->CreateRq($matrixPointSize);
        $this->assign('data',$imgSrc);
        $this->display('Index/showRq');

        /*判断有没有当前的二维码
        if(is_file('Uploads/BusinessQrCode/business_id=2.png')){

        }else{

        }*/

    }
    
    /*
     * 下载二维码
     * */
    public function downloadRq()
    {
        $filename = $_GET['filename'];
        $img = "Uploads/BusinessQrCode/{$filename}";
        //设置头信息
        header('Content-Disposition:attachment;filename=' . basename($filename));
        header('Content-Length:' . filesize($img));
        //读取文件并写入到输出缓冲
        readfile($img);
    }

}