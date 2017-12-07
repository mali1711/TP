<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信其他功能</title>
</head>
<body>
<span class="desc">调起微信扫一扫接口</span>
<button class="btn btn_primary" id="scanQRCode0">scanQRCode(微信处理结果)</button>
<button class="btn btn_primary" id="scanQRCode1">scanQRCode(直接返回结果)</button>
<link rel="stylesheet" href="http://203.195.235.76/jssdk/css/style.css">
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
		wx.config({
			debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
			appId: 'wxc0b200b1c8da037b', // 必填，公众号的唯一标识
			timestamp:<?php echo ($data["timestamp"]); ?>, // 必填，生成签名的时间戳
			nonceStr:<?php echo ($data["nonceStr"]); ?>, // 必填，生成签名的随机串
			signature: <?php echo ($data["signature"]); ?>,// 必填，签名，见附录1
			jsApiList: [
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
		] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
		});

	</script>
<script src="http://203.195.235.76/jssdk/js/zepto.min.js"></script>
<script src="http://203.195.235.76/jssdk/js/demo.js"> </script>
</body>
</html>