<?php

/**
 * Class RegexTool
 * @description 一个简单的php正则表达式应用类
 * @author 天堂芝士
 * @link http://www.gioov.com
 *
 */

class RegexTool
{


    //自带的匹配语法，便于生产调用
    private static $validate = array(
        'require'=>'/.+/',  //判断是否已输入
        'mobile'=>'/^1(3|4|5|7|8|)\d{9}$/', //手机号判断
        'url'=>'/^(https?://)?(\w+\.)+[a-zA-Z]+$/', //url判断全部可能 加 http:// https://  或 未加http:// https://
        'url_'=>'/^(\w+\.)+[a-zA-Z]+$/',    //只判断未加 http:// https://
        'url_http'=>'/^(https?://)+(\w+\.)+[a-zA-Z]+$/',    //只判断加http:// https://
        'qq'=>'/^[1-9]{5,11}$/',    //qq号码判断
        'email'=>'/^\w+(\.\w+)?@\w+.+[a-zA-Z]$/',   //email判断
        'number'=>'/^\d+$/',    //是否为数字判断

        // 语言判断
        'chinese'=>'/^[\u2E80-\u9FFF]+$/',  //汉字判断，其中\u2E80-\u9FFF为汉字unicode内码编码区间
        'english'=>'/^[a-zA-Z]$/',  //英文字母判断

    );


    /**
     * @param string $pattern  正则表达式语法
     * @param string $subject  欲被匹配的字符串
     * @param string $fixMode   修正模式
     * @param string $result    返回的匹配结果
     * @return bool
     */
    public static function regex($pattern,$subject,$fixMode='',&$result=''){

        $pattern=array_key_exists($pattern,self::$validate)?self::$validate[$pattern]:$pattern;
        $return=preg_match_all($pattern.$fixMode, $subject, $result);
        return $return==1?true:false;
    }

}


//  调用方法
print_r(RegexTool::regex('qq','1134444423','',$res));
print_r($res);

//  返回结果：
//  boolean true
//  Array ( [0] => Array ( [0] => 1134444423 ) )
