<?php
require'../db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT * FROM media WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);?>

<div id="this<?php echo$r['id'];?>" class="form-group form-group-sm">
  <label for="mediatitle" class="control-label col-xs-4">Title</label>
  <div class="input-group col-xs-8">
    <input id="mediatitle" class="form-control" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="title" onchange="update('<?php echo$r['id'];?>','media','title',$(this).val());$('#media-title<?php echo$r['id'];?>').html($(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediacategory_1" class="control-label col-xs-4">Category Primary</label>
  <div class="input-group col-xs-8">
    <input id="mediacategory_1" list="mediacategory_1_options" type="text" class="form-control" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_1" onchange="update('<?php echo$r['id'];?>','media','category_1',$(this).val());">
    <datalist id="mediacategory_1_options">
<?php $s=$db->query("SELECT DISTINCT category_1 FROM media WHERE category_1!='' ORDER BY category_1 ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_1'].'"/>';?>
    </datalist>
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediacategory_2" class="control-label col-xs-4">Category Secondary</label>
  <div class="input-group col-xs-8">
    <input id="mediacategory_2" list="mediacategory_2_options" type="text" class="form-control" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="category_2" onchange="update('<?php echo$r['id'];?>','media','category_2',$(this).val());">
    <datalist id="mediacategory_2_options">
<?php $s=$db->query("SELECT DISTINCT category_2 FROM media WHERE category_2!='' ORDER BY category_2 ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_2'].'"/>';?>
    </datalist>
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaAttributionName" class="control-label col-xs-4">Attribution Name</label>
  <div class="input-group col-xs-8">
    <input id="mediaAttributionName" class="form-control" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="attributionImageName" onchange="update('<?php echo$r['id'];?>','media','attributionImageName',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaAttributionURL" class="control-label col-xs-4">Attribution URL</label>
  <div class="input-group col-xs-8">
    <input id="mediaAttributionURL" class="form-control" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="attributionImageURL" onchange="update('<?php echo$r['id'];?>','media','attributionImageURL',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifISO" class="control-label col-xs-4">ISO</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifISO" class="form-control" value="<?php echo$r['exifISO'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifISO" onchange="update('<?php echo$r['id'];?>','media','exifISO',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifAperture" class="control-label col-xs-4">Aperture</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifAperture" class="form-control" value="<?php echo$r['exifAperture'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifAperture" onchange="update('<?php echo$r['id'];?>','media','exifAperture',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifFocalLength" class="control-label col-xs-4">Focal Length</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifFocalLength" class="form-control" value="<?php echo$r['exifFocalLength'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifFocalLength" onchange="update('<?php echo$r['id'];?>','media','exifFocalLength',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifShutterSpeed" class="control-label col-xs-4">Shutter Speed</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifShutterSpeed" class="form-control" value="<?php echo$r['exifShutterSpeed'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifShutterSpeed" onchange="update('<?php echo$r['id'];?>','media','exifShutterSpeed',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifCamera" class="control-label col-xs-4">Camera</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifCamera" class="form-control" value="<?php echo$r['exifCamera'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifCamera" onchange="update('<?php echo$r['id'];?>','media','exifCamera',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifLens" class="control-label col-xs-4">Lens</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifLens" class="form-control" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifLens" onchange="update('<?php echo$r['id'];?>','media','exifLens',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifFilename" class="control-label col-xs-4">Filename</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifFilename" class="form-control" value="<?php echo$r['exifFilename'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifFilename" onchange="update('<?php echo$r['id'];?>','media','exifFilename',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaexifti" class="control-label col-xs-4">EXIF Date</label>
  <div class="input-group col-xs-8">
    <input id="mediaexifti" class="form-control" value="<?php echo$r['exifti'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="exifti" onchange="update('<?php echo$r['id'];?>','media','exifti',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaseoTitle" class="control-label col-xs-4">SEO Title</label>
  <div class="input-group col-xs-8">
    <input id="mediaseoTitle" class="form-control" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="seoTitle" onchange="update('<?php echo$r['id'];?>','media','seoTitle',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaseoCaption" class="control-label col-xs-4">Caption</label>
  <div class="input-group col-xs-8">
    <input id="mediaseoCaption" class="form-control" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="seoCaption" onchange="update('<?php echo$r['id'];?>','media','seoCaption',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaseoDescription" class="control-label col-xs-4">Description</label>
  <div class="input-group col-xs-8">
    <input id="mediaseoDescription" class="form-control" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="seoDescription" onchange="update('<?php echo$r['id'];?>','media','seoDescription',$(this).val());">
  </div>
</div>
<div class="form-group form-group-sm">
  <label for="mediaviews" class="control-label col-xs-4">Views</label>
  <div class="input-group col-xs-8">
    <input id="mediaviews" class="form-control" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="media" data-dbc="views" onchange="update('<?php echo$r['id'];?>','media','views',$(this).val());">
  </div>
</div>
<script>
  $('#this<?php echo$r['id'];?>').parent('div').prev('h3').append('<div class="mediaicon"><img src="<?php echo$r['file'].'?'.time();?>"></div>');
</script>