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

/**
 * Class sample
 * 实例类演示：一般一个功能集合为一个类
 *
 */

//引用视图类
require_once ROOT_PATH.'/include/viewHtml.class.php';

class sample{

    //配置页面，c=initPage&m=$initArray 参数
    public function initPage($initArray='error')
    {
        switch ($initArray){
            case 'home':
                viewHtml::html_start('zh_CN');
                viewHtml::head_start();
                viewHtml::tag_format_output(0,array('tag'=>'meta',array('author'=>'godcheese','keywords'=>'gioov,gioov.com')));
                viewHtml::head_end();
                viewHtml::body_start();
                echo 'home';
                viewHtml::body_end();
                viewHtml::html_end();
                break;

            case 'error':
                viewHtml::html_start('zh_CN');
                viewHtml::head_start();
                viewHtml::tag_format_output(0,array('tag'=>'meta',array('author'=>'godcheese','keywords'=>'gioov,gioov.com')));
                viewHtml::head_end();
                viewHtml::body_start();
                echo 'error';
                viewHtml::body_end();
                viewHtml::html_end();
                break;
            default:
                echo 'default';
                break;
        }

    }


}

?>
