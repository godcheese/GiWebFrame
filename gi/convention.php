<?php
return array(

    /* 调试设置 */
    'debug'=>true,


    /* Cookie设置 */
    //'cookie_expire'         =>  0,       // Cookie有效期
    //'cookie_domain'         =>  '',      // Cookie有效域名
    //'cookie_path'           =>  '/',     // Cookie路径
    //'cookie_prefix'         =>  '',      // Cookie前缀 避免冲突
    //'cookie_secure'         =>  false,   // Cookie安全传输
    //'cookie_httponly'       =>  '',      // Cookie httponly设置

    /* SESSION设置 */
    //'session_auto_start'    =>  true,    // 是否自动开启Session
    //'session_options'       =>  array(), // session 配置数组 支持type name id path expire domain 等参数
    //'session_type'          =>  '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    //'session_prefix'        =>  '', // session 前缀
    //'VAR_SESSION_ID'      =>  'session_id',     //sessionID的提交变量




    /* 默认设置 */
    'default_controller_layer'       =>  'Controller', // 默认的控制器层名称
    'default_model_layer'       =>  'Model', // 默认的模型层名称
    'default_method'        =>  '__main', // 默认操作名称

    // 错误controller时报错的方法 ， 错误method报错的方法
    'default_error_msg_controller'      =>  'errorController',    //错误信息默认处理controller类
    'default_error_msg_method'          =>  array(
        'controller_method'=>'errorController','controller_msg'=>'错误的控制器！', // 控制器（controller）的报错方法及报错信息
        'method_method'=>'errorMethod','method_msg'=>'错误的方法！'   //方法（method）的报错方法及报错信息
    ),

    // request（post|get）请求的参数
    'default_controller_request'    =>  'c',
    'default_method_request'    =>  'm',


    'default_timezone'      =>  'PRC',	// 默认时区
    //'default_ajax_return'   =>  'JSON',  // 默认AJAX 数据返回格式,可选JSON XML ...
    //'default_jsonp_handler' =>  'jsonpReturn', // 默认JSONP格式返回的处理方法
    'default_filter'        =>  'htmlspecialchars', // 默认参数过滤方法 用于I函数...

    /* 模版设置 */
    'template_root_path'=>CONTENT_PATH.'template'.DS,
    'template'          =>  'default',  // 默认主题路径
    'template_compile'      =>   'template_c', // 模版编译路径
    'template_ext'          =>  '.tpl.html',    // 模版后缀
    'template_left_delimiter'   =>  '{',  // 模版左定界符
    'template_right_delimiter'  =>  '}',  // 模版右定界符

    'template_deny_func_list'   =>  'echo,exit',    // 模板引擎禁用函数
    'template_deny_php'         =>  false, // 默认模板引擎是否禁用PHP原生代码


    /* 数据库设置 */
    'db_type'               =>  'mysql',     // 数据库类型
    'db_host'               =>  'localhost', // 服务器地址
    'db_name'               =>  'test',          // 数据库名
    'db_user'               =>  'root',      // 用户名
    'db_password'           =>  '',          // 密码
    'db_port'               =>  '3306',        // 端口
    'db_prefix'             =>  'gi_',    // 数据库表前缀
    'db_charset'            =>  'utf8',      // 数据库编码默认采用utf8
    'db_params'             =>  array(), // 数据库连接参数
    'db_debug'  			=>  true, // 数据库调试模式 开启后可以记录SQL日志



    /* URL设置 */
    //'url_case_insensitive'  =>  true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    'url_model'             =>  URL_PATHINFO,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'url_pathinfo_delimiter'     =>  '/',	// PATHINFO模式下，各参数之间的分割符号
    //'url_pathinfo_fetch'    =>  'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
    'url_request_uri'       =>  'REQUEST_URI', // 获取当前页面地址的系统变量 默认为REQUEST_URI
    //'url_html_suffix'       =>  'html',  // URL伪静态后缀设置
    //'url_deny_suffix'       =>  'ico|png|gif|jpg', // URL禁止访问的后缀设置
    //'url_params_bind_type'  =>  0, // URL变量绑定的类型 0 按变量名绑定 1 按变量顺序绑定
    //'url_params_filter'     =>  false, // URL变量绑定过滤
    //'url_params_filter_type'=>  '', // URL变量绑定过滤方法 如果为空 调用DEFAULT_FILTER
    // 'url_ROUTER_ON'         =>  false,   // 是否开启URL路由
    // 'url_ROUTE_RULES'       =>  array(), // 默认路由规则 针对模块
    //'url_MAP_RULES'         =>  array(), // URL映射定义规则


);