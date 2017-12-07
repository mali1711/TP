<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品列表</title>
    <link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style7.css"/>
    <!--引入vue.js-->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://unpkg.com/vue"></script>
</head>
<body>
<div id="bod">
    <div id="top">
        <div class="zhuangtailan"></div>
        <div class="huike" onclick="javascript:history.back(-1);"><b>{{ message }}</b></div>
    </div>
    <div id="content">
        <div class="content01"><b>热门商品</b></div>
        <?php if(is_array($goodList)): foreach($goodList as $key=>$vo): ?><div class="content02">
                <a href="/TP/index.php/Users/Bunsiness/GoodDetail/id/<?php echo ($vo["bun_goods_id"]); ?>"><div class="content02_01" style="background:url(/TP/Uploads/<?php echo ($vo["bun_goods_pic"]); ?>);"></div></a>
                <div class="content02_02">
                    <div class="content_text"><p><b><?php echo ($vo["bun_goods_name"]); ?></b><br/></p><span><?php echo ($vo["bun_goods_price"]); ?></span>积分</div>
                    <div class="content_push" style="margin-top: 45px;"><a style="text-decoration: none;color: #ffffff" href="/TP/index.php/Users/Bunsiness/BuyGoods/id/<?php echo ($vo["bun_goods_id"]); ?>">确认购买</a></div>
                </div>
            </div><?php endforeach; endif; ?>
        <script>
            var app = new Vue({
                el: '#bod',
                data: {
                    message: '积分商城'
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