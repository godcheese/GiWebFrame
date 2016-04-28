<?php


class error extends \GiWebFrame\Core\Controller implements \GiWebFrame\Inf\Controller,\GiWebFrame\Inf\ErrorController{

    function __construct()
    {
        $this->layout('error404');
        $this->assign('page_title','404错误');
    }

    /**
     * @note 默认访问方法
     */
    public function __default()
    {
        $this->assign('error_tip','预料之外的错误！');

    }

    //首页方法
    public function __errorController(){
        $this->assign('error_tip','错误控制器');
    }

    //首页方法
    public function __errorMethod(){
        $this->assign('error_tip','错误的方法');
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->display();
    }

}