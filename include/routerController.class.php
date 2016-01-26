<?php
/**
 * @project :   GiWebFrame
 * @version :   v1.0 alpha
 * @author  :   godcheese
 * @website :   http://www.gioov.com
 * @github  :   https://github.com/godcheese
 * @link    :   https://github.com/godcheese/GiWebFrame.git
 * @copyriht    :   godcheese copyright all reserved.
 * @date    :   2016.01
 *
 */

/**
 * Class routerController
 * 路由控制器控制类
 * 
 */

defined('ROOT_PATH')?:define('ROOT_PATH',dirname(dirname(__FILE__)));

class routerController
{
    protected $strictUrl = true;//严格的url模式
    protected $homeUrlArray = array('/', '/index.php');//数组型,在解析时将解析出数组元素的字符串长度 eg:array('/','/index.php')
    /*
     * 重写数组
     * $class->IndexUrlArray=array('egurl1','egurl2');
     * or
     * 原有数组下添加元素
     * $class->IndexUrlArray[]='egurl1';
     * $class->IndexUrlArray[]='egurl2';
     */


    //初始化函数
    function __construct($strictUrl = true, $homeUrlArray = array('/', '/index.php'))
    {
        $this->strictUrl = $strictUrl;
        $this->homeUrlArray = $homeUrlArray;
    }

    //get ServerName eg:www.gioov.com
    public static function getServerName()
    {
        $tmp_serverName = $_SERVER['SERVER_NAME'];
        return $tmp_serverName;
    }

    //get RequestUrl eg:/,/index.php?a=aVal&d=dVal
    public static function getRequestUrl()
    {
        $tmp_requestUri = $_SERVER['REQUEST_URI'];
        return $tmp_requestUri;
    }

    //计算主页url数组的元素字符串长度，再+1（这个1是"?"的长度，因为url后面跟参数时候需要加上?所以用?的位置来判断url是否符合规范）
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

    //解析字符串 字符串长度，字符串所在位置
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
                $getC = trim($getC); //将C值去除左右空格
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
                $getC = trim($getC); //将C值去除左右空格
                return $getC;
            }

        }
    }

    //GET Controller 值
    public function getController()
    {
        //GET C http://www.gioov.com/?c=controller
        $tmp_requrl = $this->getRequestUrl();

        //判断是否为严格的url模式,非严格模式
        if ($this->strictUrl == false) {
            $getC = isset($_GET['c']) ? $_GET['c'] : null;
            $getC = trim($getC); //将C值去除左右空格
            return $getC;

        } else {
            return $this->getC();
        }
    }

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
            $getM = trim($getM); //将C值去除左右空格
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
            $getM = trim($getM); //将M值去除左右空格
            return $getM;
        }

    }

    //GET Method 值
    public function getMethod()
    {
        if ($this->strictUrl == false) {
            $getMethod = isset($_GET['m']) ? $_GET['m'] : null;
            $getMethod = trim($getMethod); //将Method值去除左右空格
            return $getMethod;

        } else {
            return $this->getM();
        }
    }

    // 判断当前是否为首页
    public function isHome()
    {
        if (in_array($this->getRequestUrl(), $this->homeUrlArray)) {
            return true;
        }
    }

    private function errorController(){
        echo '错误的控制器！';
    }
    private function errorMethod(){
        echo '错误的方法！';
    }

    private function errorCustom($eType,$class=null){
        switch ($eType){
            case 'controller':
                $controller='error404';
                $con_file = ROOT_PATH . '/include/controller/' . $controller . '.controller.php';
                if (file_exists($con_file)) {   //判断controller文件是否存在 绝对路径 root/controller/*.controller.php
                    //404类文件存在时
                    require_once $con_file;
                    $class = new $controller;
                    if(class_exists($class,false)){
                        //类存在时候
                        if(method_exists($controller,'error404')){
                            //方法存在时
                            $resContent=call_user_func(array($class,'error404'));
                            return $resContent;
                        }else{$this->errorMethod();}
                    }else{$this->errorController();}

                }else{$this->errorController();}
                break;
            case 'method':
                if(method_exists($class,'error')){
                    $resContent = call_user_func(array($class, 'error'));
                    return $resContent;
                }else{$this->errorMethod();}
                break;


        }

    }

    //将数组格式化成字符串输出 p1,p2,p3
    private function format_output_array_parameter($tmp_a=array())
    {

        $tmp_vv = '';
        foreach ($tmp_a as $tmp_k => $tmp_v) {
            $tmp_vv = $tmp_vv . ',' . $tmp_v;
        }
        $tmp_vv=ltrim($tmp_vv,',');
        return $tmp_vv;
    }

    //给出$controller,和$method(数组)，前面已经设定默认值
    public function callController($controller=null, $method=array())
    {
        if ($controller == null) {
            /**
             * $controller 为空时
             */
            return $this->errorCustom('controller');


        } else {
            /**
             * $controller 不为空时
             */
            $con_file = ROOT_PATH . '/include/controller/' . $controller . '.controller.php';
            var_dump($con_file);
            if (file_exists($con_file)) {
                //类文件存在时

                //引用类文件
                require_once $con_file;
                $class = new $controller;
                //类文件存在时
                if (class_exists($controller,false)) {
                    //$controller 类存在时
                    if ($method[0] != null) {
                        //$method 不为空时
                        if (method_exists($class, $method[0])) {
                            if (count($method) >= 2 && !in_array(null,$method)) {
                                //所访问的方法有参数时
                                $tmp_array = array_slice($method, 1);  //从第二个元素起读取（除去方法元素）
                                $resContent = call_user_func(array($class, $method[0]), $this->format_output_array_parameter($tmp_array));
                                return $resContent;
                            }else{
                                //所访问的方法无参数时
                                $resContent = call_user_func(array($class, $method[0]));
                                return $resContent;
                            }

                        } else {
                            //指定要访问的方法不存在时
                            $this->errorCustom('method',$class);}

                    } else {
                        //未指定要访问的方法时
                       return $this->errorCustom('method',$class);}

                } else {

                    //$controller 类不存在时
                    return $this->errorCustom('controller');}
            } else {
                //类文件不存在时
                var_dump('ddd');
                return $this->errorCustom('controller');
            }
        }

    }


    //销毁函数
    function __destruct()
    {
    }


}
?>
