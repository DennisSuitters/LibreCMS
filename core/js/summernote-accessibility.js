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
  $.extend(true,$.summernote.lang,{
    'en-US':{
      accessibility:{
        tooltip:'Check Accessibility',
        cmsinfo:'<div class="alert alert-default">As it is recommended for LibreCMS Themes to use HTML5 and display the editor content within <code>&lt;main&gt;&lt;/main&gt;</code> element, this Accessibility tester only checks for Accessibility issue\'s for elements that are allowed within the <code>&lt;main&gt;&lt;/main&gt;</code> element.</div>'
      }
    }
  });
  $.extend($.summernote.options,{
    accessibility:{
      icon:'<i class="note-icon" data-toggle="accessbility"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" id="libre-accessibility"><path d="m 6.9999997,1 c -0.620817,0 -1.125,0.50296 -1.125,1.125 0,0.62204 0.502959,1.126 1.125,1.125 0.620816,0 1.1250001,-0.50296 1.1250001,-1.125 C 8.1249998,1.50418 7.6220407,1 6.9999997,1 Z m -5.0878906,1.38867 -0.2792969,0.69727 3.8652344,1.66797 0,3.00195 L 3.9589841,12.73438 4.6621091,13 6.8398435,8.13086 l 0.3222656,0 L 9.3378903,13 10.041016,12.73438 8.5019528,7.75391 l 0,-3 3.8652352,-1.66797 -0.279297,-0.69727 -4.7128913,1.61328 -0.75,0 -4.7128906,-1.61328 z"/></svg></i>'
    }
  });
  $.extend($.summernote.plugins,{
    'accessibility':function(context){
      var self=this;
      var ui=$.summernote.ui;
      var $note=context.layoutInfo.note;
      var $editor=context.layoutInfo.editor;
      var options=context.options;
      var lang=options.langInfo;
      var cleanText=function(txt,nlO){}
      context.memo('button.accessibility',function(){
        var button=ui.button({
          contents:options.accessibility.icon,
          tooltip:lang.accessibility.tooltip,
          click:function(e){
            e.preventDefault();
            var toolButton=$(this);
            if($(this).hasClass('btn-success')){
                $(this).removeClass('btn-success');
                $('.note-btn').removeClass('disabled').attr("disabled",false);
                var showPopover='destroy';
                var items=$(".note-editing-area *");
                $.each(items,function(index,item){
                    $(this).removeClass('accessibility-error error');
                    $(this).removeAttr("data-attrnum");
                    if(!$(this).attr("class"))$(this).removeAttr("class");
                });
            }else{
                $(this).addClass('btn-success');
                $('.note-btn').addClass('disabled').attr("disabled",true);
                $(this).removeClass('disabled').attr("disabled",false);
                var showPopover='show';
                var items=$(".note-editable *")
                var i=1;
                var errorText='';
// https://specs.webplatform.org/html-aria/webspecs/master/
// http://www.tutorialrepublic.com/html-reference/html5-tags.php
                $.each(items,function(index,item){
                    var attrs=getAttributes($(this));
/* a
  deprecated = charset|coords|name|code|rev|shape
  download =
  href =
  hreflang =
  media =
  rel = alternate|author|bookmark|help|license|next|nofollow|noreferrer|prefetch|prev|search|tag
  target = _blank|_parent|_self|_top|{framename}
  type = {content-type}
  role = link|button|checkbox|menuitem|menuitemcheckbox|menuitemradio|tab|switch|treeitem
*/
                    if($(this).is('a')){
                      var error='';
                      if($(this).attr('charset'))error+='<div id="acharset'+i+'" class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;charset&gt;</code> attribute is Deprecated. <div class="pull-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'charset\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div>';
                      if($(this).attr('coords'))error+='<div id="acoords'+i+'" class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;coords&gt;</code> attribute is Deprecated. <div class="pull-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'coords\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div>';
                      if($(this).attr('name'))error+='<div id="aname'+i+'" class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;name&gt;</code> attribute is Deprecated. Use the Global Attribute <code>id</code> instead. <div class="pull-right"><button class="btn btn-default add" onclick="if(!$(\'[data-attrnum='+i+']\').attr(\'id\')){$(\'[data-attrnum='+i+']\').attr(\'id\',$(\'[data-attrnum='+i+']\').attr(\'name\'));}$(\'[data-attrnum='+i+']\').removeAttr(\'name\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div>';
                      if($(this).attr('rev'))error+='<div id="arev'+i+'" class="alert alert-danger" data-attrernum="'+i+'">The <code>rev</code> attribute is Deprecated. <div class="pull-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'rev\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div>';
                      if($(this).attr('shape'))error+='<div id="ashape'+i+'" class="alert alert-danger" data-attrernum="'+i+'">The <code>shape</code> attribute is Deprecated. <div class="pull-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'shape\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div>';
                      if(!$(this).attr('href')){
                        if($(this).attr('role'))error+='<div class="alert alert-danger" data-attrernum="'+i+'">This link element does not contain an <code>href</code> attribute, and unnessarily contains a <code>role</code> attribute.</div>';
                        if($(this).attr('target'))error+='<div class="alert alert-danger" data-attrernum="'+i+'">This link element does not contain an <code>href</code> attribute, and unnessarily contains a <code>target</code> attribute.</div>';
                      }
                      if($(this).attr('hreflang')){

                      }
                      if($(this).attr('download')){

                      }
                      if($(this).attr('role')){
                        var val=$(this).attr('role');
                        var allval=["link","button","checkbox","menuitem","menuitemcheckbox","menuitemradio","tab","switch","treeitem"];
                        if(allval.indexOf(val)==-1)error+='<div class="alert alert-danger" data-attrernum="'+i+'">The value &quot;'+val+'&quot; used in the <code>role</code> attribute is not an allowed value.<div class="input-group col-xs-4 pull-right"><select id="aroleselect'+i+'" class="form-control"><option value="link">link</option><option value="button">button</option><option value="checkbox">checkbox</option><option value="menuitem">menuitem</option><option value="menuitemcheckbox">menuitemcheckbox</option><option value="menuitemradio">menuitemradio</option><option value="tab">tab</option><option value="switch">switch</option><option value="treeitem">treeitem</option></select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'role\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div></div>';
                        if(val=='link')error+='<div class="alert alert-info" data-attrernum="'+i+'">The value <code>role=&quot;link&quot;</code> is an allowed value, although it isn\'t necessary as it is already implied.</div>';
                      }
                      if($(this).attr('rel')){
                        var val=$(this).attr('rel');
                        var allval=["alternate","author","bookmark","follow","help","license","next","nofollow","noreferrer","prefetch","prev","search","tag"];
                        if(allval.indexOf(val)==-1)error+='<div class="alert alert-danger" data-attrernum="'+i+'">The value &quot;'+val+'&quot; used in the <code>rel</code> attribute is not an allowed value. Allowed values are  &quot;alternate|author|bookmark|help|license|next|nofollow|noreferrer|prefetch|prev|search|tag&quot;</div>';
                        if(val=='follow')error+='<div class="alert alert-info" data-attrernum="'+i+'">The value <code>rel=&quot;follow&quot;</code> is an allowed value, although it isn\'t necessary as it is already implied.</div>';
                      }
                      if($(this).attr('target')){
                        var val=$(this).attr('target');
                        var allval=["_blank","_parent","_self","_top"];
                        if(allval.indexOf(val)==-1)error+='<div class="alert alert-info" data-attrernum="'+i+'">This link contains a <code>target</code> attribute, but does not contain a recommended value of &quot;_blank| |_parent|_self|_top&quot;. While it is possible to name a frame to target, it is no longer a safe recommendation.</div>';
                      }
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* address */
                    if($(this).is('address')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* area */
                    if($(this).is('area')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* article
  role = [article]|presentation|document|application|main|region
*/
                    if($(this).is('article')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* aside
  role = [complementary]|note|region|search
*/
                    if($(this).is('aside')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* blockquote */
                    if($(this).is('blockquote')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* button
  type = menu
  role = [button]|link|menuitem|menuitemcheckbox|menuitemradio|radio
*/
                    if($(this).is('button')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* caption */
                    if($(this).is('caption')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* center
  Deprecated
*/
                    if($(this).is('center')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* col */
                    if($(this).is('col')){
                      var error='';
                      if(error){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        errorText=errorText+error;
                        i++;
                      }
                    }
/* colgroup */
                  if($(this).is('colgroup')){
                    var error='';
                    if(error){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      errorText=errorText+error;
                      i++;
                    }
                  }
/* datalist
  role = [listbox]
 */
                 if($(this).is('datalist')){
                   var error='';
                   if(error){
                     $(this).addClass('accessibility-error error');
                     $(this).attr("data-attrnum",i);
                     errorText=errorText+error;
                     i++;
                   }
                 }
/* del */
                if($(this).is('del')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* dd */
                if($(this).is('article')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* dt */
                if($(this).is('dt')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* details
  role = group
*/
                if($(this).is('details')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* dialog
  role = [dialog]|alertdialog
*/
                if($(this).is('dialog')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* div */
                if($(this).is('div')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* dl
  role = list
*/
                if($(this).is('dl')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* embed
  role =  application|document|presentation|img
*/
                if($(this).is('embed')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
/* figure */
                if($(this).is('figure')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* footer
    role = [contentinfo]
  */
                if($(this).is('footer')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* form
    role = [form]
  */
                if($(this).is('form')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* p */
                if($(this).is('p')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* pre */
                if($(this).is('pre')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* h1 to h6
    role = [heading]|tab|presentation
  */
                if($(this).is('h1')){
                  var error='';
                  error+='<div class="alert alert-info" data-attrnum="'+i+'">Using an <code>H1</code> element is unneccessary in LibreCMS as long as the theme is setup to to include the title of the content within a <code>H1</code> element.</div>';
                  if(!$(this).attr('role'))error+='<div class="alert alert-danger" data-attrnum="'+i+'">Headings should contain a <code>role="heading"</code> attribute.</div>';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
                if($(this).is('h2,h3,h4,h5,h6')){
  //                    errorText=+'<div class="alert alert-danger" data-attrnum="'+i+'">Should heading start with H1:H6</div>';
                  $(this).addClass('accessibility-error error');
                  $(this).attr("data-attrnum",i);
                  i++;
                }

  /* head */
                if($(this).is('head')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* header
    role = [banner]
  */
                if($(this).is('header')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* hr
    role = [separator]
  */
                if($(this).is('hr')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* iframe
    role = application|document|img
  */
                if($(this).is('iframe')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* img
    alt
    src
    role = [img]
  */
                if($(this).is('img')){
                  var error='';
                  if(!$(this).attr('src'))error+='<div class="alert alert-danger" data-attrnum="'+i+'">Images Should Contain a src=value</div>';
                  if(!$(this).attr('alt'))error+='<div class="alert alert-danger" data-attrnum="'+i+'">Images Should Contain an alt=value</div>';
                  if(error!=''){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* input[button]
    type = button
      role = [button]|link, menuitem, menuitemcheckbox, menuitemradio, radio or switch
    type = checkbox
      role = [checkbox], menuitemcheckbox or switch
    type = color
    type = date
    type = datetime
    type = email
      role = [textbox]
    type = file
    type = hidden
    type = image
      role = [button], link, menuitem, menuitemcheckbox, menuitemradio, radio or switch
    type = month
    type = number
      role = spinbutton
    type = password
      role = [textbox]
    type = radio
      role = [radio],menuitemradio
    type = range
      role = [slider]
    type = reset
      role = [button]
    type = search
      role = [textbox]
    type = submit
      role = [button]
    type = tel
      role = [textbox]
    type = text
      role = [textbox]
    type = text,search,tel,url,email with list attribute
      role = [combobox]
    type = time
    type = url
      role = [textbox]
    type = week
  */
                if($(this).is('input')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* ins */
                if($(this).is('ins')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* keygen */
                if($(this).is('keygen')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* label */
                if($(this).is('label')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* li
    role = [listitem], menuitem, menuitemcheckbox, menuitemradio, option, separator, tab, or treeitem
  */
                if($(this).is('li')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* main
    role = [main]
  */
                if($(this).is('main')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* map */
                if($(this).is('map')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* math
    role = [math]
  */
                if($(this).is('math')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* menu
    type = toolbar
    role = toolbar
  */
                if($(this).is('menu')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* menuitem
    type = command
      role = menuitem
    type = checkbox
      role = menuitemcheckbox
    type = radio
      role = menuitemradio
  */
                if($(this).is('menuitem')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* meta */
                if($(this).is('meta')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* meter
    role = [progressmeter]
  */
                if($(this).is('meter')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* nav
    role = [navigation]
  */
                if($(this).is('nav')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* noscript */
                if($(this).is('noscript')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* object
    role =  application, document, or img
  */
                if($(this).is('object')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* ol
    role = [list], directory, group, listbox, menu, menubar, tablist, toolbar or tree
  */
                if($(this).is('ol')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* optgroup */
                if($(this).is('optgroup')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* option
    role = [option]
  */
                if($(this).is('option')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* output
    role = status
  */
                if($(this).is('article')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* p */
                if($(this).is('p')){
                  var error='';
                  if(error!=''){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* param */
                if($(this).is('param')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* picture */
                if($(this).is('picture')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* progress
    role = progressbar
  */
                if($(this).is('progress')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* script */
                if($(this).is('script')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* section
    role = [region], alert, alertdialog, application, contentinfo, dialog, document, log, marquee, search, or status
  */
                if($(this).is('section')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* select
    role = [listbox]
  */
                if($(this).is('select')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* source */
                if($(this).is('source')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* span */
                if($(this).is('span')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* style */
                if($(this).is('style')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* svg
    role = application, document, or img
  */
                if($(this).is('svg')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* summary
    role = [button]
  */
                if($(this).is('summary')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* table */
                if($(this).is('table')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* template */
                if($(this).is('template')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* textarea
    role = [textbox]
  */
                if($(this).is('textarea')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* tbody
    role = rowgroup
  */
                if($(this).is('tbody')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* thead
    role = rowgroup
  */
                if($(this).is('thead')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /*  tfoot
      role = rowgroup
  */
                if($(this).is('tfoot')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* title */
                if($(this).is('title')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* td */
                if($(this).is('td')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* th */
                if($(this).is('th')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* tr */
                if($(this).is('tr')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* em */
                if($(this).is('em')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* strong */
                if($(this).is('strong')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* small */
                if($(this).is('small')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /*  s */
                if($(this).is('s')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* cite */
                if($(this).is('cite')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* q */
                if($(this).is('q')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* dfn */
                if($(this).is('dfn')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* abbr */
                if($(this).is('abbr')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* time */
                if($(this).is('time')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* code */
                if($(this).is('code')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* var */
                if($(this).is('var')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* samp */
                if($(this).is('samp')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* kbd */
                if($(this).is('kbd')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* sub */
                if($(this).is('sub')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* sup */
                if($(this).is('sup')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* i */
                if($(this).is('i')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* b
    Deprecated
   */
                if($(this).is('b')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* u */
                if($(this).is('u')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* mark */
                if($(this).is('mark')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* ruby */
                if($(this).is('ruby')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* rt */
                if($(this).is('rt')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* rp */
                if($(this).is('rp')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* bdi */
                if($(this).is('bdi')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* bdo */
                if($(this).is('bdo')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* br */
                if($(this).is('br')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* wbr */
                if($(this).is('wbr')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* th
    role = columnheader or rowheader
  */
                if($(this).is('th')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* tr */
                if($(this).is('tr')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* track */
                if($(this).is('track')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* ul
    role = [list],directory, group, listbox, menu, menubar, tablist, toolbar, tree, presentation
  */
                if($(this).is('ul')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }
  /* video
    role = application
  */
                if($(this).is('video')){
                  var error='';
                  if(error){
                    $(this).addClass('accessibility-error error');
                    $(this).attr("data-attrnum",i);
                    errorText=errorText+error;
                    i++;
                  }
                }







                  });
                }
                if(errorText==''){
                  errorText=lang.accessibility.cmsinfo+'<div class="alert alert-success">Congratulations! There are no Accessibility Errors!</div>';
                }else{
                  errorText=lang.accessibility.cmsinfo+errorText;
                }
                $('[data-toggle="accessbility"]').popover({
                  html:true,
                  trigger:'click',
                  title:'Accessibility Results',
                  container:'body',
                  placement:'top',
                  template:'<div class="popover accessibility" role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                  content:errorText
                }).popover(showPopover);
            }
        });
        return button.render();
      });
    }
  });
}));
function getAttributes ( $node ) {
    var attrs = {};
    $.each( $node[0].attributes, function ( index, attribute ) {
        attrs[attribute.name] = attribute.value;
    } );

    return attrs;
}
