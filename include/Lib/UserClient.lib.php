<?php

/**
 * @note Class UserClient 输出用户设备客户端信息的类 调用方式其实通过数组的
 * $UserClient['Device'] 取得设备类型，Desktop桌面 or Mobile移动
 * $UserClient['System']
 * $UserClient['Browser']
 * $UserClient['BrowserVer']
 * $UserClient['ClientIP'] 获获取用户
 * 
 * @date 2016-04-09 16:00
 * @author:godcheese
 * @website:http://www.gioov.com
 * @link:http://www.gioov.com/index.php/godcheese
 *
 */

class UserClient
{

    private $DesktopClientSystemFlagArray=array(
        'Windows NT 6.1; WOW64'=>'Windows 7 x64',//供Chrome/Firefox识别
        'Windows NT 6.1; Win64; x64'=>'Windows 7 x64',//供微软IE浏览器识别
        'Mac OS X'=>'Mac'//供微软IE浏览器识别

    );
    private $MobileClientSystemFlagArray=array(
        'Android'=>'Android',
        'iPhone'=>'iPhone',
        'iPad'=>'iPad',
        'Windows Phone'=>'Windows Phone',
        'KFAPWI'=>'Kindle Fire HDX',//亚马逊 Kindle
        'PlayBook'=>'PlayBook',//黑莓 PlayBook
        'BB'=>'BlackBerry',//黑莓
        'MeeGo'=>'MeeGo',//诺基亚MeeGo系统

    );
    private $BrowserClientFlagArray=array(
        'Version'=>'Safari',// Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2
        'Chrome'=>'Chrome',// Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36
        'MSIE'=>'MSIE',// Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)
        'Firefox'=>'Firefox',// Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0
        'OPR'=>'Opera',// OPR因为在【Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36 OPR/36.0.2130.46】这段信息中显示靠后，所以最好放在最后识别
        'Silk'=>'Silk',//亚马逊Kindle Fire浏览器
        'NokiaBrowser'=>'NokiaBrowser',//诺基亚浏览器

    );

    /**
     * @note 输出设备信息
     * @param string $outFormat
     * @return mixed|string
     */
    public function outputClientInfo(){

        $resOutput=array('Device'=>'','System'=>'','Browser'=>'','BrowserVer'=>'','ClientIP'=>'');

        $flagArr=$this->listFlag();//获取flag源数组
        foreach($flagArr as $arr){

            foreach($arr as $flag => $tip){

                $useragent=$this->getUserAgent();


                if(stripos($useragent,$flag)!=false){
                    switch($arr){
                        case $this->DesktopClientSystemFlagArray:

                            $resOutput['System']=$tip;
                            $resOutput['Device']='Desktop';
                            continue;
                        case $this->MobileClientSystemFlagArray:
                            $resOutput['System']=$tip;
                            $resOutput['Device']='Mobile';
                            continue;

                        case $this->BrowserClientFlagArray:
                            $resOutput['Browser']=$tip;

                            switch ($flag){
                                case 'MSIE':
                                    $pattern='/MSIE\s(\d+)../i';
                                    preg_match($pattern,$useragent,$preg);
                                    $resOutput['BrowserVer']=$preg[1];
                                    continue;

                                default:
                                    $pattern='/'.$flag.'\/(\d+)../i';
                                    preg_match($pattern,$useragent,$preg);
                                    $resOutput['BrowserVer']=$preg[1];
                                    continue;

                            }

                            continue;
                        default:
                            $resOutput='';
                            continue;
                    }


                }



            }

        }


        $clientIP=$this->getClientIP();
        $resOutput['ClientIP']=$clientIP;//用户客户端IP

        return $resOutput;

    }

    /**
     * @note 定义新的移动设备系统标识数组
     * @param array $newFlagArray
     * @return array
     */
    public function DesktopClientSystemFlag($newFlagArray=array()){
        if($newFlagArray==''){
            $arr=$this->DesktopClientSystemFlagArray;

        }else{
            $arr=$newFlagArray;
        }
        return $arr;
    }

