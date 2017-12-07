<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>分享有礼</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style7.css"/>
    <!--引入vue.js-->
    <style>
        .top{
            width: 100%;
            background-color: #009DFF;
            height: 45px;;
        }
        .top a{
            float: left;
            color: white;
            line-height: 45px;
        }
        .top-font{
            color:white;
            font-size: 16px;
            line-height: 45px;


        }
        .top-font b{
            margin: 0 auto;
        }
        .jiathis_style_32x32{
            float: right;
        }
        .fetitle{
            float: right;
            line-height: 30px;
            margin-right: 10px;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="top">
        <a href="#"><b>&lt;</b></a>
        <center>
        <span class="top-font"><b>活动首页</b></span>
        </center>
    </div>
    <div>
        <?php echo ($list["share_desc"]); ?>
    </div>
    <!-- 设置分享 start-->
    <!-- JiaThis Button BEGIN -->
    <div class="jiathis_style_32x32" onmouseover="setShare(
        '您的好友邀请您加入....',
        'http://www.baidu.com',
        '', '', true, false);">
        <a class="jiathis_button_tsina" ></a>
        <a class="jiathis_button_weixin"></a>
        <a class="jiathis_button_cqq"></a>
    </div>
    <span class="fetitle">分享有礼</span>
    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=" charset="utf-8"></script>
    <script type="text/javascript" >

        function setShare(title, url,  pic, summary, shortUrl, hideMore) {
            jiathis_config.title = title;
            jiathis_config.url = url;
            jiathis_config.pic = pic;
            jiathis_config.summary = summary;
            jiathis_config.shortUrl = shortUrl;
            jiathis_config.hideMore = hideMore;
        }

        var jiathis_config = {};
    </script>
    <!-- JiaThis Button END -->
    <!-- 设置分享 end-->
</body>

<script src="https://code.jquery.com/jquery.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="js/bootstrap.min.js"></script>
</html>