<?php
/*
Plugin Name: IframeDog
Plugin URI: #
Description: IframeDog
Version: 2.5
Author: Carseason
Author URI: #
*/  
add_action('admin_menu', 'IframeDog_submenu');  //插件形式
    function IframeDog_submenu() {              //执行插件方法
        add_options_page(__('IframeDog'), __('IframeDog'), 'read', 'your-unique-identifier', 'add_IframeDog_submenu');  //add_options_page是在设置下添加插件
    }
    function add_IframeDog_submenu() {	        //执行后台设置插件方法
        $down_data=(get_option( 'iframe_dog' ));    //读取数据库
        $down_data_ar = array();                    //创建空数组
        if($down_data){                             //如果数据库不为空
            $down_data_ar  = json_decode( $down_data, true );   //把数据库的值按数组赋值
        }
        echo  '<h2>框架狗设置</h2>'; 
        $IframeDogCss=plugins_url('',__FILE__);
        wp_enqueue_style('IfrmaeDog',$IframeDogCss."/IfrmaeDog.css", array(), '2.5');   //注册css
        wp_enqueue_script('IfrmaeDog', $IframeDogCss."/IfrmaeDog.js", array(), '2.5', true);
        echo <<<EOF
        <form action="" method="post" id="my_plugin_test_form"><div class="Car-video-box">
EOF;
        if($down_data_ar && is_array($down_data_ar) ){   //如果不是空和数组
            foreach($down_data_ar  as $value ){
           //   echo $down_data_ar['name'][0]."<br>";
            $html='<div class="video-U-li"><div class="video-Uname">';
            $html.='<input type="text" name="iframe_dog[name][]" class="video-Uurl" value="'.urldecode($value['name']).'" placeholder="正则">';
            $html.='<input type="text" name="iframe_dog[url][]" class="video-Uurl" value="'.urldecode($value['url']).'" placeholder="链接地址">';
            $html.='<span class="video-U-li-delete">删除</span></div></div>';
            echo $html;
            }
        }else{
                $html='<div class="video-U-li"><div class="video-Uname">';
                $html.='<input type="text" name="iframe_dog[name][]" class="video-Uurl" value="" placeholder="正则">';
                $html.='<input type="text" name="iframe_dog[url][]" class="video-Uurl" value="" placeholder="链接地址">';
                $html.='<span class="video-U-li-delete">删除</span></div></div>';
                echo $html;
            }
            echo '</div><div class="Car-video-add">添加资源框</div><input type="submit" name="submit" value="保存" class="button button-primary" /><input type="hidden" name="test_hidden" value="dogup"/></form>';
            echo    <<<EOF

EOF;

            if($_POST['test_hidden'] == 'dogup') {  //捕获是否点击保存按钮
                $down_data = array();               //新建一个数组
                foreach ($_POST['iframe_dog']['url'] as $key => $value) {   //对数组元素遍历
                    $down_data[] = array(       //把提交的值存储进数组里
                    'name'=> urlencode( $_POST['iframe_dog']['name'][$key] ),
                    'url' => urlencode( $value )
                    );
                }
                $down_data_sql  = json_encode( $down_data );    //对数组进行json格式化
                update_option('iframe_dog', $down_data_sql );   //存储sql
                echo '<div id="message" style="color: #000;">保存成功 !</div><script>location.reload();</script>';        
            }
    }
    add_shortcode('dog', 'IframeDog');             //短代码判断
    function IframeDog($array_url_title) {//短代码要处理的函数
        $vide_data=(get_option( 'iframe_dog' ));    //读取数据库
        $vide_data_ar = array();                    //创建空数组
        if($vide_data){                             //如果数据库不为空
            $vide_data_ar  = json_decode( $vide_data, true );   //把数据库的值按数组赋值
        }
        $url= explode(',',$array_url_title["url"]); //文章url短代码链接,以英文逗号分割
        $name= explode(',',$array_url_title["name"]);//文章短代码名字,以英文逗号分割
        $video_i= count($url);  //获取数量
        $up=$array_url_title["up"];
        $video="";
        if($video_i==1){
            $url[0]=$up.$url[0];
            foreach($vide_data_ar as $value){
                if(preg_match("/".urldecode($value['name'])."/i",$url[0]) && urldecode($value['name']) !=""){
                    $video=$value['url'];  
                    break;
                }
            }
            $selselect='';
        }else{
            for($i=0;$i<$video_i;$i++){
                $url[$i]=$up.$url[$i];
                foreach($vide_data_ar as $value){
                    if(preg_match("/".urldecode($value['name'])."/i",$url[$i]) && urldecode($value['name']) !=""){
                        $video=$value['url'];  
                        break;
                    }
                }
                $j=$i+1;
                $name[$i]=urldecode($name[$i]);
                $selselect .= '<div onclick="IframeDog('.$j.')" class="IfrmaeDog-selselect" title="'.$name[$i].'">'.$name[$i].'</div>';
            }
        }
        
        $vpage = $_GET["vpage"]; //获取浏览器输入如1.php?vpage=XXXX,即截取XXXX
        if (($vpage)&&(is_numeric($vpage))&&($vpage<=$video_i)){
            $vpage=$vpage-1;
            $video=urldecode($video.$url[$vpage]);    //第一个url
        }else{
            $vpage=0;
            $video=urldecode($video.$url[0]);    //第一个url
        }
        $IframeDogCss=plugins_url('IfrmaeDog.css',__FILE__);
        wp_enqueue_style('IfrmaeDog',$IframeDogCss, array(), '2.5');   //注册css
        return<<<EOF
        <div class="Car-player">
            <div class="Car-iframe">
                <iframe id="IframeDog" src="$video" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" __idm_frm__="23" frameborder=0 ></iframe>
            </div>
            <div class="Car-listSkip">$selselect</div>
        </div>
        <script type="text/javascript">
            document.getElementsByClassName("IfrmaeDog-selselect")[$vpage].style.background='#00bcd4';
            function IframeDog(i){
                IframeUrl=location.href.split("?vpage=")[0];
                document.location.href=IframeUrl+"?vpage="+i;
            }
        </script>
EOF;

    }
    add_action('after_wp_tiny_mce', 'Cae_iframe');
    function Cae_iframe($mce_settings) {
        echo<<<EOF
            <script type="text/javascript">  
                    QTags.addButton('dplayerin','插入框架狗','[dog up="" url="" name=""]','');  
            </script>
EOF;
   }
