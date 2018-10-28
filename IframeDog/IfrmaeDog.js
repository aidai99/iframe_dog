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