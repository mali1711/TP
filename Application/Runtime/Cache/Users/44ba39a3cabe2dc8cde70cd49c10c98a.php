<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>付款</title>
    <link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style4.css"/>
</head>
<body>
<form action="/TP/index.php/Users/Bunsiness/getMoney" method="post">
    <div id="top">
        <div class="top_img"></div>
        <a href="/TP/index.php/Users/Index/index">&lt;</a><b>付款码</b>
    </div>
    <center style="margin-top:250px;">
        <img width="800px" src="/TP/Public/Style/User/App/img/mmexport1511097319109.png"/>
    </center>

</form>

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
</body>
</html>