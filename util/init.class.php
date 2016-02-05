<?php
/**
 * @project :   GiWebFrame
 * @version :   v1.2 alpha
 * @author  :   godcheese
 * @website :   http://www.gioov.com
 * @github  :   https://github.com/godcheese
 * @link    :   https://github.com/godcheese/GiWebFrame.git
 * @copyright    :   godcheese copyright all reserved.
 * @date    :   2016.02
 *
 */


namespace GiWebFrame\Util;

/**
 * Class init
 * @package GiWebFrame\Util
 */

// 根目录路径，如c:\test\web\gfm
defined('ROOT_PATH') or define('ROOT_PATH',dirname(dirname(__FILE__)));

//伪静态开关
defined('URL_REWRITE') or define('URL_REWRITE',false);



class init{
    /**
     * @note
     */
    function __construct(){}

    /**
     * @note 用于URL REWRITE 路径判断的首页链接
     * @return array
     */
    public static function homeUrlArray(){

        $homeUrl=array('/','/index.php');
        return $homeUrl;

    }

    /**
     * @note 获取当前请求的uri 如：/index.php?c=index&m=page/
     * @return mixed
     */
    public static function getRequestUri(){
        $uri=$_SERVER['REQUEST_URI'];
        return $uri;
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
    public static function loadControllerFileHandleClass($controllerName){
        $file=ROOT_PATH.'/util/controller/'.$controllerName.'.controller.php';
        if(is_file($file)){
            require_once $file;
            if(class_exists($controllerName,false)){
                $newClass=new $controllerName;
                return $newClass;
            }
        }
    }

    /**
     * @note 自动载入所请求的controller和method
     */
    public static function autoLoadControllerAndMethod($homeUrlArray=array()){
        if(URL_REWRITE) {
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
            $newClass=self::loadControllerFileHandleClass($c);
            if($newClass!=null) {

                if ($m != null) {
                    if (method_exists($newClass, $m)) {
                        call_user_func(array($newClass, $m));
                    } else {
                        self::loadErrorHandle('method');
                    }
                } else {
                    self::loadErrorHandle('method');

                }
            }else{

                self::loadErrorHandle('controller');
            }

        }

    }

    /**
     * @note 手动载入所请求的controller和method
     * @param $controller
     * @param $method
     * @param array $paramArray
     */
    public static function handLoadControllerAndMethod($controller,$method,$paramArray=array()){
        $c=$controller;
        $m=$method;

        if($c!=null){
            $newClass=self::loadControllerFileHandleClass($c);
            if($newClass!=null) {
                if ($m != null) {
                    if (method_exists($newClass, $m)) {
                        if($paramArray!=null){
                            foreach ($paramArray as $paramKey => $paramValue){
                                $_REQUEST[$paramKey]=$paramValue;
                            }
                        }

                        call_user_func(array($newClass,$m));
                    } else {
                        self::loadErrorHandle('method');
                    }
                } else {
                    self::loadErrorHandle('method');
                }
            }else{

                self::loadErrorHandle('controller');
            }

        }

    }


    /**
     * @note 判断是否在首页
     * @param array $homeUrl
     * @return bool
     */
    public static function isHome($homeUrlArray=array())
    {


        if(URL_REWRITE) {
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
     * @note 载入报错，先载入用户事先自定义的报错controller，如若不存在自动载入下面系统默认的报错处理函数
     * @param $errorType
     */
    public static function loadErrorHandle($errorType){
        switch ($errorType) {

            case 'controller':
                $newClass = self::loadControllerFileHandleClass('error');
                if ($newClass != null) {
                    if (method_exists($newClass, 'errorController')) {
                        call_user_func(array($newClass, 'errorController'));
                    } else {
                        self::loadDefaultError('controller');//载入框架自带的controller默认报错函数
                    }
                }
                break;

            case 'method':
                $newClass = self::loadControllerFileHandleClass('error');
                if ($newClass != null) {
                    if (method_exists($newClass, 'errorMethod')) {
                        call_user_func(array($newClass, 'errorMethod'));
                    } else {
                        self::loadDefaultError('method');//载入框架自带的method默认报错函数
                    }
                }
                break;

            default:
                $newClass = self::loadControllerFileHandleClass('error');
                if ($newClass != null) {
                    if (method_exists($newClass, 'errorController')) {
                        call_user_func(array($newClass, 'errorController'));
                    } else {
                        self::loadDefaultError('controller');//载入框架自带的controller默认报错函数
                    }
                    break;
                }
        }
    }

    /**
     * @note 系统默认（可供用户自定义） 错误处理函数
     * @param $errorType
     *
     */
    public static function loadDefaultError($errorType){
        $errorType=strtolower($errorType);
        switch($errorType){

            case 'controller':
                $content='错误的控制器！';
                echo $content;
                break;

            case 'method':
                $content='错误的方法！';
                echo $content;
                break;

            default:
                $content='错误的控制器！';
                echo $content;
                break;

        }
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


    /**
     * @note
     */
    function __destruct(){}
}
?>
