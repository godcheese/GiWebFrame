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
 * Class error
 * 自定义错误类
 *
 */

//引用html视图代码输出类
require_once ROOT_PATH . '/include/htmlView.class.php';

class error{

    /**
     * 404 错误
     */
    public function error404()
    {
        htmlView::print_l(htmlView::html_start(array('lang'=>'zh_CN', 'xmlns'=>'http://www.w3.org/1999/xhtml')));
        htmlView::print_l(htmlView::head_start());
        htmlView::print_l(htmlView::tag_format_output(0,array('tag'=>'meta','attr'=>array('charset'=>'utf-8'))));

        //标题 title
        $page_title='404 错误';
        htmlView::print_l(htmlView::tag_format_output(1,array('tag'=>'title','attr'=>'','content'=>$page_title)));
        htmlView::print_l(htmlView::head_end());

        //body 输出
        htmlView::print_l(htmlView::body_start(array('class'=>'body')));
        $content="404 错误 error：测试输出！";
        htmlView::print_l(htmlView::tag_format_output(1,array('tag'=>'p','attr'=>array('class'=>'container'),'content'=>$content)));
        htmlView::print_l(htmlView::body_end());

        htmlView::html_end();

    }


}

?>
