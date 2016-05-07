<?php

/**
 * @project :   GiWebFrame
 * @version :   v1.1 alpha
 * @author  :   godcheese
 * @website :   http://www.gioov.com
 * @github  :   https://github.com/godcheese
 * @link    :   https://github.com/godcheese/GiWebFrame.git
 * @copyright    :   godcheese copyright all reserved.
 * @date    :   2016.02
 *
 */


namespace GiWebFrame\Core;

/**
 * Class Init
 * @package GiWebFrame\Core
 */

class App{

    /**
     * @note 用于URL REWRITE 路径判断的首页链接
     * @return mixed
     */
    public static function homeUrlArray(){
        $homeUrl=c('system')['home_url_array'];
        return $homeUrl;
    }


    public static function run(){


        // 判断是否为入口处
        if(\GiWebFrame\Core\App::isHome()){

            // 为网站唯一入口，用于加载整个网站
            \GiWebFrame\Core\App::handLoad(c('system')['home_controller']['c'],c('system')['home_controller']['m']);
        }else{
            self::autoLoad(self::homeUrlArray());
        }


    }
    


    /**
     * @note 获取当前请求的uri 如：/index.php?c=index&m=page/
     * @return mixed
     */
    public static function getRequestUri(){
        if(isset($_SERVER['REQUEST_URI'])){
            $uri=$_SERVER['REQUEST_URI'];
        }else{
            $uri=getenv('REQUEST_URI');
        }

        return $uri;
    }

    /**
     * @note 获取request提交请求数据参数
     * @param $submitType
     * @param $submitKey
     * @return null
     */
    public static function getSubmitRequestQueryValue($submitType,$submitKey){

        $submitType=strtolower($submitType);
        switch($submitType){
            case 'get':
                if(array_key_exists($submitKey,$_GET)) {
                    $getQueryValue = isset($_GET[$submitKey]) ? $_GET[$submitKey] : null;
                    if ($getQueryValue != null) {
                        return $getQueryValue;
                    }
                }
                break;

            case 'post':
                $getQueryValue=isset($_POST[$submitKey])?$_POST[$submitKey]:null;
                if($getQueryValue != null){
                    return $getQueryValue;
                }
                break;

            case 'request':
                $getQueryValue=isset($_REQUEST[$submitKey])?$_REQUEST[$submitKey]:null;
                if($getQueryValue != null){
                    return $getQueryValue;
                }
                break;

            default:
                $getQueryValue=isset($_REQUEST[$submitKey])?$_REQUEST[$submitKey]:null;
                if($getQueryValue != null){
                    return $getQueryValue;
                }
                break;
        }
    }

    /**
     * @note 获取当前访问的controller key是c
     * @return null
     */
    public static function getController(){
        $c=self::getSubmitRequestQueryValue('REQUEST','c');
        if($c != null){
            return $c; //获取controller值
        }
    }

    /**
     * @note 获取当前访问的method key是m
     * @return null
     */
    public static function getMethod(){
        $m=self::getSubmitRequestQueryValue('REQUEST','m');
        if($m != null){
            return $m; //获取method值
        }
    }

    /**
     * @note 载入指定的controller file并初始化类
     * @param $controllerName
     * @return mixed
     */
    public static function loadHandleClass($controllerName)
    {

        if (class_exists($controllerName)) {
            $newClass = new $controllerName;
            return $newClass;
        }
    }

    /**
     * @note 自动载入所请求的controller和method
     */
    public static function autoLoad($homeUrlArray=array()){
        if(c('system')['url_rewrite_on']) {
            if(self::urlRewrite_isPath($homeUrlArray)) {
                $c = self::urlRewrite_getRequest($homeUrlArray,'1');
                $m = self::urlRewrite_getRequest($homeUrlArray,'2');
            }else{
                $c = self::getController();
                $m = self::getMethod();
            }

        }else{
            $c = self::getController();
            $m = self::getMethod();
        }

        if($c!=null){
            $newClass=self::loadHandleClass($c);
            if($newClass!=null) {

                /**
                if ($m != null) {
                if (method_exists($newClass, $m)) {
                call_user_func(array($newClass, $m));
                } else {
                self::loadDefaultError('method');
                }
                } else {

                if(isset($_REQUEST['m'])){
                self::loadError('method');
                }else{
                call_user_func(array($newClass,'__default'));
                }
                }
                 *
                 * */

                if($m!=null){
                    if (method_exists($newClass, $m)) {
                        call_user_func(array($newClass, $m));
                    }else{
                        self::loadError('method');
                    }

                }else{

                    if(isset($_REQUEST['m'])){
                        self::loadError('method');
                    }else{
                        call_user_func(array($newClass,'__default'));
                    }
                }
            }else{

                self::loadError('controller');
            }

        }


    }

    /**
     * @note 手动载入所请求的controller和method 适用于网站入口文件index.php用
     * @param $controller
     * @param $method
     * @param array $paramArray
     */
    public static function handLoad($controller,$method,$paramArray=array()){
        $c=$controller;
        $m=$method;

        if($c!=null){
            $newClass=self::loadHandleClass($c);
            if($newClass!=null) {
                if ($m != null) {
                    if (method_exists($newClass, $m)) {
                        if($paramArray!=null){
                            foreach ($paramArray as $paramKey => $paramValue)
                                if(isset($_REQUEST[$paramKey])){
                                    $_REQUEST[$paramKey]=$paramValue;
                                }
                        }
                        call_user_func(array($newClass,$m));
                    }else{
                        self::loadError('method');
                    }
                } else {
                    if(isset($_REQUEST['m'])){
                        self::loadError('method');
                    }else{
                        call_user_func(array($newClass,'__default'));
                    }
                }
            }else{
                self::loadError('controller');
            }
        }else{
            self::loadError('controller');
        }

    }

