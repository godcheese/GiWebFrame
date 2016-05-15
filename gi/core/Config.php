<?php

namespace gi\core;


class Config
{
    /**
     * @description 加载配置文件
     * @param string $file_name
     * @return mixed
     */
    public static function loadConfig($file_name=''){
        if (is_file($file_name)) {
            $config = require $file_name;
            return $config;
        }
    }

    /**
     * @description 加载配置文件后判断是否存在key_name
     * @param string $key_name
     * @param string $config 返回引用变量
     * @param string $file_name
     * @return bool
     */
    public static function hasKeyName($key_name='',&$config='',$file_name=''){

        $config=self::loadConfig($file_name);
        if(is_array($config)){
            if (array_key_exists($key_name, $config)) return true;
        }else{
            $config=array();
        }
    }
    
    /**
     * @description APP的单独配置信息
     * @param string $key_name
     * @param string $result 返回引用变量
     * @param string $file_name
     * @return bool
     */
    public static function appConfig($key_name='',&$result='',$file_name=''){
        $file_name=APP_PATH.DS.'config'.EXT;
        if(self::hasKeyName($key_name,$config,$file_name)){
            $result=$config[$key_name];
            return true;
        } else {
            $result=$config;    // key_name 为空或者不存在时候返回所有配置
            return false;
        }
    }

    /**
     * @description 网站根文件夹下的全局配置信息
     * @param string $key_name
     * @param string $result
     * @param string $file_name
     * @return bool
     */
    public static function rootConfig($key_name='',&$result='',$file_name=''){
        $file_name=ROOT_PATH.'config'.EXT;
        if(self::hasKeyName($key_name,$config,$file_name)){
            $result=$config[$key_name];
            return true;
        } else {
            $result=$config;    // key_name 为空或者不存在时候返回所有配置
            return false;
        }
    }

    /**
     * @description 框架定义默认配置信息
     * @param string $key_name
     * @param string $result
     * @param string $file_name
     * @return bool
     */
    public static function giConfig($key_name='',&$result='',$file_name=''){
        $file_name=GI_PATH.'convention'.EXT;
        if(self::hasKeyName($key_name,$config,$file_name)){
            $result=$config[$key_name];
            return true;
        } else {
            $result=$config;    // key_name 为空或者不存在时候返回所有配置
            return false;
        }

    }

    /**
     * @description 获取配置项的值
     * @param string $key_name
     * @param string $file_name
     * @return bool
     */
    public static function get($key_name='',$file_name='')
    {
        /**
         * var_dump(self::appConfig($key_name, $app_config_result));
         * var_dump(self::rootConfig($key_name, $root_config_result));
         * var_dump(self::giConfig($key_name, $gi_config_result));
         *
         * var_dump($app_config_result);
         * var_dump($root_config_result);
         * var_dump($gi_config_result);
         * */


        if ($file_name != '') {

            if(self::hasKeyName($key_name,$config,$file_name)){
                return $config[$key_name];
            }else{
                return false;
            }


        } else {

            if (self::appConfig($key_name, $app_config_result)) {
                return $app_config_result;
            } else {
                if (self::rootConfig($key_name, $root_config_result)) {
                    return $root_config_result;
                } else {
                    if (self::giConfig($key_name, $gi_config_result)) {
                        return $gi_config_result;
                    } else {
                        if ($key_name != '') {
                            return false;
                        } else {
                            return array_merge($gi_config_result, $root_config_result, $app_config_result);
                        }
                    }
                }
            }

        }
    }


}