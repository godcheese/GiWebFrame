<?php

namespace gi\core;

class Init{

    // run
    public static function run(){
        if(Route::isSelf()){ // 判断是否为index.php或admin.php本身
            self::handLoad(BIND_CONTROLLER);    //如若为本身就访问本身绑定的index。
        }else{
            self::autoLoad();
        }
    }


    // 自动加载类
    public static function loadClass($class_name){


        if($class_name!=''){
            if(strpos($class_name,'\\')){
                $class_name=basename($class_name);
            }

            $core_file=CORE_PATH.$class_name.EXT;

            if(is_file($core_file)) include_once $core_file;

            $lib_file=LIB_PATH.$class_name.EXT;

            if(is_file($lib_file)) include_once $lib_file;

            if(defined('APP_PATH')){
                $app_controller_file=APP_PATH.DS.strtolower(c('default_controller_layer')).DS.$class_name.EXT;
                $app_model_file=APP_PATH.DS.strtolower(c('default_model_layer')).DS.$class_name.EXT;
                if(is_file($app_controller_file)) include_once $app_controller_file;
                if(is_file($app_model_file)) include_once $app_model_file;
            }
        }

    }


    // 初始化controller类
    public static function initController($controller_name = ''){

        // 判断controller是否为空
        if($controller_name == '') {

            //为空时自动调用默认controller
            Route::getRequest(c('default_controller_request'), $controller_name);
        }

        // 实例化controller之前先判断是否为空
        if ($controller_name != '') {

            if(class_exists($controller_name))
                return new $controller_name;

        }
    }

    // 加载错误的提示
    public static function errorMessage($error_type){

        $error_type=strtolower($error_type);
        switch ($error_type){
            case 'controller':
                $obj=self::initController(c('default_error_msg_controller')); //读取配置中设定的值
                if(is_object($obj)){
                    $error_method=c('default_error_msg_method');
                    if(method_exists($obj,$error_method['controller_method']))
                        call_user_func(array($obj, $error_method['controller_method']));
                }else{
                    $error_method=c('default_error_msg_method');
                    echo $error_method['controller_msg'];

                }
                break;

            case 'method':
                $obj=self::initController(c('default_error_msg_controller')); //读取配置中设定的值
                if(is_object($obj)){
                    $error_method=c('default_error_msg_method');
                    if(method_exists($obj,$error_method['method_method']))
                        call_user_func(array($obj, $error_method['method_method']));
                }else{
                    $error_method=c('default_error_msg_method');
                    echo $error_method['method_msg'];

                }
                break;


        }

    }

    /**
     * @description 加载controller类
     * @param $c
     * @return mixed
     */
    public static function loadController($c){

        if($c!=''){
            $obj = self::initController($c.c('default_controller_layer'));
            if (is_object($obj)) {
                return $obj;
            }else{
                self::errorMessage('controller');
            }
        }

    }

    public static function loadMethod($obj,$m){
        if($obj!=''){
            if($m!=''){
                if(method_exists($obj,$m)) {
                    call_user_func(array($obj, $m));
                }else{
                    self::errorMessage('method');
                }
            }else{
                self::loadDefaultMethod($obj);
            }
        }
    }

    public static function autoLoad(){

        switch (c('url_model')){
            case URL_COMMON:
                Route::getRequest(c('default_controller_request'),$c);
                $controller=self::loadController($c);
                if(is_object($controller)){
                    Route::getRequest(c('default_method_request'),$m);
                    self::loadMethod($controller,$m);
                }

                break;


            case URL_PATHINFO:
                $pathinfo = Route::getControllerMethodPathinfo();

                if(Route::getRequest(c('default_controller_request'),$c)){

                }else{
                    $c=$pathinfo['c'];
                }

                $controller=self::loadController($c);
                if(is_object($controller)){

                    if(Route::getRequest(c('default_method_request'),$m)){

                    }else{
                        $m=$pathinfo['m'];
                    }

                    self::loadMethod($controller,$m);
                }

                break;

            case URL_REWRITE:
                $pathinfo = Route::getControllerMethodPathinfo();
                if(Route::getRequest(c('default_controller_request'),$c)){

                }else{
                    $c=$pathinfo['c'];
                }

                $controller=self::loadController($c);
                if(is_object($controller)){

                    if(Route::getRequest(c('default_method_request'),$m)){

                    }else{
                        $m=$pathinfo['m'];
                    }

                    self::loadMethod($controller,$m);
                }
                break;


        }




    }

    public static function handLoad($controller_name,$method_name=''){

        $c = $controller_name;
        if($c==''){
            return;
        }

        $obj =  self::initController($c);
        if (is_object($obj)) {

            $m = Route::getRequest(c('default_method_request_key'));
            if ($m != '') {

                if(method_exists($obj,$m)) {
                    call_user_func(array($obj, $m));
                }else{
                    self::errorMessage('method');
                }
            }else{
                self::loadDefaultMethod($obj);
            }

        }else{
            self::errorMessage('controller');
        }

    }

    public static function loadDefaultMethod($obj)
    {
        if (method_exists($obj, c('default_method'))) {
            call_user_func(array($obj, c('default_method')));
        }else{
            self::errorMessage('method');
        }
    }


}

