<?php

namespace gi\core;

class Route
{

    public static $c='';
    public static $m='';

    /**
     * @description 当前是否访问的是自己本身
     * @return bool
     */
    public static function isSelf()
    {
        $uri = Route::requestUri();
        $p_uri=parse_url($uri);

        if ($uri == '/' || (trim(CURRENT_RUN,'/')==trim($p_uri['path'],'/') && self::getUriQuery() == '') ) {
            return true;

        }
    }

    /**
     * @description
     * @return bool
     */
    public static function hasSelf()
    {
        $path = self::getUriPath();
        if (count($path) >= 1) {
            if (strpos($path[0], EXT)) {
                return true;
            }
        }

    }

    /**
     * @description 获取当前访问的uri,不完整
     * @return mixed
     */
    public static function requestUri()
    {
        return $_SERVER[c('url_request_uri')];
    }

    /**
     * @description get所请求的uri的路径
     * @param string $request_uri
     * @return mixed
     */
    public static function getUriPath($request_uri = '')
    {
        $delimiter = c('url_pathinfo_delimiter');
        $request_uri = $request_uri == '' ? self::requestUri() : $request_uri;
        $request_uri = trim($request_uri, $delimiter);
        $request_uri = parse_url($request_uri);

        $request_uri = isset($request_uri['path']) ? $request_uri['path'] : null;
        $request_uri = trim($request_uri, $delimiter);
        if (strpos($request_uri, $delimiter) != -1) {
            return explode($delimiter, $request_uri);
        }
    }

    /**
     * @description get所请求uri的参数
     * @param string $request_uri
     * @return mixed|null|string
     */
    public static function getUriQuery($request_uri = '')
    {
        $request_uri = $request_uri == '' ? self::requestUri() : $request_uri;
        $request_uri = parse_url($request_uri);
        $request_uri = isset($request_uri['query']) ? $request_uri['query'] : null;
        return $request_uri;
    }

    /**
     * @description get请求数组的 request
     * @param $request_key
     * @param string $request_type
     * @return null
     */
    public static function getRequest($request_key,&$request_result='',$request_type = '')
    {

        if ($request_key != '') {
            $request_key = strtolower($request_key);
            $request_type = strtolower($request_type);
            switch ($request_type) {
                case 'get':
                    $request_value = isset($_GET[$request_key]) ? $_GET[$request_key] : null;
                    $request_result=$request_value;
                    return isset($_GET[$request_key]);
                    break;

                case 'post':
                    $request_value = isset($_POST[$request_key]) ? $_POST[$request_key] : null;
                    $request_result=$request_value;
                    return isset($_POST[$request_key]);
                    break;
                default:
                    $request_value = isset($_REQUEST[$request_key]) ? $_REQUEST[$request_key] : null;
                    $request_result=$request_value;
                    return isset($_REQUEST[$request_key]);
                    break;
            }
        }
    }

    /**
     * @description 获取域名
     * @return mixed
     */
    public static function getDomain()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @description set请求数组的 request
     * @param $request_key
     * @param string $request_value
     * @param string $request_type
     * @return string
     */
    public static function setRequest($request_key, $request_value = '', $request_type = '')
    {
        if ($request_key != '') {
            $request_key = strtolower($request_key);
            $request_type = strtolower($request_type);
            switch ($request_type) {
                case 'get':
                    return $_GET[$request_key] = $request_value;
                    break;
                case 'post':
                    return $_POST[$request_key] = $request_value;
                    break;
                default:
                    return $_REQUEST[$request_key] = $request_value;
                    break;
            }
        }
    }

    /**
     * @description 获取controller method
     * @return array
     */
    public static function getControllerMethodPathinfo()
    {
        $path = self::getUriPath();
        
        if ($path != '') {
            if (c('url_model') != URL_REWRITE) {
                $path = array_slice($path, 1);
            } else {
                if (self::hasSelf()) {
                    $path = array_slice($path, 1);
                }
            }
        }

        if (!array_key_exists(0, $path)) {
            $path[0] = '';
        }
        if (!array_key_exists(1, $path)) {
            $path[1] = '';
        }

        return array('c' => $path[0], 'm' => $path[1]);
    }

    /**
     * @description request function 调用它
     * @param $query_key
     * @param int $query_position
     * @return null
     */
    public static function request($query_key,&$query_result, $query_position = 0)
    {
        switch (c('url_model')) {
            case URL_COMMON:
                return Route::getRequest($query_key,$query_result);
                break;

            case URL_PATHINFO:

                $uri=self::requestUri();
                var_dump($uri);
                $path = self::getUriPath();
                $path_array=$path;

                var_dump($path);
                if(count($path)>=3) {
                    $path = array_slice($path, 3);

                    if($path!=null || isset($path[$query_position])){
                        $query_result=$path[$query_position];
                        return true;
                    }else{
                        if(count($path_array)==3) {
                            return self::getRequest($query_key,$query_result);
                        }
                    }
                }


                break;

            case URL_REWRITE:
                $path = self::getUriPath();
                $path_array=$path;
                if(!self::hasSelf() && $path[0]!='') {

                    if (count($path) >= 2) {
                        $path = array_slice($path, 2);
                    }else{

                    }

                    if ($path != null || isset($path[$query_position])) {
                        $query_result=$path[$query_position];
                        return true;
                    } else {
                        if (count($path_array) == 2) {
                            return self::getRequest($query_key,$query_result);
                        }
                    }

                }else{

                    if(count($path)>=3) {
                        $path = array_slice($path, 3);

                        if($path!=null || isset($path[$query_position])){
                            $query_result=$path[$query_position];
                            return true;
                        }else{
                            if(count($path_array)==3) {
                                return self::getRequest($query_key,$query_result);
                            }
                        }
                    }

                }

                break;
        }


    }
}
