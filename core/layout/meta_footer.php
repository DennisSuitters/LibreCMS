<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Meta-Footer containts inline Javascript
 *
 * meta_footer.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Meta-Footer
 * @package    core/layout/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Remove Media Editing Popup
 * @changes    v2.0.1 Fix Media ReOrdering Items
 * @changes    v2.0.1 Make Images Uploading auto-populate thumbnail
 * @canges     v2.0.2 Add i18n.
 */?>
<script>
var unsaved=false;

window.onbeforeunload = function(e) {
//$(window).bind('beforeunload',function (e) {
//  if(unsaved){
//    e.preventDefault();
//    Swal.fire({
//      title: 'Custom animation with Animate.css',
//      animation: false,
//      customClass: 'animated tada'
//    });
//    e.stopPropogation();
//  }
  if (unsaved) return '<?php echo localize('warning_unsaved');?>';
}
<?php if(file_exists('core'.DS.'sounds'.DS.'notification.mp3')&&$config['notification_volume']!=0){?>
  ion.sound({
    sounds:[
<?php if(file_exists('core'.DS.'sounds'.DS.'notification.mp3')){?>
      {
        name:"notification"
      },
<?php }?>
    ],
    path:"core/sounds/",
    preload:true,
    multiplay:true,
    volume:<?php echo$config['notification_volume']/100;?>
  });
<?php }?>
<?php if($config['idleTime']!=0){?>
  $(document).ready(function(){
    idleTimer=null;
    idleState=false;
    idleWait=<?php echo$config['idleTime']*60000;?>;
    $(document).on('mousemove scroll keyup keypress mousedown mouseup mouseover',function(){
      clearTimeout(idleTimer);
      idleState=false;
      idleTimer=setTimeout(function(){
        idleState=true;
        unsaved=false;
<?php if(file_exists('core'.DS.'sounds'.DS.'notification.mp3')&&$config['notification_volume']!=0){?>
        ion.sound.play("notification");
<?php }?>
        document.location.href="<?php echo URL.$settings['system']['admin'].'/logout';?>";
      },idleWait);
    });
    $("body").trigger("mousemove");
  });
<?php }?>
  $('#seoTitle').keyup(function(){
  	var length=$(this).val().length;
  	var max=70;
  	var length=max-length;
  	$("#seoTitlecnt").text(length);
  	if(length<0){
  		$("#seoTitlecnt").addClass('text-danger');
  	}else{
  		$("#seoTitlecnt").removeClass('text-danger');
  	}
  });
  $('#seoCaption').keyup(function(){
  	var length=$(this).val().length;
  	var max=160;
  	var length=max-length;
  	$("#seoCaptioncnt").text(length);
  	if(length<0){
  		$("#seoCaptioncnt").addClass('text-danger');
  	}else{
  		$("#seoCaptioncnt").removeClass('text-danger');
  	}
  });
  $('#seoDescription').keyup(function(){
  	var length=$(this).val().length;
  	var max=160;
  	var length=max-length;
  	$("#seoDescriptioncnt").text(length);
  	if(length<0){
  		$("#seoDescriptioncnt").addClass('text-danger');
  	}else{
  		$("#seoDescriptioncnt").removeClass('text-danger');
  	}
  });
<?php if(isset($r['pti'])){?>
  $('#pti').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['pti']!=0?$r['pti']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#ptix').val(start.unix());
  });
<?php }
if(isset($r['tis'])){?>
  $('#tis').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['tis']!=0?$r['tis']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#tisx').val(start.unix());
  });
<?php }
if(isset($r['tie'])){?>
  $('#tie').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['tie']!=0?$r['tie']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#tiex').val(start.unix());
  });
<?php }
if(isset($r['due_ti'])){?>
  $('#due_ti').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['due_ti']!=0?$r['due_ti']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#due_tix').val(start.unix());
  });
<?php }?>
  $('.save').click(function(e){
	 	e.preventDefault();
	 	var l=Ladda.create(this);
    var el=$(this).data("dbid");
    var id=$('#'+el).data("dbid"),
        t=$('#'+el).data("dbt"),
        c=$('#'+el).data("dbc"),
        da=$('#'+el).val();
    if(c=='tis'||c=='tie'||c=='pti'||c=='due_ti'){
      da=$('#'+c+'x').val();
    }
	 	l.start();
    $('#'+el).attr('disabled','disabled');
    $.ajax({
      type:"GET",
      url:"core/update.php",
      data:{
        id:id,
        t:t,
        c:c,
        da:da
      }
    }).done(function(msg){
      l.stop();
      $('#'+el).removeAttr('disabled');
      $('#save'+c).removeClass('btn-danger');
      unsaved=false;
    });
	 	return false;
	});
