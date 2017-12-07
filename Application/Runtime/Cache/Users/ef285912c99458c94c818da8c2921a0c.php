<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet"  type="text/css"  href="/TP/Public/Style/User/App/css/style2.css"/>
</head>
<body>
		<div id="top">
			<div class="zhuangtailan"></div>
			<div class="huike"><i><b>汇客会员</b></i></div>
			<div class="head">
				<div class="head_01"><p><b>无言以对</b><p><span>18*******71</span></div>
				<div class="head_02">推广有礼</div>
			</div>
			<div class="icon">
				<div class="icon01"><h6>扫一扫</h6></div>
				<div class="icon02"><h6>付款码</h6></div>
				<div class="icon03"><h6>卡劵</h6></div>
			</div>
		</div>
		<div  id="jifen">
			<div class="jifen01"><p>积分<p><span>今日签到<a href="#">5</a>分</span></div>
			<div class="jifen02"><p>积分商城<p><span>好货等你来抢</span></div>
		</div>
		<div id="san01"></div>
		<div id="shouyi"><h6>我的收益(元)</h6></div>
		<div id="shouyi_fen">
				<a>总收益<br/><span class="data01">5888.88</span></a>
				<div class="shouyi_fen_line"></div>
		       <a>总支出<br/><span class="data02">288.88</span></a>
			   <div class="shouyi_fen_line"></div>
			   <a>返还中<br/><span class="data03">200.59</span></a>
		</div>
		<div id="san02"></div>
		<div id="banner"></div>
		<div id="foot">技术支持汇客会员</div>
	 
	
	
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