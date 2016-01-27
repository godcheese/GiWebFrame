<?php
/**
 * @project :   GiWebFrame
 * @version :   v1.0 alpha
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

//引用路由控制器控制类
require_once 'include/routerController.class.php';

//引用html视图代码输出类
require_once 'include/htmlView.class.php';

//抽象路由控制类
$rC=new routerController(true);

//判断是否在首页
if($rC->isHome()){
    $resContent=$rC->callController('page','home'); //指定 首页home页面
    echo $resContent;
}else{
    echo $rC->callController($rC->getController(),$rC->getMethod());
}

?>
