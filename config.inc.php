<?php


//开发者可自定义的系统配置项
$GLOBALS['config']['system']=array(
    'status'=>'on',         //网站状态，开启或关闭
    'close_link'=>'/index.php?c=index&m=close',
    'theme'=>'default',//主题模板
    'url_rewrite'=>false,
);

//数据库配置项
$GLOBALS['config']['database']=array(
    'db_debug'=>true,         //数据库调试模式，调试则报告错误信息。

    'db_type'=>'mysql',        //数据库类型
    'db_host'=>'localhost',    //数据库主机
    'db_port'=>3306,         //数据库端口
    'db_charset'=>'utf8',       //数据库编码
    'db_name'=>'giwebframe',       //数据库名
    'db_user'=>'root',         //数据库用户
    'db_password'=>'',         //数据库用户密码
);