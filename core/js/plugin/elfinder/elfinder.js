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
    $.extend($.summernote.plugins,{
        'media':function(context){
            var self=this;
            var ui=$.summernote.ui;
            context.memo('button.media',function(){
                var button=ui.button({
                    contents:'<i class="fa fa-folder"/>',
                    tooltip:'Media Browser',
                    click:function(){
                        mediaDialog();
                    }
                });
                var $elfinder=button.render();
                return $elfinder;
            });
            this.destroy=function(){
                this.$panel.remove();
                this.$panel=null;
            };
        }
    });
}));
