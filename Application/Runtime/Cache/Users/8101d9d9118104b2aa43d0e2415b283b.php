<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link  rel="stylesheet"   type="text/css"  href="/TP/Public/Style/User/App/css/style3.css"/>
</head>
<body>
<form action="/TP/index.php/Users/Users/doRegister" method="post">
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
	<div id="name"><b>性名</b><input class="tiaojian" type="text" name="users_name" style="width:74%;height:92px;font-size:30px;border:0px"/><span>未填写&nbsp;></span></div>
	<div id="sex"><b>姓别</b><input class="tiaojian" type="text" name="users_sex" style="width:74%;height:92px;font-size:30px;border:0px"/><span>未填写&nbsp;></span></div>
	<div id="num"><b>电话</b><input class="tiaojian" type="text" name="users_phone" style="width:74%;height:92px;font-size:30px;border:0px"/><span>未填写&nbsp;></span></div>
	<div id="num"><b>密码</b><input class="tiaojian" type="password" name="users_pass" style="width:74%;height:92px;font-size:30px;border:0px"/><span>未填写&nbsp;></span></div>
	<div id="foot">
		<div class="sub"><input type="submit" name="" value="提交"  style="width:100%; height:90px;background-color:#009dff;color:#ffffff;				
							text-align:center;border-radius:45px;font-size:40px;letter-spacing:5px;line-height:86px;border:0px;"/></div>
	</div>
</form>
<script>
	//input的class属性是tiaojian
	$(".tiaojian").focus(function(){
		$(this).next().html('');
		//alert($(this).next);
	});

	$(".tiaojian").blur(function(){
		$val = $(this).val();
		if($val==''){
			$(this).next().html('未填写&nbsp;>');
		}
		//alert($(this).next);
	});
</script>
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