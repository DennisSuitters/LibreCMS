(function (factory){
    if (typeof define==='function'&&define.amd){
        define(['jquery'],factory);
    }else if(typeof module==='object'&&module.exports){
        module.exports=factory(require('jquery'));
    }else{
        factory(window.jQuery);
    }
}(function($){

    $.extend(true,$.summernote.lang,{
        'en-US':{
            imageAttributes:{
                tooltip:'Image Attributes',
                title:'Title',
                alt:'Alt',
                class:'Class',
                style:'Style',
                url:'URL',
                target:'Target'
            }
        }
    });
    $.extend($.summernote.options,{
        imageAttributes:{
            icon:'<i class="note-icon-edit"/>',
            removeEmpty:true
        }
    })
    $.extend($.summernote.plugins,{
        'imageAttributes':function(context){

            var self=this;
            var ui=$.summernote.ui;
            var $note=context.layoutInfo.note;
            var $editor=context.layoutInfo.editor;
            var $editable=context.layoutInfo.editable;
            var options=context.options;
            var lang=options.langInfo;

            context.memo('button.imageAttributes',function(){
                var button=ui.button({
                    contents:options.imageAttributes.icon,
                    tooltip:lang.imageAttributes.tooltip,
                    click:function(e){
                        context.invoke('imageAttributes.show');
                    }
                });
                return button.render();
            });

            this.initialize=function(){
                var $container=options.dialogsInBody?$(document.body):$editor;
                var body=''+
                '<div class="form-group">' +
                    '<label class="control-label col-xs-2">' + lang.imageAttributes.title + '</label>' +
                    '<div class="input-group col-xs-10">' +
                        '<input class="note-image-attributes-title form-control" type="text">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="control-label col-xs-2">' + lang.imageAttributes.alt + '</label>' +
                    '<div class="input-group col-xs-10">' +
                        '<input class="note-image-attributes-alt form-control" type="text">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="control-label col-xs-2">' + lang.imageAttributes.class + '</label>' +
                    '<div class="input-group col-xs-10">' +
                        '<input class="note-image-attributes-class form-control" list="note-image-class-select" type="text">' +
                        '<div class="input-group-btn">' +
                            '<select class="note-image-attributes-class-select btn btn-default" onchange="$(\'.note-image-attributes-class\').val($(\'.note-image-attributes-class\').val()+\' \'+$(this).val());">' +
                                '<option value="">Select Class</option>' +
                                '<option value="img-responsive">Responsive</option>' +
                                '<option value="img-rounded">Rounded</option>' +
                                '<option value="img-circle">Circle</option>' +
                                '<option value="img-thumbnail">Thumbnail</option>' +
                            '</select>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="control-label col-xs-2">' + lang.imageAttributes.style + '</label>' +
                    '<div class="input-group col-xs-10">' +
                        '<input class="note-image-attributes-style form-control" type="text">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="control-label col-xs-2">' + lang.imageAttributes.url + '</label>' +
                    '<div class="input-group col-xs-10">' +
                        '<input class="note-image-attributes-href form-control" type="text" name="url">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="control-label col-xs-2">' + lang.imageAttributes.target + '</label>' +
                    '<div class="input-group col-xs-10">' +
                        '<select class="note-image-attributes-target form-control" name="target">' +
                            '<option value="_self">Self</option>' +
                            '<option value="_blank">Blank</option>' +
                            '<option value="_top">Top</option>' +
                            '<option value="_parent">Parent</option>' +
                        '</select>' +
                    '</div>' +
                '</div>';

                this.$dialog=ui.dialog({
                    title:'Image Attributes',
                    body:body,
                    footer:'<button href="#" class="btn btn-primary note-image-attributes-btn">OK</button>'
                }).render().appendTo($container);
            };

            this.destroy=function(){
                ui.hideDialog(this.$dialog);
                this.$dialog.remove();
            };

            this.bindEnterKey=function($input,$btn){
                $input.on('keypress',function(event){
                    if(event.keyCode===13){
                        $btn.trigger('click');
                    }
                });
            };

            this.show = function(){

                var $img=$($editable.data('target'));

                var imgInfo={
                    imgDom:$img,
                    title:$img.attr('title'),
                    alt:$img.attr('alt'),
                    class:$img.attr('class'),
                    style:$img.attr('style'),
                };

                this.showLinkDialog(imgInfo)
                    .then(function(imgInfo){

                        ui.hideDialog(self.$dialog);

                        var $img=imgInfo.imgDom;

                        if(options.imageAttributes.removeEmpty){
                            if(imgInfo.alt){
                                $img.attr('alt',imgInfo.alt);
                            } else {
                                $img.removeAttr('alt');
                            }

                            if(imgInfo.title){
                                $img.attr('title',imgInfo.title);
                            } else {
                                $img.removeAttr('title');
                            }

                            if(imgInfo.class){
                                $img.attr('class',imgInfo.class);
                            } else {
                                $img.removeAttr('class');
                            }

                            if(imgInfo.style){
                                $img.attr('style',imgInfo.style);
                            } else {
                                $img.removeAttr('style');
                            }

                        } else {
                            $img.attr('alt',imgInfo.alt);
                            $img.attr('title',imgInfo.title);
                            $img.attr('class',imgInfo.class);
                            $img.attr('style',imgInfo.style);
                            $img.attr('href',imgInfo.url);
                            $img.attr('target',imgInfo.target);
                        }

                        // Link
                        if ( $img.parent().is( "a" )) {
                            $img.unwrap();
                        }

                        if(imgInfo.url) {
                            $img.wrap('<a href="' + imgInfo.url + '" target="' + imgInfo.target + '"></a>');
                        }

                        $note.val(context.invoke('code'));
                        $note.change();
                    });
            };

            this.showLinkDialog = function(imgInfo){
                return $.Deferred(function(deferred){

                    var $imageTitle=self.$dialog.find('.note-image-attributes-title');
                    var $imageAlt=self.$dialog.find('.note-image-attributes-alt');
                    var $imageClass=self.$dialog.find('.note-image-attributes-class');
                    var $imageStyle=self.$dialog.find('.note-image-attributes-style');
                    var $imageUrl=self.$dialog.find('.note-image-attributes-url');
                    var $imageTarget=self.$dialog.find('.note-image-attributes-target');
                    var $editBtn=self.$dialog.find('.note-image-attributes-btn');

                    ui.onDialogShown(self.$dialog,function(){
                        context.triggerEvent('dialog.shown');

                        $editBtn.click(function(event){
                            event.preventDefault();
                            deferred.resolve({
                                imgDom : imgInfo.imgDom,
                                title : $imageTitle.val(),
                                alt : $imageAlt.val(),
                                class : $imageClass.val(),
                                style : $imageStyle.val(),
                                url : $imageUrl.val(),
                                target : $imageTarget.val()
                            });
                        });

                        self.bindEnterKey(
                            $editBtn
                        );
                    });

                    ui.onDialogHidden(self.$dialog,function(){
                        $editBtn.off('click');
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
