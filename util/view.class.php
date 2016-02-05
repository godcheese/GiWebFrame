<?php
/**
 * @project :   GiWebFrame
 * @version :   v1.1 alpha
 * @author  :   godcheese
 * @website :   http://www.gioov.com
 * @github  :   https://github.com/godcheese
 * @link    :   https://github.com/godcheese/GiWebFrame.git
 * @copyright    :   godcheese copyright all reserved.
 * @date    :   2016.02
 *
 */


namespace GiWebFrame\Util;

/**
 *
 * @note 框架自带 html视图代码输出类
 *
 * Class init
 * @package GiWebFrame\Util
 *
 */


class view
{

    /**
     * @note 标签末换行输出
     *
     * @param $str 换行输出
     *
     */
    public static function printl($str)
    {
        echo $str.'
';
    }


    /**
     * @note 标签输出格式 0=<tag attr="attrV"> 1=<tag attr="attrV"></tag>
     *
     * @param int $oT
     * @param array $in
     * @return string
     */
    private static function format_tag($oT = 0, $in = array('tag' => '', 'attr' => array(), 'content' => ''))
    {
        if (array_key_exists('attr', $in)&& !empty($in['attr'])) {//检测$in数组内是否存在 attr key

            //有attr key 遍历格式输出数组key及值
            $vv = '';
            foreach ($in['attr'] as $key => $value) {
                $vv = $vv . ' ' . $key . '="' . $value . '"';
            }
            switch ($oT) {
                case 0:
                    return '<' . $in['tag'] . $vv . '>';
                    break;
                case 1:
                    if (array_key_exists('content', $in)) {//检测$in数组内是否存在 content key
                        //有content key
                        return '<' . $in['tag'] . $vv . '>' . $in['content'] . '</' . $in['tag'] . '>';
                    } else {
                        //无content key
                        $in['content'] = '';
                        return '<' . $in['tag'] . $vv . '>' . $in['content'] . '</' . $in['tag'] . '>';
                    }
                    break;
                default:
                    return '<' . $in['tag'] . $vv . '>';
                    break;
            }
        }else{
            $vv='';

            //判断输出格式
            switch ($oT) {
                case 0:
                    return '<' . $in['tag'] . $vv . '>';
                    break;
                case 1:
                    if (array_key_exists('content', $in)) {//检测$in数组内是否存在 content key
                        //有content key
                        return '<' . $in['tag'] . $vv . '>' . $in['content'] . '</' . $in['tag'] . '>';
                    } else {
                        //无content key
                        $in['content'] = '';
                        return '<' . $in['tag'] . $vv . '>' . $in['content'] . '</' . $in['tag'] . '>';
                    }
                    break;
                default:
                    return '<' . $in['tag'] . $vv . '>';
                    break;
            }

        }
    }


    /**
     * @note 在标签末尾插入/
     *
     * @param $str
     * @return string
     */
    private static function insertBackSlant($str)
    {
        $str = rtrim($str, '>');
        $str = $str . '/>';
        return $str;
    }


    /**
     * @note html 标签
     *
     * @param array $attr 标签属性数组
     */
    public static function html_start($attr = array())
    {
        if (count($attr) != null) {
            $str = self::format_tag(1, array('tag' => 'html', 'attr' => $attr));
            $str = self::printl('<!DOCTYPE html>') . $str;
            $str = rtrim($str, '</html>') . '>';
            echo $str;
        } else {
            $str = '<!DOCTYPE html>
<html lang="zh_CN">';
            echo $str;
        }
    }
    public static function html_end()
    {
        $str = '</html>';
        echo $str;
    }


    /**
     * @note head 标签
     *
     */
    public static function head_start()
    {
        $str = '<head>';
        echo $str;
    }
    public static function head_end()
    {
        $str = '</head>';
        echo $str;
    }

    /**
     * @note 标签格式化后输出
     *
     * @param int $outputType 0=<tag attr=v>;1=<tag attr=v></tag>
     * @param array $input array('tag'=>'','attr'=>array(),'content'=>'')
     *
     */
    public static function tag_format_output($outputType = 0, $input = array('tag' => '', 'attr' => array(), 'content' => ''))
    {

        /**
         * 格式化标签输出函数
         * @param int $oT 0=<tag attr=v>;1=<tag attr=v></tag>
         * @param array $in array('tag'=>'','attr'=>array(),'content'=>'')
         * @return string
         */


        /**
         * 标签内结尾添加反斜杠函数，如<img src="" />
         * @param $str 要添加反斜杠的字符串
         * @return string
         */


        switch ($input['tag']) {
            case 'meta':    //<meta attr="value" >
                $res = self::format_tag($outputType, $input);
                echo $res;
                break;
            case 'link':    //<link attr="value" >
                $res = self::format_tag($outputType, $input);
                echo $res;
                break;
            case 'title':   //<title></title>
                $res = self::format_tag(1, $input);
                echo $res;
                break;
            case 'script':  //<script attr="value" >...</script>
                $res = self::format_tag($outputType, $input);
                echo $res;
                break;
            case 'style':   //<style type="text/stylesheet">...</style>
                $res = self::format_tag(1, $input);
                echo $res;
                break;

            default:
                $res = self::format_tag($outputType, $input);
                echo $res;
                break;
        }

    }

