<?php

//框架自带的配置项

$GLOBALS['giconfig']['system']=array(
    'app'=>array(
        'app_name'=>'GiWebFrame',
        'app_version'=>'1.1.0',
        'app_homepage'=>'http://www.gioov.com',
        'app_projectpage'=>'http://github.com/godcheese/giwebframe.git'),
    
    'debug'=>'off',         //调试状态，用于开发者开发调试用（原生显示，数据库非）
    'url_rewrite'=>true,    //网站伪静态虚拟路径
    'timezone'=>'rpc',      //时区
    
    'home_controller'=>array('c'=>'index','m'=>'home'),   //指定首页入口的controller 和method
    
    'home_url_array'=>array('/','/index.php'),  //网站单一入口文件
    
);


$GLOBALS['giconfig']['giview']=array(
    'tpl_extension'=>'tpl.html',
    'left_delimiter'=>'{',
    'right_delimiter'=>'}',
    'tag_var'=>'var',
    'tag_include'=>'include',
    'tag_loop'=>'loop',
);


$GLOBALS['giconfig']['giinit']=array(
    'error_controller'=>'error',
);

$GLOBALS['giconfig']['gierror']=array(
    1000=>'Code:1000 Message:Error controller!',
    1100=>'Code:1100 Message:Error method!',
    2000=>'Code:2000 Message:Error file！',
    2100=>'Code:2100 Message:Error theme file！',
);



