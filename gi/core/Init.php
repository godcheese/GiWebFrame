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

    public static function initController($controller){


        // 实例化controller之前先判断是否为空
        if ($controller != '') {
            $pos=strpos($controller,c('default_controller_layer'));
            $str1=strlen($controller);
            $str2=strlen(c('default_controller_layer'));

            if($pos!=$str1-$str2){
                $controller.=c('default_controller_layer');
            }



            if(class_exists($controller)) {
                $obj = new $controller;
                return $obj;
            }
        }
    }

    public static function handLoad($controller=''){
        $c = $controller;
        if($c==''){
            return;
        }

        $obj =  self::loadController($c);
        if (is_object($obj)) {

            $m = Route::getRequest(c('default_method_request_key'));
            if ($m != '') {

                if(method_exists($obj,$m)) {
                    call_user_func(array($obj, $m));
                }else{
                    self::loadError('method');
                }
            }else{
                self::loadDefaultMethod($obj);
            }

        }else{
            self::loadError('controller');
        }
    }

    public static function autoLoad(){
        $url_model=c('url_model');

        switch ($url_model){

            case URL_COMMON:
                Route::getRequest(c('default_controller_request'),$controller);
                $controller=self::loadController($controller);
                if(is_object($controller)){
                    Route::getRequest(c('default_method_request'),$method);
                    self::loadMethod($controller,$method);
                }else{
                    self::loadError('controller');
                }

                break;

            case URL_PATHINFO:

                $pathinfo = Route::getControllerMethodPathinfo();

                
                if(Route::getRequest(c('default_controller_request'),$controller)){

                }else{
                    $controller=$pathinfo['c'];
                }



                $controller=self::loadController($controller);
                if(is_object($controller)){

                    if(Route::getRequest(c('default_method_request'),$method)){

                    }else{
                        $method=$pathinfo['m'];
                    }

                    self::loadMethod($controller,$method);
                }else{
                    self::loadError('controller');

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

                    if(Route::getRequest(c('default_method_request'),$method)){

                    }else{
                        $method=$pathinfo['m'];
                    }

                    self::loadMethod($controller,$method);
                }else{
                    self::loadError('controller');

                }
                break;


        }

    }


    public static function loadMethod($object,$method){
        if(is_object($object)){
            if($method!=''){
                if(method_exists($object,$method)) {
                    call_user_func(array($object, $method));

                }else{
                    self::loadError('method');
                }
            }else{
                self::loadDefaultMethod($object);
            }
        }
    }

    public static function loadError($type){
        $type=strtolower($type);

        // 实例化报错controller class
        $error_obj=self::initController(c('default_error_controller'));

        $error_obj_method=c('default_error_method');

        $error_obj_controller_method=$error_obj_method['controller_method'];
        $error_obj_method_method=$error_obj_method['method_method'];

        // 以上两个方法在error object内找不到的话就使用一下两个默认报错信息
        $error_obj_controller_msg=$error_obj_method['controller_msg'];
        $error_obj_method_msg=$error_obj_method['method_msg'];




        switch ($type){

            case 'controller':

                if(is_object($error_obj)){
                    if(method_exists($error_obj,$error_obj_controller_method)){

                    }else{
                        echo $error_obj_controller_msg;
                    }

                }else{
                    echo $error_obj_controller_msg;
                }

                break;
            case 'method':

                if(is_object($error_obj)){
                    if(method_exists($error_obj,$error_obj_method_method)){

                    }else{
                        echo $error_obj_method_msg;
                    }

                }else{
                    echo $error_obj_method_msg;
                }

                break;

            default:
                exit();
                break;


        }
    }


    // 自动加载类 供gi.php内的 spl_autoload_register 调用
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

    /**
     * @description 加载controller类
     * @param $c
     * @return mixed
     */
    public static function loadController($controller=''){


        // 判断controller是否为空
        if($controller == '') {

            //为空时自动调用默认controller
            Route::getRequest(c('default_controller_request'), $controller);

        }

        return self::initController($controller);

    }


    // 载入默认方法__main
    public static function loadDefaultMethod($obj)
    {

        if (method_exists($obj, c('default_method'))) {
            call_user_func(array($obj, c('default_method')));
        }else{
            self::errorMessage('method');
        }
    }


}

