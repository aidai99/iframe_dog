     
$(document).ready(function(){
    var url=location.href;           //当前url
    var video_page=/.*#(\d+)$/.exec(url);   //正则查找
   var objSelect = document.getElementById("selselect");

    if (video_page !=null){
       objSelect.value =video_page[1];  
        url = url.replace(/#\d+$/i,"");
        $(".iframe_dp iframe").attr("src",$("option[value = '"+$('select#selselect').val()+"']").attr("data-video"));
    }else{
        $(".iframe_dp iframe").attr("src",$("option[value = '"+$('select#selselect').val()+"']").attr("data-video"));
    }
    $(".d-player .listSkip select").change(function(){   
      var video=  $(this).val();
      $(".iframe_dp iframe").attr("src",$("select#selselect option:selected").attr("data-video")); 
          document.location.href=url+"#"+video
        });   
      $("a.before").click(function(){  
        q= $(".d-player .listSkip select").find("option:selected").val();   //当前option的value
        if(q !=1){
        q2=(--q);  
        objSelect.value =q2; //触发select
        document.location.href=url+"#"+(q2)   //改变url
        $(".iframe_dp iframe").attr("src",$(".d-player .listSkip select option[value = '"+$('select#selselect').val()+"']").attr("data-video"));
	}
    });
    $("a.under").click(function(){     
       v= $(".d-player .listSkip select").find("option:selected").val();
       v1=$(".d-player .listSkip select option:last").val();//获取select最后一个value
       if(v !=v1){
        v2=(++v);
        objSelect.value =v2; //触发select
        document.location.href=url+"#"+v2   //改变url
        $(".iframe_dp iframe").attr("src",$("option[value = '"+$('#selselect').val()+"']").attr("data-video"));
	}
    });
});