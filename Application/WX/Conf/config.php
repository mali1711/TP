<?php
return array(
	//'配置项'=>'配置值'1
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'huike', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '123456', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

	// 支付配置文件
	'PAPMENT'   =>	array(
		'operator_id'=>'ccaaad2ba1f2a6baccb986d0a748dbb9',//收银员id
		'app'	=>	'A00305710000067',					//测试用的app
		'key'	=>	'3d54fa25f393f2690817a1fab9314b92',	//测试app对应的加密key
	),

	// 微信配置文件
	'WX'		=>	array(
		
	)
);