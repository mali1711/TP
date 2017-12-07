<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style5.css"/>
	<style>
		a{
			text-decoration:none;
			out-line: none;
			color: #ffffff;
		}
		.head_02{
			float: left;
		}
	</style>
</head>
<body>
		<div id="top">

			<div class="zhuangtailan"></div>
			<div class="head_02"><a href="/TP/index.php/Users/Index/index"> &lt;</a></div>
			<div class="huike"><b>积分</b></div>
			<div class="head">
				<div class="head_01"><p><b><?php echo ($list["user"]["users_name"]); ?></b><p><span><?php echo ($list["user"]["users_phone"]); ?></span></div>
			</div>
			<?php if(isset($list["BunsinessInfo"])): ?><div id="fen">
					<p><b><?php echo ($list["BunsinessInfo"]["users_integral_num"]); ?></b>分<p>
					<span>您在本店可用的积分</span>
				</div>
				<?php else: ?>
				<div id="fen">
					<p><b>0</b>分<p>
					<span>您目前没有消费记录</span>
				</div><?php endif; ?>

		</div>
		<div id="content">
			<h5><span>友情提示：</span>您在以下商家还有积分可用</h5>
			<?php if(is_array($list["business"])): foreach($list["business"] as $key=>$vo): ?><div class="shop04">
				<div class="shop_01"><p><b><?php echo ($vo["business_name"]); ?></b><br/>您在本店本店可以可用<?php echo ($vo["BunsinessInfo"]["users_integral_num"]); ?>分</p></div>
				<div class="shop_02"><a href="/TP/index.php/Users/Index/BunsinessList/id/<?php echo ($vo["business_id"]); ?>"><input type="button" name="" value="进入" style="width:100%; height:42px;border-radius:22px;
				                     background-color:#009dff;font-size:32px;color:#ffffff;text-align:center;border:0px"/></a></div>
			</div><?php endforeach; endif; ?>
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