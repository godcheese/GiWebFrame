<?php
/**
 * @project :   GiWebFrame
 * @version :   v1.1 alpha
 * @author  :   godcheese
 * @website :   http://www.gioov.com
 * @github  :   https://github.com/godcheese
 * @link    :   https://github.com/godcheese/GiWebFrame.git
 * @copyright    :   godcheese copyright all reserved.
 * @date    :   2016.01
 *
 */

/**
 * Class controller
 * 控制器控制类
 *
 */

//定义根目录
defined('ROOT_PATH')?:define('ROOT_PATH',dirname(dirname(__FILE__)));

class controller
{
    //严格的url模式
    protected $strictUrl = true;


    /*
     * //数组型,在解析时将解析出数组元素的字符串长度 eg:array('/','/index.php')
     * 重写数组
     * $class->IndexUrlArray=array('egurl1','egurl2');
     * or
     * 原有数组下添加元素
     * $class->IndexUrlArray[]='egurl1';
     * $class->IndexUrlArray[]='egurl2';
     */
    protected $homeUrlArray = array('/', '/index.php');


    /**
     * 初始化类方法
     * @param bool $strictUrl   严格url模式
     * @param array $homeUrlArray   首页url数组
     */
    function __construct($strictUrl = true, $homeUrlArray = array('/', '/index.php'))
    {
        $this->strictUrl = $strictUrl;
        $this->homeUrlArray = $homeUrlArray;
    }

    /**
     * @return mixed
     * get ServerName eg:www.gioov.com
     */
    public static function getServerName()
    {
        $tmp_serverName = $_SERVER['SERVER_NAME'];
        return $tmp_serverName;
    }

    /**
     * @return mixed
     * get RequestUrl eg:/,/index.php?a=aVal&d=dVal
     */
    public static function getRequestUrl()
    {
        $tmp_requestUri = $_SERVER['REQUEST_URI'];
        return $tmp_requestUri;
    }

    /**
     * @param null $HomeUrlArray
     * @return array
     * 计算主页url数组的元素字符串长度，再+1（这个1是"?"的长度，因为url后面跟参数时候需要加上?所以用?的位置来判断url是否符合规范）
     */
    public function HomeUrlArrayStringLengthPlusOneArray($HomeUrlArray = null)
    {
        if ($HomeUrlArray == null) {

            //先取出数组内所有元素的长度
            $tmp_homeUrlArray = $this->homeUrlArray;
            $HomeUrlArrayStringLengthPlusOneArray = array();
            foreach ($tmp_homeUrlArray as $tmp_homeUrlArrayString) {
                $HomeUrlArrayStringLengthPlusOneArray[] = strlen($tmp_homeUrlArrayString) + 1;
            }
            return $HomeUrlArrayStringLengthPlusOneArray;

        } else {
            $tmp_homeUrlArray = $HomeUrlArray;
            foreach ($tmp_homeUrlArray as $tmp_homeUrlArrayString) {
                $HomeUrlArrayStringLengthPlusOneArray[] = strlen($tmp_homeUrlArrayString) + 1;
            }
            return $HomeUrlArrayStringLengthPlusOneArray;
        }
    }

    /**
     * @param $parseType
     * @param array $parseValue
     * @return bool|int|string
     * 解析字符串 字符串长度，字符串所在位置
     */
    public static function parseString($parseType, $parseValue = array('strict'=>null))
    {

        $tmp_parseType = array(
            'position',//字符串位置，返回数值
        );

        switch ($parseType) {
            case 'position':
                /**
                 * 字符串位置，返回数值
                 * string:规定要搜索的字符串。
                 * find:规定要查找的字符串。
                 * start:规定在何处开始搜索。
                 * strict:规定严格模式搜索，为空或者为0表示区别大小写
                 *
                 */
                if ($parseValue['strict'] == null || $parseValue['strict'] == 0) {
                    $tmp_strPos = strpos($parseValue['string'], $parseValue['find'], $parseValue['start']);
                } else {
                    $tmp_strPos = stripos($parseValue['string'], $parseValue['find'], $parseValue['start']);
                }
                return $tmp_strPos;
                break;
            default:
                return '0';
                break;
        }

    }

    /**
     * @return null|string
     * GET C
     */

    private function trimGET($str){
        $str=trim($str);
        return $str;
    }

    private function getC()
    {

        $parseValue = array(
            'string' => $this->getRequestUrl(),
            'find' => '?',
            'start' => 0,
            'strict'=>0
        );

        $tmp_pos = $this->parseString('position', $parseValue)+1;
        if (in_array($tmp_pos, $this->HomeUrlArrayStringLengthPlusOneArray())) {//判断在问号后进行的controller /?c=test&m=test

            $tmp_p_array = array();
            $tmp_a = $this->HomeUrlArrayStringLengthPlusOneArray();
            foreach ($tmp_a as $tmp_p) {
                $tmp_p_array[] = $tmp_p + 1;
            }

            //判断get c为小写时候
            $parseValue = array(
                'string' => $this->getRequestUrl(),
                'find' => 'c',
                'start' => 0,
                'strict' => 0
            );

            if (in_array($this->parseString('position', $parseValue) + 1, $tmp_p_array)) {
                $getC = isset($_GET['c']) ? $_GET['c'] : null;
                $getC = $this->trimGET($getC); //将C值去除左右空格
                return $getC;
            }

            //判断get c为大写时候
            $parseValue = array(
                'string' => $this->getRequestUrl(),
                'find' => 'C',
                'start' => 0,
                'strict' => 0
            );

            if (in_array($this->parseString('position', $parseValue) + 1, $tmp_p_array)) {
                $getC = isset($_GET['C']) ? $_GET['C'] : null;
                $getC = $this->trimGET($getC); //将C值去除左右空格
                return $getC;
            }

        }
    }

