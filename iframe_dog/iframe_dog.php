<?php
/*
Plugin Name: iframe_dog
Plugin URI: #
Description: 嵌套ifame视频
Version: 1.2
Author: Carseason
Author URI: https://github.com/Carseason/iframe_dog
*/
add_shortcode('dog', 'iframe_dog');
//挂载短代码
//dog为短代码名称,iframe_dog为函数
//即你在编辑文章时输入[dog]就会执行 iframe_dog 函数
function iframe_dog($array_url_title) {//短代码要处理的函数
    $dog_url= explode(',',$array_url_title["url"]); //文章url短代码链接,以英文逗号分割
    $dog_name= explode(',',$array_url_title["name"]);//文章短代码名字,以英文逗号分割
    $dog_url_i=  count($dog_url);   //获取数量
    $dog_name_i= count($dog_name);  //获取数量
    $dog_i=($dog_url_i > $dog_name_i) ? $dog_url_i:$dog_name_i; //三元比较
    $dog_html = "";
    for(    $i=0;   $i<$dog_i;  $i++){
        global  $dog_html;
        if (strpos($dog_url[$i],'av=')!==false){
              $dog_html .=  '<div class="d_video" data-video="//player.bilibili.com/player.html?aid='.(str_replace("av=","",$dog_url[$i])).'" title="'.$dog_name[$i].'">'.$dog_name[$i].'</div>';
        }else{
            $dog_html .=  '<div class="d_video" data-video="/wp-content/plugins/iframe_dog/Dplayer.php?'.$dog_url[$i].'" title="'.$dog_name[$i].'">'.$dog_name[$i].'</div>';
        }    
    }
    $dog_video="";
    if (strpos($dog_url[0],'av=')!==false){
        $dog_video="//player.bilibili.com/player.html?aid=".(str_replace("av=","",$dog_url[0]));
    }else{
        $dog_video="/wp-content/plugins/iframe_dog/Dplayer.php?".$dog_url[0];
    }



return <<<EOF
<script src="/wp-content/plugins/iframe_dog/jquery-3.3.1.min.js"></script>
<script src="/wp-content/plugins/iframe_dog/iframe_dog.js"></script>
<link rel="stylesheet" href="/wp-content/plugins/iframe_dog/iframe_dog.css" type="text/css" media="all">
<div class="v-player" >
    <div id="iframe_dp" class="iframe_dp" >
        <iframe src="$dog_video" frameborder="0" allowfullscreen="" scrolling="none">
        </iframe>
    </div>
    <div class="listSkip">
    $dog_html
    </div>
</div>

EOF;
}
?>
