<?php
class system
{

    public static function menu_main()
    {
        $menu = array(
            array(
                'title' => '<a href="/">首页</a>',
            ),
            array(
                'title' => '<a href="/index.php?c=index&m=catalog">分类</a>',
            ),
            array(
                'title' => '<a href="/index.php?c=index&m=test">测试页面</a>',
            ),
            array(
                'title' => '<a href="/index.php/index/about">关于我</a>',
            ),
        );
        return $menu;

    }
}