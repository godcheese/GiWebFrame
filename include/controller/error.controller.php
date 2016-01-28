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

/**
 * Class error
 * 自定义错误类
 *
 */

//引用html视图代码输出类
require_once ROOT_PATH . '/include/view.class.php';

class error{

    public function init()
    {
        view::print_l(view::html_start(array('lang'=>'zh_CN', 'xmlns'=>'http://www.w3.org/1999/xhtml')));
        view::print_l(view::head_start());
        view::print_l(view::tag_format_output(0,array('tag'=>'meta','attr'=>array('charset'=>'utf-8'))));

        //标题 title
        $page_title='404 错误';
        view::print_l(view::tag_format_output(1,array('tag'=>'title','attr'=>'','content'=>$page_title)));
        view::print_l(view::head_end());

        //body 输出
        view::print_l(view::body_start(array('class'=>'body')));
        $content="init 404 错误 error：测试输出！";
        view::print_l(view::tag_format_output(1,array('tag'=>'p','attr'=>array('class'=>'container'),'content'=>$content)));
        view::print_l(view::body_end());

        view::html_end();

    }

    /**
     * 404 错误
     */
    public function error404()
    {
        view::print_l(view::html_start(array('lang'=>'zh_CN', 'xmlns'=>'http://www.w3.org/1999/xhtml')));
        view::print_l(view::head_start());
        view::print_l(view::tag_format_output(0,array('tag'=>'meta','attr'=>array('charset'=>'utf-8'))));

        //标题 title
        $page_title='404 错误';
        view::print_l(view::tag_format_output(1,array('tag'=>'title','attr'=>'','content'=>$page_title)));
        view::print_l(view::head_end());

        //body 输出
        view::print_l(view::body_start(array('class'=>'body')));
        $content="error 404 错误 error：测试输出！";
        view::print_l(view::tag_format_output(1,array('tag'=>'p','attr'=>array('class'=>'container'),'content'=>$content)));
        view::print_l(view::body_end());

        view::html_end();

    }


}

?>
