<?php


/**
 * @description c方法 获取系统或开发者自定义配置项
 * @param string $name
 * @return array
 */
function c($key_name='',$file_name='')
{
    return \gi\core\Config::get($key_name,$file_name);
}



function r($query_key, &$query_result ,$query_position = 0){
    if($query_key!=''){
        return \gi\core\Router::request($query_key,$query_result,$query_position);
    }

}