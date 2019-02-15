<?php
$q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
$q->execute(array(':id'=>$args[1]));
$r=$q->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Content</li>
    <li class="breadcrumb-item">Newsletters</li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active" aria-current="page"><strong id="titleupdate"><?php echo$r['title'];?></strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="Pace.restart();$('#sp').load('core/newsletter.php?id=<?php echo$r['id'];?>&act=');return false;" data-tooltip="tooltip" data-placement="left" title="Send Newsletters"><?php svg('libre-gui-email-send');?></a>
        <?php if($help['newsletters_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['newsletters_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['newsletters_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['newsletters_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card col-sm-12">
      <div class="card-body">
        <div id="notification"></div>
        <div class="form-group row">
          <label for="title" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <?php echo($user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-fingerprint').'</button></div>':'');?>
            <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" placeholder="Enter a Subject..." onkeyup="$('#titleupdate').text($(this).val());">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ti" class="control-label col-xs-4 col-sm-3 col-lg-2">Created</label>
          <div class="input-group col-xs-8 col-sm-9 col-lg-10">
            <input type="text" id="ti" class="form-control" value="<?php echo date('M jS, Y g:i A',$r['ti']);?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="published" class="col-form-label col-sm-2">Status</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="status">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo$user['options']{1}==0?' readonly':'';?> data-toggle="tooltip" title="Change Status" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status">
              <option value="unpublished"<?php echo$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
              <option value="published"<?php echo$r['status']=='published'?' selected':'';?>>Published</option>
              <option value="delete"<?php echo$r['status']=='delete'?' selected':'';?>>Delete</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2"></label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary btn-sm fingerprint" data-dbgid="da">'.svg2('libre-gui-fingerprint').'</button></div><div id="da" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="notes"></div>':'';?>
            <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
            <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="content">
              <input type="hidden" name="c" value="notes">
              <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
