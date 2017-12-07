<?php
/**
 * Created by PhpStorm.
 * User: mali
 * Date: 2017/12/2
 * Time: 22:37
 */
import("Org.Phpqrcode.CreateRq");


/*
 * 创建二维码
 * */
function CreateRq($value='https://www.baidu.com/',$qrcodeName='Uploads/BusinessQrCode/xxxqrcode.png',$errorCorrectionLevel = 'L',$matrixPointSize =20){
    $text = new \CreateRq();
    $text->CreateQr($value,$qrcodeName,$errorCorrectionLevel,$matrixPointSize);
    return $qrcodeName;
}