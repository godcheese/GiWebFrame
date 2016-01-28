<?php
/**
 * @project :   GiWebFrame
 * @version :   v1.1 alpha
 * @author  :   godcheese
 * @website :   http://www.gioov.com
 * @github  :   https://github.com/godcheese
 * @link    :   https://github.com/godcheese/GiWebFrame.git
 * @copyright    :   godcheese copyright all reserved.
 * @date    :   2016.01
 *
 */

//*******************************Main***************************************//

//定义根目录
defined('ROOT_PATH')?:define('ROOT_PATH',dirname(__FILE__));

//引用控制器控制类
require_once ROOT_PATH.'/include/controller.class.php';

//引用html视图代码输出类
//require_once ROOT_PATH.'/include/view.class.php';

//抽象控制器控制类
$controller=new controller(false);

//判断是否在首页
if($controller->isHome()){
    $resContent=$controller->callController('page','home'); //指定 首页home页面
    echo $resContent;
}else{
    echo $controller->callController($controller->getController(),$controller->getMethod());
}

?>
