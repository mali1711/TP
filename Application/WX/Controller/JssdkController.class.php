<?php
namespace WX\Controller;
use Think\Controller;

/*
 * 获取SDK所需要的信息
 * */
class JssdkController extends Controller{

/*
 * 获取微信sdk
 * */
    public function getSignPackage()
    {
        import("Org.Wxsdk.Jssdk");
        $Jssdk = new \Jssdk("wx83f31cdf94a5a7de", "978bc823217573b8b8f5853859b14f2c");
        $signPackage = $Jssdk->getSignPackage();
        return $signPackage;
    }

}