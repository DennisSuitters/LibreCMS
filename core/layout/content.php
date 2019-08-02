<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Displays a Content Items
 *
 * content.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Content
 * @package    core/layout/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.3
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header
 * @changes    v2.0.2 Add Category 3 & 4 Editing
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.3 Fix urlSlug initial content creation.
 * @changes    v2.0.3 Fix Page Redirect when Creating Content.
 */
$rank=0;
$show='categories';
if($args[0]=='scheduler'){
  include'core'.DS.'layout'.DS.'scheduler.php';
}else{
  if($view=='add'){
    $stockStatus='none';
    $ti=time();
    $schema='';
    $comments=0;
    if($args[0]=='article')$schema='blogPosting';
    if($args[0]=='inventory'){
      $schema='Offer';
      $stockStatus='quantity';
    }
    if($args[0]=='service')$schema='Service';
    if($args[0]=='gallery')$schema='ImageGallery';
    if($args[0]=='testimonial')$schema='Review';
    if($args[0]=='news')$schema='NewsArticle';
    if($args[0]=='event')$schema='Event';
    if($args[0]=='portfolio')$schema='CreativeWork';
    if($args[0]=='proof'){
      $schema='CreativeWork';
      $comments=1;
    }
    $q=$db->prepare("INSERT INTO `".$prefix."content` (options,uid,login_user,contentType,schemaType,status,active,stockStatus,ti,eti,pti) VALUES ('00000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:stockStatus,:ti,:ti,:ti)");
    $uid=isset($user['id'])?$user['id']:0;
    $login_user=$user['name']!=''?$user['name']:$user['username'];
    $q->execute([':contentType'=>$args[0],':uid'=>$uid,':login_user'=>$login_user,':schemaType'=>$schema,':stockStatus'=>$stockStatus,':ti'=>$ti]);
    $id=$db->lastInsertId();
    $args[0]=ucfirst($args[0]).' '.$id;
    $s=$db->prepare("UPDATE `".$prefix."content` SET title=:title,urlSlug=:urlslug WHERE id=:id");
    $s->execute([
      ':title'=>$args[0],
      ':urlslug'=>str_replace(' ','-',$args[0]),
      ':id'=>$id
    ]);
    if($view!='bookings')$show='item';
    $rank=0;
    $args[0]='edit';
    $args[1]=$id;
    echo'<script>/*<![CDATA[*/window.location.replace("'.URL.$settings['system']['admin'].'/content/edit/'.$args[1].'");/*]]>*/</script>';
  }
  if($args[0]=='edit'){
    $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
    $s->execute([':id'=>$args[1]]);
    $show='item';
  }
  if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_content.php';
  else{
    if($show=='categories'){
      if($args[0]=='type'){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType=:contentType AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
        $s->execute([':contentType'=>$args[1]]);
      }else{
        if(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND LOWER(category_3) LIKE LOWER(:category_3) AND LOWER(category_4) LIKE LOWER(:category_4) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1]),
            ':category_3'=>str_replace('-',' ',$args[2]),
            ':category_4'=>str_replace('-',' ',$args[3])
          ]);
        }elseif(isset($args[3])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND LOWER(category_3) LIKE LOWER(:category_3) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1]),
            ':category_3'=>str_replace('-',' ',$args[2])
          ]);
        }elseif(isset($args[1])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute([
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1])
          ]);
        }elseif(isset($args[0])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti ASC,title ASC");
          $s->execute([':category_1'=>str_replace('-',' ',$args[0])]);
        }else{
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType!='booking' AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute();
        }
      }?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
