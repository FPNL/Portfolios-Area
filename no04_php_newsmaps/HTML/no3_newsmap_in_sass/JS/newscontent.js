$('.input-item').on('keyup',function(){
    $(this).removeClass('empty')
    if($(this).text() == ""){
        $(this).addClass('empty')
    }
})

$('.input-item').on('keyup',function(event){
    if($(this).text().length >= $(this).attr('data-length')){
        var text = $(this).text().substr(0, $(this).attr('data-length'));
        $(this).text(text);
        // 截取后将光标放到最后
        var _this = $(this)[0]
        _this.focus();
        if($.support.msie)
        {
            var range = document.selection.createRange();
            this.last = range;
            range.moveToElementText(_this);
            range.select();
            document.selection.empty(); //取消选中
        }
        else
        {
            var range = document.createRange();
            range.selectNodeContents(_this);
            range.collapse(false);
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }
})
