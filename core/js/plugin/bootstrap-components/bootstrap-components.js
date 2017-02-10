(function(factory){
    if(typeof define==='function'&&define.amd){
        define(['jquery'],factory);
    }else if(typeof module==='object'&&module.exports){
        module.exports=factory(require('jquery'));
    }else{
        factory(window.jQuery);
    }
}(function($){
    $.extend($.summernote.options,{
        bootstrapComponents:{
            icon:'libre libre-social-blogger',
            name:'Bootstrap Components',
            tooltip:'Bootstrap Components',
            path:'core/js/plugin/bootstrap-components/'
        }
    });
    $.extend($.summernote.plugins,{
        'bootstrapComponents':function(context){
            var self=this;
            var ui=$.summernote.ui;
            var $editor=context.layoutInfo.editor;
            var options=context.options.bootstrapComponents;
            context.memo('button.bootstrapComponents',function(){
                return ui.button({
                    contents:'<i class="'+options.icon+'"/>',
                    tooltip:options.tooltip,
                    click: context.createInvokeHandler('bootstrapComponents.showDialog')
                }).render();
            });
            self.initialize=function(){
                var $container=options.dialogsInBody?$(document.body):$editor;
                var modalHTML='<div class="panel panel-default">'+
                    '<div class="panel-body">'+
                        '<a href="#"><i class="libre libre-alien"></i></a>'+
                    '</div>'+
                    '</div>';
                self.$dialog=ui.dialog({
                    title:options.name,
                    fade:options.dialogsFade,
                    body:modalHTML,
                    footer:''
                }).render().appendTo($container);
            };
            self.destroy=function(){
                self.$dialog.remove();
                self.$dialog=null;
            };
            self.showDialog=function(){
                self.openDialog()
                    .then(function(dialogData){
                        ui.hideDialog(self.$dialog);
                        context.invoke('editor.restoreRange');
                        console.log("dialog returned:",dialogData)
                    })
                    .fail(function(){
                        context.invoke('editor.restoreRange');
                    });
            };
            self.openDialog=function(){
                return $.Deferred(function(deferred){
                    var $dialogBtn=self.$dialog.find('.ext-bootstrapComponents-btn');
                    ui.onDialogShown(self.$dialog,function(){
                        context.triggerEvent('dialog.shown');
                        $dialogBtn
                        .click(function(event){
                            event.preventDefault();
                            deferred.resolve({action:'Boostrap Components dialog OK clicked...'});
                        });
                    });
                    ui.onDialogHidden(self.$dialog,function(){
                        $dialogBtn.off('click');
                        if(deferred.state()==='pending'){
                            deferred.reject();
                        }
                    });
                    ui.showDialog(self.$dialog);
                });
            };
        }
    });
}));
