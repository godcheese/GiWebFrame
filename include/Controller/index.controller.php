<?php


class index extends GiWebFrame\Core\Controller implements GiWebFrame\Inf\Controller{



    function __construct()
    {
        $this->layout('default');
        $this->assign_loop('menu',4,system::menu_main());

    }

    /**
     * @note 默认访问方法
     */
    public function __default()
    {
        self::home();
        //header('Location:/index.php?c=index');
    }

    //首页方法
    public function home(){

        $page['title']='首页';
        $page['bread']='面包屑';
        $page['content']='这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。';
        $this->assign('page',$page);

       // $this->assign('bread_path','GiWebFrame');

        /**
        $b=array(
            array(
                '_id'=>'p11iddsfsdf',
                '_title'=>'p11titledfdsfdsvcvc',
                '_content'=>'p11contentsdgerter',
            ),
            array(
                '_id'=>'p22id23dsfsdf',
                '_title'=>'p22titled34fdsfdsvcvc',
                '_content'=>'p22contentsd5gerter',
            ),
            array(
                '_id'=>'p33iddsf576sdf',
                '_title'=>'p33titledfd5676sfdsvcvc',
                '_content'=> 'p33contentsdge676rter',
            ),

        );
       $this->assign_loop('page',3,$b);
         **/
    }

    
    public function test(){

        $page['title']='测试页面';
        $page['bread']='首页-测试页面';
        $page['content']='这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。这里是测试。';
        $this->assign('page',$page);

        $b=array(
            array(
                '_id'=>'来自测试页面的id1',
                '_title'=>'来自测试页面的title1',
                '_content'=>'来自测试页面的content1',
            ),
            array(
                '_id'=>'来自测试页面的id2',
                '_title'=>'来自测试页面的title2',
                '_content'=>'来自测试页面的content2',
            ),
            array(
                '_id'=>'来自测试页面的id3',
                '_title'=>'来自测试页面的title3',
                '_content'=> '来自测试页面的content3',
            ),

        );
        $this->assign_loop('page',3,$b);

    }


    public function about(){

        $page['title']='关于我们';
        $page['bread']='首页-关于我们';
        $page['content']='<h3>GiWebFrame v1.1.0</h3>
<p><strong>开发者：</strong>天堂芝士</p>
<p><strong>网站：<a href="http://www.gioov.com"></strong>http://www.gioov.com</a></p>
<p><strong>项目Git：</strong><a href="http://github.com/godcheese/giwebframe.git">http://github.com/godcheese/giwebframe.git</a></p>
<p><strong>开发者微博：</strong><a href="http://weibo.com/handsomedg">http://weibo.com/handsomedg</a></p>';

        $this->assign('page',$page);

    }




    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->display();
    }

}