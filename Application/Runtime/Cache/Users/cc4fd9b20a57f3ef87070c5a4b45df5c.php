<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style5.css"/>
  
</head>
<body>
		<div id="top">
			<div class="zhuangtailan"></div>
			<div class="huike"><b>积分</b></div>
			<div class="head">
				<div class="head_01"><p><b>无言以对</b><p><span>18*******71</span></div>
				<div class="head_02">&gt;</div>
			</div>
			<div id="fen">
				<p><b>500</b>分<p>
				<span>您在本店可使用积分</span>
			</div>
		</div>
		<div id="content">
			<h5><span>友情提示：</span>您在以下商家还有积分可用</h5>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="shop04">
				<div class="shop_01"><p><b><?php echo ($vo["business_name"]); ?></b><br/>您在本店本店可以可用300分</p></div>
				<div class="shop_02"><a href="/TP/index.php/Users/Index/BunsinessDetail/id/<?php echo ($vo["business_id"]); ?>"><input type="button" name="" value="进入" style="width:100%; height:42px;border-radius:22px;
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