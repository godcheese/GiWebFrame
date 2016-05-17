<?php

class indexController extends \gi\core\Controller{

    //初始
    function __main(){
        $this->home();
    }

    function home(){

        $this->assign('page_title','首页');
        $this->assign('page_keywords','关键词1,关键词2,关键词3');
        $this->assign('page_description','描述这个页面的内容~');
    }

   function test(){

       $this->assign('page_title','测试页面');
       $this->assign('page_keywords','测试关键词1,测试关键词2,测试关键词3');
       $this->assign('page_description','测试描述这个页面的内容~');
    }

    function error(){
        echo '错误';
    }
    
}



