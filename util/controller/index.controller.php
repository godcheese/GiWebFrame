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

class index{
    function __construct(){}


    public function page()
    {

        $view1 = GiInit::urlRewrite_getRequest(GiInit::homeUrlArray(), 3);//url rewrite下读取view参数值(c=1，m=2，view=3)
        $view2= GiInit::getSubmitRequestQueryValue('request', 'view');//非url rewrite下获取view参数值

        //URL REWRITE 判断
        if(URL_REWRITE) {
            $view = $view1 != null?$view1:$view2;
        }else{
            $view = $view2 != null?$view2:$view2;
        }
        if ($view != null) {

            switch ($view) {

                case 'home':
                    $file = ROOT_PATH . '/template/index.html';
                    $content = GiView::loadViewFile2Parse($file);
                    $content=GiView::setParseTag($content, 'page', array('title' => '首页','webtitle'=>'浙师微课'));

                    $ee=9;
                    $id='';
                    for($i=1;$i<=$ee;$i++){
                        $id=GiView::delimiterLoopOutput($id,$i,'||');
                    }

                    $content=GiView::setParseTag_loop($content, 'page', array('id'=>$id),'||');
                    GiView::show($content);

                    break;

                case 'about':
                    $content = 'about';
                    GiView::show($content);
                    break;

                default:
                    $content = '错误页面';
                    GiView::show($content);
                    break;
            }

        }else{
            $content = '在这里你可以浏览所有页面';
            GiView::show($content);
        }
    }


    function __destruct(){}
}
?>
