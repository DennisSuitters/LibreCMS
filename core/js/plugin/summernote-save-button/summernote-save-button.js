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
        icon:'<i class="fa fa-save"/>'
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
                        $('.note-save button').removeClass('btn-danger');
                        this.form.submit();
                    }
                });
                return button.render();
            });
            this.events={
                'summernote.change':function(we,e){
                    unsaved=true;
                    $('.note-save button').addClass('btn-danger');
                }
            };
        }
    });
}));
