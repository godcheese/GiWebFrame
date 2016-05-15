<?php

class indexController extends \gi\core\Controller{

    function __main(){
        $this->home();
        m('indexModel')->index();
    }

    public function home(){

        echo '__main';
        $this->display();
    }

   public function test(){
       $this->display('test.tpl.html');
    }

    public function error(){
        echo '错误';
    }
    
}



