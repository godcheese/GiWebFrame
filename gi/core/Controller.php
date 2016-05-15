<?php

namespace gi\core;

/**
 * @description Class Controller
 * @package gi\core
 */

class Controller{

    private $Smarty='smarty/Smarty.class.php';

    private $left_delimiter='';
    private $right_delimiter='';
    private $template_dir='';
    private $template_compile_dir='';

    // 初始化Smarty
    function __construct()
    {
        require_once $this->Smarty;
        $this->Smarty=new \Smarty;

        $this->left_delimiter=c('template_left_delimiter');     // 模版左定界符
        $this->right_delimiter=c('template_right_delimiter');   // 模版右定界符

        $this->template_dir=c('template');   // 模版右定界符

        $current_app_template=c(APP_PATH.'_template');
        if($current_app_template!=''){
            $this->template_dir=$this->template_dir.DS.$current_app_template;
        }

        $this->template_compile_dir=c('template_compile');   // 模版右定界符

        $this->Smarty->left_delimiter=$this->left_delimiter;
        $this->Smarty->right_delimiter=$this->right_delimiter;

        $this->Smarty->setTemplateDir(c('template_root_path').$this->template_dir.DS);
        $this->Smarty->setCompileDir(CONTENT_PATH.$this->template_compile_dir.DS);

    }

    // 赋值变量
    public function assign($template_var='',$value=null,$no_cache=false){
        return $this->Smarty->assign($template_var,$value,$no_cache);
    }

    // 显示模版
    public function display($template=null,$cache_id=null,$compile_id=null,$parent=null){
        if($template==''){
            $template=$this->get_current_subclass().TPL_EXT;
        }
        $this->Smarty->display($template,$cache_id,$compile_id,$parent);
    }

    // 注册模版插件
    public function registerPlugin($type='',$name='',callable $callback,$cache_able,$cache_attr=null){
        return $this->Smarty->registerPlugin($type,$name,$callback,$cache_able,$cache_attr);
    }

    // 获取当前子类名
    private function get_current_subclass(){
        $class=get_class($this);
        $controller=c('default_controller_layer');
        if(strpos($class,$controller)){
            return str_replace($controller,'',$class);
        }
    }

    // 释放内存
    function __destruct()
    {
        $this->Smarty=null;
        // TODO: Implement __destruct() method.
    }

}