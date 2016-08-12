(function(factory){
    if(typeof define==='function'&&define.amd){
        define(['jquery'],factory)
    }else if(typeof module==='object'&&module.exports){
        module.exports=factory(require('jquery'));
    }else{
        factory(window.jQuery)
    }
}
(function($){
    $.extend(true,$.summernote.lang,{
        'en-US':{
            save:{
                tooltip:'Save'
            }
        }
    });
    $.extend($.summernote.options,{
      save:{
        icon:'<i class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" id="libre-floppy" viewBox="0 0 14 14"><path d="m 4,12 h 6 V 9 H 4 v 3 z m 7,0 h 1 V 5 Q 12,4.890625 11.9219,4.699219 11.8438,4.507813 11.76564,4.429688 L 9.57033,2.234375 Q 9.49223,2.156245 9.30471,2.078125 9.11719,2 9,2 V 5.25 Q 9,5.5625 8.78125,5.78125 8.5625,6 8.25,6 H 3.75 Q 3.4375,6 3.21875,5.78125 3,5.5625 3,5.25 V 2 H 2 V 12 H 3 V 8.75 Q 3,8.4375 3.21875,8.21875 3.4375,8 3.75,8 h 6.5 Q 10.5625,8 10.78125,8.21875 11,8.4375 11,8.75 V 12 z M 8,4.75 V 2.25 Q 8,2.148438 7.9258,2.074219 7.85156,2 7.75,2 H 6.25 Q 6.14844,2 6.07422,2.07422 6,2.148438 6,2.25 v 2.5 Q 6,4.851562 6.0742,4.925781 6.14844,5 6.25,5 h 1.5 Q 7.85156,5 7.92578,4.92578 8,4.851562 8,4.75 z M 13,5 v 7.25 q 0,0.3125 -0.21875,0.53125 Q 12.5625,13 12.25,13 H 1.75 Q 1.4375,13 1.21875,12.78125 1,12.5625 1,12.25 V 1.75 Q 1,1.4375 1.21875,1.21875 1.4375,1 1.75,1 H 9 q 0.3125,0 0.6875,0.15625 0.375,0.15625 0.59375,0.375 l 2.1875,2.1875 Q 12.6875,3.9375 12.84375,4.3125 13,4.6875 13,5 z"/></svg></i>'
      }
    });
    $.extend($.summernote.plugins,{
        'save':function(context){
            var self=this;
            var ui=$.summernote.ui;
            var $note=context.layoutInfo.note;
            var $editor=context.layoutInfo.editor;
            var $editable=context.layoutInfo.editable;
            var options=context.options;
            var lang=options.langInfo;
            context.memo('button.save',function(){
                var button=ui.button({
                    contents:options.save.icon,
                    tooltip:lang.save.tooltip,
                    click:function(){
                        $("#block").css({display:"block"});
                        unsaved=false;
                        $editor.find('.note-save .btn').removeClass('btn-danger');
                        this.form.submit();
                    }
                });
                return button.render();
            });
            this.events={
                'summernote.change':function(we,e){
                    unsaved=true;
                    $editor.find('.note-save .btn').addClass('btn-danger');
                },
                'summernote.keydown':function(we,e){
                    if(e.keyCode==83&&(navigator.platform.match("Mac")?e.metaKey:e.ctrlKey)){
                        e.preventDefault();
                        $('#block').css({display:"block"});
                        unsaved=false;
                        $editor.find('.note-save .btn').removeClass('btn-danger');
                        this.form.submit();
                    }
                }
            };
        }
    });
}));
