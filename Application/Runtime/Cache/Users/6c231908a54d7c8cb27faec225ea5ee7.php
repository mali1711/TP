<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style7.css"/>
</head>
<body>
		<div id="top">
			<div class="zhuangtailan"></div>
			<div class="huike"><b>分享有礼</b></div>		
		</div>
		<div id="banner"></div>
		<div id="content">
			<div class="content01"><b>热门活动</b></div>
			<div class="content02">
			    <div class="content02_01"></div>
			    <div class="content02_02">
					<div class="content_text"><p><b>活动名称</b><br/>请输入活动概述</p><span>567</span>人参加</div>
					<div class="content_push">进入</div>
				</div>
			</div>
			<div class="content03">
			    <div class="content03_01"></div>
			    <div class="content03_02">
					<div class="content_text"><p><b>活动名称</b><br/>请输入活动概述</p><span>567</span>人参加</div>
					<div class="content_push">进入</div>
				</div>
			</div>
			<div class="content04">
			    <div class="content04_01"></div>
			    <div class="content04_02">
					<div class="content_text"><p><b>活动名称</b><br/>请输入活动概述</p><span>567</span>人参加</div>
					<div class="content_push">进入</div>
				</div>
			</div>
			<div class="content05">
			    <div class="content05_01"></div>
			    <div class="content05_02">
					<div class="content_text"><p><b>活动名称</b><br/>请输入活动概述</p><span>567</span>人参加</div>
					<div class="content_push">进入</div>
				</div>
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