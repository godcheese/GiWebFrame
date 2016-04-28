<?php



//初始化加载函数库/Model/Controller
function file_autoload($class_name){

    //判断如果是有namespace那就通过此处
    if(strpos($class_name,'\\')){
        $class_name=ltrim(strrchr($class_name,'\\'),'\\');//去除namespace
    }


    $lib_file=AROOT.DS.'include'.DS.'Lib'.DS.$class_name.'.lib.php';
    $model_file=AROOT.DS.'include'.DS.'Model'.DS.$class_name.'.model.php';
    $controller_file=AROOT.DS.'include'.DS.'Controller'.DS.$class_name.'.controller.php';
   
    if(file_exists($lib_file)){
        require_once $lib_file;
    }
    if(file_exists($model_file)){
        require_once $model_file;
    }
    if(file_exists($controller_file)){
        require_once $controller_file;
    }

}
spl_autoload_register('file_autoload');



//  ==迅捷函数=======

/**
 * @note 读取配置文件配置信息，支持二维数组（通过sub_key）
 * @param string $key
 * @param string $sub_key
 * @return mixed
 */
function c($key='')
{
    $config=null;
    if(isset($GLOBALS['config']) && isset($GLOBALS['giconfig'])) {

        if(isset($GLOBALS['config'][$key]) || isset($GLOBALS['giconfig'][$key])) {
            if(isset($GLOBALS['config'][$key])) $config=$GLOBALS['config'][$key];
            if (isset($GLOBALS['giconfig'][$key]))
                foreach ($GLOBALS['giconfig'][$key] as $k => $v) {
                    $config[$k] = $v;
                }
        }
        return $config;
    }
    
}


/**
 * @note 调试输出
 * @param $str
 */
function dump($str){
    print_r($str);
};

/**
 * @note 读取$GLOBALS全局数组
 * @param $str
 * @return bool|mixed
 */
function g($str){ return isset( $GLOBALS[$str]) ? $GLOBALS[$str] : null;}

/**
 * @note 将字符串转换为整型
 * @param $str
 * @return int
 */
function i($str){ return intval($str); }

/**
 * @note 去除字符串首尾处的空白字符（或者其他字符）
 * @param $str
 * @return string
 */
function t($str){ return trim($str); }

/**
 * @note urlencode字符串
 * @param $str
 * @return string
 */
function u($str){ return urlencode($str); }

/**
 * @note 读取$_POST/$_GET/$_REQUEST 的数据
 * @param $str
 * @return mixed
 */
function v($str){
    if(isset($_POST[$str])){
        return $_POST[$str];
    }
    elseif(isset($_GET[$str])){
        return $_GET[$str];
    }
    elseif(isset($_REQUEST[$str])){
        return $_REQUEST[$str];
    }
}

/**
 * @note 从字符串中去除HTML和PHP标记
 * @param $str
 * @return string
 */
function z($str){ return strip_tags($str); }

/**
 * @note 字符串长度是否大于0
 * @param $str
 * @return int
 */
function sl($str){ return strlen($str>0); }

/**
 * @note 数值是否大于0
 * @param $int
 * @return bool
 */
function si($int){ return intval($int)>0; }

//数据库相关函数
function s($str){}







/**

//暂时无用
function is_dev(){
if(function_exists('C')){
$system_config=C('system');
//debug调试PHP
if(array_key_exists('dev',$system_config)) {
//0表示false 不报告所有错误
if(strtolower($system_config['dev']=='on')) set_error_handler('custom_error_reperting');
}
}
}

//暂时无用
function custom_error_reperting($err_no,$err_message,$err_file,$err_line){
switch($err_no){
case E_USER_ERROR:
$err_str=custom_error_reperting_style('',$err_no,$err_message,$err_file,$err_line);
break;
case E_USER_WARNING:
$err_str=custom_error_reperting_style('',$err_no,$err_message,$err_file,$err_line);
break;
default:
$err_str=custom_error_reperting_style('Fatal Error',$err_no,$err_message,$err_file,$err_line);
break;
}
echo $err_str;
}

//暂时无用
function custom_error_reperting_style($err_name='',$err_no,$err_message,$err_file,$err_line){
$err_str="<p><span style=\"background-color: #cc0000; color: #fce94f; font-size: x-large;\">( ! )</span>$err_name
<span style='background: red;color:white;font-weight: bold;'>-Error NO.:</span><span style='background: red;color:white;'>[$err_no]</span><br/>
<span style='background: red;color:white;font-weight: bold;'>-Error Message:</span><span style='background: red;color:white;'>[$err_message]</span><br/>
<span style='background: red;color:white;font-weight: bold;'>-Error File:</span><span style='background: red;color:white;'>[$err_file]</span><br/>
<span style='background: red;color:white;font-weight: bold;'>-Error Line:</span><span style='background: red;color:white;'>[$err_line]</span>
</p>";

$style='font-size:16px;';
$err_str='<div class="xdebug-error xe-fatal-error">'.$err_str.'</div>';
return $err_str;
}


 **/