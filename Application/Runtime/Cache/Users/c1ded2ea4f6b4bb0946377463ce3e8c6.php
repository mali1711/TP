<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>优惠券列表</title>
    <link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style7.css"/>
    <!--引入vue.js-->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://unpkg.com/vue"></script>
</head>
<body>
<div id="bod">
    <div id="top">
        <div class="zhuangtailan"></div>
        <div class="huike" onclick="location.href='/TP/index.php/Users/Users/index';"><b>{{ message }}</b></div>
    </div>
    <div id="banner"></div>
    <div id="content">
        <div class="content01"><b>优惠券列表</b></div>
        <?php if(is_array($couponslist)): foreach($couponslist as $key=>$vo): ?><div class="content02">
            <div class="content02_01"></div>
            <div class="content02_02">
                <div class="content_text"><p><b><?php echo ($vo["coupons_name"]); ?></b><br/>满<?php echo ($vo["coupons_satisfy"]); ?>减<?php echo ($vo["coupons_money"]); ?></p><span>拥有1</span>张</div>
                <a href="/TP/index.php/Users/Coupons/useCoupons/business_id/<?php echo ($vo["business_id"]); ?>"><div class="content_push">使用</div></a>
            </div>
        </div><?php endforeach; endif; ?>
        <script>
            var app = new Vue({
                el: '#bod',
                data: {
                    message: '优惠券列表'
                }
            })
        </script>


    </div>
</body>

<script type="text/javascript">
    (function (doc, win) {
        var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    docEl.style.fontSize = 30 * (clientWidth / 320) + 'px';
                };

        // Abort if browser does not support addEventListener
        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
</script>
</html>