<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户中心</title>
	<link rel="stylesheet"  type="text/css"  href="/TP/Public/Style/User/App/css/style2.css"/>
	<style>
		.fontS36{
			font-size: 36px;
		}
		.fontS34{
			font-size: 34px;
		}
		.fontS32{
			font-size: 32px;
		}
	</style>
</head>
<body>
<div id="top">
	<div class="zhuangtailan"></div>
	<div class="huike"><i><b style="font-size: 55px;">汇客会员</b></i></div>
	<div class="head">
		<div class="head_01"><p><b class="fontS34"><?php echo ($list["users_name"]); ?></b><p><span class="fontS32"><?php echo ($list["users_phone"]); ?></span></div>
		<a href="/TP/index.php/Users/Bunsiness/extension"><div class="head_02 fontS34">推广有礼</div></a>
	</div>
	<div class="icon">
		<div class="icon01"><h6 class="fontS34">扫一扫</h6></div>
		<!--		<div class="icon01"><h6><input type="file" capture="camera" accept="image/*" id="cameraInput" name="cameraInput" class="sign_file"/></h6></div>-->	<a href="/TP/index.php/Users/Index/payment"><div class="icon02"><h6 class="fontS34">付款码</h6></div></a>
		<a href="/TP/index.php/Users/Coupons/index"><div class="icon03"><h6 class="fontS34">卡劵</h6></div></a>
	</div>
</div>
<div  id="jifen">
	<a href="/TP/index.php/Users/Index/BunsinessList"><div class="jifen01"><p class="fontS34">积分<p>今日签到5分</span></div></a>
	<a href="/TP/index.php/Users/Bunsiness/goodslist"><div class="jifen02"><p class="fontS34">积分商城<p><span class="fontS32">好货等你来抢</span></div></a>
</div>
<div id="san01"></div>
<div id="shouyi"><h6 style="font-size: 37px;">我的收益(元)</h6></div>
<div id="shouyi_fen">
	<a class="fontS34">总收益<br/><span class="data01"><?php echo ($list["users_integral_total_amount"]); ?></span></a>
	<div class="shouyi_fen_line"></div>
	<a class="fontS34">总支出<br/><span class="data02"><?php echo ($list["users_money_total"]); ?></span></a>
	<div class="shouyi_fen_line fontS34"></div>
	<a>分红中<br/><span class="data03">0</span></a>
</div>
<div id="san02"></div>
<div id="banner"></div>
<div id="foot">技术支持汇客会员</div>
<script>

</script>

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