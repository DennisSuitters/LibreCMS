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
    'elfinder':function(context){
      var self=this;
      var ui=$.summernote.ui;
      context.memo('button.elfinder',function(){
        var button=ui.button({
          contents:'<i class="note-icon-browse-media"/>',
          tooltip:'Media Browser',
          click:function(){
            elfinderDialog(context);
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
