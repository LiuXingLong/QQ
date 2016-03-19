<?php
return array(
	//'配置项'=>'配置值'
	'URL_MODEL'         => 2,  // URL 以模块的形式访问
	'DEFAULT_MODULE'    => 'Home',               //配置默认模块
	
	/* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'qq',   // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',      // 密码
    'DB_PORT'               =>  '3306',      // 端口
	
	// 启用表单令牌功能
	'view_filter'           =>  array('Behavior\TokenBuild'),
);