    /**
     * @return null|string
     * GET Controller 值
     */
    public function getController()
    {

        //判断是否为严格的url模式,非严格模式
        if ($this->strictUrl == false) {
            $getC = isset($_GET['c']) ? $_GET['c'] : null;
            $getC = $this->trimGET($getC); //将C值去除左右空格
            return $getC;

        } else {
            return $this->getC();
        }
    }

    /**
     * @return null|string
     * GET M
     */
    private function getM()
    {
        $tmp_m_array = array();
        $tmp_a = $this->HomeUrlArrayStringLengthPlusOneArray();
        foreach ($tmp_a as $tmp_m) {
            $tmp_m_array[] = $tmp_m + 2 + strlen($this->getController()) + 1;   //大小写m所在位置区间
        }

        //判断get m为小写时候
        $parseValue = array(
            'string' => $this->getRequestUrl(),
            'find' => 'm',
            'start' => 0,
            'strict' => 0
        );

        //读取m的位置数值是否在区间内
        if (in_array($this->parseString('position', $parseValue), $tmp_m_array)) {
            $getM = isset($_GET['m']) ? $_GET['m'] : null;
            $getM = $this->trimGET($getM); //将C值去除左右空格
            return $getM;
        }


        //判断get M为大写时候
        $parseValue = array(
            'string' => $this->getRequestUrl(),
            'find' => 'M',
            'start' => 0,
            'strict' => 0
        );

        //读取M的位置数值是否在区间内
        if (in_array($this->parseString('position', $parseValue), $tmp_m_array)) {
            $getM = isset($_GET['M']) ? $_GET['M'] : null;
            $getM =  $this->trimGET($getM); //将M值去除左右空格
            return $getM;
        }

    }

    /**
     * @return null|string
     * GET Method 值
     */
    public function getMethod()
    {
        if ($this->strictUrl == false) {
            $getMethod = isset($_GET['m']) ? $_GET['m'] : null;
            $getMethod =  $this->trimGET($getMethod); //将Method值去除左右空格
            return $getMethod;
        } else {
            return $this->getM();
        }
    }

    /**
     * @return bool 判断当前是否为首页
     */
    public function isHome()
    {

        /**
         * if (in_array($this->getRequestUrl(), $this->homeUrlArray)) {
         *      return true;
         *  }
         *
         */

        if($this->getC() ==null & $this->getM()==null){
            return true;
        }
    }

    /**
     * 系统输出的处理错误引用类及方法
     */
    private function errorController(){
        @include_once ROOT_PATH . '/include/system.controller.php';
        @$sys=new system();
        return @$sys->errorController();
    }
    private function errorMethod(){
        @include_once ROOT_PATH . '/include/system.controller.php';
        @$sys=new system();
        return @$sys->errorMethod();
    }


    /**
     * @param array $tmp_a 将数组格式化成字符串输出 p1,p2,p3
     * @return string
     */
    private function format_output_array_parameter($tmp_a=array())
    {

        $tmp_vv = '';
        foreach ($tmp_a as $tmp_k => $tmp_v) {
            $tmp_vv = $tmp_vv . ',' . $tmp_v;
        }
        $tmp_vv=ltrim($tmp_vv,',');
        return $tmp_vv;
    }

    /**
     * @return mixed|void 自定义错误
     */
    private function errorCustom()
    {
        $controller = 'error';
        $con_file = ROOT_PATH . '/include/controller/' . $controller . '.controller.php';
        if (file_exists($con_file)) {
            require_once $con_file;
            if(class_exists($controller,false)){
                $class = new $controller;
                if(method_exists($class,'error404')){
                    //存在error404方法
                    $resContent=call_user_func(array($class,'error404'));
                    return $resContent;
                }else{
                    //不能存在error404方法,调用系统自带的error
                    return $this->errorMethod();
                }

            }else{
                //用户自定义的error类不存在时，调用系统自带的error
                return $this->errorController();
            }
        }
    }


    /**
     * @param null $controller
     * @param null $method
     * 给出$controller,和$method(数组)，前面已经设定默认值
     */
    public function callController($controller=null, $method=null)
    {
        if ($controller == null) {
            //$controller 为空时
            $resContent=$this->errorCustom();
            echo $resContent;
        } else {
            //$controller 不为空时
            $con_file = ROOT_PATH . '/include/controller/' . $controller . '.controller.php';

            if(file_exists($con_file)){

                //controller文件存在时
                require_once $con_file;

                if(class_exists($controller,false)){
                    //$controller 类存在时
                    $class= new $controller;

                    if($method!=null){
                        //$method 不为空时

                        if(method_exists($class,$method)){
                            //$method 存在时
                            $resContent=call_user_func(array($class,$method));
                            echo $resContent;

                        }else{
                            //$method 不存在时

                            if(method_exists($class,'init')){
                                $resContent=call_user_func(array($class,'init'));
                                echo $resContent;
                            }else {
                                echo $this->errorCustom();

                            }
                        }

                    }else{
                        //$method 为空时

                        if(method_exists($class,'init')){
                            $resContent=call_user_func(array($class,'init'));
                            echo $resContent;
                        }else {
                            echo $this->errorCustom();

                        }

                    }

                }else{
                    //$controller 类不存在时
                    echo $this->errorCustom();
                }

            }else{
                //controller文件不存在时
                echo $this->errorCustom();
            }

        }
    }



    //销毁函数
    function __destruct(){}


}
?>
