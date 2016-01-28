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
 * Class htmlView
 * 框架自带 html视图代码输出类
 *
 */

class view
{
    /**
     * @param string $str 标签末换行输出
     */
    static public function print_l($str)
    {
        echo $str.'
';
    }

    /**
     * @param int $oT 标签输出格式 0=<tag attr="attrV"> 1=<tag attr="attrV"></tag>
     * @param array $in
     */
    static private function format_tag($oT = 0, $in = array('tag' => '', 'attr' => array(), 'content' => ''))
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
     * @param $str
     * @return string
     * 在标签末尾插入/
     */
    static private function insertBackSlant($str)
    {
        $str = rtrim($str, '>');
        $str = $str . '/>';
        return $str;
    }

    /**
     * @param array $attr 标签属性
     * html 标签
     */
    static public function html_start($attr = array())
    {
        if (count($attr) != null) {
            $str = self::format_tag(1, array('tag' => 'html', 'attr' => $attr));
            $str = self::print_l('<!DOCTYPE html>') . $str;
            $str = rtrim($str, '</html>') . '>';
            echo $str;
        } else {
            $str = '<!DOCTYPE html>
<html lang="zh_CN">';
            echo $str;
        }
    }
    static public function html_end()
    {
        $str = '</html>';
        echo $str;
    }


    /**
     * head 标签
     */
    static public function head_start()
    {
        $str = '<head>';
        echo $str;
    }
    static public function head_end()
    {
        $str = '</head>';
        echo $str;
    }

    /**
     * @param int $outputType 0=<tag attr=v>;1=<tag attr=v></tag>
     * @param array $input array('tag'=>'','attr'=>array(),'content'=>'')
     *
     */
    static public function tag_format_output($outputType = 0, $input = array('tag' => '', 'attr' => array(), 'content' => ''))
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
     * @param array $attr body 属性参数
     */
    static public function body_start($attr=array())
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
    static public function body_end(){
        $str = '</body>';
        echo $str;

    }

}

?>