    /**
     * @note 定义新的桌面设备系统标识数组
     * @param array $newFlagArray
     * @return array
     */
    public function MobileClientSystemFlag($newFlagArray=array()){
        if($newFlagArray==''){
            $arr=$this->MobileClientSystemFlagArray;

        }else{
            $arr=$newFlagArray;
        }
        return $arr;
    }

    /**
     * @note 定义新的浏览器标识数组
     * @param array $newFlagArray
     * @return array
     */
    public function BrowserClientFlagArray($newFlagArray=array()){
        if($newFlagArray=='') {
            $arr =$this->BrowserClientFlagArray;
        }else{
            $arr=$newFlagArray;
        }
        return $arr;
    }

    /**
     * @note 在源数组下添加新的标识信息组
     * @param array $flagArray 标识数组array('Client'=>'isMyClient')
     * @param array $hackArray 指向数组
     * @return array
     */
    private function addFlag($flagArray=array(),$hackArray=array()){
        if(is_array($flagArray) && is_array($hackArray)) {
            foreach ($flagArray as $key => $value) {

                if($key!='' && $value!='' && !is_numeric($key)){
                    $hackArray[$key] = $value;
                }
            }
            return $hackArray;
        }
    }

    /**
     * @note 在源数组下添加新的桌面设备系统标识信息组
     * @param array $flagArray 标识数组array('Client'=>'isMyClient')
     */
    public function addDesktopClientSystemFlag($flagArray=array()){
        $this->DesktopClientSystemFlagArray=$this->addFlag($flagArray,$this->DesktopClientSystemFlagArray);
    }

    /**
     * @note 在源数组下添加新的移动设备系统标识信息组
     * @param array $flagArray
     */
    public function addMobileClientSystemFlag($flagArray=array()){
        $this->MobileClientSystemFlagArray=$this->addFlag($flagArray,$this->MobileClientSystemFlagArray);
    }

    /**
     * @note 在源数组下添加新的浏览器客户端标识信息组
     * @param array $flagArray
     */
    public function addBrowserClientFlag($flagArray=array()){
        $this->BrowserClientFlagArray($this->addFlag($flagArray,$this->BrowserClientFlagArray()));
    }

    /**
     * @note 列出所有Flag
     * @return array
     */
    public function listFlag(){
        $arr=array('DesktopSystem'=>$this->DesktopClientSystemFlagArray,'MobileSystem'=>$this->MobileClientSystemFlagArray,'BrowserFlag'=>$this->BrowserClientFlagArray);
        return $arr;
    }

    /**
     * @note 获取用户Agent信息
     * @return string
     */
    public function getUserAgent(){
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_USER_AGENT'])){
                $agent=$_SERVER['HTTP_USER_AGENT'];
            }else{
                $agent=getenv('HTTP_USER_AGENT');
            }
        }else{
            $agent=getenv('HTTP_USER_AGENT');
        }
        return $agent;
    }

    /**
     * @note 获取用户客户端（浏览器）真实ip地址
     * @return string
     */
    private function getClientIP()
    {
        $ip='';
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } else {
                    if (isset($_SERVER['REMOTE_ADDR'])) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }
                }
            }
        }else{

            if (getenv('HTTP_X_FORWARDED_FOR')){
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                if (getenv('HTTP_CLIENT_IP')) {
                    $ip = getenv('HTTP_CLIENT_IP');
                } else {
                    if (getenv('REMOTE_ADDR')) {
                        $ip = getenv('REMOTE_ADDR');
                    }
                }
            }

        }

        if(strpos($ip,',')>=7){
            $ip=explode(',',$ip);
           $ip=reset($ip);
        }

        return $ip;
    }

    function __destruct(){}
}
?>