<?php if($args[1]!=''){?>
    <li class="breadcrumb-item active"><?php echo ucfirst(localize($args[1])).(in_array($args[1],array('article','service'))?'s':'');?></li>
<?php }?>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
<?php if($args[1]!=''){?>
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'];?>/add/<?php echo$args[1];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Add').' '.ucfirst($args[1]);?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-add');?></a>
<?php }
        if($help['content_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['content_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['content_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
<?php if($args[0]==''){?>
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="row">
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/media';?>" aria-label="Go to Media Page">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Media');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-picture','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/pages';?>" aria-label="Go to Pages">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Pages');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-content','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>" aria-label="Go to Scheduler">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Scheduler');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-calendar-time','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/article';?>" aria-label="Go to Articles">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Articles');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-content','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/portfolio';?>" aria-label="Go to Portfolio">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Portfolio');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-portfolio','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/events';?>" aria-label="Go to Events">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Events');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-calendar','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/news';?>" aria-label="Go to News">
        <span class="card">
          <span class="card-header h3"><?php echo localize('News');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-email-read','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>" aria-label="Go to Testimonials">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Testimonials');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-testimonial','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/inventory';?>" aria-label="Go to Inventory">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Inventory');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-shipping','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/rewards';?>" aria-label="Go to Rewards">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Rewards');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-credit-card','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/service';?>" aria-label="Go to Services">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Services');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-service','libre-5x');?></span>
        </span>
      </a>
<?php /*
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/gallery';?>" aria-label="Go to Gallery">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Gallery');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-gallery','libre-5x');?></span>
        </span>
      </a>
*/ ?>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/proofs';?>" aria-label="Go to Proofs">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Proofs');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-proof','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>" aria-label="Go to Newsletters">
        <span class="card">
          <span class="card-header h3"><?php echo localize('Newsletters');?></span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-newspaper','libre-5x');?></span>
        </span>
      </a>
    </div>
