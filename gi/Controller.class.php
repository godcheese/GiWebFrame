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


namespace GiWebFrame\Core;

/**
 *
 * @note 框架自带 html视图代码输出类
 *
 * Class Controller
 * @package GiWebFrame\Core
 *
 */


class Controller
{
    private $left_delimiter='{!--';
    private $right_delimiter='--!}';
    private $contents='';

    /**
     * @note 标签末换行输出
     *
     * @param $str 换行输出
     *
     */
    protected function printl($str)
    {
        echo ($str."\n");
    }

    /**
     * @note 标签输出格式 0=<tag attr="attrV"> 1=<tag attr="attrV"></tag>
     *
     * @param int $oT
     * @param array $in
     * @return string
     */
    protected function format_tag($oT = 0, $in = array('tag' => '', 'attr' => array(), 'content' => ''))
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
    protected function insertBackSlant($str)
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
    protected function html_start($attr = array())
    {
        if (count($attr) != null) {
            $str = $this->format_tag(1, array('tag' => 'html', 'attr' => $attr));
            $str = $this->printl('<!DOCTYPE html>') . $str;
            $str = rtrim($str, '</html>') . '>';
            echo $str;
        } else {
            $str = '<!DOCTYPE html>
<html lang="zh_CN">';
            echo $str;
        }
    }
    protected function html_end()
    {
        $str = '</html>';
        echo $str;
    }


    /**
     * @note head 标签
     *
     */
    protected function head_start()
    {
        $str = '<head>';
        echo $str;
    }
    protected function head_end()
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
    protected function tag_format_output($outputType = 0, $input = array('tag' => '', 'attr' => array(), 'content' => ''))
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
                $res = $this->format_tag($outputType, $input);
                echo $res;
                break;
            case 'link':    //<link attr="value" >
                $res = $this->format_tag($outputType, $input);
                echo $res;
                break;
            case 'title':   //<title></title>
                $res = $this->format_tag(1, $input);
                echo $res;
                break;
            case 'script':  //<script attr="value" >...</script>
                $res = $this->format_tag($outputType, $input);
                echo $res;
                break;
            case 'style':   //<style type="text/stylesheet">...</style>
                $res = $this->format_tag(1, $input);
                echo $res;
                break;

