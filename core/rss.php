<?php
header('Content-Type:application/rss+xml;charset=ISO-8859-1');
include'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$favicon=$this->favicon();
if($args[0]=='')$args[0]='%_%';
$ti=time();?>
<rss version="2.0">
	<channel>
		<title><?php echo$config['seoTitle'];?></title>
		<description><?php echo$config['seoCaption'];?></description>
		<link><?php echo URL;?></link>
		<copyright><?php echo'Copyright'.' '.date('Y',$ti)." ".$config['seoTitle'];?></copyright>
		<generator>libreCMS - https://github.com/StudioJunkyard/LibreCMS</generator>
		<pubDate><?php echo strftime("%a, %d %b %Y %T %Z",$ti);?></pubDate>
		<ttl>60</ttl>
<?php if(file_exists("layout/".$config['theme']."/images/favicon.jpg")){
	$favicon="http://".$_SERVER['HTTP_HOST'].$config['url']."layout/".$config['theme']."/images/favicon.jpg";
	$deffiletype="image/jpeg";
	$deflength=filesize('layout/'.$config['theme'].'/images/favicon.jpg');
}elseif(file_exists("layout/".$config['theme']."/images/favicon.png")){
	$favicon="http://".$_SERVER['HTTP_HOST'].$config['url']."layout/".$config['theme']."/images/favicon.png";
	$deffiletype="image/png";
	$deflength=filesize('layout/'.$config['theme'].'/images/favicon.png');
}else{
	$favicon=URL."core/images/favicon.png";
	$deffiletype="image/png";
	$deflength=filesize('core/images/favicon.png');
}
$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND status='published' AND internal!='1' ORDER BY ti DESC LIMIT 25");
$s->execute(array(':contentType'=>$args[0]));
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$img=$favicon;
		$filetype=$deffiletype;
		$length=$deflength;
		if($r['contentType']!='gallery'){
			$match=preg_match('/(src=["\'](.*?)["\'])/',$r['notes'],$match);
			$split=preg_split('/["\']/',$match[0]);
			if($split[0]!=''){
				$img=$split[0];
				$filetype="image/jpeg";
				$length=strlen($img);
			}
		}else{
			if(file_exists('media/'.$r['thumb'])){
				$img='http://'.$_SERVER['HTTP_HOST'].$config['url'].'/media/'.$r['thumb'];
				$filetype="image/jpeg";
				$length=filesize('media/'.$r['thumb']);
			}else{
				$img='http://'.$_SERVER['HTTP_HOST'].$config['url'].'/media/'.$r['file'];
				$filetype="image/jpeg";
				$length=filesize('media/'.$r['file']);
			}
		}?>
		<item>
			<title><?php echo$config['seoTitle'].' - '.ucfirst($r['contentType']).' - '.$r['title'];?></title>
			<description><?php if($r['caption']==""){echo strip_tags($r['notes']);}else{echo$r['caption'];}?></description>
			<link><?php echo URL.$r['contentType'].'/'.str_replace(' ','-',$r['title']);?></link>
			<pubDate><?php echo strftime("%a, %d %b %Y %T %Z",$r['ti']);?></pubDate>
			<enclosure url="<?php echo$img;?>" length="<?php echo$length;?>" type="<?php echo$filetype;?>" />
		</item>
<?php }?>
	</channel>
</rss>
