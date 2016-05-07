<?php


//  版本信息
define('GI_VERSION', '1.2.0');

// URL 模式定义
const URL_COMMON        =   0;  //普通模式 用参数
const URL_PATHINFO      =   1;  //PATHINFO模式
const URL_REWRITE       =   2;  //REWRITE模式
const URL_COMPAT        =   3;  // 兼容模式


defined('DS') or define('DS', DIRECTORY_SEPARATOR); //// 定义系统路径分割符
defined('GI_PATH') or define('GI_PATH', dirname(__FILE__) . DS); //框架根目录
defined('ROOT_PATH') or define('ROOT_PATH', dirname(GI_PATH) . DS); //根目录
defined('CORE_PATH') or define('CORE_PATH', GI_PATH . 'core' . DS); //内核库目录
defined('LIB_PATH') or define('LIB_PATH', GI_PATH . 'library' . DS); //lib目录
defined('RUN_PATH') or define('RUN_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS); //当前脚本运行目录
defined('CURRENT_RUN') or define('CURRENT_RUN', $_SERVER['SCRIPT_NAME']); //当前脚本运行目录
defined('EXT') or define('EXT', '.php'); //php扩展
defined('ENV_PREFIX') or define('ENV_PREFIX', 'ENV_'); // 环境变量的配置前缀
defined('APP_PATH') or define('APP_PATH', ROOT_PATH.'app'); // app文件夹

// 环境常量
define(ENV_PREFIX.'IS_CGI', strpos(PHP_SAPI, 'cgi') === 0 ? 1 : 0);
define(ENV_PREFIX.'IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define(ENV_PREFIX.'IS_MAC', strstr(PHP_OS, 'Darwin') ? 1 : 0);
define(ENV_PREFIX.'IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);
define(ENV_PREFIX.'IS_AJAX', (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false);
define(ENV_PREFIX.'NOW_TIME', $_SERVER['REQUEST_TIME']);
define(ENV_PREFIX.'REQUEST_METHOD', ENV_PREFIX.'IS_CGI' ? 'GET' : $_SERVER['REQUEST_METHOD']);
define(ENV_PREFIX.'IS_GET', ENV_PREFIX.'REQUEST_METHOD' == 'GET' ? true : false);
define(ENV_PREFIX.'IS_POST', ENV_PREFIX.'REQUEST_METHOD' == 'POST' ? true : false);
define(ENV_PREFIX.'IS_PUT', ENV_PREFIX.'REQUEST_METHOD' == 'PUT' ? true : false);
define(ENV_PREFIX.'IS_DELETE', ENV_PREFIX.'REQUEST_METHOD' == 'DELETE' ? true : false);