    /**
     * @note body 标签
     *
     * @param array $attr body 属性参数
     */
    public static function body_start($attr=array())
    {
        if (count($attr) != null) {
            $str = self::format_tag(1, array('tag' => 'body', 'attr' => $attr));
            $str = rtrim($str, '</body>') . '>';
            echo $str;
        } else {
            $str = '<body>';
            echo $str;
        }
    }
    public static function body_end(){
        $str = '</body>';
        echo $str;

    }

    /**
     * @note 校验文件读取权限并读取文件内容
     * @param $file
     * @return string
     */
    public static function getFile($file){
        $fopen=fopen($file,'r+');//是否可读，不可读则输出失败
        if($fopen!=null) {
            $fileContent = file_get_contents($file);
            return $fileContent;
        }
    }

    /**
     * @note 加载view文件
     * @param $file
     * @return mixed|string
     */
    public static function loadViewFile2Parse($file){
        $fileContent=self::getFile($file);
        $in_start_pos=strpos($fileContent,'@{include%');
        $in_end_pos=strpos($fileContent,'%include};');
        if($in_start_pos!=-1 && $in_end_pos!=-1){//存在一个@{include<>include};
            $in_start_count=substr_count($fileContent,'@{include%');//用位置判断是否存在@include{<
            $in_end_count=substr_count($fileContent,'%include};');//用位置判断是否存在>}include@  @include{<~/include/efff/>}include@
            $in_count=$in_start_count>$in_end_count?$in_end_count:$in_start_count;//安全判断include是否完整
            for($repeat=0;$repeat<$in_count;$repeat++){
                $in_start_pos_r=strpos($fileContent,'@{include%');
                $in_end_pos_r=strpos($fileContent,'%include};');

                $in_file=substr($fileContent,$in_start_pos_r+strlen('@{include%'),$in_end_pos_r-$in_start_pos_r-strlen('%include};'));//include file路径
                $in_file_s='@{include%'.$in_file.'%include};';
                if(strpos($in_file,'~')==0){
                    $in_file=str_replace('~',ROOT_PATH,$in_file);
                }
                $in_file_content=self::getFile($in_file);
                $fileContent=str_replace($in_file_s,$in_file_content,$fileContent);
            }
            return $fileContent;
        }
        return $fileContent;
    }


    /**
     * @note 为view文件添加数据格式标签
     * @param $content
     * @param $tagFormat
     * @param array $attrArray
     * @param null $formatType
     * @return mixed
     */
    public static function setParseTag($content,$tagFormat,$attrArray=array(),$formatType=null)
    {

        if ($content!=null && $tagFormat != null && $attrArray != null) {
            $tagFormat_left = '@{' . $tagFormat . ':';
            $tagFormat_right = '};';

            switch ($formatType) {
                default:
                    foreach ($attrArray as $attrKey => $attrValue) {
                        $tagFormat = $tagFormat_left . $attrKey . $tagFormat_right;
                        $content = str_replace($tagFormat, $attrValue, $content);
                    }
                    return $content;
                    break;

            }
        }

    }

    /**
     * @note 为view 文件添加数据循环输出格式标签，默认分割符||
     * @param $content
     * @param $tagFormat
     * @param array $attrArray
     * @param null $delimiter
     * @return mixed
     */
    public static function setParseTag_loop($content,$tagFormat,$attrArray=array(),$delimiter=null)
    {

        if ($content!=null && $tagFormat != null && $attrArray != null) {
            $tagFormat_left = '@{' . $tagFormat . ':';
            $tagFormat_right = '};';
            if($delimiter==null){
                foreach ($attrArray as $attrKey => $attrValue) {
                    $arr=explode('||',$attrValue);
                    $tagFormat = $tagFormat_left . $attrKey . $tagFormat_right;
                    $i='';
                    foreach(array_slice($arr,1) as $key => $value) {
                        $i=$i.$value;
                    }
                    $content = str_replace($tagFormat, $i   , $content);
                }
                return $content;

            }elseif($delimiter!=null){

                foreach ($attrArray as $attrKey => $attrValue) {
                    $arr=explode($delimiter,$attrValue);
                    $tagFormat = $tagFormat_left . $attrKey . $tagFormat_right;
                    $i='';
                    foreach(array_slice($arr,1) as $key => $value) {
                        $i=$i.$value;
                    }
                    $content = str_replace($tagFormat, $i   , $content);
                }
                return $content;
            }
        }
    }

    /**
     * @note 用默认||分割符格式化输出数据，可供以上函数使用
     * @param $input1='';
     * @param $input2
     */
    public static function delimiterLoopOutput($input1=null,$input2,$delimiter=null){
        if($delimiter==null){
            $input1=$input1.'||'.$input2;
            return $input1;
        }elseif($delimiter!=null){
            $input1=$input1.$delimiter.$input2;
            return $input1;
        }
    }

    /**
     * @note 输出显示view 内容
     * @param $content
     */
    public static function show($content){
        echo $content;
    }




}
?>
