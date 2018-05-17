<?php
/*
Plugin Name: iframe_dog
Plugin URI: #
Description: 嵌套ifame视频
Version: 1.0
Author: Carseason
Author URI: https://github.com/Carseason/iframe_dog
*/
add_shortcode('dog', 'iframe_dog');
//挂载短代码
//dog为短代码名称,iframe_dog为函数
//即你在编辑文章时输入[dog]就会执行 iframe_dog 函数
function iframe_dog($array_url_title) {//短代码要处理的函数

    wp_enqueue_style('iframe_dog', plugins_url('iframe_dog.css', __FILE__), false, '');   //引用js
    wp_enqueue_script('iframe_dog', plugins_url('iframe_dog.js', __FILE__), false, '');   //引用css
    $dog_url= explode(',',$array_url_title["url"]); //文章url短代码链接,以英文逗号分割
    $dog_name= explode(',',$array_url_title["name"]);//文章短代码名字,以英文逗号分割
    $dog_url_i=  count($dog_url);   //获取数量
    $dog_name_i= count($dog_name);  //获取数量
    $dog_i=($dog_url_i > $dog_name_i) ? $dog_url_i:$dog_name_i; //三元比较
    $dog_html = "";
    for(    $i=0;   $i<$dog_i;  $i++){
        global  $dog_html;
        $dog_html .=  '<div class="d_video" onclick="iframedog(\''.$dog_url[$i].'\');" title="'.$dog_name[$i].'"><a>'.$dog_name[$i].'</a></div>';
    }
   // echo $dog_html;
    echo '<div class="v-player" ><div class="listSkip">'.$dog_html.'</div><div id="iframe" class="iframe" ><iframe src="'.$dog_url[0].'" frameborder="0" allowfullscreen="" scrolling="none"></iframe></div></div>';


  // return $array_url_title["url"].$array_url_title["name"];


}

//[dog url="1,2" name="第01集,第02集" ]
?>
