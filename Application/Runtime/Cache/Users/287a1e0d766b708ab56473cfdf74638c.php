<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style3.css"/>
</head>
<body>
	<div id="top">
		<div class="top_img"></div>
		<a href="#">&lt;</a><b>注册</b>
	</div>
	<div id="san01"></div>
	<div id="touxiang" >
		<div class="touxiang_img"></div>
		<div class="touxiang_trans"><input type="submit" name="" value="点击上传" style="width:164px;height:42px;
						border:2px solid #009dff;border-radius:21px;color:#009dff;font-size:28px;background-color:#ffffff;"/></div>
	</div>
	<div id="san02"></div>
	<div id="name"><b>性名</b><input type="text" name="" style="width:74%;height:92px;font-size:30px;border:0px"/><span>未填写&nbsp;></span></div>
	<div id="sex"><b>性别</b><input type="text" name="" style="width:74%;height:92px;font-size:30px;border:0px"/><span>未填写&nbsp;></span></div>
	<div id="num"><b>电话</b><input type="text" name="" style="width:74%;height:92px;font-size:30px;border:0px"/><span>未填写&nbsp;></span></div>
	<div id="foot">
		<div class="sub"><input type="submit" name="" value="提交"  style="width:100%; height:90px;background-color:#009dff;color:#ffffff;				
							text-align:center;border-radius:45px;font-size:40px;letter-spacing:5px;line-height:86px;border:0px;"/></div>
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