<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page"><strong>Theme</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <?php if($help['template_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['template_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['template_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['template_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div id="preference-theme" class="container-fluid">
    <div class="card">
      <div class="card-body">
<?php echo'<div id="notheme" class="alert alert-danger'.(file_exists(THEME.DS.'theme.ini')?' hidden':'').'">A Website Theme has not been set.</div>';?>
        <div class="row theme-chooser">
<?php $folders=preg_grep('/^([^.])/',scandir("layout"));
foreach($folders as$folder){
  if(!file_exists('layout'.DS.$folder.DS.'theme.ini'))continue;
  $theme=parse_ini_file('layout'.DS.$folder.DS.'theme.ini',true);?>
          <div class="card col-12 col-sm-2 col-md-3 text-white m-0 mb-2 m-sm-2 p-0<?php echo$config['theme']==$folder?' bg-secondary':'';?>" data-theme="<?php echo$folder;?>">
            <img class="img-fluid" src="<?php if(file_exists('layout'.DS.$folder.DS.'theme.jpg'))echo'layout'.DS.$folder.DS.'theme.jpg';elseif(file_exists('layout'.DS.$folder.DS.'theme.png'))echo'layout'.DS.$folder.DS.'theme.png';else echo NOIMAGE;?>" alt="<?php echo $theme['title'];?>">
            <div class="card-body">
              <div class="card-title"><?php echo isset($theme['title'])&&$theme['title']!=''?$theme['title']:'No Title Assigned';?></div>
              <p>
<?php echo isset($theme['version'])&&$theme['version']!=''?'<small class="version">Version: '.$theme['version'].'</small><br>':'';
  if(isset($theme['creator'])&&$theme['creator']!='')
    echo'<small class="creator">Creator'.(isset($theme['creator_url'])&&$theme['creator_url']!=''?': <a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>':$theme['creator']).'</small><br>';
  if(isset($theme['framework_name'])&&$theme['framework_name']!='')
    echo'<small class="creator">Framework'.(isset($theme['framework_url'])&&$theme['framework_url']!=''?': <a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>':$theme['framework_name']).'</small><br>';?>
              </p>
            </div>
          </div>
<?php }?>
        </div>
      </div>
      <script>/*<![CDATA[*/
        $("div.theme-chooser").not(".disabled").find("div.card").on("click",function(){
          $('#preference-theme .card').removeClass("bg-secondary");
          $(this).addClass("bg-secondary");
          $('#notheme').addClass("hidden");
          Pace.restart();
          $.ajax({
            type:"GET",
            url:"core/update.php",
            data:{
              id:"1",
              t:"config",
              c:"theme",
              da:$(this).attr("data-theme")
            }
          });
        });
      /*]]>*/</script>
      </div>
    </div>
  </div>
</main>
