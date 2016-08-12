<?php
$search=isset($_POST['search'])?trim(filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING)):'';
$what=isset($_POST['what'])?filter_input(INPUT_POST,'what',FILTER_SANITIZE_STRING):'content';
$status=isset($_POST['status'])?filter_input(INPUT_POST,'status',FILTER_SANITIZE_STRING):'all';
$ord=isset($_POST['ord'])?filter_input(INPUT_POST,'ord',FILTER_SANITIZE_STRING):'desc';?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Search</h4>
    </div>
    <div class="panel-body">
        <form method="post" action="admin/search">
            <div class="form-group input-group">
                <div class="input-group-addon">Search for</div>
                <input type="text" class="form-control" name="search" value="<?php echo trim($search);?>" placeholder="Enter a Search Phrase...">
            </div>
            <div class="form-group input-group">
                <div class="input-group-addon">in</div>
                <div class="input-group-btn">
                    <select class="form-control" name="what">
                        <option value="content"<?php if($what=='content')echo' selected';?>>Content</option>
                        <option value="comments"<?php if($what=='comments')echo' selected';?>>Comments</option>
                        <option value="messages"<?php if($what=='messages')echo' selected';?>>Messages</option>
                        <option value="orders"<?php if($what=='orders')echo' selected';?>>Orders</option>
                        <option value="pages"<?php if($what=='pages')echo' selected';?>>Pages</option>
                    </select>
                </div>
                <div class="input-group-addon">where Status is</div>
                <div class="input-group-btn">
                    <select class="form-control" name="status">
                        <option value="all"<?php if($status=='all')echo' selected';?>>All</option>
                        <option value="published"<?php if($status=='published')echo' selected';?>>Published</option>
                        <option value="unpublished"<?php if($status=='unpublished')echo' selected';?>>Unpublished</option>
                    </select>
                </div>
                <div class="input-group-addon">Order By</div>
                <div class="input-group-btn">
                    <select class="form-control" name="ord">
                        <option value="desc"<?php if($ord=='desc')echo' selected';?>>Descending</option>
                        <option value="asc"<?php if($ord=='asc')echo' selected';?>>Ascending</option>
                    </select>
                </div>
                <div class="input-group-btn">
                    <button class="btn btn-default">Go</button>
                </div>
            </div>
        </form>