            default:
                $res = $this->format_tag($outputType, $input);
                echo $res;
                break;
        }

    }

    /**
     * @note body 标签
     *
     * @param array $attr body 属性参数
     */
    protected function body_start($attr=array())
    {
        if (count($attr) != null) {
            $str = $this->format_tag(1, array('tag' => 'body', 'attr' => $attr));
            $str = rtrim($str, '</body>') . '>';
            echo $str;
        } else {
            $str = '<body>';
            echo $str;
        }
    }
    protected function body_end(){
        $str = '</body>';
        echo $str;

    }

    protected function layout($theme_file,$path=''){

        $left=c('giview')['left_delimiter'];
        $right=c('giview')['right_delimiter'];
        if($left!='' && $right!=''){
            $this->left_delimiter=$left;
            $this->right_delimiter=$right;
        }

        $path=$path==''?$path=THEME:$path;
        $this->contents=$this->get_contents($path.$theme_file);

        $this->parse_has_theme_tag();
        $this->parse_include_tag();

    }

    protected function display(){
        print_r($this->parse_assign()); // 输出缓存在GiView类里的contents

        $this->contents='';             // 释放缓存在GiView类里的contents，这句代码至关重要。
    }

    protected function get_contents($file){
        ob_start();

        if(file_exists($file.'.'.c('giview')['tpl_extension'])){
            include ($file.'.'.c('giview')['tpl_extension']);
        }else{
            print_r(c('gierror')[2100]);
        }
        $contents=ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    private function parse_has_theme_tag(){
        $contents=$this->contents;
        $left_pos=strpos($contents,$this->left_delimiter);
        $right_pos=strpos($contents,$this->right_delimiter);
        if($left_pos!=-1 && $right_pos!=-1){
            return true;
        }else{
            return false;
        }
    }

    private function parse_include_tag($include_tag='include'){

        $include_tag=c('giview')['tag_include']==''?$include_tag:c('giview')['tag_include'];
        $contents=$this->contents;
        $tag_left=$this->left_delimiter."<$include_tag";
        $tag_right='/>'.$this->right_delimiter;

        $count=substr_count($contents,$tag_left);

        for($i=0;$i<=$count;$i++) {


            $left_pos = strpos($contents, $tag_left);
            $right_pos = strpos($contents, $tag_right);

            $start = $left_pos + strlen($tag_left);
            $len = $right_pos - $start;
            $attr = substr($contents, $start, $len);

            $attr_start = 'file="';
            $attr_left_pos = strpos($attr, 'file="');
            $attr_right_pos = strpos($attr, '"');

            if ($attr_left_pos !=-1 && $attr_right_pos !=-1) {
                $start = $attr_left_pos + strlen($attr_start);
                $len = $attr_right_pos - $start;

                $attr_value = substr($attr, $start, $len);
                if (strpos($attr_value, '~') == 0) {
                    $file = str_replace('~', THEME, $attr_value);
                    if (file_exists($file.'.'.c('giview')['tpl_extension'])) {
                        $search = substr($contents, $left_pos, $right_pos + strlen($tag_right) - $left_pos);
                        $content = $this->get_contents($file);
                        $str = str_replace($search, $content, $contents);
                        $contents=$str;
                    }
                }
            }
        }

        $this->contents=$contents;
    }

    protected function parse_assign_bak($var_tag='var_tag')
    {
        $var_tag=c('giview')['tag_var']==''?$var_tag:c('giview')['tag_var'];

        $contents=$this->contents;

        if(is_array(g($var_tag))) {

            foreach (g($var_tag) as $k => $v) {
                $tag_left = $this->left_delimiter . '$' . $var_tag . '[';
                $tag_right = ']' . $this->right_delimiter;
                $var = $tag_left . $k . $tag_right;

                if (strpos($contents, $var) !=-1) {

                    $left_pos = strpos($contents, $tag_left);
                    $right_pos = strpos($contents, $tag_right);

                    if ($left_pos != -1 && $right_pos != -1) {
                        $contents = str_replace($var, $v, $contents);
                    }
                }
            }
        }

        return $contents;
    }


    protected function parse_assign($var_tag='var_tag')
    {
        $var_tag=c('giview')['tag_var']==''?$var_tag:c('giview')['tag_var'];

        $contents=$this->contents;

        if(is_array(g($var_tag))) {

            foreach (g($var_tag) as $var_name => $var_value) {

                if(is_array($var_value)){

                    foreach ($var_value as $k=>$v){
                        //{$page[title]}
                        $tag_left = $this->left_delimiter . '$' . $var_name . '[';
                        $tag_right = ']' . $this->right_delimiter;
                        $value_k = $tag_left . $k . $tag_right;

                        if (strpos($contents, $value_k) !=-1) {

                            $left_pos = strpos($contents, $tag_left);
                            $right_pos = strpos($contents, $tag_right);

                            if ($left_pos != -1 && $right_pos != -1) {
                                $contents = str_replace($value_k, $v, $contents);
                            }
                        }
                    }


                }else{
                    //{$page[title]}
                    $tag_left = $this->left_delimiter . '$' . $var_name ;
                    $tag_right = $this->right_delimiter;
                    $value_k = $tag_left . $tag_right;

                    if (strpos($contents, $value_k) !=-1) {

                        $left_pos = strpos($contents, $tag_left);
                        $right_pos = strpos($contents, $tag_right);

                        if ($left_pos != -1 && $right_pos != -1) {
                            $contents = str_replace($value_k, $var_value, $contents);
                        }
                    }
                }


            }
        }

        return $contents;
    }


    protected function assign($var_name='',$var_value='',$var_tag='var_tag')
    {
        $var_tag = c('giview')['tag_var'] == '' ? $var_tag : c('giview')['tag_var'];


        if ($var_tag != '' && $var_name != '') {

            if (is_array($var_value)) {

                foreach ($var_value as $k => $v) {
                    $GLOBALS[$var_tag][$var_name][$k]=$v;

                }

            }else{
                $GLOBALS[$var_tag][$var_name]=$var_value;
            }
        }

    }



    protected function assign_loop($for,$repeat=0,$array_param=array(),$loop_tag='loop'){

        $loop_tag=c('giview')['tag_loop']==''?$loop_tag:c('giview')['tag_loop'];
        $contents=$this->contents;
        $tag_left=$this->left_delimiter."<$loop_tag";
        $tag_delimiter='>';
        $tag_right="</$loop_tag>".$this->right_delimiter;

        $count_left=substr_count($contents,$tag_left);
        $count_right=substr_count($contents,$tag_right);
        $count=$count_left==$count_right?$count_left:$count_left;

        for($i=0;$i<$count;$i++) {

            $left_pos = strpos($contents, $tag_left);
            $right_pos = strpos($contents, $tag_delimiter, $left_pos);

            $start = $left_pos + strlen($tag_left);
            $len = $right_pos - $start;
            $attr = substr($contents, $start, $len);

            $for_left = 'for="';
            $for_right = '"';

            $for_left_pos = strpos($attr, $for_left);
            $for_right_pos = strpos($attr, $for_right);

            $for_start = $for_left_pos + strlen($for_left);
            $for_len = $for_right_pos - $for_start;
            $for_value = substr($attr, $for_start, $for_len);

            if($for_value==$for){
                $left_pos = strpos($contents, $tag_left);
                $left_pos = strpos($contents, $tag_delimiter,$left_pos);
                $right_pos = strpos($contents, $tag_right, $left_pos);

                $start = $left_pos+1;
                $len = $right_pos - $start;
                $attr= substr($contents, $start, $len);


                $left_pos = strpos($contents, $tag_left);
                $right_pos = strpos($contents, $tag_right,$left_pos);
                $start = $left_pos;
                $len = $right_pos+strlen($tag_right)-$left_pos;
                $search = substr($contents, $start,$len);
                $str='';
                for($ii=0;$ii<$repeat;$ii++){
                    $v=$array_param[$ii];

                    $i=0;
                    $content=$attr;
                    if(is_array($v)) {
                        foreach ($v as $kk => $vv) {
                            $i++;
                            $loop_k_left = $this->left_delimiter . '&' . $loop_tag . '[';
                            $loop_k_right = ']' . $this->right_delimiter;
                            $loop_param_tag = $loop_k_left . $kk . $loop_k_right;

                            $content = str_replace($loop_param_tag, $vv, $content);
                            if (count($v) == $i) {
                                continue;
                            }
                        }
                    }

                    $str.=$content;

                }

                $contents=str_replace($search,$str,$contents);
                $this->contents=$contents;

                break;
            }


        }

    }


    function __destruct()
    {
        // TODO: Implement __destruct() method.

    }

}