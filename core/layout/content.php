<?php
$rank=0;
$show='categories';
if($view=='add'){
    $ti=time();
    $schema='';
    $comments=0;
    if($args[0]=='article')
        $schema='blogPost';
    if($args[0]=='inventory')
        $schema='Product';
    if($args[0]=='service')
        $schema='Service';
    if($args[0]=='gallery')
        $schema='ImageGallery';
    if($args[0]=='testimonial')
        $schema='Review';
    if($args[0]=='news')
        $schema='NewsArticle';
    if($args[0]=='event')
        $schema='Event';
    if($args[0]=='portfolio')
        $schema='CreativeWork';
    if($args[0]=='proof'){
        $schema='CreativeWork';
        $comments=1;
    }
    $q=$db->prepare("INSERT INTO content (options,uid,login_user,contentType,schemaType,status,active,ti,eti,pti) VALUES ('00000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:ti,:ti,:ti)");
    if(isset($user['id']))
        $uid=$user['id'];
    else
        $uid=0;
    if($user['name']!='')
        $login_user=$user['name'];
    else
        $login_user=$user['username'];
    $q->execute(array(
        ':contentType'=>$args[0],
        ':uid'=>$uid,
        ':login_user'=>$login_user,
        ':schemaType'=>$schema,
        ':ti'=>$ti
    ));
    $id=$db->lastInsertId();
    $args[0]=ucfirst($args[0]).' '.$id;
    $s=$db->prepare("UPDATE content SET title=:title WHERE id=:id");
    $s->execute(array(
        ':title'=>$args[0],
        ':id'=>$id
    ));
    if($view!='bookings')
        $show='item';
    $rank=0;
    $args[0]='edit';
    $args[1]=$id;
}
if($args[0]=='edit'){
    $s=$db->prepare("SELECT * FROM content WHERE id=:id");
    $s->execute(array(
        ':id'=>$args[1]
    ));
    $show='item';
}
if($args[0]=='settings'){
    include'core'.DS.'layout'.DS.'set_content.php';
}else{
if($show=='categories'){
    if($args[0]=='type'){
        $s=$db->prepare("SELECT * FROM content WHERE
            contentType=:contentType
            AND contentType!='message_primary'
            ORDER BY pin DESC,ti DESC,title ASC");
        $s->execute(array(
            ':contentType'=>$args[1]
        ));
    }else{
        if(isset($args[1])){
            $s=$db->prepare("SELECT * FROM content WHERE
                LOWER(category_1) LIKE LOWER(:category_1)
                AND LOWER(category_2) LIKE LOWER(:category_2)
                AND contentType!='message_primary'
                ORDER BY pin DESC,ti DESC,title ASC");
            $s->execute(array(
                ':category_1'=>str_replace('-',' ',$args[0]),
                ':category_2'=>str_replace('-',' ',$args[1])
            ));
        }elseif(isset($args[0])){
            $s=$db->prepare("SELECT * FROM content WHERE
                LOWER(category_1) LIKE LOWER(:category_1)
                AND contentType!='message_primary'
                ORDER BY pin DESC,ti ASC,title ASC");
            $s->execute(array(
                ':category_1'=>str_replace('-',' ',$args[0])
            ));
        }else{
            $s=$db->prepare("SELECT * FROM content WHERE
                contentType!='booking' AND
                contentType!='message_primary'
                ORDER BY pin DESC,ti DESC,title ASC");
            $s->execute();
        }
    }?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-8">
            <ol class="breadcrumb">
                <li><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
                <li class="active relative">
                    <a class="dropdown-toggle" data-toggle="dropdown"><?php if(isset($args[1])&&$args[1]!='')echo ucfirst($args[1]);else echo'All';?> <i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">All</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/article">Article</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/portfolio">Portfolio</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/events">Event</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/news">News</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/testimonials">Testimonial</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/inventory">Inventory</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/service">Service</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/gallery">Gallery</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/proofs">Proof</a></li>
                    </ul>
                </li>
            </ol>
        </h4>
        <div class="pull-right">
<?php if($user['rank']==1000||$user['options']{0}==1){?>
            <div class="btn-group"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Add"';?>>
                <button class="btn btn-default add btn-xs dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php svg('add');?></button>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/article">Article</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/portfolio">Portfolio</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/events">Event</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/news">News</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/testimonials">Testimonial</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/inventory">Inventory</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/service">Service</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/gallery">Gallery</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/proofs">Proof</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/content/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
            </div>
<?php }?>
            <div class="btn-group">
                <a target="_blank" class="btn btn-default info btn-xs" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#content"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-xs-5">Title</th>
                        <th class="col-xs-1 hidden-xs"></th>
                        <th class="col-xs-1 text-center hidden-xs">Comments</th>
                        <th class="col-xs-1 text-center hidden-xs"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Reviews/score"';?>>Reviews</th>
                        <th class="col-xs-1 text-center hidden-xs">Views</th>
                        <th class="col-xs-3"></th>
                    </tr>
                </thead>
                <tbody id="listtype" class="list" data-t="menu" data-c="ord">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo' danger';elseif($r['status']=='unpublished')echo'warning';?>">
                        <td>
                            <div class="visible-xs"><small><?php echo ucfirst($r['contentType']);?></small></div>
                            <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?php echo$r['title'];?></a>
                        </td>
                        <td class="text-center hidden-xs">
                            <?php echo ucfirst($r['contentType']);?>
                        </td>
                        <td class="text-center hidden-xs">
<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
    $sc=$db->prepare("SELECT COUNT(id) as cnt FROM comments WHERE rid=:id AND status='unapproved'");
    $sc->execute(array(':id'=>$r['id']));
    $cnt=$sc->fetch(PDO::FETCH_ASSOC);?>
                            <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>#d43"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Comments"';?>><?php svg('comments');?> <?php echo$cnt['cnt'];?></a>
<?php }?>
                        </td>
                        <td class="text-center hidden-xs">
<?php $sr=$db->prepare("SELECT COUNT(id) as num,SUM(cid) as cnt FROM comments WHERE contentType='review' AND rid=:rid AND status='approved'");
    $sr->execute(array(':rid'=>$r['id']));
    $rr=$sr->fetch(PDO::FETCH_ASSOC);
    if($rr['num']!=0)
    echo'<a href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d60">'.$rr['num'].'/'.$rr['cnt'].'</a>';?>
                        </td>
                        <td class="text-center hidden-xs">
                            <span id="views<?php echo$r['id'];?>"><?php echo$r['views'];?></span> <button class="btn btn-default btn-xs trash" onclick="$('#views<?php echo$r['id'];?>').text('0');update('<?php echo$r['id'];?>','content','views','0');"><?php svg('eraser');?></button>
                        </td>
                        <td id="controls_<?php echo$r['id'];?>" class="text-right">
                            <a id="pin<?php echo$r['id'];?>" class="btn btn-default<?php if($r['pin']{0}==1)echo' btn-success';?> btn-xs hidden-xs" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Pin"';?>><?php svg('pin');?></a>
                            <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'];?>/content/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php svg('edit');?></a>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
                            <button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><?php svg('restore');?></button>
                            <button class="btn btn-default btn-xs trash<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><?php svg('trash');?></button>
                            <button class="btn btn-default btn-xs trash<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','content')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><?php svg('purge');?></button>
                        </td>
                    </tr>
<?php }
}?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php }
if($show=='item'){
    $r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-8">
            <ol class="breadcrumb">
                <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/">Content</a></li>
                <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/<?php echo$r['contentType'];?>"><?php echo ucfirst($r['contentType']);?></a></li>
                <li class="active relative"><?php $so=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND id NOT LIKE :id ORDER BY title ASC, ti DESC");$so->execute(array(':id'=>$r['id'],':contentType'=>$r['contentType'].'%'));?><a class="dropdown-toggle" data-toggle="dropdown"><?php echo$r['title'];?> <i class="caret"></i></a><ul class="dropdown-menu"><?php while($ro=$so->fetch(PDO::FETCH_ASSOC)){?><li><a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$ro['id'];?>"><?php echo$ro['title'];?></a></li><?php }?></ul></li>
            </ol>
        </h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/content/type/'.$r['contentType'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
            </div>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
            <div class="btn-group"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Add"';?>>
                <button class="btn btn-default add btn-xs dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php svg('add');?></button>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/article">Article</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/portfolio">Portfolio</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/events">Event</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/news">News</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/testimonials">Testimonial</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/inventory">Inventory</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/service">Service</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/gallery">Gallery</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/proofs">Proof</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <a target="_blank" class="btn btn-default info btn-xs" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#content-edit"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
            </div>
        </div>
    </div>
<?php }?>
    <div class="panel-body">
        <ul class="nav nav-tabs" role="tablist">
            <li id="d000" role="presentation" class="active"><a href="#d0" aria-controls="d0" role="tab" data-toggle="tab">Content</a></li>
            <li id="d026" class="" role="presentation"><a href="#d26" aria-controls="d26" role="tab" data-toggle="tab">Images</a></li>
            <li id="o0pts" class="" role="presentation"><a href="#opts" aria-controls="opts" role="tab" data-toggle="tab">Options</a></li>
            <li id="d043" class="<?php if($r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery')echo'hidden';?>" role="presentation"><a href="#d43" aria-controls="d43" role="tab" data-toggle="tab">Comments</a></li>
            <li id="d060" class="<?php if($r['contentType']=='testimonials'||$r['contentType']=='event'||$r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='news'||$r['contentType']=='portfolio'||$r['contentType']=='proof')echo'hidden';?>" role="presentation"><a href="#d60" aria-controls="d60" role="tab" data-toggle="tab">Reviews</a></li>
            <li id="d044" role="presentation"><a href="#d44" aria-controls="d44" role="tab" data-toggle="tab">SEO</a></li>
            <li id="d050" role="presentation"><a href="#d50" aria-controls="d50" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
<?php /* content */ ?>
            <div id="d0" role="tabpanel" class="tab-pane active">
                <div id="d1" class="form-group clearfix">
                    <label for="title" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="btn-danger" placeholder="Content MUST contain a title or it won't be accessible...">
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Content MUST contain a Title, or it won't be accessible...</small>
                </div>
                <div id="d2" class="form-group">
                    <label for="ti" class="control-label col-xs-5 col-sm-3 col-lg-2">Created</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
                    </div>
                </div>
                <div id="d3" class="form-group<?php if($r['contentType']=='proofs')echo' hidden';?>">
                    <label for="pti" class="control-label col-xs-5 col-sm-3 col-lg-2">Published On</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="pti" class="form-control" data-dbid="<?php echo$r['id'];?>" value="<?php if($r['pti']>0)echo date($config['dateFormat'],$r['pti']);?>">
                    </div>
                </div>
                <div id="d4" class="form-group">
                    <label for="eti" class="control-label col-xs-5 col-sm-3 col-lg-2">Edited</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="eti" class="form-control" value="<?php echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>" readonly>
                    </div>
                </div>
                <div id="d5" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery')echo' hidden';?>">
                    <label for="cid" class="control-label col-xs-5 col-sm-3 col-lg-2">Client</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <select id="cid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','cid',$(this).val());$('#tstavinfo').toggleClass('hidden');"<?php if($user['options']{1}==0)echo' disabled';?>>
                            <option value="0">Select Client</option>
<?php $cs=$db->query("SELECT * FROM login ORDER BY name ASC, username ASC");while($cr=$cs->fetch(PDO::FETCH_ASSOC)){?>
                            <option value="<?php echo$cr['id'];?>"<?php if($r['cid']==$cr['id'])echo' selected';?>><?php echo$cr['username'].':'.$cr['name'];?></option>
<?php }?>
                        </select>
                    </div>
                </div>
                <div id="d6" class="form-group<?php if($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service')echo' hidden';?>">
                    <label for="author" class="control-label col-xs-5 col-sm-3 col-lg-2">Author</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <select id="uid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';?>>
<?php $su=$db->query("SELECT id,username,name FROM login WHERE username!='' AND status!='delete' ORDER BY username ASC, name ASC");while($ru=$su->fetch(PDO::FETCH_ASSOC)){?>
                            <option value="<?php echo$ru['id'];?>"<?php if($ru['id']==$r['uid'])echo' selected';echo'>'.$ru['username'].':'.$ru['name'];?></option><?php }?>
                        </select>
                    </div>
                </div>
                <div id="d7" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="code" class="control-label col-xs-5 col-sm-3 col-lg-2">Code</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="code" class="form-control textinput" value="<?php echo$r['code'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code" placeholder="Enter a Code..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d8" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="barcode" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Barcode</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="barcode" class="form-control textinput" value="<?php echo$r['barcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="barcode" placeholder="Enter a Barcode..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d9" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="fccid" class="control-label col-xs-5 col-sm-3 col-lg-2">FCCID</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="fccid" class="form-control textinput" value="<?php echo$r['fccid'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fccid" placeholder="Enter an FCC ID..."<?php if($user['options']{1}==0)echo' readonly';?>>
                        <div class="help-block"><a target="_blank" href="https://fccid.io/">fccid.io</a> for more information or to look up an FCC ID.</div>
                    </div>
                </div>
                <div id="d10" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="brand" class="control-label col-xs-5 col-sm-3 col-lg-2">Brand</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="brand" class="form-control textinput" value="<?php echo$r['brand'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="brand" placeholder="Enter a Brand..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d11" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="tis" class="control-label col-xs-5 col-sm-3 col-lg-2">Event Start</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="tis" class="form-control"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';if($r['tis']==0){echo'Select a Date/Time..."';}else{echo date($config['dateFormat'],$r['tis']).'"';}}?> value="<?php if($r['tis']!=0)echo date('Y-m-d h:m',$r['tis']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" placeholder="Select a Date/Time..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d12" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="tie" class="control-label col-xs-5 col-sm-3 col-lg-2">Event End</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="tie" class="form-control"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';if($r['tie']==0)echo'Select a Date/Time..."';else echo date($config['dateFormat'],$r['tie']).'"';}?> value="<?php if($r['tie']!=0)echo date('Y-m-d h:m',$r['tie']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" placeholder="Select a Date/Time..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d13" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery')echo' hidden';?> clearfix">
                    <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
<?php if($r['ip']!=''){?>
                    <span class="col-xs-7 col-sm-9 col-lg-10 pull-right help-block"><?php echo$r['ip'];?></span>
<?php }?>
                </div>
                <div id="d14" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery')echo' hidden';?>">
                    <label for="name" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d15" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery')echo' hidden';?>">
                    <label for="url" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url" placeholder="Enter a URL..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d16" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery')echo' hidden';?>">
                    <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d17" class="form-group<?php if($r['contentType']=='testimonials')echo' hidden';?>">
                    <label for="category_1" class="control-label col-xs-5 col-sm-3 col-lg-2">Category Primary</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1" placeholder="Enter a Category/Select from List..."<?php if($user['options']{1}==0)echo' readonly';?>>
                        <datalist id="category_1_options">
<?php $s=$db->query("SELECT DISTINCT category_1 FROM content WHERE category_1!='' ORDER BY category_1 ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_1'].'"/>';?>
                        </datalist>
                    </div>
                </div>
                <div id="d18" class="form-group<?php if($r['contentType']=='testimonials')echo' hidden';?>">
                    <label for="category_2" class="control-label col-xs-5 col-sm-3 col-lg-2">Category Secondary</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2" placeholder="Enter a Category/Select from List..."<?php if($user['options']{1}==0)echo' readonly';?>>
                        <datalist id="category_2_options">
<?php $s=$db->query("SELECT DISTINCT category_2 FROM content WHERE category_2!='' ORDER BY category_2 ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_2'].'"/>';?>
                        </datalist>
                    </div>
                </div>
                <div id="d19" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="cost" class="control-label col-xs-5 col-sm-3 col-lg-2">Cost</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="input-group-addon">$</div>
                        <input type="text" id="cost" class="form-control textinput" value="<?php echo$r['cost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" placeholder="Enter a Cost..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d20" class="form-group clearfix<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0"<?php if($r['options']{0}==1)echo' checked';if($user['options']{1}==0)echo' readonly';?>>
                            <label for="options0">Show Cost</label>
                        </div>
                    </div>
                </div>
                <div id="d21" class="form-group<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <label for="quantity" class="control-label col-xs-5 col-sm-3 col-lg-2">Quantity</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="quantity" class="form-control textinput" value="<?php echo$r['quantity'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="quantity" placeholder="Enter a Quantity..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d22" class="form-group clearfix<?php if($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs')echo' hidden';?>">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="featured0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0"<?php if($r['featured']{0}==1)echo' checked';if($user['options']{1}==0)echo' readonly';?>>
                            <label for="featured0">Featured</label>
                        </div>
                    </div>
                </div>
                <div id="d23" class="form-group">
                    <div class="input-group col-xs-12">
                        <form id="summernote" method="post" target="sp" action="core/update.php">
                            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                            <input type="hidden" name="t" value="content">
                            <input type="hidden" name="c" value="notes">
                            <textarea id="notes" class="form-control summernote" name="da"><?php echo$r['notes'];?></textarea>
                        </form>
                    </div>
                </div>
                <fieldset id="d24" class="control-fieldset<?php if($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <legend class="control-legend">Content Attribution</legend>
                    <div id="d25" class="form-group">
                        <label for="attributionContentName" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" id="attributionContentName" class="form-control textinput" value="<?php echo$r['attributionContentName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentName" placeholder="Enter a Name...">
                        </div>
                    </div>
                    <div id="d25" class="form-group">
                        <label for="attributionContentURL" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" id="attributionContentURL" class="form-control textinput" value="<?php echo$r['attributionContentURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentURL" placeholder="Enter a URL...">
                        </div>
                    </div>
                </fieldset>
            </div>
<?php /* images */ ?>
            <div id="d26" role="tabpanel" class="tab-pane">
                <fieldset id="d26t" class="control-fieldset<?php if($r['contentType']!='testimonials'){echo' hidden';}?>">
                    <div class="form-group">
                        <div id="tstavinfo" class="alert alert-info<?php if($r['cid']==0)echo' hidden';?>">Currently using the Avatar associated with the chosen Client Account.</div>
                        <label for="avatar" class="control-label col-xs-5 col-sm-3 col-lg-2">Avatar</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" class="form-control" value="<?php echo$r['file'];?>" readonly>
                            <div class="input-group-btn">
                                <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
                                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                                    <input type="hidden" name="act" value="add_tstavatar">
                                    <div class="btn btn-default btn-file">
                                        <?php svg('browse-computer');?>
                                        <input type="file" name="fu">
                                    </div>
                                    <button class="btn btn-default" type="submit"><?php svg('upload');?></button>
                                </form>
                            </div>
                            <div class="input-group-addon img">
                                <img id="tstavatar" src="<?php if($r['file']!=''&&file_exists('media'.DS.'avatar'.DS.$r['file']))echo'media/avatar/'.$r['file'];else echo'core/images/noavatar.jpg';?>">
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file','');"><?php svg('trash');?></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset id="d26nt" class="control-fieldset<?php if($r['contentType']=='testimonials')echo' hidden';?>">
                    <div id="d27" class="form-group">
                        <label for="file" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" id="fileURL" class="form-control textinput" value="<?php echo$r['fileURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileURL" placeholder="Enter a URL...">
                            <div class="input-group-btn">
                                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','fileURL');"><?php svg('trash');?></button>
                            </div>
                        </div>
                    </div>
                    <div id="d28" class="form-group clearfix">
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
                            <input id="file" type="text" class="form-control" value="<?php echo$r['file'];?>" readonly>
                            <div class="input-group-btn">
                                <button class="btn btn-default" onclick="mediaDialog('<?php echo$r['id'];?>','content','file');"><?php svg('browse-media');?></button>
                            </div>
                            <div class="input-group-addon img">
<?php $rfile=basename($r['file']);
if($r['file']!=''&&file_exists('media'.DS.$rfile))
    echo'<a href="'.$r['file'].'" data-featherlight="image"><img id="fileimage" src="'.$r['file'].'"></a>';
elseif($r['fileURL']!='')
    echo'<a href="'.$r['fileURL'].'" data-featherlight="image"><img id="fileimage" src="'.$r['fileURL'].'"></a>';
else echo'<img id="fileimage" src="core/images/noimage.jpg">';?>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file');"><?php svg('trash');?></button>
                            </div>
                        </div>
                    </div>
                    <div id="d29" class="form-group clearfix">
                        <label for="thumb" class="control-label col-xs-5 col-sm-3 col-lg-2">Thumbnail</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
                            <input id="thumb" type="text" class="form-control" value="<?php echo$r['thumb'];?>" readonly>
                            <div class="input-group-btn">
                                <button class="btn btn-default" onclick="mediaDialog('<?php echo$r['id'];?>','content','thumb');"><?php svg('browse-media');?></button>
                            </div>
                            <div class="input-group-addon img">
<?php $rthumb=basename($r['thumb']);
if($r['thumb']!=''&&file_exists('media'.DS.$rthumb))
    echo'<a href="'.$r['thumb'].'" data-featherlight="image"><img id="thumbimage" src="'.$r['thumb'].'"></a>';
else echo'<img id="thumbimage" src="core/images/noimage.jpg">';?>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','thumb');"><?php svg('trash');?></button>
                            </div>
                        </div>
                        <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Uploaded Images take Precedence over URL's.</div>
                    </div>
                    <fieldset id="d30" class="control-fieldset">
                        <legend class="control-legend">Exif Information</legend>
                        <div id="d31" class="form-group">
                            <label for="exifFilename" class="control-label col-xs-5 col-sm-3 col-lg-2">Original Filename</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" class="form-control" value="<?php echo$r['exifFilename'];?>" placeholder="Original Filename..." readonly>
                            </div>
                        </div>
                        <div id="d32" class="form-group">
                            <label for="exifCamera" class="control-label col-xs-5 col-sm-3 col-lg-2">Camera</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="exifCamera" class="form-control textinput" value="<?php echo$r['exifCamera'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifCamera" placeholder="Enter Camera Brand...">
                            </div>
                        </div>
                        <div id="d33" class="form-group">
                            <label for="exifLens" class="control-label col-xs-5 col-sm-3 col-lg-2">Lens</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="exifLens" class="form-control textinput" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifLens" placeholder="Enter Lens...">
                            </div>
                        </div>
                        <div id="d34" class="form-group">
                            <label for="exifAperture" class="control-label col-xs-5 col-sm-3 col-lg-2">Aperture</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="exifAperture" class="form-control textinput" value="<?php echo$r['exifAperture'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifAperture" placeholder="Enter Aperture/FStop...">
                            </div>
                        </div>
                        <div id="d35" class="form-group">
                            <label for="exifFocalLength" class="control-label col-xs-5 col-sm-3 col-lg-2">Focal Length</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="exifFocalLength" class="form-control textinput" value="<?php echo$r['exifFocalLength'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFocalLength" placeholder="Enter Focal Length...">
                            </div>
                        </div>
                        <div id="d36" class="form-group">
                            <label for="exifShutterSpeed" class="control-label col-xs-5 col-sm-3 col-lg-2">Shutter Speed</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="exifShutterSpeed" class="form-control textinput" value="<?php echo$r['exifShutterSpeed'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifShutterSpeed" placeholder="Enter Shutter Speed...">
                            </div>
                        </div>
                        <div id="d37" class="form-group">
                            <label for="exifISO" class="control-label col-xs-5 col-sm-3 col-lg-2">ISO</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="exifISO" class="form-control textinput" value="<?php echo$r['exifISO'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifISO" placeholder="Enter ISO...">
                            </div>
                        </div>
                        <div id="d38" class="form-group">
                            <label for="exifti" class="control-label col-xs-5 col-sm-3 col-lg-2">Taken</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="exifti" class="form-control textinput" value="<?php if($r['exifti']!=0){echo date($config['dateFormat'],$r['exifti']);}?>" placeholder="Select the Date/Time Image was Taken..." readonly>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="d39" class="control-fieldset">
                        <legend class="control-legend">Image Atrribution</legend>
                        <div id="d40" class="form-group">
                            <label for="attributionImageTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
                            </div>
                        </div>
                        <div id="d41" class="form-group">
                            <label for="attributionImageName" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="attributionImageName" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageName" placeholder="Enter a Name...">
                            </div>
                        </div>
                        <div id="d42" class="form-group">
                            <label for="attributionImageURL" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <input type="text" id="attributionImageURL" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL" placeholder="Enter a URL...">
                            </div>
                        </div>
                    </fieldset>
                </fieldset>
            </div>
<?php /* options */ ?>
            <div id="opts" role="tabpanel" class="tab-pane<?php if($r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery')echo' hidden';?>">
                <fieldset class="control-fieldset">
                    <legend class="control-legend">Options</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-lg-2">&nbsp;</label>
                        <form target="sp" method="post" action="core/add_data.php">
                            <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
                            <input type="hidden" name="act" value="add_option">
                            <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                                <span class="input-group-addon">Option</span>
                                <input type="text" class="form-control" name="ttl" value="" placeholder="Enter an Option Title...">
                                <span class="input-group-addon">Quantity</span>
                                <input type="text" class="form-control" name="qty" value="" placeholder="Quantity">
                                <div class="input-group-btn">
                                    <button class="btn btn-default add"><?php svg('plus');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="itemoptions">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE rid=:rid ORDER BY title ASC");
    $ss->execute(array(':rid'=>$r['id']));
    while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                        <div id="l_<?php echo$rs['id'];?>" class="form-group">
                            <label class="control-label hidden-xs col-sm-3 col-lg-2">&nbsp;</label>
                            <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                                <span class="input-group-addon">Option</span>
                                <input type="text" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'title',$(this).val());" placeholder="Enter an Option Title...">
                                <span class="input-group-addon">Quantity</span>
                                <input type="text" class="form-control" value="<?php echo$rs['ti'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'ti',$(this).val());" placeholder="Quantity...">
                                <div class="input-group-btn">
                                    <form target="sp" action="core/purge.php">
                                        <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                                        <input type="hidden" name="t" value="choices">
                                        <button class="btn btn-default trash"><?php svg('trash');?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
<?php }?>
                    </div>
                </fieldset>
            </div>
<?php /* comments */ ?>
            <div id="d43" role="tabpanel" class="tab-pane<?php if($r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery')echo' hidden';?>">
                <div class="form-group">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-md-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1"<?php if($r['options']{1}==1)echo' checked';?>>
                            <label for="options1">Enable Comments</label>
                        </div>
                    </div>
                </div>
                <div id="comments">
<?php $sc=$db->prepare("SELECT * FROM comments WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");$sc->execute(array(':contentType'=>$r['contentType'],':rid'=>$r['id']));while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                    <div id="l_<?php echo$rc['id'];?>" class="media clearfix<?php if($rc['status']=='delete')echo' danger';if($rc['status']=='unapproved')echo' warning';?>">
                        <div class="media-object col-xs-2 col-sm-1 pull-left">
<?php $su=$db->prepare("SELECT * FROM login WHERE id=:id");$su->execute(array(':id'=>$rc['uid']));$ru=$su->fetch(PDO::FETCH_ASSOC);?>
                            <img class="commentavatar img-thumbnail img-responsive" src="<?php if($ru['avatar']!=''&&file_exists('media/avatar/'.$ru['avatar']))echo'media/avatar/'.$ru['avatar'];elseif($ru['gravatar']!='')echo md5($ru['gravatar']);else echo$noavatar;?>">
                        </div>
                        <div class="media-body">
                            <div class="well clearfix">
                                <h5 class="media-heading"><?php echo$rc['name'];?></h5>
                                <time><small class="text-muted"><?php echo date($config['dateFormat'],$rc['ti']);?></small></time><br>
                                <?php echo strip_tags($rc['notes']);?>
                                <div id="controls-<?php echo$rc['id'];?>" class="btn-group pull-right">
                                    <button id="approve_<?php echo$rc['id'];?>" class="btn btn-default btn-sm<?php if($rc['status']!='unapproved')echo' hidden';?>" onclick="update('<?php echo$rc['id'];?>','comments','status','approved')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Approve"';?>><?php svg('approve');?></button>
                                    <button class="btn btn-default btn-sm trash" onclick="purge('<?php echo$rc['id'];?>','comments')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><?php svg('trash');?></button>
                                </div>
                            </div>
                        </div>
                    </div>
<?php }?>
                    <iframe name="comments" id="comments" class="hidden"></iframe>
                    <div class="form-group">
                        <form role="form" target="comments" method="post" action="core/add_data.php">
                            <input type="hidden" name="act" value="add_comment">
                            <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
                            <input type="hidden" name="contentType" value="<?php echo$r['contentType'];?>">
                            <label for="email" class="control-label col-xs-4 col-md-3 col-lg-2">Email</label>
                            <div class="input-group col-xs-8 col-md-9 col-lg-10">
                                <input type="text" class="form-control" name="email" value="<?php echo$user['email'];?>">
                            </div>
                            <label for="name" class="control-label col-xs-4 col-md-3 col-lg-2">Name</label>
                            <div class="input-group col-xs-8 col-md-9 col-lg-10">
                                <input type="text" class="form-control" name="name" value="<?php echo$user['name'];?>">
                            </div>
                            <label for="da" class="control-label col-xs-4 col-md-3 col-lg-2">Comment</label>
                            <div class="input-group col-xs-8 col-md-9 col-lg-10">
                                <textarea id="da" class="form-control" name="da" placeholder="Enter a Comment..." required></textarea>
                            </div>
                            <label class="control-label col-xs-4 col-md-3 col-lg-2">&nbsp;</label>
                            <div class="input-group col-xs-8 col-md-9 col-lg-10">
                                <button class="btn btn-default btn-block">Add Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<?php /* reviews */ ?>
            <div id="d60" role="tabpanel" class="tab-pane<?php if($r['contentType']=='testimonials'||$r['contentType']=='event'||$r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='news'||$r['contentType']=='portfolio'||$r['contentType']=='proof')echo' hidden';?>">
<?php $sr=$db->prepare("SELECT * FROM comments WHERE contentType='review' AND rid=:rid ORDER BY ti DESC");
$sr->execute(array(':rid'=>$r['id']));
while($rr=$sr->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?php echo$rr['id'];?>" class="media<?php if($rr['status']=='unapproved')echo' danger';?>">
                    <div class="media-body well">
                        <span class="rat">
                            <span<?php if($rr['cid']==5)echo' class="set"';?>>☆</span>
                            <span<?php if($rr['cid']==4)echo' class="set"';?>>☆</span>
                            <span<?php if($rr['cid']==3)echo' class="set"';?>>☆</span>
                            <span<?php if($rr['cid']==2)echo' class="set"';?>>☆</span>
                            <span<?php if($rr['cid']==1)echo' class="set"';?>>☆</span>
                        </span>
                        <div id="controls-<?php echo$rr['id'];?>" class="btn-group pull-right">
                            <button id="approve_<?php echo$rr['id'];?>" class="btn btn-default btn-sm<?php if($rr['status']=='approved')echo' hidden';?>" onclick="update('<?php echo$rr['id'];?>','comments','status','approved')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Approve"';?>><?php svg('approve');?></button>
                            <button class="btn btn-default btn-sm trash" onclick="purge('<?php echo$rr['id'];?>','comments')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><?php svg('trash');?></button>
                        </div>
                        <h6 class="media-heading"><?php echo$rr['name'].', '.date($config['dateFormat'],$rr['ti']);?></h6>
                        <p><?php echo$rr['notes'];?></p>
                    </div>
                </div>
<?php }?>
            </div>
<?php /* seo */ ?>
            <div id="d44" role="tabpanel" class="tab-pane">
                <div id="d45" class="form-group">
                    <label for="views" class="control-label col-xs-5 col-sm-3 col-lg-2">Views</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views"<?php if($user['options']{1}==0)echo' readonly';?>>
                        <div class="input-group-btn">
                            <button class="btn btn-default trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','content','views','0');"><?php svg('eraser');?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="metaRobots" class="control-label col-xs-5 col-sm-3 col-lg-2">Meta Robots</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="metaRobots" placeholder="Enter a Robots Option as Below...">
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">
                        Options for Meta Robots: <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default."';?>>index</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Disallow search engines from showing this page in their results."';?>>noindex</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea."';?>>noimageIndex</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all."';?>>none</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not."';?>>follow</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Tells the search engines robots to not follow any links on the page at all."';?>>nofollow</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Prevents the search engines from showing a cached copy of this page."';?>>noarchive</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Same as noarchive, but only used by MSN/Live."';?>>nocache</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page."';?>>nosnippet</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results."';?>>noodp</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag."';?>>noydir</span>
                    </small>
                </div>
                <div id="d46" class="form-group<?php if($r['contentType']=='proofs')echo' hidden';?>">
                    <label for="schemaType" class="control-label col-xs-5 col-sm-3 col-lg-2">Schema Type</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <select id="schemaType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';if($config['options']{4}==1)echo' data-toggle="tooltip" title="Schema for Microdata Content."';?>>
                            <option value="blogPost"<?php if($r['schemaType']=='blogPost')echo' selected';?>>blogPost for Articles</option>
                            <option value="Product"<?php if($r['schemaType']=='Product')echo' selected';?>>Product for Inventory</option>
                            <option value="Service"<?php if($r['schemaType']=='Service')echo' selected';?>>Service for Services</option>
                            <option value="ImageGallery"<?php if($r['schemaType']=='ImageGallery')echo' selected';?>>ImageGallery for Gallery Images</option>
                            <option value="Review"<?php if($r['schemaType']=='Review')echo' selected';?>>Review for Testimonials</option>
                            <option value="NewsArticle"<?php if($r['schemaType']=='NewsArticle')echo' selected';?>>NewsArticle for News</option>
                            <option value="Event"<?php if($r['schemaType']=='Event')echo' selected';?>>Event for Events</option>
                            <option value="CreativeWork"<?php if($r['schemaType']=='CreativeWork')echo' selected';?>>CreativeWork for Portfolio/Proofs</option>
                        </select>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php $cntc=70-strlen($r['seoTitle']);if($cntc<0){$cnt=abs($cntc);$cnt=number_format($cnt)*-1;}else{$cnt=number_format($cntc);}?>
                        <div class="input-group-addon">
                            <span id="seoTitlecnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
                        </div>
                        <div class="input-group-btn">
                            <button class="btn btn-default" onclick="removeStopWords('seoTitle',$('#seoTitle').val());"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Remove Stop Words."';?>><?php svg('magic');?></button>
                        </div>
                        <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">
                        The recommended character count for Title's is 70.
                    </small>
                </div>
                <div id="d49" class="form-group clearfix">
                    <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">Caption</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php $cntc=160-strlen($r['seoCaption']);if($cntc<0){$cnt=abs($cntc);$cnt=number_format($cnt)*-1;}else{$cnt=number_format($cntc);}?>
                        <div class="input-group-addon">
                            <span id="seoCaptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
                        </div>
                        <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoCaption" placeholder="Enter a Caption..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">
                        The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.
                    </small>
                </div>
                <div id="d49a" class="form-group clearfix">
                    <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">Description</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php $cntc=160-strlen($r['seoDescription']);if($cntc<0){$cnt=abs($cntc);$cnt=number_format($cnt)*-1;}else{$cnt=number_format($cntc);}?>
                        <div class="input-group-addon">
                            <span id="seoDescriptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
                        </div>
                        <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoDescription" placeholder="Enter a Description..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">
                        The recommended character count for Descriptions is 160.
                    </small>
                </div>
                <div id="d47" class="form-group<?php if($r['contentType']=='proofs')echo' hidden';?>">
                    <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">Keywords</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoKeywords" placeholder="Enter Keywords..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
                <div id="d48" class="form-group">
                    <label for="tags" class="control-label col-xs-5 col-sm-3 col-lg-2">Tags</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags" placeholder="Enter Tags..."<?php if($user['options']{1}==0)echo' readonly';?>>
                    </div>
                </div>
            </div>
<?php /* settings */ ?>
            <div id="d50" role="tabpanel" class="tab-pane">
                <div id="d51" class="form-group">
                    <label for="published" class="control-label col-xs-5 col-sm-3 col-lg-2">Status</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
                            <option value="unpublished"<?php if($r['status']=='unpublished')echo' selected';?>>Unpublished</option>
                            <option value="published"<?php if($r['status']=='published')echo' selected';?>>Published</option>
                            <option value="delete"<?php if($r['status']=='delete')echo' selected';?>>Delete</option>
                        </select>
                    </div>
                </div>
                <div id="d52" class="form-group">
                    <label for="contentType" class="control-label col-xs-5 col-sm-3 col-lg-2">Content Type</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <select id="contentType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';if($config['options']{4}==1)echo' data-toggle="tooltip" title="Change the Type of Content this Item belongs to."';?>>
                            <option value="article"<?php if($r['contentType']=='article')echo' selected';?>>Article</option>
                            <option value="portfolio"<?php if($r['contentType']=='portfolio')echo' selected';?>>Portfolio</option>
                            <option value="events"<?php if($r['contentType']=='events')echo' selected';?>>Event</option>
                            <option value="news"<?php if($r['contentType']=='news')echo' selected';?>>News</option>
                            <option value="testimonials"<?php if($r['contentType']=='testimonials')echo' selected';?>>Testimonial</option>
                            <option value="inventory"<?php if($r['contentType']=='inventory')echo' selected';?>>Inventory</option>
                            <option value="service"<?php if($r['contentType']=='service')echo' selected';?>>Service</option>
                            <option value="gallery"<?php if($r['contentType']=='gallery')echo' selected';?>>Gallery</option>
                            <option value="proofs"<?php if($r['contentType']=='proofs')echo' selected';?>>Proof</option>
                        </select>
                    </div>
                </div>
                <div id="d53" class="form-group clearfix<?php if($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='gallery')echo' hidden';?>">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="internal0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0"<?php if($r['internal']==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
                            <label for="internal0">Internal</label>
                        </div>
                    </div>
                </div>
                <div id="d54" class="form-group clearfix<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='gallery'||$r['contentType']=='proofs')echo' hidden';?>">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="bookable0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0"<?php if($r['bookable']==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
                            <label for="bookable0">Bookable</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
}