<?php
  if($view=='media'||$args[0]=='edit'){?>
  $.widget.bridge('uibutton', $.ui.button);
  $.widget.bridge('uitooltip', $.ui.tooltip);
<?php }
  if($config['options']{4}==0){?>
  $().tooltip('disable');
<?php }else{?>
  $('body').tooltip({
    selector:'[data-tooltip="tooltip"]',
    container:"body"
  });
<?php }
  if($args[0]=='edit'||$args[0]=='settings'||$args[0]=='security'||($view=='content'||$view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')){?>
  function elfinderDialog(id,t,c){
    var fm=$('<div class="shadow light"/>').dialogelfinder({
      url:"<?php echo URL.DS.'core'.DS.'elfinder'.DS.'php'.DS.'connector.php';?>",
      lang:'en',
      width:840,
      height:450,
      destroyOnClose:true,
      useBrowserHistory:false,
      getFileCallback:function(file,fm){
        if(id>0){
          $('#'+c).val(file.url);
          if(t=='content'&&c=='file'){
            $('#thumb').val(file.url.replace('media','media/thumbs'));
          }
          if(t=='category'){
            
          }else if(t!='media'||t!='category'){
            if(t=='config'&&c=='php_honeypot'){
              $('#php_honeypot_link').html('<a target="_blank" href="'+file.url+'">'+file.url+'</a>');
            }else{
              $('#'+c+'image').attr('src',file.url);
            }
          }
        }else{
          if(file.url.match(/\.(jpeg|jpg|gif|png)$/)){
            $('.summernote').summernote('editor.insertImage',file.url);
          }else{
            $('.summernote').summernote('createLink',{
              text:file.name,
              url:file.url,
              newWindow:true
            });
          }
        }
      },
      commandsOptions:{
        getfile:{
          oncomplete:'close',
          folders:false
        }
      }
    }).dialogelfinder('instance');
  }
<?php }
  if($view=='media'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'&&$args[0]=='settings')){?>
  $().ready(function(){
    var fm=$('#elfinder').elfinder({
      url:"<?php echo URL.DS.'core'.DS.'elfinder'.DS.'php'.DS.'connector.php';?>",
      lang:'en',
      width:'100vw',
      height:$(window).height()-102,
      resizeable:true,
      handlers:{
        dblclick:function(e,eI){
          e.preventDefault();
          eI.exec('getfile').done(function(){
            eI.exec('quicklook');
          }).fail(function(){
            eI.exec('open');
          });
        }
      },
      getFileCallback:function(){
        return false;
      },
    }).elfinder('instance');
    var $elfinder=$('#elfinder').elfinder();
    $(window).resize(function(){
        resizeTimer && clearTimeout(resizeTimer);
        resizeTimer=setTimeout(function(){
            var h=parseInt($(window).height())-102;
            if(h!=parseInt($('#elfinder').height())){
                fm.resize('100%',h);
            }
        },200);
    });
  });
<?php }?>
  document.addEventListener("DOMContentLoaded",function(event){
    $(document).ajaxComplete(function(){
      Pace.restart();
    });
<?php if($args[0]=='edit'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')){?>
    $('.summernote').summernote({
      height:300,
      tabsize:2,
      popover:{
        image:
          [
            ['custom',['imageAttributes','imageShapes','captionIt']],
            ['imagesize',['imageSize100','imageSize50','imageSize25']],
            ['float',['floatLeft','floatRight','floatNone']],
            ['remove',['removeMedia']],
          ],
        link:
          [
            ['link',['linkDialogShow','unlink']]
          ],
        air:
          [
            ['color',['color']],
            ['font',['bold','underline','clear']],
            ['para',['ul','paragraph']],
            ['table',['table']],
            ['insert',['media','link','picture']]
          ]
      },
      lang:'en-US',
      toolbar:
        [
          ['save',['save']],
//        ['librecms',['accessibility','findnreplace','cleaner','seo']],
          ['style',['style']],
          ['font',['bold','italic','underline','clear']],
          ['fontname',['fontname']],
          ['fontsize',['fontsize']],
          ['color',['color']],
          ['para',['ul','ol','paragraph']],
          ['height',['height']],
          ['table',['table']],
          ['insert',['videoAttributes','elfinder','link','hr']],
          ['view',['fullscreen','codeview']],
          ['help',['help']]
        ],
        callbacks:{
          onInit:function(){
            $('body > .note-popover').appendTo(".note-editing-area");
          }
        }
    });
<?php }?>
    $(".textinput").on({
    	blur:function(event){
    		event.preventDefault();
    	},
    	keydown:function(event){
    		var id=$(this).data("dbid");
    		if(event.keyCode==46||event.keyCode==8){
    			$(this).trigger('keypress');
    		}
    	},
    	keyup:function(event){
    		if(event.which==9){
    			var id=$(this).data("dbid");
    			var da=$(this).val();
    			$(this).trigger('keypress');
    			$(this).next("input").focus();
          unsaved=true;
    		}
    	},
    	keypress:function(event){
        var save=$(this).data("dbc");
        $('#save'+save).addClass('btn-danger');
        unsaved=true;
    		if(event.which==13){
    			event.preventDefault();
    		}
    	},
    	change:function(event){
        var save=$(this).data("dbc");
        $('#save'+save).addClass('btn-danger');
        unsaved=true;
    	}
    });
    $(document).on(
    	'click','#content input[type=checkbox]',
    	{},
    	function(event){
    		var id=$(this).data("dbid");
    		if('#home input[type=checkbox]'){
    			$('#actions').toggleClass('hidden');
    		}else{
    			$('#actions').toggleClass('hidden');
  		   }
    		if(id=='checkboxtoggle'){
    			if(this.checked){
    				$('.switchinput').each(function(){
    					this.checked=true;
              $(this).attr("aria-checked", "true");
    				});
    			}else{
    				$('.switchinput').each(function(){
    					this.checked=false;
              $(this).attr("aria-checked", "false");
    				});
    			}
    		}else{
    			var t=$(this).data("dbt");
    			var c=$(this).data("dbc");
    			var b=$(this).data("dbb");
//   			var a=$(this).data("dba");
          $.ajax({
            type:"GET",
            url:"core/toggle.php",
            data:{
              id:id,
              t:t,
              c:c,
              b:b
            }
          }).done(function(msg){
        });
    		}
    	}
    );
    setInterval(function(){
      $.get("<?php echo URL;?>/core/nav-stats.php",{},function(results){
        var stats=results.split(",");
        var navStat=$('#nav-stat').html();
        var stats=results.split(",");
        var navStat=$('#nav-stat').html();
        if(stats[0]==0)stats[0]='';
        $('#nav-nou').html(stats[2]);
        if(stats[1]==1){
<?php if(file_exists('core'.DS.'sounds'.DS.'notification.mp3')&&$config['notification_volume']!=0){?>
          ion.sound.play("notification");
<?php }?>
        }
        var stathtml='<div class="dropdown-header text-center"><strong><?php echo localize('Notifications');?></strong></div>';
        if(stats[3]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/content"><?php svg('libre-gui-comments');?> <?php echo localize('Comments');?><span id="nav-nc" class="badge badge-info">'+stats[3]+'</span></a>';
        if(stats[4]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/content"><?php svg('libre-gui-review');?> <?php echo localize('Reviews');?><span id="nav-nr" class="badge badge-info">'+stats[4]+'</span></a>';
        if(stats[5]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/messages"><?php svg('libre-gui-inbox');?> <?php echo localize('Messages');?><span id="nav-nm" class="badge badge-info">'+stats[5]+'</span></a>';
        if(stats[6]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/orders/pending"><?php svg('libre-gui-order');?> <?php echo localize('Orders');?><span id="nav-po" class="badge badge-info">'+stats[6]+'</span></a>';
        if(stats[7]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/bookings"><?php svg('libre-gui-calendar');?> <?php echo localize('Bookings');?><span id="nav-nb" class="badge badge-info">'+stats[7]+'</span></a>';
        if(stats[8]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/accounts"><?php svg('libre-gui-users');?> <?php echo localize('Users');?><span id="nav-nu" class="badge badge-info">'+stats[8]+'</span></a>';
        if(stats[9]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/content/type/testimonials"><?php svg('libre-gui-testimonial');?> <?php echo localize('Testimonials');?><span id="nav-nt" class="badge badge-info">'+stats[9]+'</span></a>';
        if(stats[2]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/accounts"><?php svg('libre-gui-users');?> <?php echo localize('Active Users');?><span id="nav-nou" class="badge badge-info">'+stats[2]+'</span></a>';
        $('#nav-stat').html(stats[0]);
        $('#nav-stat-list').html(stathtml);
        if(stats[1]==0){
          document.title='<?php echo localize('Administration');?> - LibreCMS';
        }else{
          $("#easyNotify").easyNotify({
            title:'<?php echo localize('Administration');?> - LibreCMS',
            options:{
              body:'('+stats[0]+') <?php echo localize('New Notifications to view');?>...',
              icon:'core/images/favicon.png',
              lang:'<?php echo localize('lang');?>'
            }
          });
        }
        if(stats[0]>0)document.title='('+stats[0]+') <?php echo localize('Administration');?> - LibreCMS';
      });
    },30000);
    function autoPlayModal(){
      var trigger=$("body").find('[data-toggle="modal"]');
      trigger.click(function(){
        var theFrame=$(this).data("frame");
        var theModal=$(this).data("target");
        var videoSRC=$(this).data("video");
        videoSRCauto=videoSRC+"?autoplay=1";
        $(theModal+' '+theFrame).attr('src',videoSRCauto);
        $(theModal).on('hidden.bs.modal',function(){
          $(theModal+' '+theFrame).removeAttr('src');
        })
      });
    }
    autoPlayModal();
    $('.pathviewer').popover({
      html:true,
      trigger:'manual',
      title:'<?php echo localize('Visitor Path');?> <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover pathviewer shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var id=$(this).data("dbid");
        return $.ajax({
          url:'core/layout/pathviewer.php',
          dataType:'html',
          async:false,
          data:{
            id:id
          }
        }).responseText;
      }
    }).click(function(e){
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e) {
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
    $('.phpviewer').popover({
      html:true,
      trigger:'manual',
      title:'<?php echo localize('Project Honey Pot Threat Assessment');?> <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover suggestions shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var id=$(this).data("dbid"),
            t=$(this).data("dbt");
        return $.ajax({
          url:'core/layout/phpviewer.php',
          dataType:'html',
          async:false,
          data:{
            id:id,
            t:t
          }
        }).responseText;
      }
    }).click(function(e){
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e){
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
    $('.suggestions').popover({
      html:true,
      trigger:'manual',
      title:'<?php echo localize('Editing Suggestions');?> <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover suggestions shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var el=$(this).data("dbgid");
        var id=$('#'+el).data("dbid"),
            t=$('#'+el).data("dbt"),
            c=$('#'+el).data("dbc");
        return $.ajax({
          url:'core/layout/suggestions.php',
          dataType:'html',
          async:false,
          data:{
            id:id,
            t:t,
            c:c
          }
        }).responseText;
      }
    }).click(function(e) {
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e){
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
<?php if($user['rank']>899){?>
    $('.fingerprint').popover({
      html:true,
      trigger:'manual',
      title:'<?php echo localize('Fingerprint Analysis');?> <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover suggestions shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var el=$(this).data("dbgid");
        var id=$('#'+el).data("dbid"),
            t=$('#'+el).data("dbt"),
            c=$('#'+el).data("dbc");
        return $.ajax({
          url:'core/layout/dataspy.php',
          dataType:'html',
          async:false,
          data:{
            id:id,
            t:t,
            c:c
          }
        }).responseText;
      }
    }).click(function(e) {
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e){
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
    $('.addsuggestion').popover({
      html:true,
      trigger:'manual',
      title:'<?php echo localize('Add Suggestion');?> <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover suggestions shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var el=$(this).data("dbgid");
        var id=$('#'+el).data("dbid"),
            t=$('#'+el).data("dbt"),
            c=$('#'+el).data("dbc");
        return $.ajax({
          url:'core/layout/suggestions-add.php',
          dataType:'html',
          async:false,
          data:{
            id:id,
            t:t,
            c:c
          }
        }).responseText;
      }
    }).click(function(e) {
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e){
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
<?php }?>
      });
    </script>
    <iframe id="sp" name="sp" class="d-none"></iframe>
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="" frameborder="0" allow="autoplay;encrypted-media" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>