<?php }else{?>
    <div class="card">
      <div class="card-body">
        <table class="table table-condensed table-striped table-hover" role="table">
          <thead>
            <tr role="row">
              <th role="columnheader"></th>
              <th class="col" role="columnheader"><?php echo localize('Title');?></th>
              <th class="col-sm-1 text-center" role="columnheader"><?php echo localize('Comments');?></th>
              <th class="col-sm-1 text-center" data-tooltip="tooltip" title="<?php echo localize('Reviews').'/'.localize('Score');?>" role="columnheader"><?php echo localize('Reviews');?></th>
              <th class="col-3 text-center" role="columnheader"><span class="d-inline"><?php echo localize('Views');?>&nbsp;</span><button class="btn btn-secondary btn-xs d-inline" onclick="$('[data-views=\'views\']').text('0');purge('0','contentviews','<?php echo$args[1];?>');" data-tooltip="tooltip" title="<?php echo localize('Clear All');?>" role="button" aria-label="<?php echo localize('aria_clear');?>"><?php svg('libre-gui-eraser');?></button></th>
              <th class="col-sm-2" role="columnheader"></th>
            </tr>
          </thead>
          <tbody id="listtype" class="list" data-t="menu" data-c="ord">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo' danger';elseif($r['status']!='published')echo' warning';?>" role="row">
              <td role="cell">
<?php           if($r['thumb']!='')
                  echo'<a href="'.$r['file'].'" data-lightbox="lightbox" data-max-width="700"><img class="img-rounded" style="max-width:32px;" src="'.$r['thumb'].'" alt="'.$r['title'].'"></a>';
                elseif($r['file']!='')
                  echo'<a href="'.$r['file'].'" data-lightbox="lightbox" data-max-width="700"><img class="img-rounded" style="max-width:32px;" src="'.$r['file'].'" alt="'.$r['title'].'"></a>';
                elseif($r['fileURL']!='')
                  echo'<a href="'.$r['fileURL'].'" data-lightbox="lightbox" data-max-width="700"><img class="img-rounded" style="max-width:32px;" src="'.$r['fileURL'].'" alt="'.$r['title'].'"></a>';
                else
                  echo'';?>
              </td>
              <td role="cell">
                <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>" aria-label="Edit <?php echo$r['title'];?>"><?php echo $r['thumb']!=''&&file_exists($r['thumb'])?'<img class="table-thumb" src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                <?php echo$r['suggestions']==1?'<span data-tooltip="tooltip" title="'.localize('Editing Suggestions').'" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</span>':'';?>
<?php           if($r['contentType']=='proofs'){
                  $sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
                  $sp->execute([':id'=>$r['uid']]);
                  $sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                  <div class="small"><small><small><?php echo localize('Belongs to');?> <a href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>" aria-label="<?php echo localize('aria_view_proofs');?>"><?php echo$sr['username'].$sr['name']!=''?':'.$sr['name']:'';?></a></small></small></div>
<?php           }?>
              </td>
              <td class="text-center" role="cell">
<?php           if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
                  $sc=$db->prepare("SELECT COUNT(id) as cnt FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType");
                  $sc->execute([':id'=>$r['id'],':contentType'=>$r['contentType']]);
                  $cnt=$sc->fetch(PDO::FETCH_ASSOC);
                  $scc=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType AND status='unapproved'");
                  $scc->execute([':id'=>$r['id'],'contentType'=>$r['contentType']]);
                  $sccc=$scc->rowCount($scc);
                  echo'<a class="btn btn-secondary'.($sccc>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d43" data-tooltip="tooltip" title="'.$sccc.' '.localize('New Comments').'" role="button" aria-label="'.localize('aria_view_comments').'">'.svg2('libre-gui-comments').'&nbsp;&nbsp;'.$cnt['cnt'].'</a>';
                }?>
              </td>
              <td class="text-center" role="cell">
<?php           $sr=$db->prepare("SELECT COUNT(id) as num,SUM(cid) as cnt FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid");
                $sr->execute([':rid'=>$r['id']]);
                $rr=$sr->fetch(PDO::FETCH_ASSOC);
                $srr=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid AND status!='approved'");
                $srr->execute([':rid'=>$r['id']]);
                $src=$srr->rowCount($srr);
                echo$rr['num']>0?'<a class="btn btn-secondary'.($src>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d60"'.($src>0?' data-tooltip="tooltip" title="'.$src.' '.localize('New Reviews').'"':'').' role="button" aria-label="'.localize('aria_view_reviews').'">'.$rr['num'] .'/'.$rr['cnt'].'</a>':'';?>
              </td>
              <td class="text-center" role="cell">
                <button class="btn btn-secondary trash" onclick="$('#views<?php echo$r['id'];?>').text('0');updateButtons('<?php echo$r['id'];?>','content','views','0');" data-tooltip="tooltip" title="<?php echo localize('Clear');?>" role="button" aria-label="<?php echo localize('aria_clear');?>"><?php svg('libre-gui-eraser');?>&nbsp;&nbsp;<span id="views<?php echo$r['id'];?>" data-views="views"><?php echo$r['views'];?></span></button>
              </td>
              <td id="controls_<?php echo$r['id'];?>" role="cell">
                <div class="btn-group float-right" role="group">
                  <a id="pin<?php echo$r['id'];?>" class="btn btn-secondary<?php echo$r['pin']{0}==1?' btn-success':'';?>" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')" data-tooltip="tooltip" title="<?php echo localize('Pin');?>" role="button" aria-label="<?php echo localize('aria_pin');?>"><?php svg('libre-gui-pin');?></a>
                  <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/content/edit/<?php echo$r['id'];?>" data-tooltip="tooltip" title="<?php echo localize('Edit');?>" role="button" aria-label="<?php echo localize('aria_edit');?>"><?php svg('libre-gui-edit');?></a>
<?php   if($user['rank']==1000||$user['options']{0}==1){?>
                  <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="<?php echo localize('Restore');?>" role="button" aria-label="<?php echo localize('aria_restore');?>"><?php svg('libre-gui-untrash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-tooltip="tooltip" title="<?php echo localize('Purge');?>" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-purge');?></button>
<?php   }?>
                </div>
              </td>
            </tr>
<?php }?>
          </tbody>
        </table>
        <script>
          $(document).ready(function(){
            $('[data-lightbox="lightbox"]').simpleLightbox();
          });
        </script>
      </div>
    </div>
<?php }?>
  </div>
</main>
<?php }
    if($show=='item')
      include'core'.DS.'layout'.DS.'edit_content.php';
  }
}
