<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style8.css"/>

</head>
<body>
		<div id="top">
			<div class="zhuangtailan"></div>
			<div class="huike"><b>商家名称</b></div>	
			<div id="fen">
				<p><b>3,868.35</b><br/>
				<span>今日交易额</span><p>
			</div>
		</div>
		<div id="content01">
			<div class="content01_icon01"><p><b>今日订单</b><br/>234笔<p></div>
			<div class="content01_icon02"><p><b>会员信息</b><br/>233笔<p></div>
		</div>
		<div id="content02">
			<div class="content02_icon01"><p><b>今日订单</b><br/>234笔<p></div>
			<div class="content02_icon02"><p><b>会员信息</b><br/>233笔<p></div>
		</div>
		<div class="san"></div>
		<div id="banner01"></div>
		<div class="san"></div>
		<div id="banner02"></div>
		<div class="san"></div>

		
	 
	
	
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