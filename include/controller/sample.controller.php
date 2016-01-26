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

class sample{

    //配置页面，c=initPage&m=$initArray 参数
    public function initPage($initArray='error')
    {
        switch ($initArray){
            case 'home':
                echo 'home';
                break;

            case 'error':
                echo 'error 404';
                break;
            default:
                echo 'default';
                break;
        }

    }


}

?>
