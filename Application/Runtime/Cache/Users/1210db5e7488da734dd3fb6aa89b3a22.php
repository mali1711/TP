<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style6.css"/>
	<style>
		.title{
			text-align: center;
		}
	</style>
</head>
<body>
	<div id="top">
		<div class="top_img"></div>
			<a href="#">&lt;</a><b class="title">收益统计</b>
	</div>
	<div id="content">
		<div class="content_01"><p><b><?php echo ($list["count"]); ?></b><br/>您在汇客的总收益为&nbsp;(元)</p></div>
		<div class="content_02"><p><b><?php echo ($list["person"]["users_integral_total_amount"]); ?></b><br/>您在本店的总收益为&nbsp;(元)</p></div>
		<div class="foot">
			<h5>您在其他店铺的收益分别为</h5>
			<?php if(is_array($list["list"])): foreach($list["list"] as $key=>$vo): ?><div class="foot01"><p><b><?php echo ($vo["users_integral_total_amount"]); ?></b><br/>您在<?php echo ($vo["business_name"]); ?>店的总收益为&nbsp;(元)</p></div><?php endforeach; endif; ?>
		</div>
	</div>

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