<?php

//引入开发者自定义的配置
require_once AROOT.DS.'config.inc.php';

//载入框架核心脚本
require_once AROOT.DS.'include'.DS.'Core'.DS.'App.inc.php';           // 核心配置文件
require_once AROOT.DS.'include'.DS.'Core'.DS.'App.class.php';       // 核心脚本库
require_once AROOT.DS.'include'.DS.'Core'.DS.'Controller.class.php';       // 核心视图库
require_once AROOT.DS.'include'.DS.'Core'.DS.'Inf'.DS.'Controller.Inf.php';  // controller接口
require_once AROOT.DS.'include'.DS.'Core'.DS.'Inf'.DS.'ErrorController.Inf.php';  // 错误controller接口

require_once AROOT.DS.'include'.DS.'functions.php';  //公用函数库

//debug开关
if(function_exists('c')){
    $system_config=c('system');
    //debug调试PHP
    if(array_key_exists('debug',$system_config)) {
        if(strtolower($system_config['debug']=='off')) error_reporting(0);      //0表示false 不报告所有错误
        if(strtolower($system_config['debug']=='off')) error_reporting(30719);  //30719==E_ALL 表示报告所有错误
    }
}



define('THEME',AROOT.DS.'content'.DS.'theme'.DS.c('system')['theme'].DS);



