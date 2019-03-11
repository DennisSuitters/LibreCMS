<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Displays a Content Items
 *
 * content.php version 2.0.1
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
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header
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
      $schema='Product';
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
    $s=$db->prepare("UPDATE `".$prefix."content` SET title=:title WHERE id=:id");
    $s->execute([':title'=>$args[0],':id'=>$id]);
    if($view!='bookings')$show='item';
    $rank=0;
    $args[0]='edit';
    $args[1]=$id;
    echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/content/edit/'.$args[1].'");/*]]>*/</script>';
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
        if(isset($args[1])){
          $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
          $s->execute([':category_1'=>str_replace('-',' ',$args[0]),':category_2'=>str_replace('-',' ',$args[1])]);
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
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
<?php if($args[1]!=''){?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($args[1]).(in_array($args[1],array('article','service'))?'s':'');?></li>
<?php }?>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
<?php if($args[1]!=''){?>
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'];?>/add/<?php echo$args[1];?>" data-tooltip="tooltip" data-placement="left" title="Add New <?php echo ucfirst($args[1]);?>"><?php svg('libre-gui-add');?></a>
<?php }
      if($help['content_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['content_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
      if($help['content_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
<?php if($args[0]==''){?>
    <noscript><div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none">The Administration works better on larger displays, such as Laptop or Desktop screen sizes. On smaller screens some Elements may be truncated or cut off, making usage difficult.</div>
    <div class="row">
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/media';?>">
        <span class="card">
          <span class="card-header h3">Media</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-picture','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/pages';?>">
        <span class="card">
          <span class="card-header h3">Pages</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-content','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>">
        <span class="card">
          <span class="card-header h3">Scheduler</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-calendar-time','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/article';?>">
        <span class="card">
          <span class="card-header h3">Articles</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-content','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/portfolio';?>">
        <span class="card">
          <span class="card-header h3">Portfolio</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-portfolio','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/events';?>">
        <span class="card">
          <span class="card-header h3">Events</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-calendar','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/news';?>">
        <span class="card">
          <span class="card-header h3">News</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-email-read','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>">
        <span class="card">
          <span class="card-header h3">Testimonials</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-testimonial','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/inventory';?>">
        <span class="card">
          <span class="card-header h3">Inventory</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-shipping','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/rewards';?>">
        <span class="card">
          <span class="card-header h3">Rewards</span>
          <span class="card-body card-text text-center"><?php svg('libre-credit-card','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/service';?>">
        <span class="card">
          <span class="card-header h3">Services</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-service','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/gallery';?>">
        <span class="card">
          <span class="card-header h3">Gallery</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-gallery','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/content/type/proofs';?>">
        <span class="card">
          <span class="card-header h3">Proofs</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-proof','libre-5x');?></span>
        </span>
      </a>
      <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>">
        <span class="card">
          <span class="card-header h3">Newsletters</span>
          <span class="card-body card-text text-center"><?php svg('libre-gui-newspaper','libre-5x');?></span>
        </span>
      </a>
    </div>
<?php }else{?>
    <div class="card">
      <div class="card-body">
        <table class="table table-condensed table-striped table-hover">
          <thead>
            <tr>
              <th></th>
              <th class="col">Title</th>
              <th class="col-sm-1 text-center">Comments</th>
              <th class="col-sm-1 text-center" data-tooltip="tooltip" title="Reviews/score">Reviews</th>
              <th class="col-3 text-center"><span class="d-inline">Views&nbsp;</span><button class="btn btn-secondary btn-xs d-inline" onclick="$('[data-views=\'views\']').text('0');purge('0','contentviews','<?php echo$args[1];?>');" data-tooltip="tooltip" title="Clear All"><?php svg('libre-gui-eraser');?></button>
              </th>
              <th class="col-sm-2"></th>
            </tr>
          </thead>
          <tbody id="listtype" class="list" data-t="menu" data-c="ord">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo' danger';elseif($r['status']!='published')echo' warning';?>">
              <td>
<?php   if($r['thumb']!='')
          echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['thumb'].'">';
        elseif($r['file']!='')
          echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['file'].'">';
        elseif($r['fileURL']!='')
          echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['fileURL'].'">';
        else
          echo'';?>
              </td>
              <td>
                <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?php echo $r['thumb']!=''&&file_exists($r['thumb'])?'<img class="table-thumb" src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                <?php echo$r['suggestions']==1?'<span data-tooltip="tooltip" title="Editing suggestions.">'.svg2('libre-gui-lightbulb').'</span>':'';?>
<?php   if($r['contentType']=='proofs'){
          $sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
          $sp->execute([':id'=>$r['uid']]);
          $sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                <div class="small"><small><small>Belongs to <a href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>"><?php echo$sr['username'].$sr['name']!=''?':'.$sr['name']:'';?></a></small></small></div>
<?php   }?>
              </td>
              <td class="text-center">
<?php   if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
          $sc=$db->prepare("SELECT COUNT(id) as cnt FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType");
          $sc->execute([':id'=>$r['id'],':contentType'=>$r['contentType']]);
          $cnt=$sc->fetch(PDO::FETCH_ASSOC);
          $scc=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType AND status='unapproved'");
          $scc->execute([':id'=>$r['id'],'contentType'=>$r['contentType']]);
          $sccc=$scc->rowCount($scc);
          echo'<a class="btn btn-secondary'.($sccc>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d43" data-tooltip="tooltip" title="'.$sccc.' New Comments">'.svg2('libre-gui-comments').'&nbsp;&nbsp;'.$cnt['cnt'].'</a>';
        }?>
              </td>
              <td class="text-center">
<?php   $sr=$db->prepare("SELECT COUNT(id) as num,SUM(cid) as cnt FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid");
        $sr->execute([':rid'=>$r['id']]);
        $rr=$sr->fetch(PDO::FETCH_ASSOC);
        $srr=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid AND status!='approved'");
        $srr->execute([':rid'=>$r['id']]);
        $src=$srr->rowCount($srr);
        echo$rr['num']>0?'<a class="btn btn-secondary'.($src>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d60"'.($src>0?' data-tooltip="tooltip" title="'.$src.' New Reviews"':'').'>'.$rr['num'] .'/'.$rr['cnt'].'</a>':'';?>
              </td>
              <td class="text-center">
                <button class="btn btn-secondary trash" onclick="$('#views<?php echo$r['id'];?>').text('0');updateButtons('<?php echo$r['id'];?>','content','views','0');" data-tooltip="tooltip" title="Clear"><?php svg('libre-gui-eraser');?>&nbsp;&nbsp;<span id="views<?php echo$r['id'];?>" data-views="views"><?php echo$r['views'];?></span></button>
              </td>
              <td id="controls_<?php echo$r['id'];?>">
                <div class="btn-group float-right">
                  <a id="pin<?php echo$r['id'];?>" class="btn btn-secondary<?php echo$r['pin']{0}==1?' btn-success':'';?>" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')" data-tooltip="tooltip" title="Pin"><?php svg('libre-gui-pin');?></a>
                  <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/content/edit/<?php echo$r['id'];?>" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></a>
<?php   if($user['rank']==1000||$user['options']{0}==1){?>
                  <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="Restore"><?php svg('libre-gui-untrash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-tooltip="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
<?php   }?>
                </div>
              </td>
            </tr>
<?php }?>
          </tbody>
        </table>
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
