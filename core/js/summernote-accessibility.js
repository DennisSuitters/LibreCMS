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
                var items=$(".note-editable *");
                var i=1;
                var popTxt='';
                var langval=['ab','aa','af','ak','sq','am','ar','an','hy','as','av','ae','ay','az','bm','ba','eu','be','bn','bh','bi','bs','br','bg','my','ca','ch','ce','ny','ny','ny','zh','zh-Hans','zh-Hant','cv','kw','co','cr','hr','cs','da','dv','dv','dv','nl','dz','en','eo','et','ee','fo','fj','fi','fr','ff','ff','ff','ff','gl','gd','gv','ka','de','el','kl','gn','gu','ht','ha','hz','hi','ho','hu','is','io','ig','id','in','ia','ie','iu','ik','ga','it','ja','jv','kl','kl','kn','kn','kr','ks','kk','km','ki','rw','rn','ky','kv','kg','ko','ku','kj','lo','la','lv','li','ln','lt','lu','lg','lg','lb','gv','mk','mg','ms','ml','mt','mi','mr','mh','mo','mn','na','nv','ng','nd','ne','no','nb','nn','ii','oc','oj','cu','cu','or','om','os','pi','ps','ps','fa','pl','pt','pa','qu','rm','ro','ru','se','sm','sg','sa','sr','sh','st','tn','sn','ii','sd','si','so','nr','es','su','sw','ss','sv','ti','ty','tg','ta','tt','te','th','bo','ti','to','ts','tr','tk','tw','ug','uk','ur','uz','ve','vi','vo','wa','cy','wo','fy','xh','yi','ji','yo','za','za','zu'];
                var langname=['Abkhazian','Afar','Afrikaans','Akan','Albanian','Amharic','Arabic','Aragonese','Armenian','Assamese','Avaric','Avestan','Aymara','Azerbaijani','Bambara','Bashkir','Basque','Belarusian','Bengali (Bangla)','Bihari','Bislama','Bosnian','Breton','Bulgarian','Burmese','Catalan','Chamorro','Chechen','Chichewa','Chewa','Nyanja','Chinese','Chinese (Simplified)','Chinese (Traditional)','Chuvash','Cornish','Corsican','Cree','Croatian','Czech','Danish','Divehi','Dhivehi','Maldivian','Dutch','Dzongkha','English','Esperanto','Estonian','Ewe','Faroese','Fijian','Finnish','French','Fula','Fulah','Pulaar','Pular','Galician','Gaelic (Scottish)','Gaelic (Manx)','Georgian','German','Greek','Greenlandic','Guarani','Gujarati','Haitian Creole','Hausa','Hebrew','Herero','Hindi','Hiri Motu','Hungarian','Icelandic','Ido','Igbo','Indonesian','Indonesian','Interlingua','Interlingue','Inuktitut','Inupiak','Irish','Italian','Japanese','Javanese','Kalaallisut','Greenlandic','Kannada','Kanuri','Kashmiri','Kazakh','Khmer','Kikuyu','Kinyarwanda (Rwanda)','Kirundi','Kyrgyz','Komi','Kongo','Korean','Kurdish','Kwanyama','Lao','Latin','Latvian (Lettish)','Limburgish ( Limburger)','Lingala','Lithuanian','Luga-Katanga','Luganda','Ganda','Luxembourgish','Manx','Macedonian','Malagasy','Malay','Malayalam','Maltese','Maori','Marathi','Marshallese','Moldavian','Mongolian','Nauru','Navajo','Ndonga','Northern Ndebele','Nepali','Norwegian','Norwegian bokmål','Norwegian nynorsk','Nuosu','Occitan','Ojibwe','Old Church Slavonic','Old Bulgarian','Oriya','Oromo (Afaan Oromo)','Ossetian','Pāli','Pashto','Pushto','Persian (Farsi)','Polish','Portuguese','Punjabi (Eastern)','Quechua','Romansh','Romanian','Russian','Sami','Samoan','Sango','Sanskrit','Serbian','Serbo-Croatian','Sesotho','Setswana','Shona','Sichuan Yi','Sindhi','Sinhalese','Siswati','Slovak','Slovenian','Somali','Southern Ndebele','Spanish','Sundanese','Swahili (Kiswahili)','Swati','Swedish','Tagalog','Tahitian','Tajik','Tamil','Tatar','Telugu','Thai','Tibetan','Tigrinya','Tonga','Tsonga','Turkish','Turkmen','Twi','Uyghur','Ukrainian','Urdu','Uzbek','Venda','Vietnamese','Volapük','Wallon','Welsh','Wolof','Western Frisian','Xhosa','Yiddish','Yiddish','Yoruba','Zhuang','Chuang','Zulu'];
                $.each(items,function(index,item){
/* a */
                  if($(this).is('a')){
                    var er='';
                    if($(this).attr('charset'))er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>charset</code> attribute is Deprecated.</div><div class="col-xs-4 text-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'charset\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div><div class="clearfix"></div></div>';
                    if($(this).attr('coords'))er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>coords</code> attribute is Deprecated.</div><div class="col-xs-4 text-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'coords\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div><div class="clearfix"></div></div>';
                    if($(this).attr('name'))er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>name</code> attribute is Deprecated. Use the Global Attribute <code>id</code> instead.</div><div class="col-xs-4 text-right"><button class="btn btn-default add" onclick="if(!$(\'[data-attrnum='+i+']\').attr(\'id\')){$(\'[data-attrnum='+i+']\').attr(\'id\',$(\'[data-attrnum='+i+']\').attr(\'name\'));}$(\'[data-attrnum='+i+']\').removeAttr(\'name\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div><div class="clearfix"></div></div>';
                    if($(this).attr('rev'))er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>rev</code> attribute is Deprecated.</div><div class="col-xs-4 text-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'rev\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div><div class="clearfix"></div></div>';
                    if($(this).attr('shape'))er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>shape</code> attribute is Deprecated.</div><div class="col-xs-4 text-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').removeAttr(\'shape\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div><div class="clearfix"></div></div>';
                    if(!$(this).attr('href')){
                      if($(this).attr('role'))er+='<div class="alert alert-danger" data-attrernum="'+i+'">This link element does not contain a <code>href</code> attribute, and unnessarily contains a <code>role</code> attribute.</div>';
                      if($(this).attr('target'))er+='<div class="alert alert-danger" data-attrernum="'+i+'">This link element does not contain an <code>href</code> attribute, and unnessarily contains a <code>target</code> attribute.</div>';
                    }
                    if($(this).attr('hreflang')){
                      if(!$(this).attr('href'))er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>hreflang</code> should only be used when the <code>href</code> attribute is present. The <code>hreflang</code> specifies the language of the linked document.</div>';
                      if(langval.indexOf($(this).attr('hreflang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('hreflang')+'&quot; used in the <code>hreflang</code> attribute is not an allowed value.<br> The <code>hreflang</code> attribute specifies the language of the linked document.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'hreflang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.<br> The <code>lang</code> attribute specifies the primary language for the element\'s text content.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('role')){
                      var allval=["link","button","checkbox","menuitem","menuitemcheckbox","menuitemradio","tab","switch","treeitem"];
                      if(allval.indexOf($(this).attr('role'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('role')+'&quot; used in the <code>role</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'role\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('rel')){
                      var allval=["alternate","author","bookmark","follow","help","license","next","nofollow","noreferrer","prefetch","prev","search","tag"];
                      if(allval.indexOf($(this).attr('rel'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('rel')+'&quot; used in the <code>rel</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'rel\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('target')){
                      var allval=["_blank","_parent","_self","_top"];
                      if(allval.indexOf($(this).attr('target'))==-1){
                        er+='<div class="alert alert-info" data-attrernum="'+i+'"><div class="col-xs-8">This link contains a <code>target</code> attribute, but does not contain a recommended value of &quot;'+$(this).attr('target')+'&quot;. While it is possible to name a frame to target, it is no longer a safe recommendation.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'target\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('type')){
                      var allval=["text/css","text/javascript","text/html","image/jpeg","image/jpg","image/gif","image/png","image/tiff","video/mpeg","video/mp4","video/avi","audio/basic","audio/mp3","audio/ogg"];
                      if(allval.indexOf($(this).attr('type'))==-1){
                        er+='<div class="alert alert-info" data-attrernum="'+i+'"><div class="col-xs-8">This link contains a <code>type</code> attribute, but does not contain a recommended value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'type\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')&&$(this).attr('style')!='')error+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* abbr */
                  if($(this).is('abbr')){
                    var er;
                    if($(this).attr('title')){
                      var abbrtext=$(this).text();
                      if($(this).attr('title')==abbrtext)er='<div class="alert alert-info" data-attrernum="'+i+'"><div class="col-xs-8">The <code>title</code> attribute contains a value that is the same is the textual content within the element. It is recommended that the <code>title</code> text is different.</div><div class="input-group col-xs-4"><input type="text" class="form-control" value="'+$(this).attr('title')+'"><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'title\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* acronym Deprecated */
                  if($(this).is('acronym')){
                    var er='';
                    var tempText='<abbr>'+$(this).text()+'</abbr>';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>&lt;acronym&gt;</code> element is deprecated. It is now recommended to use <code>&lt;abbr&gt;</code> element instead.</div><div class="col-xs-4 text-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').replaceWith(\''+tempText+'\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div><div class="clearfix"></div></div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* address */
                  if($(this).is('address')){
                    var er='';
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* applet Deprecated */
                  if($(this).is('applet')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;applet&gt;</code> element is deprecated. It is now recommended to use <code>&lt;embed&gt;</code> or <code>&lt;object&gt;</code> elements instead.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popText+=er;
                      i++;
                    }
                  }
/* article */
                  if($(this).is('article')){
                    var er='';
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';
                        for(var ii=0;ii<val.length;ii++)
                          er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';
                        er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('role')){
                      var allval=["article","presentation","document","application","main","region"];
                      if(allval.indexOf($(this).attr('role'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('role')+'&quot; used in the <code>role</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'role\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* aside */
                  if($(this).is('aside')){
                    var er='';
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('role')){
                      var allval=["complementary","note","region","search"];
                      if(allval.indexOf($(this).attr('role'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('role')+'&quot; used in the <code>role</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'role\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* b Deprecated */
                  if($(this).is('b')){
                    var er='';
                    var tempText='<strong>'+$(this).text()+'</strong>';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>&lt;b&gt;</code> element is deprecated. It is now recommended to use <code>&lt;strong&gt;</code> element instead.</div><div class="col-xs-4 text-right"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').replaceWith(\''+tempText+'\');$(this).closest(\'.alert\').fadeOut();">Fix</button></div><div class="clearfix"></div></div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* basefont Deprecated */
                  if($(this).is('basefont')){
                    var er='';
                    er+='<div class="alert alert-info" data-attrernum="'+i+'">The <code>&lt;basefont&gt;</code> element is deprecated. It is now recommended to use CSS to set Font Styles instead.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* bdi */
                  if($(this).is('bdi')){
                    var er='';
                    var val=["ltr","rtl","auto"];
                    if($(this).attr('dir')){
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* bdo */
                  if($(this).is('bdo')){
                    var er='';
                    var val=["ltr","rtl"];
                    if($(this).attr('dir')){
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }else{
                      er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is a required attribute in the <code>&lt;bdo&gt;</code> element.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style'))er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* big Deprecated */
                  if($(this).is('big')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;big&gt;</code> element is deprecated. It is now recommended to use CSS Styling for elements instead.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* blockquote */
                  if($(this).is('blockquote')){
                    var er='';
                    if($(this).attr('cite')){
                      var regex=/(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
                      if(!regex.test($(this).attr('cite')))
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>cite=&quot;'+$(this).attr('cite')+'&quot;</code> is not a valid URL.</div><div class="input-group col-xs-4 text-right"><input type="text" class="form-control" value="'+$(this).attr('cite')+'"><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'cite\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                    }
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popText+=er;
                      i++;
                    }
                  }
/* body Not Applicable for LibreCMS */
/* br */
/* button */
                  if($(this).is('button')){
                    var er='';
                    if($(this).attr('formenc')){
                      var allval=["multipart/form-data","application/x-www-form-urlencoded","text/plain"];
                      if(allval.indexOf($(this).attr('formenc'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>formenc=&quot;'+$(this).attr('formenc')+'&quot;</code> attribute is not an allowed value. This attribute should only be used when the <code>&lt;button&gt;</code> attribute <code>type=&quot;submit&quot;</code> is used.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'formenc\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('formmethod')){
                      var allval=["get","post"];
                      if(allval.indexOf($(this).attr('formmethod'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>formmethod=&quot;'+$(this).attr('formmethod')+'&quot;</code> attribute is not an allowed value. This attribute should only be used when the <code>&lt;button&gt;</code> attribute <code>type=&quot;submit&quot;</code> is used.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'formmethod\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('formtarget')){
                      var allval=["_blank","_self","_parent","_top"];
                      if(allval.indexOf($(this).attr('formtarget'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>formtarget=&quot;'+$(this).attr('formtarget')+'&quot;</code> attribute is not an allowed value. This attribute should only be used when the <code>&lt;button&gt;</code> attribute <code>type=&quot;submit&quot;</code> is used.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'formtarget\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('type')){
                      var allval=["button","reset","submit"];
                      if(allval.indexOf($(this).attr('type'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>type=&quot;'+$(this).attr('type')+'&quot;</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'type\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('role')){
                      var allval=["button","link","menuitem","menuitemcheckbox","menuitemradio","radio"];
                      if(allval.indexOf($(this).attr('role'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>role=&quot;'+$(this).attr('role')+'&quot;</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<allval.length;ii++)er+='<option value="'+allval[ii]+'">'+allval[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'role\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* caption */
                  if($(this).is('caption')){
                    var er='';
                    if(!$(this).parent().is('table')){
                      er+='<div class="alert alert-info" data-attrernum="'+i+'">This <code>&lt;caption&gt;</code> element is not inside a <code>&lt;table&gt;</code>.</div>';
                    }else{
                      if($(this).attr('align'))er+='<div class="alert alert-info" data-attrernum="'+i+'">The <code>align</code> is Deprecated in HTML5 within the <code>&lt;caption&gt;</code> element. Use CSS to style the element.</div>';
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* center Deprecated instead use styling */
                  if($(this).is('center')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;center&gt;</code> element is deprecated. It is now recommended to use css styles to center content within elements</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      errorText+=error;
                      i++;
                    }
                  }
/* cite */
                  if($(this).is('cite')){
                    var er='';
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popText+=er;
                      i++;
                    }
                  }
/* code */
                  if($(this).is('code')){
                    var er='';
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* col */
                  if($(this).is('col')){
                    var er='';
                    if(!$(this).parent().is('colgroup')){
                      er+='<div class="alert alert-info" data-attrernum="'+i+'">This <code>&lt;col&gt;</code> element is not inside a <code>&lt;colgroup&gt;</code>.</div>';
                    }
                    if($(this).attr('span')){
                      if(!/^\d+$/.test($(this).attr('span')))er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>span=&quot;'+$(this).attr('span')+'&quot;</code> is not a numerical valid value in the <code>&lt;col&gt;</code> element.</div>';
                    }
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* colgroup */
                  if($(this).is('colgroup')){
                    var er='';
                    if(!$(this).prev().is('caption'))er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>colgroup</code element should be placed directly after the <code>caption</code> element.</div>';
                    if(!$(this).parent().is('table'))er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>colgroup</code> element should be within the <code>table</code> element, after the <code>caption</code> element.</div>';
                    if($(this).attr('dir')){
                      var val=["ltr","rtl","auto"];
                      if(val.indexOf($(this).attr('dir'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value <code>dir=&quot;'+$(this).attr('dir')+'&quot;</code> is not a valid value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<val.length;ii++)er+='<option value="'+val[ii]+'">'+val[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'dir\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('lang')){
                      if(langval.indexOf($(this).attr('lang'))==-1){
                        er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The value &quot;'+$(this).attr('lang')+'&quot; used in the <code>lang</code> attribute is not an allowed value.</div><div class="input-group col-xs-4 text-right"><select class="form-control">';for(var ii=0;ii<langval.length;ii++)er+='<option value="'+langval[ii]+'">'+langname[ii]+'</option>';er+='</select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').attr(\'lang\',$(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div><div class="clearfix"></div></div>';
                      }
                    }
                    if($(this).attr('style')!='')er+='<div class="alert alert-info" data-attrernum="'+i+'">Current trends dicatate that it is no longer good practise to use <code>style</code> attributes in elements, but rather use CSS via a linked stylesheet.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
// https://specs.webplatform.org/html-aria/webspecs/master/
// http://www.tutorialrepublic.com/html-reference/html5-tags.php
// http://www.w3schools.com/tags/tag_abbr.asp
// https://www.tutorialspoint.com/html5/html5_deprecated_tags.htm
// https://www.w3.org/TR/html5/obsolete.html
/* datalist
  role = [listbox]
*/
                  if($(this).is('datalist')){
                   var er='';
                   if($(this).attr('id')){
                     var elid=$(this).attr('id');
                     if(!$('input[list="'+elid+'"]').length>0){
                       alert('element exists');
                     }
                   }
                   if(er){
                     $(this).addClass('accessibility-error error');
                     $(this).attr("data-attrnum",i);
                     popTxt+=er;
                     i++;
                   }
                  }
/* del
if($(this).is('del')){
  var er='';
  if(er){
    $(this).addClass('accessibility-error error');
    $(this).attr("data-attrnum",i);
    popTxt+=er;
    i++;
  }
} */
/* details
  role = group

if($(this).is('details')){
  var er='';
  if(er){
    $(this).addClass('accessibility-error error');
    $(this).attr("data-attrnum",i);
    popTxt+=er;
    i++;
  }
} */
/* dd
if($(this).is('dd')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* dfn
if($(this).is('dfn')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* dialog
  role = [dialog]|alertdialog

if($(this).is('dialog')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* dir Deprecated */
                  if($(this).is('dir')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;dir&gt;</code> element is deprecated. It is now recommended to use <code>&lt;ul&gt;</code> element instead.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* div
if($(this).is('div')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* dl
  role = list

if($(this).is('dl')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* dt
if($(this).is('dt')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* em
if($(this).is('em')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* embed
  role =  application|document|presentation|img

if($(this).is('embed')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* figure
if($(this).is('figure')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* font Deprecated */
                  if($(this).is('font')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;font&gt;</code> element is deprecated. It is now recommended to use css styling to change an elements font styling</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt+=er;
                      i++;
                    }
                  }
/* footer
  role = [contentinfo]

if($(this).is('footer')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* form
  role = [form]

if($(this).is('form')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* frame Deprecated */
                    if($(this).is('frame')){
                      var er='';
                      er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;frame&gt;</code> element is deprecated. Either use <code>&lt;iframe&gt; and CSS instead, or use server-side includes to generate complete pages with the various invariant parts merged in.</div>';
                      if(er){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        popTxt+=er;
                        i++;
                      }
                    }
/* frameset Deprecated */
                    if($(this).is('frameset')){
                      var er='';
                      er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;frameset&gt;</code> element is deprecated. Either use <code>&lt;iframe&gt; and CSS instead, or use server-side includes to generate complete pages with the various invariant parts merged in.</div>';
                      if(er){
                        $(this).addClass('accessibility-error error');
                        $(this).attr("data-attrnum",i);
                        popTxt=er;
                        i++;
                      }
                    }
/* h1 to h6
  role = [heading]|tab|presentation

if($(this).is('h1')){
var er='';
er+='<div class="alert alert-info" data-attrnum="'+i+'">Using an <code>H1</code> element is unneccessary in LibreCMS as long as the theme is setup to to include the title of the content within a <code>H1</code> element.</div>';
if(!$(this).attr('role'))er+='<div class="alert alert-danger" data-attrnum="'+i+'">Headings should contain a <code>role="heading"</code> attribute.</div>';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt=er;
  i++;
}
}
if($(this).is('h2,h3,h4,h5,h6')){
//                    errorText=+'<div class="alert alert-danger" data-attrnum="'+i+'">Should heading start with H1:H6</div>';
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  i++;
} */
/* header
  role = [banner]

if($(this).is('header')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* hr
  role = [separator]

if($(this).is('hr')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* i
if($(this).is('i')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* iframe
  role = application|document|img

if($(this).is('iframe')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* img
  alt
  src
  role = [img]

if($(this).is('img')){
  var er='';
  if(!$(this).attr('src'))er+='<div class="alert alert-danger" data-attrnum="'+i+'">Images Should Contain a src=value</div>';
  if(!$(this).attr('alt'))er+='<div class="alert alert-danger" data-attrnum="'+i+'">Images Should Contain an alt=value</div>';
  if(er!=''){
    $(this).addClass('accessibility-error error');
    $(this).attr("data-attrnum",i);
    popTxt=er;
    i++;
  }
} */
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

if($(this).is('input')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* ins
if($(this).is('ins')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* isindex Deprecated */
                  if($(this).is('isindex')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;isindex&gt;</code> element is deprecated. Instead use an explicit <code>&lt;form&gt;</code> and <code>text</code> field combination instead.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt=er;
                      i++;
                    }
                  }
/* kbd
if($(this).is('kbd')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* keygen
if($(this).is('keygen')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* label
if($(this).is('label')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* li
  role = [listitem], menuitem, menuitemcheckbox, menuitemradio, option, separator, tab, or treeitem

if($(this).is('li')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* main
  role = [main]

if($(this).is('main')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* map
if($(this).is('map')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* mark
if($(this).is('mark')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* math
  role = [math]

if($(this).is('math')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* menu
  type = toolbar
  role = toolbar

if($(this).is('menu')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* menuitem
  type = command
    role = menuitem
  type = checkbox
    role = menuitemcheckbox
  type = radio
    role = menuitemradio

if($(this).is('menuitem')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* meta
if($(this).is('meta')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* meter
  role = [progressmeter]

if($(this).is('meter')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* nav
  role = [navigation]

if($(this).is('nav')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* noframes Deprecated */
                  if($(this).is('noframes')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;noframes&gt;</code> element is deprecated. Either use <code>&lt;iframe&gt; and CSS instead, or use server-side includes to generate complete pages with the various invariant parts merged in.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt=er;
                      i++;
                    }
                  }
/* noscript
if($(this).is('noscript')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* object
  role =  application, document, or img

if($(this).is('object')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* ol
  role = [list], directory, group, listbox, menu, menubar, tablist, toolbar or tree

if($(this).is('ol')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* optgroup
if($(this).is('optgroup')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* option
  role = [option]

if($(this).is('option')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* output
  role = status

if($(this).is('article')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* p
if($(this).is('p')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* param
if($(this).is('param')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* picture
if($(this).is('picture')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* pre
if($(this).is('pre')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* progress
  role = progressbar

if($(this).is('progress')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* q
if($(this).is('q')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* rp
if($(this).is('rp')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* rt
if($(this).is('rt')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* ruby
if($(this).is('ruby')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/*  s
if($(this).is('acronym')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* samp
if($(this).is('samp')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* script
if($(this).is('script')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* section
  role = [region], alert, alertdialog, application, contentinfo, dialog, document, log, marquee, search, or status

if($(this).is('section')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* select
  role = [listbox]

if($(this).is('select')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* small
if($(this).is('small')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* source
if($(this).is('source')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* span
if($(this).is('span')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* strike Deprecated */
                  if($(this).is('strike')){
                    var er='';
                    var tempText=$(this).text();
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'"><div class="col-xs-8">The <code>&lt;strike&gt;</code> element is deprecated. Use <code>&lt;del&gt;</code> instead if the element is marking an edit, otherwise use <code>&lt;s&gt;</code> instead.</div><div class="col-xs-4 text-right"><div class="input-group"><select class="form-control"><option value="<del>'+tempText+'</del>">Replace with &lt;del&gt;</option><option value="<s>'+tempText+'</s>">Replace with &lt;s&gt;</option></select><div class="input-group-btn"><button class="btn btn-default add" onclick="$(\'[data-attrnum='+i+']\').replaceWith($(this).closest(\'.input-group\').find(\'.form-control\').val());$(this).closest(\'.alert\').fadeOut();">Fix</button></div></div></div><div class="clearfix"></div></div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popText=er;
                      i++;
                    }
                  }
/* strong
if($(this).is('strong')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* style
if($(this).is('style')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* svg
  role = application, document, or img

if($(this).is('svg')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* sub
if($(this).is('sub')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* sup
if($(this).is('sup')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* summary
  role = [button]

if($(this).is('summary')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* table
if($(this).is('table')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* template
if($(this).is('template')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* textarea
  role = [textbox]

if($(this).is('textarea')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* tbody
  role = rowgroup

if($(this).is('tbody')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* td
if($(this).is('td')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/*  tfoot
    role = rowgroup

if($(this).is('tfoot')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* th
if($(this).is('th')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* thead
  role = rowgroup

if($(this).is('thead')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* time
if($(this).is('time')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* tr
if($(this).is('tr')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* track
if($(this).is('track')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* tt Deprecated */
                  if($(this).is('tt')){
                    var er='';
                    er+='<div class="alert alert-danger" data-attrernum="'+i+'">The <code>&lt;tt&gt;</code> element is deprecated. Where the <code>&lt;tt&gt;</code> element would have been used for marking up keyboard input, consider the <code>&lt;kbd&gt;</code> element instead.</div>';
                    if(er){
                      $(this).addClass('accessibility-error error');
                      $(this).attr("data-attrnum",i);
                      popTxt=er;
                      i++;
                    }
                  }
/* u
if($(this).is('acronym')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* ul
  role = [list],directory, group, listbox, menu, menubar, tablist, toolbar, tree, presentation

if($(this).is('ul')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* var
if($(this).is('var')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* video
  role = application

if($(this).is('video')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
/* wbr
if($(this).is('wbr')){
var er='';
if(er){
  $(this).addClass('accessibility-error error');
  $(this).attr("data-attrnum",i);
  popTxt+=er;
  i++;
}
} */
                  });
                }
                if(popTxt==''){
                  popTxt=lang.accessibility.cmsinfo+'<div class="alert alert-success">Congratulations! There are no Accessibility Errors!</div>';
                }else{
                  popTxt=lang.accessibility.cmsinfo+popTxt;
                }
                $('[data-toggle="accessbility"]').popover({
                  html:true,
                  trigger:'click',
                  title:'Accessibility Results',
                  container:'body',
                  placement:'auto',
                  template:'<div class="popover accessibility" role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                  content:popTxt
                }).popover(showPopover);
            }
        });
        return button.render();
      });
    }
  });
}));
