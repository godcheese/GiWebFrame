<?php
/**
 * @project :   GiWebFrame
 * @version :   v1.0 alpha
 * @author  :   godcheese
 * @website :   http://www.gioov.com
 * @github  :   https://github.com/godcheese
 * @link    :   https://github.com/godcheese/GiWebFrame.git
 * @copyriht    :   godcheese copyright all reserved.
 * @date    :   2016.01
 *
 */

//*******************************Main***************************************//

//定义更目录
defined('ROOT_PATH')?:define('ROOT_PATH',dirname(__FILE__));

//引用路由控制类
require_once 'include/routerController.class.php';

//抽象路由控制类,参数1 true为严格url模式
$rC=new routerController(true);

//调试输出当前访问页面链接
var_dump($rC->getRequestUrl());

//此处判断是否在首页home页
if($rC->isHome){

    //调用欲被访问的Controller以及方法，并输出
    $res=callController($rC->getController(),array('initPage','home'));
    echo $res;

}else{
    //如若不是首页home页时，自动调用欲被访问的Controller及指定方法
    $res->callController($rC->getController,array('initPage',$rC->getMethod()));
    echo $res;
}



?>
