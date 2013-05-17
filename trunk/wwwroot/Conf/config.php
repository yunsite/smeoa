<?php
    if (!defined('THINK_PATH')) exit();
    $array=array(
        'URL_MODEL'=>3, // 如果你的环境不支持PATHINFO 请设置为3
        'DB_TYPE'=>'mysql',
        'DB_HOST'=>'localhost',
        'DB_NAME'=>'demo',
        'DB_USER'=>'demo',
		'VAR_PAGE'=>'p',
        'DB_PWD'=>'demo',
        'DB_PORT'=>'3306',
        'DB_PREFIX'=>'think_',
		'TOKEN_ON'=>false, 
		'TOKEN_TYPE'=>'md5',
		'TOKEN_NAME'=>'__hash__',
		'URL_CASE_INSENSITIVE' =>   true,
		'TMPL_CACHE_ON'=>false,
		'DB_FIELDS_CACHE'=>false,
        'APP_AUTOLOAD_PATH'=>'@.TagLib',
        'SESSION_AUTO_START'=>true,
        'USER_AUTH_KEY'             =>'authId',	// 用户认证SESSION标记
        'ADMIN_AUTH_KEY'			=>'administrator',
        'USER_AUTH_MODEL'           =>'User',	// 默认验证数据表模型
        'AUTH_PWD_ENCODER'          =>'md5',	// 用户认证密码加密方式
        'USER_AUTH_GATEWAY'         =>'login/index',// 默认认证网关
        'NOT_AUTH_MODULE'           =>"Push,Login,Home,Index,File,Userconfig",
        'DB_LIKE_FIELDS'            =>'title|content|name|remark',
		'SAVE_PATH'=>'Data/Files/',
        'SHOW_PAGE_TRACE'=>1, //显示调试信息
    );
    return $array;
?>