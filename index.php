<?php

/**
 *

define('APP_PATH','app');   //定义网站脚本目录
define('BIND_CONTROLLER','indexController'); //绑定默认controller
require_once './gi/gi.php';
 */

$uri=$_SERVER['REQUEST_URI'];
$uri=parse_url($uri);

var_dump($uri);

var_dump($uri['query']);

$pattern='/^c=\S+/i';
$query=$uri['query'];
var_dump(preg_match($pattern,$query,$match));

var_dump($match);

class Route{

    public static function getRequestUri($type='',$uri=''){
        $request_uri=$_SERVER['REQUEST_URI'];
        $uri=$uri==''?$request_uri:$uri;
        $uri=parse_url($uri);
        switch ($type){

            case 'path':

                if(array_key_exists('path',$uri)){
                    return $uri['path'];
                }

                break;

            case 'query':
                if(array_key_exists('query',$uri)){
                    return $uri['query'];
                }

                break;


            default:
                return $request_uri;
                break;
        }
    }


}

$pattern='/c=(\S+[&?])/i';
$pattern='/c=(\S+)/i';
$query=Route::getRequestUri();
var_dump(preg_match($pattern,$query,$match));

var_dump($match);
