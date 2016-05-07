<?php

namespace gi\core;


class Config
{

    public static function loadConfig($file_name=''){
        if (is_file($file_name)) {
            $config = require $file_name;
            return $config;
        }
    }


    public static function hasKeyName($key_name='',&$config='',$file_name=''){

        $config=self::loadConfig($file_name);
        if(is_array($config)){
            if (array_key_exists($key_name, $config)) return true;
        }else{
            $config=array();
        }
    }

    public static function appConfig($key_name='',&$result,$file_name=''){
        $file_name=APP_PATH.DS.'config'.EXT;
        if(self::hasKeyName($key_name,$config,$file_name)){
            $result=$config[$key_name];
            return true;
        } else {
            $result=$config;    // key_name 为空或者不存在时候返回所有配置
            return false;
        }
    }

    public static function rootConfig($key_name='',&$result,$file_name=''){
        $file_name=ROOT_PATH.'config'.EXT;
        if(self::hasKeyName($key_name,$config,$file_name)){
            $result=$config[$key_name];
            return true;
        } else {
            $result=$config;    // key_name 为空或者不存在时候返回所有配置
            return false;
        }
    }

    public static function giConfig($key_name='',&$result,$file_name=''){
        $file_name=GI_PATH.'convention'.EXT;
        if(self::hasKeyName($key_name,$config,$file_name)){
            $result=$config[$key_name];
            return true;
        } else {
            $result=$config;    // key_name 为空或者不存在时候返回所有配置
            return false;
        }

    }


    // 获取配置项的值
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