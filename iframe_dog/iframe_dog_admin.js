$(document).ready(function(){
	var t=$("form#my_plugin_test_form").attr("value");

	$(document).delegate("a.increase", "click", function() {	//动态触发效果
		$("input.button.button-primary").before('<table border="1" class="dp_increase'+t+'" style="width:100%;border-color: #fff; border-spacing: 0;"><tbody><th style="width:10%"><label for="test_insert_options">正则:</label></th><th style="width:20%">  <input type="text" name="iframe_dog[name][]" value="" style="width:100%" /></th><th style="width:10%"><label for="test_insert_options">框架地址:</label></th><th style="width:40%"><input type="text" name="iframe_dog[url][]" value="" style="width:100%" /></th><th style="width:10%"><a class="increase" value="'+t+'" style="float: left;width: 50%;font-size:2rem">+</a><a class="delete" value="'+t+'"  style="font-size: 2rem;">-</a></th></tbody></table>');
		t=++t;
	});
	$(document).delegate("a.delete", "click", function() {	//动态触发效果
		p=$(this).attr("value");
		$(".dp_increase"+p).remove();
   	 });
    });

    