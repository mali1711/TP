<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>分享有礼</title>
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
		<div id="banner"></div>

		<div id="content">
			<div class="content01"><b>热门活动</b></div>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="content02">
			    <div class="content02_01" style="background:url(/TP/Uploads/<?php echo ($vo["share_pic"]); ?>);"></div>
			    <div class="content02_02">
					<div class="content_text"><p><b><?php echo ($vo["share_title"]); ?></b><br/><?php echo ($vo["share_content"]); ?></p><span>0</span>人参加</div>
					<a href="/TP/index.php/Users/Share/showShareDetail/id/<?php echo ($vo["share_id"]); ?>"><div class="content_push">进入</div></a>
				</div>
			</div><?php endforeach; endif; ?>
		</div>


		<script>
			var app = new Vue({
				el: '#bod',
				data: {
					message: '推荐有礼'
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