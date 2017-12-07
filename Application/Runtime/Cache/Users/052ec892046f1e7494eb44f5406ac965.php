<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>付款</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style4.css"/>
</head>
<body>
<form action="/TP/index.php/Users/Bunsiness/getMoney" method="post">
	<div id="top">
		<div class="top_img"></div>
		<a href="/TP/index.php/Users/Index/index">&lt;</a><b>付款码</b>
	</div>
	<div id="san01"></div>
	<!--临时测试付款-->

<!--			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><input  style="width:50%; height:50px;border-radius:10px;background-color:#f2f2f2;line-height:100px;border:0px;font-size:10px;" type="radio" name="business_id" value="<?php echo ($vo["business_id"]); ?>"/><span style="font-size: 50px;"><?php echo ($vo["business_name"]); ?>
			</span><?php endforeach; endif; ?>-->
	<!--临时测试付款-->
	<div id="content">
		<div class="content_01"><b>现金支付金额</b></div>
		<div class="content_02"><input name="money" type="text" size="15" style="width:100%; height:100px;border-radius:16px;
								background-color:#f2f2f2;line-height:100px;border:0px;font-size:40px;"/></div>
		<div class="content_03"><b>积分抵现金额</b><span>拥有积分：<?php echo ($list["integral"]); ?></span></div>
		<div class="content_04"><input name="integral" type="text" size="15" style="width:100%; height:100px;border-radius:16px;
								background-color:#f2f2f2;line-height:100px;border:0px;font-size:40px;"/></div>
	</div>
	<div id="foot">
		<div class="sub"><b><input name="" type="submit"  value="提交" style="width:100%; height:90px;border-radius:50px;
		     text-align:center;line-height:90px;color:#ffffff;font-size:40px;background-color:#009dff;border:0px;"/></b></div>
	</div>

</form>
	
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