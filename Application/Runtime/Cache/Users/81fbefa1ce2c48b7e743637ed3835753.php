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
			<a href="#">&lt;</a><b class="title">消费统计</b>
	</div>
	<div id="content">
<!--		<div class="content_01"><p><b>5,647.78</b><br/>您在汇客的总收益为&nbsp;(元)</p></div>
		<div class="content_02"><p><b>1,654.45</b><br/>您在本店的总收益为&nbsp;(元)</p></div>-->
		<div class="foot">
			<h5>消费记录</h5>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="foot02"><p><b><?php echo ($vo["consume_money"]); ?></b><br/>您在<?php echo ($vo["business_name"]); ?>店消费&nbsp;(元)</p></div><?php endforeach; endif; ?>
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