<?php
namespace WX\Controller;
use Think\Controller;


class TextController extends Controller{

    public function index()
    {
        $Jssdk = A('Jssdk');
        $data = $Jssdk->getSignPackage();
        /*
         * array(6) {
         *   ["appId"] => NULL
         *   ["nonceStr"] => string(16) "rvZwndXrj431IB5d"
         *   ["timestamp"] => int(1512377949)
         *   ["url"] => string(29) "http://www.sir6.cn/TP/WX/Text"
         *   ["signature"] => string(40) "06a81c051948b1084e6b463d4f9950b9f40f38e7"
         *   ["rawString"] => string(94) "jsapi_ticket=&noncestr=rvZwndXrj431IB5d&timestamp=1512377949&url=http://www.sir6.cn/TP/WX/Text"
         *  }
         * */
        $this->assign('data',$data);
        $this->display('Index/index');
    }
}