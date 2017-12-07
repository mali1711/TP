<?php    
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
class CreateRq{

    public function __construct()
    {
        //引入核心文件
        include "qrlib.php";
    }

    /*
     * 实例化二维码生成类
     * $value url：地址
     * $errorCorrectionLevel：错误级别
     * $matrixPointSize 二维码大小
     * $qrcodeName 二维码名称
     * */
    public function CreateQr($value='https://www.baidu.com/',$qrcodeName='Uploads/BusinessQrCode/qrcode.png',$errorCorrectionLevel = 'L',$matrixPointSize =6)
    {
        //生成二维码图片
        QRcode::png($value, $qrcodeName, $errorCorrectionLevel,$matrixPointSize,2);
        $logo = 'logo.png';//准备好的logo图片
        $QR = 'qrcode.png';//已经生成的原始二维码图

        if ($logo !== FALSE) {
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }

//        imagepng($QR, 'helloweixin.png');
//        echo '<img src="/Uploads/helloweixin.png">';
    }

}