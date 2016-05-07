<?php
class index{

    function __main(){
        echo '测试sa ';
        echo '<br/>';
       // echo '<hr/>';
       // $path =\gi\core\Router::getUriPath();

        echo 'r<hr/>';
        var_dump('r?:'.r('act',$res,0));
        var_dump('res:'.$res);


        var_dump(c('db_name'));
    }

   public function test(){

        echo '哈哈哈哈哈哈这是index的测试';
       echo '<hr/>';
       $path =\gi\core\Router::getUriPath();
       var_dump($path);
    }

    public function error(){
        echo '错误';
    }
    
}



