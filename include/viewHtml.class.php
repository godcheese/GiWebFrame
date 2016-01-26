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
 * Class viewHtml
 * 路由视图类
 *
 */

class viewHtml
{
    /**
     * @param $str
     */
    static public function print_line($str){
        echo $str.'
        ';
    }


    /**
     * html 标签
     * @param $lang 页面语言 zh_CN
     */
    static public function html_start($lang = 'zh_CN'){
        $str='
<!DOCTYPE html>
<html lang="'.$lang.'">';
        echo $str;
    }
    static public function html_end(){
        $str='</html>';
        echo $str;
    }


    /**
     * head 标签
     */
    static public function head_start(){
        $str='<head>';
        echo $str;
    }
    static public function head_end(){
        $str='</head>';
        echo $str;
    }

    /**
     * @param int $outputType   0=<tag attr=v>;1=<tag attr=v></tag>
     * @param array $input  array('tag'=>'','attr'=>array(),'content'=>'')
     *
     */
    static public function tag_format_output_($outputType=0,$input=array('tag'=>'','attr'=>array(),'content'=>'')){

        /**
         * 格式化标签输出函数
         * @param int $oT   0=<tag attr=v>;1=<tag attr=v></tag>
         * @param array $in array('tag'=>'','attr'=>array(),'content'=>'')
         * @return string
         */
        function format_tag($oT=0,$in=array('tag'=>'','attr'=>array(),'content'=>''))
        {
            $vv='';
            foreach ($in['attr'] as $key => $value) {
                $vv = $vv . ' ' . $key . '="' . $value . '"';
            }
            switch ($oT){
                case 0:
                    echo '<' . $in['tag'] . $vv . '>';
                    break;
                case 1:
                    if(!array_key_exists('content',$in)){
                        $in['content']='';
                        echo '<'.$in['tag'].$vv.'>'.$in['content'].'</'.$in['tag'].'>';
                    }else {
                        echo '<' . $in['tag'] . $vv . '>' . $in['content'] . '</' . $in['tag'] . '>';
                    }
                    break;
                default:
                    echo '<' . $in['tag'] . $vv . '>';
                    break;
            }
        }


        /**
         * 标签内结尾添加反斜杠函数，如<img src="" />
         * @param $str 要添加反斜杠的字符串
         * @return string
         */
        function insertBackSlant($str){
            $str=rtrim($str,'>');
            $str=$str.'/>';
            return $str;
        }

        switch ($input['tag']){
            case 'meta':    //<meta attr="value" >
                $res=format_tag(0,$input);
                echo $res;
                break;
            case 'link':    //<link attr="value" >
                $res=format_tag(0,$input);
                echo $res;
                break;
            case 'title':   //<title></title>
                $res=format_tag(1,$input);
                echo $res;
                break;
            case 'script':  //<script attr="value" >...</script>
                $res=format_tag($outputType,$input);
                echo $res;
                break;
            case 'style':   //<style type="text/stylesheet">...</style>
                $res=format_tag(1,$input);
                echo $res;
                break;

            default:
                $res=format_tag(0,$input);
                echo $res;
                break;
        }




    }

    /**
     * body 标签
     * @param $styleclass body标签引用的样式类或
     */
    static public function body_start($styleclass=null){

        if(!empty($styleclass)){
            $str='
        <body '.$styleclass.'>';
            echo $str;
        }else{
            $str='<body>';
            echo $str;
        }
    }

    static public function body_end(){
        $str='</body>';
        echo $str;
    }

}
?>