<?php if($search!=''){
    $qry="SELECT * FROM";
    if($what=='content')
        $qry.=" content WHERE LOWER(seoKeywords) LIKE LOWER(:search) OR LOWER(barcode) LIKE LOWER(:search) OR LOWER(fccid) LIKE LOWER(:search) OR LOWER(code) LIKE LOWER(:search) OR LOWER(brand) LIKE LOWER(:search) OR LOWER(title) LIKE LOWER(:search) OR LOWER(category_1) LIKE LOWER(:search) OR LOWER(category_2) LIKE LOWER(:search) OR LOWER(name) LIKE LOWER(:search) OR LOWER(url) LIKE LOWER(:search) OR LOWER(email) LIKE LOWER(:search) OR LOWER(business) LIKE LOWER(:search) OR LOWER(address) LIKE LOWER(:search) OR LOWER(suburb) LIKE LOWER(:search) OR LOWER(city) LIKE LOWER(:search) OR LOWER(state) LIKE LOWER(:search) OR LOWER(postcode) LIKE LOWER(:search) OR LOWER(phone) LIKE LOWER(:search) OR LOWER(mobile) LIKE LOWER(:search) OR LOWER(attributionImageTitle) LIKE LOWER(:search) OR LOWER(attributionImageName) LIKE LOWER(:search) OR LOWER(exifISO) LIKE LOWER(:search) OR LOWER(exifAperture) LIKE LOWER(:search) OR LOWER(exifFocalLength) LIKE LOWER(:search) OR LOWER(exifShutterSpeed) LIKE LOWER(:search) OR LOWER(exifCamera) LIKE LOWER(:search) OR LOWER(exifLens) LIKE LOWER(:search) OR LOWER(cost) LIKE LOWER(:search) OR LOWER(subject) LIKE LOWER(:search) OR LOWER(notes) LIKE LOWER(:search) OR LOWER(attributionContentName) LIKE LOWER(:search) OR LOWER(tags) LIKE LOWER(:search) OR LOWER(seoCaption) LIKE LOWER(:search) OR LOWER(seoDescription) LIKE LOWER(:search)";
    if($what=='comments')
        $qry.=" comments WHERE LOWER(email) LIKE LOWER(:search) OR LOWER(name) LIKE LOWER(:search) OR LOWER(notes) LIKE LOWER(:search)";
    if($what=='messages')
        $qry.=" messages WHERE LOWER(to_email) LIKE LOWER(:search) OR LOWER(to_name) LIKE LOWER(:search) OR LOWER(from_email) LIKE LOWER(:search) OR LOWER(from_name) LIKE LOWER(:search) OR LOWER(subject) LIKE LOWER(:search) OR LOWER(notes_raw) LIKE LOWER(:search) OR LOWER(attachments) LIKE LOWER(:search)";
    if($what=='orders')
        $qry.=" orders WHERE LOWER(qid) LIKE LOWER(:search) OR LOWER(iid) LIKE LOWER(:search) OR LOWER(did) LIKE LOWER(:search) OR LOWER(aid) LIKE LOWER(:search) OR LOWER(notes) LIKE LOWER(:search)";
    if($what=='pages')
        $qry.=" menu WHERE LOWER(title) LIKE LOWER(:search) OR LOWER(seoTitle) LIKE LOWER(:search) OR LOWER(attributionImageTitle) LIKE LOWER(:search) OR LOWER(attributionImageName) LIKE LOWER(:search) OR LOWER(seoKeywords) LIKE LOWER(:search) OR LOWER(seoDescription) LIKE LOWER(:search) OR LOWER(seoCaption) LIKE LOWER(:search) OR LOWER(notes) LIKE LOWER(:search)";
    if($status=='published'&&$what!='pages')
        $qry.=" AND status='published'";
    elseif($status=='unpublished'&&$what!='pages')
        $qry.=" AND status='unpublished'";
    if($status=='active')
        $qry.=" AND active='1'";
    if($status=='inactive')
        $qry.=" AND active='0'";
    if($ord=='asc'){
        if($what=='pages')
            $qry.=" ORDER BY title ASC";
        else
            $qry.=" ORDER BY ti ASC";
    }
    if($ord=='desc'){
        if($what=='pages')
            $qry.=" ORDER BY title DESC";
        else
            $qry.=" ORDER BY ti DESC";
    }
    $s=$db->prepare($qry);
    $s->execute(array(':search'=>'%'.$search.'%'));
    while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
        <div class="searchresults clearfix" data-status="<?php echo$r['status'];?>">
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo URL.$settings['system']['admin'];if($what=='pages')echo'/pages';elseif($what=='orders')echo'/orders';else echo'/content';?>"><?php echo ucfirst($what);?></a>
                </li>
<?php if($what=='content'){?>
                <li>
                    <a href="<?php echo URL.$settings['system']['admin'].'/content/type/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']);?></a>
                </li>
<?php }?>
                <li>
                    <a href="<?php echo URL.$settings['system']['admin'].'/'.$what.'/edit/'.$r['id'];?>"><?php if($what=='orders'){echo$r['qid'].$r['iid'];if($r['aid']!='')echo'/'.$r['aid'];}else echo$r['title'];?></a>
                </li>
            </ol>
            <small class="text-success"><?php echo URL.$settings['system']['admin'].'/'.$what.'/edit/'.$r['id'];?></small><br>
            <small class="float-left" style="margin-left:10px;">
<?php if($what=='content'){
    if($r['thumb']!=''&&file_exists('media/'.$r['thumb']))
        echo'<img src="media/'.$r['file'].'" class="img-thumbnail">';
    elseif($r['file']!=''&&file_exists('media/'.$r['file']))
        echo'<img src="media/'.$r['file'].'" class="img-thumbnail">';
    elseif($r['fileURL']!='')
        echo'<img src="'.$r['fileURL'].'" class="img-thumbnail">';
    else
        echo'';
}
    echo strip_tags(substr($r['notes'],0,800),'<a>');?>
            </small>
        </div>
        <hr>
<?php }
}?>
    </div>
</div>