    /**
     * @note 判断是否在首页
     * @param array $homeUrl
     * @return bool
     */
    public static function isHome($homeUrlArray=array())
    {
        
        if(c('system')['url_rewrite_on']) {
            if (self::urlRewrite_isPath($homeUrlArray)) {

                if(self::urlRewrite_getRequest($homeUrlArray,'1')==null){
                    return true;
                }

            } else {

                if (isset($_REQUEST['c'])) {
                    if ( $_REQUEST['c'] == null) {
                        return true;
                    }
                } elseif (!isset($_REQUEST['c'])) {
                    return true;
                }

            }

        }else{

            if (isset($_REQUEST['c'])) {
                return false;

            } elseif (!isset($_REQUEST['c'])) {
                return true;


            }

        }
    }

    /**
     * @note 载入报错处理句柄，先载入开发者事先自定义的报错信息，如若不存在，自动载入下面系统默认的报错处理函数，只要在controller下创建自定义error的controller即可
     * @param $errorType
     */
    public static function loadError($errorType){

        switch ($errorType) {

            case 'controller':

                $newClass=self::loadHandleClass(c('giinit')['error_controller']);

                if($newClass!=null){
                    if(method_exists($newClass,'__errorController')){
                        call_user_func(array($newClass,'__errorController'));
                    }else{
                        self::loadDefaultError('controller');//载入框架自带的method默认报错函数
                    }
                }else {
                    self::loadDefaultError('controller');//载入框架自带的method默认报错函数
                }
                break;

            case 'method':
                $newClass=self::loadHandleClass(c('giinit')['error_controller']);

                if($newClass!=null){
                    if(method_exists($newClass,'__errorMethod')){
                        call_user_func(array($newClass,'__errorMethod'));
                    }else{
                        self::loadDefaultError('method');//载入框架自带的method默认报错函数
                    }
                }else {
                    self::loadDefaultError('method');//载入框架自带的method默认报错函数
                }
                break;
        }
    }

    /**
     * @note 系统默认报错函数（可供开发者自定义）处理函数，只要在controller下创建自定义error的controller即可
     * @param $errorType
     */
    public static function loadDefaultError($errorType){
        $errorType=strtolower($errorType);
        switch($errorType){

            case 'controller':
                $content=c('gierror')[1000];
                print_r($content);
                break;

            case 'method':
                $content=c('gierror')[1100];
                print_r($content);
                break;

        }
    }

    /**
     * @param $rewriteUrlViewParamPosition url rewrite下读取view,c/m/view/参数值(c=1，m=2，view=3)
     * @param $requestType 'request'、'post'、'get'
     * @param $urlViewKey  /index.php?c=index&m=page&vid=12'，里面的vid 就是$urlViewKey
     * @return mixed|null
     */
    public static function getRequest($rewriteUrlViewParamPosition,$requestType,$urlViewKey){
        $view1 = self::urlRewrite_getRequest(self::homeUrlArray(), $rewriteUrlViewParamPosition);//url rewrite下读取view,c/m/view/参数值(c=1，m=2，view=3)
        $view2 = self::getSubmitRequestQueryValue($requestType, $urlViewKey);//非url rewrite下获取view参数值

        //URL REWRITE 判断
        if (c('system')['url_rewrite_on']) {
            $view = $view1 != null ? $view1 : $view2;
        } else {
            $view = $view2 != null ? $view2 : $view2;
        }

        return $view;
    }

    /**
     * @note 获取uri的路径uri用于伪静态
     * @return mixed
     */
    public static function getRequestUriPath(){
        $uri=$_SERVER['REQUEST_URI'];
        $pUri=parse_url($uri);
        $uriPath=$pUri['path'];
        return $uriPath;
    }

    /**
     * @note 获取url path数组 /index.php/index/page/home array(0=>'index.php',1=>'index',2=>'page')
     * @return array
     */
    public static function getRequestUriPathArray(){
        $uriPath=self::getRequestUriPath();
        $uriPath=ltrim($uriPath,'/');
        $uriPath=rtrim($uriPath,'/');
        $uriPathArray=explode('/',$uriPath);
        return $uriPathArray;
    }

    /**
     * @note 伪静态 url是否为路径请求函数，以此触发伪静态功能,输入homeUrl数组进行遍历判断
     * @param array $homeUrlArray
     * @return bool
     */
    public static function urlRewrite_isPath($homeUrlArray=array())
    {

        $homeUrlArray=$homeUrlArray==''?$homeUrlArray:self::homeUrlArray();
        if(strlen(self::getRequestUriPath())!=1){

            if (in_array(rtrim(self::getRequestUriPath(), '/'), $homeUrlArray)) {
                return false;
            }else{
                return true;
            }
        }else{
            if (in_array(self::getRequestUriPath(), $homeUrlArray)) {
                return false;
            }else{
                return true;
            }

        }
    }

    /**
     * @note 伪静态 在uri路径数组内获取请求的路径id值
     * @param $getKeyId
     * @return mixed
     */
    public static function urlRewrite_getRequest($homeUrlArray=array(),$getKeyId){
        if(self::urlRewrite_isPath($homeUrlArray)){
            $uriArray = self::getRequestUriPathArray();
            if (array_key_exists($getKeyId, $uriArray)) {
                $keyValue = $uriArray[$getKeyId];
                return $keyValue;
            }
        }
    }

}
