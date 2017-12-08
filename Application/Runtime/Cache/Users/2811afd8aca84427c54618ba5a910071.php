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
		<div id="scanQRCode1" class="icon01"><h6 class="fontS34">扫一扫</h6></div>
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	/*
	 * 注意：
	 * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
	 * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
	 * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
	 *
	 * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
	 * 邮箱地址：weixin-open@qq.com
	 * 邮件主题：【微信JS-SDK反馈】具体问题
	 * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
	 */
	wx.config({
		debug: false,
		appId: '<?php echo ($wxInfo["appId"]); ?>',
		timestamp:<?php echo ($wxInfo["timestamp"]); ?>,
		nonceStr:'<?php echo ($wxInfo["nonceStr"]); ?>',
		signature: '<?php echo ($wxInfo["signature"]); ?>',
		jsApiList: [
		// 所有要调用的 API 都要加到这个列表中
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
		'onMenuShareQZone',
		'hideMenuItems',
		'showMenuItems',
		'hideAllNonBaseMenuItem',
		'showAllNonBaseMenuItem',
		'translateVoice',
		'startRecord',
		'stopRecord',
		'onVoiceRecordEnd',
		'playVoice',
		'onVoicePlayEnd',
		'pauseVoice',
		'stopVoice',
		'uploadVoice',
		'downloadVoice',
		'chooseImage',
		'previewImage',
		'uploadImage',
		'downloadImage',
		'getNetworkType',
		'openLocation',
		'getLocation',
		'hideOptionMenu',
		'showOptionMenu',
		'closeWindow',
		'scanQRCode',
		'chooseWXPay',
		'openProductSpecificView',
		'addCard',
		'chooseCard',
		'openCard'
	]
	});
	wx.ready(function () {


		document.querySelector('#scanQRCode1').onclick = function () {
			wx.scanQRCode({
				needResult: 0,
				desc: 'scanQRCode desc',
				success: function (res) {

				}
			});
		}
	});
</script>
</body>
</html>