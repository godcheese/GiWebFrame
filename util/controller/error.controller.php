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


use GiWebFrame\Util\init as GiInit;
use GiWebFrame\Util\view as GiView;

// 根目录路径，如c:\test\web\gfm
defined('ROOT_PATH') or define('ROOT_PATH',dirname(dirname(__FILE__)));

require_once ROOT_PATH.'/util/init.class.php';
require_once ROOT_PATH.'/util/view.class.php';

class error{
    function __construct(){}

    public function errorController(){
        $content='错误的控制器！';
        GiView::show($content);
    }

    public function errorMethod(){
        $content='错误的方法！';
        GiView::show($content);
    }

    function __destruct(){}
}
?>
