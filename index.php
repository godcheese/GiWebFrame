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


/**
 * Php file index
 *
 */

header('Content-Type:text/html;charset=utf-8');
defined('ROOT_PATH') or define('ROOT_PATH',dirname(__FILE__));

require_once ROOT_PATH.'/util/init.class.php';

use GiWebFrame\Util\Init as GiInit;

//
$home=GiInit::isHome(GiInit::homeUrlArray());


if($home){
    GiInit::handLoadControllerAndMethod('index','page',array('view'=>'home'));

}else{
    GiInit::autoLoadControllerAndMethod(GiInit::homeUrlArray());
}

?>

