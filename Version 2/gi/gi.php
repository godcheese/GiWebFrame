<?php

// 开始运行时间和内存使用
define('START_TIME', microtime(true));
define('START_MEMORY', memory_get_usage());



// 加载系统基础配置
require_once 'system.php';

// 加载内核初始函数
require_once CORE_PATH.'Init'.EXT;

// 动态注册autoload函数
spl_autoload_register('gi\core\Init::loadClass');

require_once 'functions'.EXT;

gi\core\init::run();



