/**
 * Summernote Fixed Toolbar
 *
 * This is a plugin for Summernote (www.summernote.org) WYSIWYG editor.
 * It will keep the toolbar fixed to the top of the screen as you scroll.
 *
 * @author Jason Byrne, FloSports <jason.byrne@flosports.tv>
 * Modified for newer Summernote by Studio Junkyard.s
 *
 */
(function(factory){
  if(typeof define==='function'&&define.amd){
    define(['jquery'],factory);
  }else if(typeof module==='object'&&module.exports){
    module.exports=factory(require('jquery'));
  }else{
    factory(window.jQuery);
  }
}
(function($){
  $.extend($.summernote.plugins,{
    'fixedToolbar':function(context){
      var self=this;
      var ui=$.summernote.ui;
      var $note=context.layoutInfo.note;
      var $editor=context.layoutInfo.editor;
      var repositionToolbar=function(){
        alert('fixingToolbar');
        var windowTop=$(window).scrollTop(),
            editorTop=$editor.offset().top,
            editorBottom=editorTop+$editor.height();
        if(windowTop>editorTop&&windowTop<editorBottom){
          $toolbar.css('position','fixed');
          $toolbar.css('top','0');
          $toolbar.css('width',$editor.width()+'px');
          $toolbar.css('z-index','99999');
          $editor.css('padding-top','42px');
        }else{
          $toolbar.css('position','static');
          $editor.css('padding-top','0');
        }
      };
      this.events={
        'summernote.oninit':function(layoutInfo){
          var $editor=layoutInfo.holder().siblings('.note-editor'),
              $toolbar=$editor.find('.note-toolbar');
          $(window).scrollTop(repositionToolbar);
          repositionToolbar();
        }
      }
    }
  });
}));
