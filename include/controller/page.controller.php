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
 * Class page
 * 页面类
 *
 */

////引用html视图代码输出类
require_once ROOT_PATH . '/include/htmlView.class.php';

class page{

    /**
     * 必须
     * 当只访问控制器时，默认调用此方法。例如：http://www.gioov.com/?c=page 或 http://www.gioov.com/?c=page&m=
     *
     */
    public function init(){
        htmlView::print_l(htmlView::html_start(array('lang'=>'zh_CN', 'xmlns'=>'http://www.w3.org/1999/xhtml')));
        htmlView::print_l(htmlView::head_start());
        htmlView::print_l(htmlView::tag_format_output(0,array('tag'=>'meta','attr'=>array('charset'=>'utf-8'))));

        //标题 title
        $page_title='默认页面';
        htmlView::print_l(htmlView::tag_format_output(1,array('tag'=>'title','attr'=>'','content'=>$page_title)));
        htmlView::print_l(htmlView::head_end());

        //输出 body
        htmlView::print_l(htmlView::body_start(array('class'=>'body')));
        $content="默认页面 init：测试输出！";
        htmlView::print_l(htmlView::tag_format_output(1,array('tag'=>'p','attr'=>array('class'=>'container'),'content'=>$content)));
        htmlView::print_l(htmlView::body_end());

        htmlView::html_end();
    }


    /**
     * 必须
     * 当只访问控制器时，默认调用此方法。例如：http://www.gioov.com/?c=page&m=home
     */
    public function home()
    {
        htmlView::print_l(htmlView::html_start(array('lang' => 'zh_CN', 'xmlns' => 'http://www.w3.org/1999/xhtml')));
        htmlView::print_l(htmlView::head_start());
        htmlView::print_l(htmlView::tag_format_output(0, array('tag' => 'meta', 'attr' => array('charset' => 'utf-8'))));

        //标题 title
        $page_title = '首页';
        htmlView::print_l(htmlView::tag_format_output(1, array('tag' => 'title', 'attr' => '', 'content' => $page_title)));
        htmlView::print_l(htmlView::head_end());

        //输出 body
        htmlView::print_l(htmlView::body_start(array('class' => 'body')));
        $content = "首页 home：测试输出！";
        htmlView::print_l(htmlView::tag_format_output(1, array('tag' => 'p', 'attr' => array('class' => 'container'), 'content' => $content)));
        htmlView::print_l(htmlView::body_end());

        htmlView::html_end();
    }

}

?>
