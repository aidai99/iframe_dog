<?php
/*
Plugin Name: iframe_dog
Plugin URI: #
Description: iframe_dog
Version: 2.1
Author: Carseason
Author URI: #
*/    
//后台管理
error_reporting(E_ALL^E_NOTICE^E_WARNING);//隐藏错误提示
$video_url=get_option('iframe_dog')['url'];
$video_name=get_option('iframe_dog')['name'];
$t=count($video_name);
add_action('admin_menu', 'dashboard_submenu');
function dashboard_submenu() {
    add_options_page(__('iframe_dog'), __('iframe_dog'), 'read', 'your-unique-identifier', 'add_dashboard_submenu');  //add_options_page是在设置下添加插件
}
function add_dashboard_submenu() {

 global $video_url,$video_name,$t;
 echo <<<EOF
 <script src="/wp-content/plugins/iframe_dog/jquery-3.3.1.min.js"></script>
 <script src="/wp-content/plugins/iframe_dog/iframe_dog_admin.js"></script>
 <h2>添加数据</h2>
 <form action="" method="post" id="my_plugin_test_form" value="$t">
EOF;
if($t==0){
    $t=1;
}
for($i=0;$i<$t;$i++){
   echo <<<EOF
   <table border="1" class="dp_increase$i" style="width:100%;border-color: #fff; border-spacing: 0;">
   <tbody>
   <th style="width:10%"><label for="test_insert_options">正则:</label></th>
   <th style="width:20%">  <input type="text" name="iframe_dog[name][]" value="$video_name[$i]" style="width:100%" /></th>
   <th style="width:10%"><label for="test_insert_options">框架地址:</label></th>
   <th style="width:40%"><input type="text" name="iframe_dog[url][]" value="$video_url[$i]" style="width:100%" /></th>
   <th style="width:10%"><a class="increase" value="$i" style="float: left;width: 50%;font-size:2rem">+</a><a class="delete" value="$i" style="font-size: 2rem;">-</a></th>
   </tbody>
   </table>
EOF;
}
echo <<<EOF
<input type="submit" name="submit" value="保存" class="button button-primary" />
<input type="hidden" name="test_hidden" value="dogup"  />
</form>
EOF;
  if($_POST['test_hidden'] == 'dogup') {  
        update_option('iframe_dog',$_POST['iframe_dog']); //更新你添加的数据库,字段,数据,数据为input里的name
        echo <<<EOF
        <div id="message" style="color: #000;">保存成功 !</div>
       <script>location.reload();</script>
     
EOF;
    }

}

add_shortcode('loc', 'iframe_dog');
add_shortcode('dog', 'iframe_dog');
//挂载短代码
//acgloc为短代码名称,dplayerdog为函数
//即你在编辑文章时输入[acgloc]就会执行 dplayer_dog 函数
function iframe_dog($array_url_title) {//短代码要处理的函数
    global $video_url,$video_name,$t;
    $dog_url= explode(',',$array_url_title["url"]); //文章url短代码链接,以英文逗号分割
    $dog_name= explode(',',$array_url_title["name"]);//文章短代码名字,以英文逗号分割
    $dog_url_i=  count($dog_url);   //获取数量
    $dog_name_i= count($dog_name);  //获取数量
    $dog_i=($dog_url_i > $dog_name_i) ? $dog_url_i:$dog_name_i; //三元比较
    $dog_html = "";
    $video="";
    for($i=0;   $i<$dog_i;  $i++){
        global  $dog_html,$video;
            for($j=0;$j<$t;$j++){
               if(preg_match("/".$video_name[$j]."/i",$dog_url[$i])&&$video_name[$j] !=""){
                   $video=$video_url[$j];
                   break;
                }else{
                    continue;
                }
            }   
            $dog_html .=  '<option value="'.($i+1).'" data-video="'.$video.$dog_url[$i].'">'.$dog_name[$i].'</option>';
    }

return <<<EOF
<script src="/wp-content/plugins/iframe_dog/jquery-3.3.1.min.js"></script>
<script src="/wp-content/plugins/iframe_dog/iframe_dog.js"></script>
<link rel="stylesheet" href="/wp-content/plugins/iframe_dog/iframe_dog.css" type="text/css" media="all">
<div class="d-player">
    <div href="javascript:void(0)" class="listSkip">
	<a class="before">上一集</a>
        <select id="selselect">
        $dog_html
        </select>
    <a href="javascript:void(0)" class="under">下一集</a>
    </div>
    <div class="iframe_dp">
        <iframe src="" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"></iframe>
    </div>
</div>
EOF;
}
?>
<?php
 add_action('after_wp_tiny_mce', 'bolo_after_wp_tiny_mce');
 
 function bolo_after_wp_tiny_mce($mce_settings) {
    ?>
    
    <script type="text/javascript">  
    QTags.addButton('dplayerin','插入框架狗','[loc url="" name=""]','');  
    </script>
   
    <?php
}