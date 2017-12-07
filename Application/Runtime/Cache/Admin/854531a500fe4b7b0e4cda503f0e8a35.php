<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>汇客后台</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="/TP/Public/Style/Home/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/TP/Public/Style/Home/assets/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="/TP/Public/Style/Home/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="/TP/Public/Style/Home/assets/css/ace-fonts.css" />

		<!-- ace styles -->

		<link rel="stylesheet" href="/TP/Public/Style/Home/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/TP/Public/Style/Home/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/TP/Public/Style/Home/assets/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/TP/Public/Style/Home/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="/TP/Public/Style/Home/assets/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="/TP/Public/Style/Home/assets/js/html5shiv.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							<?php echo ($businessInfo["info"]["business_account"]); ?>
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>

							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-ok"></i>
									4 Tasks to complete
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Software Update</span>
											<span class="pull-right">65%</span>
										</div>

										<div class="progress progress-mini ">
											<div style="width:65%" class="progress-bar "></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Hardware Upgrade</span>
											<span class="pull-right">35%</span>
										</div>

										<div class="progress progress-mini ">
											<div style="width:35%" class="progress-bar progress-bar-danger"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Unit Testing</span>
											<span class="pull-right">15%</span>
										</div>

										<div class="progress progress-mini ">
											<div style="width:15%" class="progress-bar progress-bar-warning"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Bug Fixes</span>
											<span class="pull-right">90%</span>
										</div>

										<div class="progress progress-mini progress-striped active">
											<div style="width:90%" class="progress-bar progress-bar-success"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										See tasks with details
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-bell-alt icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-warning-sign"></i>
									8 Notifications
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
												New Comments
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary icon-user"></i>
										Bob just signed up as an editor ...
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success icon-shopping-cart"></i>
												New Orders
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-info icon-twitter"></i>
												Followers
											</span>
											<span class="pull-right badge badge-info">+11</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										See all notifications
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-envelope-alt"></i>
									5 Messages
								</li>

								<li>
									<a href="#">
										<img src="/TP/Public/Style/Home/assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Alex:</span>
												Ciao sociis natoque penatibus et auctor ...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>a moment ago</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#">
										<img src="/TP/Public/Style/Home/assets/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Susan:</span>
												Vestibulum id ligula porta felis euismod ...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>20 minutes ago</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#">
										<img src="/TP/Public/Style/Home/assets/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Bob:</span>
												Nullam quis risus eget urna mollis ornare ...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>3:15 pm</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="inbox.html">
										See all messages
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/TP/Public/Style/Home/assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									Jason
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="icon-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="#">
										<i class="icon-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="#">
										<i class="icon-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<li class="active">
							<a href="index.html">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> 商家基本详情 </span>
							</a>
						</li>

						<li>
							<a href="/TP/index.php/Admin/Shop/addGoods">
								<i class="icon-text-width"></i>
								<span class="menu-text"> 添加新商品</span>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text"> 商家其他操作 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">

								<li>
									<a href="/TP/index.php/Admin/Shop/goodslist">
										<i class="icon-double-angle-right"></i>
										<span class="menu-text"> 商品列表 </span>
									</a>
								</li>

								<li>
									<a href="/TP/index.php/Admin/RqCode/showRq">
										<i class="icon-double-angle-right"></i>
										<span class="menu-text"> 本店二维码 </span>
									</a>
								</li>

								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>

										操作二
										<b class="arrow icon-angle-down"></b>
									</a>

									<ul class="submenu">
										<li>
											<a href="#">
												<i class="icon-leaf"></i>
												操作二 · 1
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-pencil"></i>

												操作二 · 2
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">
												<li>
													<a href="#">
														<i class="icon-plus"></i>
														Add Product
													</a>
												</li>

												<li>
													<a href="#">
														<i class="icon-eye-open"></i>
														View Products
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class=" icon-bookmark"></i>
								<span class="menu-text"> 优惠券 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">

								<li>
									<a href="/TP/index.php/Admin/Coupons/addCoupons">
										<i class="icon-double-angle-right"></i>
										<span class="menu-text"> 添加优惠券 </span>
									</a>
								</li>
								<li>
									<a href="/TP/index.php/Admin/Coupons/Couponslist">
										<i class="icon-double-angle-right"></i>
										<span class="menu-text"> 优惠券列表 </span>
									</a>
								</li>

								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>

										操作二
										<b class="arrow icon-angle-down"></b>
									</a>

									<ul class="submenu">
										<li>
											<a href="#">
												<i class="icon-leaf"></i>
												操作二 · 1
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-pencil"></i>

												操作二 · 2
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">
												<li>
													<a href="#">
														<i class="icon-plus"></i>
														Add Product
													</a>
												</li>

												<li>
													<a href="#">
														<i class="icon-eye-open"></i>
														View Products
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class=" icon-bookmark"></i>
								<span class="menu-text"> 分享活动 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">

								<li>
									<a href="/TP/index.php/Admin/Share/AddShare">
										<i class="icon-double-angle-right"></i>
										<span class="menu-text"> 添加分享活动 </span>
									</a>
								</li>
								<li>
									<a href="/TP/index.php/Admin/Share/ShareList">
										<i class="icon-double-angle-right"></i>
										<span class="menu-text"> 分享活动列表 </span>
									</a>
								</li>

								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>

										操作二
										<b class="arrow icon-angle-down"></b>
									</a>

									<ul class="submenu">
										<li>
											<a href="#">
												<i class="icon-leaf"></i>
												操作二 · 1
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-pencil"></i>

												操作二 · 2
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">
												<li>
													<a href="#">
														<i class="icon-plus"></i>
														Add Product
													</a>
												</li>

												<li>
													<a href="#">
														<i class="icon-eye-open"></i>
														View Products
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>
				
    <script type="text/javascript" charset="utf-8" src="/TP/Public/Style/baiDuBianJi/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/TP/Public/Style/baiDuBianJi/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/TP/Public/Style/baiDuBianJi/lang/zh-cn/zh-cn.js"></script>

    <style type="text/css">
        div{
            width:100%;
        }
    </style>
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="icon-home home-icon"></i>
                    <a href="#">Home</a>
                </li>

                <li>
                    <a href="#">商家</a>
                </li>
                <li class="active">商品添加</li>
            </ul><!-- .breadcrumb -->

        </div>

        <div class="page-content">
            <div class="page-header">
                <h1>
                    商家后台
                    <small>
                        <i class="icon-double-angle-right"></i>
                        商品添加
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <form class="form-horizontal" role="form" action="/TP/index.php/Admin/Coupons/doUpdateCoupons" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="coupons_id" value="<?php echo ($list["coupons_id"]); ?>"/>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 优惠券图片： </label>

                            <div class="col-sm-9">
                                <input type="file" id="id-input-file-2"  name="coupons_image" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 优惠券名称： </label>

                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" name="coupons_name" value="<?php echo ($list["coupons_name"]); ?>" placeholder="优惠券名称" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-5">发布数量：</label>

                            <div class="col-sm-9">
                                <div class="clearfix">
                                    <input class="col-xs-1" type="text" name="coupons_num" value="<?php echo ($list["coupons_num"]); ?>" id="form-field-5" placeholder="" />
                                </div>

                                <div class="space-2"></div>

                                <div class="help-block" id="input-span-slider"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-5">优惠券面值：</label>

                            <div class="col-sm-9">
                                <div class="clearfix">
                                    <input class="col-xs-1" type="text" name="coupons_money" value="<?php echo ($list["coupons_money"]); ?>" id="form-field-5" placeholder="" />
                                </div>

                                <div class="space-2"></div>

                                <div class="help-block" id="input-span-slider"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-5">消费满多少可用：</label>

                            <div class="col-sm-9">
                                <div class="clearfix">
                                    <input class="col-xs-1" type="text" name="coupons_satisfy" value="<?php echo ($list["coupons_satisfy"]); ?>" id="form-field-5" placeholder="" />
                                </div>

                                <div class="space-2"></div>

                                <div class="help-block" id="input-span-slider"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-5">过期时间：</label>

                            <div class="col-sm-9">
                                <div class="clearfix">
                                    <input name="coupons_overtime" value="<?php echo ($list["coupons_overtime"]); ?>" class="ace ace-switch ace-switch-7" type="datetime-local">
                                    <span class="lbl"></span>
                                </div>

                                <div class="space-2"></div>

                                <div class="help-block" id="input-span-slider"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-5">优惠券简介：</label>

                            <div class="col-sm-9">
                                <div class="clearfix">
                                    <div>
                                        <script id="editor" name="coupons_desc" type="text/plain" style="width:80%;height:200px;"><?php echo ($list["coupons_desc"]); ?></script>
                                    </div>

                                    <script type="text/javascript">

                                        //实例化编辑器
                                        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                                        var ue = UE.getEditor('editor',{
                                            toolbars: [
                                                ['fullscreen', 'source', 'undo', 'redo'],
                                                ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
                                            ]
                                        });
                                        function isFocus(e){
                                            alert(UE.getEditor('editor').isFocus());
                                            UE.dom.domUtils.preventDefault(e)
                                        }
                                        function setblur(e){
                                            UE.getEditor('editor').blur();
                                            UE.dom.domUtils.preventDefault(e)
                                        }
                                        function insertHtml() {
                                            var value = prompt('插入html代码', '');
                                            UE.getEditor('editor').execCommand('insertHtml', value)
                                        }
                                        function createEditor() {
                                            enableBtn();
                                            UE.getEditor('editor');
                                        }
                                        function getAllHtml() {
                                            alert(UE.getEditor('editor').getAllHtml())
                                        }
                                        function getContent() {
                                            var arr = [];
                                            arr.push("使用editor.getContent()方法可以获得编辑器的内容");
                                            arr.push("内容为：");
                                            arr.push(UE.getEditor('editor').getContent());
                                            alert(arr.join("\n"));
                                        }
                                        function getPlainTxt() {
                                            var arr = [];
                                            arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
                                            arr.push("内容为：");
                                            arr.push(UE.getEditor('editor').getPlainTxt());
                                            alert(arr.join('\n'))
                                        }
                                        function setContent(isAppendTo) {
                                            var arr = [];
                                            arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
                                            UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
                                            alert(arr.join("\n"));
                                        }
                                        function setDisabled() {
                                            UE.getEditor('editor').setDisabled('fullscreen');
                                            disableBtn("enable");
                                        }

                                        function setEnabled() {
                                            UE.getEditor('editor').setEnabled();
                                            enableBtn();
                                        }

                                        function getText() {
                                            //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
                                            var range = UE.getEditor('editor').selection.getRange();
                                            range.select();
                                            var txt = UE.getEditor('editor').selection.getText();
                                            alert(txt)
                                        }

                                        function getContentTxt() {
                                            var arr = [];
                                            arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
                                            arr.push("编辑器的纯文本内容为：");
                                            arr.push(UE.getEditor('editor').getContentTxt());
                                            alert(arr.join("\n"));
                                        }
                                        function hasContent() {
                                            var arr = [];
                                            arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
                                            arr.push("判断结果为：");
                                            arr.push(UE.getEditor('editor').hasContents());
                                            alert(arr.join("\n"));
                                        }
                                        function setFocus() {
                                            UE.getEditor('editor').focus();
                                        }
                                        function deleteEditor() {
                                            disableBtn();
                                            UE.getEditor('editor').destroy();
                                        }
                                        function disableBtn(str) {
                                            var div = document.getElementById('btns');
                                            var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
                                            for (var i = 0, btn; btn = btns[i++];) {
                                                if (btn.id == str) {
                                                    UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
                                                } else {
                                                    btn.setAttribute("disabled", "true");
                                                }
                                            }
                                        }
                                        function enableBtn() {
                                            var div = document.getElementById('btns');
                                            var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
                                            for (var i = 0, btn; btn = btns[i++];) {
                                                UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
                                            }
                                        }

                                        function getLocalData () {
                                            alert(UE.getEditor('editor').execCommand( "getlocaldata" ));
                                        }

                                        function clearLocalData () {
                                            UE.getEditor('editor').execCommand( "clearlocaldata" );
                                            alert("已清空草稿箱")
                                        }
                                    </script>
                                    <span class="lbl"></span>
                                </div>

                                <div class="space-2"></div>

                                <div class="help-block" id="input-span-slider"></div>
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="submit">
                                    <i class="icon-ok bigger-110"></i>
                                    提交
                                </button>

                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset">
                                    <i class="icon-undo bigger-110"></i>
                                    撤销
                                </button>
                            </div>
                        </div>

                    </form>

                    <div class="hr hr-18 dotted hr-double"></div>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->




				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>

					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="default" value="#438EB9">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp; Choose Skin</span>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
							<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
							<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
							<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
							<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
							<label class="lbl" for="ace-settings-add-container">
								Inside
								<b>.container</b>
							</label>
						</div>
					</div>
				</div><!-- /#ace-settings-container -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='/TP/Public/Style/Home/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='/TP/Public/Style/Home/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/TP/Public/Style/Home/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/TP/Public/Style/Home/assets/js/bootstrap.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="/TP/Public/Style/Home/assets/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="/TP/Public/Style/Home/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/jquery.slimscroll.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/jquery.easy-pie-chart.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/jquery.sparkline.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/flot/jquery.flot.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/flot/jquery.flot.pie.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/flot/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->

		<script src="/TP/Public/Style/Home/assets/js/ace-elements.min.js"></script>
		<script src="/TP/Public/Style/Home/assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})

				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
				});




			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne",
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);

			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);



			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;

			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}

			 });






				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}

				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}

				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}


				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});


				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();

					var off2 = $source.offset();
					var w2 = $source.width();

					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}


				$('.dialogs,.comments').slimScroll({
					height: '300px'
			    });


				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});

				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) 
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});


			})
		</script>
	</body>
</html>