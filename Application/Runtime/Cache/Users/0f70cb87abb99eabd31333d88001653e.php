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
		.green{
			color: #00FF00;
		}
		.blue{
			color: #0066cc;
		}
		.black{
			color:black;
		}
	</style>
</head>
<body>
	<div id="top">
		<div class="top_img"></div>
			<a href="/TP/index.php/Users/Users/index">&lt;</a><b class="title">详情</b>
	</div>
	<div id="content">
	<div class="foot">
			<h5>你的具体分红详情为</h5>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="foot01"><p><b><?php echo (date("Y-m-d",$vo["users_integral_addtime"])); ?></b><br/>您于<span class="blue"><?php echo (date("Y-m-d",$vo["consume_time"])); ?></span>日消费的<span class="black"><?php echo ($vo["consume_money"]); ?></span>(元)返还了<span class="green"><?php echo ($vo["users_get_integral"]); ?></span>积分</p></div><?php endforeach; endif; ?>
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