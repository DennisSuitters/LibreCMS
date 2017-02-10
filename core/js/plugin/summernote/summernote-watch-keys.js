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
  });
  $.extend($.summernote.options,{
  });
  $.extend($.summernote.plugins,{
    'watcher':function(context){
      var ui=$.summernote.ui;
      var $note=context.layoutInfo.note;
      var $editor=context.layoutInfo.editor;
      var options=context.options;
      var lang=options.langInfo;
      this.events={
        'summernote.keydown':function(we,e){
          if(e.keyCode==8){
//            e.preventDefault();

            alert('backspace');
          }
        }
      };
    }
  });
}));
