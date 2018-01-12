<?php
namespace WX\Controller;
use Think\Controller;

/*
 * 获取SDK所需要的信息
 * */
class JssdkController extends Controller{

/*
 * 获取微信sdk
 * $jssdk = new JSSDK("wx83f31cdf94a5a7de", "3f9f0bbfbde8cbdd46ed30fdda19d38c");
 * */
    public function getSignPackage()
    {
        import("Org.Wxsdk.Jssdk");
        $Jssdk = new \Jssdk("wx83f31cdf94a5a7de", "3f9f0bbfbde8cbdd46ed30fdda19d38c");
        $signPackage = $Jssdk->getSignPackage();
        return $signPackage;
    }

}