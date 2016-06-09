<?php
header('Content-Type:application/rss+xml;charset=ISO-8859-1');
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if($args[0]==''||$args[0]=='index')$args[0]='%_%';
$ti=time();?>
<?xml version="1.0"?>
<rss version="2.0">
    <channel>
        <title><?php echo$config['seoTitle'];?></title>
        <description><?php echo$config['seoCaption'];?></description>
        <link><?php echo URL;?></link>
        <copyright><?php echo'Copyright'.' '.date('Y',$ti)." ".$config['seoTitle'];?></copyright>
        <generator>libreCMS - https://github.com/StudioJunkyard/LibreCMS</generator>
        <pubDate><?php echo strftime("%a, %d %b %Y %T %Z",$ti);?></pubDate>
        <ttl>60</ttl>
<?php $deffiletype=image_type_to_mime_type(exif_imagetype(FAVICON));
$deflength=filesize(FAVICON);
$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND status='published' AND internal!='1' ORDER BY ti DESC LIMIT 25");
$s->execute(array(':contentType'=>$args[0]));
while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $img=URL.FAVICON;
    $filetype=$deffiletype;
    $length=$deflength;
    if($r['contentType']!='gallery'){
        if($r['thumb']!=''){
            $img=$r['thumb'];
            $filetype=image_type_to_mime_type(exif_imagetype($r['thumb']));
            $file=basename($r['thumb']);
            $length=filesize('media/'.$file);
        }elseif($r['file']){
            $img=$r['file'];
            $filetype=image_type_to_mime_type(exif_imagetype($r['file']));
            $file=basename($r['file']);
            $length=filesize('media/'.$file);
        }else{
            $match=preg_match('/(src=["\'](.*?)["\'])/',$r['notes'],$match);
            $split=preg_split('/["\']/',$match[0]);
            if($split[0]!=''){
                $img=$split[0];
                $filetype=image_type_to_mime_type(exif_imagetype($img));
                $length=strlen($img);
            }
        }
    }else{
        if(file_exists('media'.DS.$r['thumb'])){
            $img=URL.DS.'media'.DS.$r['thumb'];
            $filetype=image_type_to_mime_type(exif_imagetype('media'.DS.$r['thumb']));
            $length=filesize('media'.DS.$r['thumb']);
        }else{
            $img=URL.DS.'media'.DS.$r['file'];
            $filetype=image_type_to_mime_type(exif_imagetype('media'.DS.$r['file']));
            $length=filesize('media'.DS.$r['file']);
        }
    }?>
        <item>
            <title><?php echo$r['title'].' - '.ucfirst($r['contentType']).' - '.$config['seoTitle'];?></title>
            <description><?php if($r['caption']==""){echo strip_tags($r['notes']);}else{echo$r['caption'];}?></description>
            <link><?php echo URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r['title']));?></link>
            <pubDate><?php echo strftime("%a, %d %b %Y %T %Z",$r['ti']);?></pubDate>
            <enclosure url="<?php echo$img;?>" length="<?php echo$length;?>" type="<?php echo$filetype;?>"/>
        </item>
<?php }?>
    </channel>
</rss>