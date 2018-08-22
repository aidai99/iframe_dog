<?php
/*
Plugin Name: iframe_dog
Plugin URI: #
Description: iframe_dog
Version: 2.4
Author: Carseason
Author URI: #
*/    
//后台管理
add_action('admin_menu', 'dashboard_submenu');  //插件形式

    function dashboard_submenu() {              //执行插件方法
            add_options_page(__('iframe_dog'), __('iframe_dog'), 'read', 'your-unique-identifier', 'add_dashboard_submenu');  //add_options_page是在设置下添加插件
    }
    function add_dashboard_submenu() {	        //执行后台设置插件方法
        $down_data=(get_option( 'iframe_dog' ));    //读取数据库
        $down_data_ar = array();                    //创建空数组
        if($down_data){                             //如果数据库不为空
            $down_data_ar  = json_decode( $down_data, true );   //把数据库的值按数组赋值
        }
        echo  '<h2>框架狗设置</h2>';       
        echo <<<EOF
        <style>
        .video-U-li {margin: 10px 0;position: relative;padding-right: 40px;clear: both;height: 28px;}
        .video-Uname {width: 80%;float: left;position: relative;}
        .video-U-li input {float: left; margin: 0;width: 40%;}
        .video-U-li-delete {background: #4ba563;width:10%;position: absolute;top: 5px;color: #fff;font-size: 12px;text-align: center;cursor: pointer;margin-left: 5px;}
        .Car-video-add {background: #4ba563;height: 25px;line-height: 25px;text-align: center;font-size: 12px;color: #fff;cursor: pointer;margin-top: 10px;width: 10%;}
        </style>
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
            <script type="text/javascript">
                    jQuery(document).ready(function($){
                        $('.Car-video-box').on('click','.video-U-li-delete',function(){
                            var _this = $(this).parent().parent();
                            _this.remove();
                        });
                        $('.Car-video-add').click(function(){
                            var _box = $('.Car-video-box'),
                            _html = '';
                            _html += '<div class="video-U-li">';
                            _html += '<div class="video-Uname">';
                            _html += '<input type="text" name="iframe_dog[name][]" class="video-Uurl" value="" placeholder="正则">';
                            _html += '<input type="text" name="iframe_dog[url][]]" class="video-Uurl" value="" placeholder="链接地址">';
                            _html += '<span class="video-U-li-delete">删除</span>';
                            _html += '</div>';
                            _box.append(_html);
                        });
                        $('.Car-video-box').on('change','.video-Uname select',function(){
                            var _this = $(this),
                                _input = _this.siblings('input');
                            _input.val(_this.val());
                        });	
                    });
                </script>
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
    add_shortcode('loc', 'iframe_dog');             //短代码判断
    add_shortcode('dog', 'iframe_dog');
    function iframe_dog($array_url_title) {//短代码要处理的函数
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
        $listskip='';
        for($i=0;$i<$video_i;$i++){
            $url[$i]=$up.$url[$i];
            foreach($vide_data_ar as $value){
                if(preg_match("/".urldecode($value['name'])."/i",$url[$i]) && urldecode($value['name']) !=""){
                    $video=$value['url'];  
                    break;
                }
            }
            $j=$i+1;
            if($i==0){
                $one=urldecode($video.$url[$i]);
            }
            $selselect .= '<a href="javascript:void(0)" class="video'.$j.'" value="'.$j.'" data-video="'.urldecode($video.$url[$i]).'" title="'.urldecode($name[$i]).'">'.urldecode($name[$i]).'</a>';
            if($$video_i==1){
                $selselect_none='style=display:none';
            }else{
                $selselect_none='';
            }
        }
        return <<<EOF
                <script>
                $(document).ready(function(){
                  var url=location.href;           //当前url
                  var video_page=/.*#(\d+)$/.exec(url);   //正则查找	
                  if (video_page !=null){
                      url = url.replace(/#\d+$/i,"");		//正则删除链接后面的#XXX
                      $(".Car-iframe iframe").attr("src",$(".video"+video_page[1]).attr("data-video"));
                      $(".Car-listSkip a").removeAttr("style");
                      $(".video"+video_page[1]).css("background","#00bcd4");
                  }else{
                      $("a.video1").css("background","#00bcd4");
                  }
                    $(".Car-listSkip a").click(function(){
                    $(".Car-iframe iframe").attr("src",$(this).attr("data-video"));
                    $(".Car-listSkip a").removeAttr("style");
                    $(this).css("background","#00bcd4");
                    document.location.href=url+"#"+($(this).attr("value"));   //改变url
                  });
                });
            </script>
            <style>
              .Car-player{width:100%;float:left; }
              .Car-iframe{width:100%;float:left;height: 0; margin-bottom: 1rem;padding-bottom: 50%;position: relative;}
              .Car-iframe iframe{background: #000;height: 100%;position: absolute;width: 100%;}
              .Car-listSkip{width:100%;float:left;}
              .Car-listSkip a{background: grey;color: white;border-radius: 5px;margin:0 5px 5px 5px;float: left;width: 9.15%;text-align: center;height: 30px;line-height: 30px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;}
              @media (max-width: 800px){
                  .Car-listSkip a{width:22%}
                  .Car-player{margin-top:10px;}
                  .Car-iframe{padding-bottom: 70%;}
              }
            </style>
            <div class="Car-player">
                <div class="Car-iframe">
                <iframe src="$one" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" __idm_frm__="23" frameborder=0 ></iframe>
                </div>
                <div class="Car-listSkip" $selselect_none>$selselect</div>
            </div>
EOF;
    }  

 add_action('after_wp_tiny_mce', 'Cae_iframe');
 
 function Cae_iframe($mce_settings) {
    ?>
    
    <script type="text/javascript">  
    QTags.addButton('dplayerin','插入框架狗','[loc up="" url="" name=""]','');  
    </script>
   
    <?php
}
