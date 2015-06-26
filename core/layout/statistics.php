<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-comments libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE status='unapproved'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</div>
						<div class="stat">New Comments!</div>
					</div>
				</div>
			</div>
			<div class="panel-footer hidden-xs">
				<a href="<?php echo URL;?>/admin/content">
				<span class="pull-left">View Details</span>
				<a href="#" onclick="statsContent('comments');return false;">
					<span class="pull-right"><i class="libre libre-chevron-down"></i></span>
				</a>
				<div class="clearfix"></div>
			</div>
			<div id="stats_comments"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-envelope libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</div>
						<div class="stat">New Messages!</div>
					</div>
				</div>
			</div>
			<div class="panel-footer hidden-xs">
				<a href="<?php echo URL;?>/admin/messages">
					<span class="pull-left">View Details</span>
				</a>
				<a href="#" onclick="statsContent('messages');return false;">
					<span class="pull-right"><i class="libre libre-chevron-down"></i></span>
				</a>
				<div class="clearfix"></div>
			</div>
			<div id="stats_messages"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-shopping-cart libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</div>
						<div class="stat">Pending Orders!</div>
					</div>
				</div>
			</div>
			<a class="hidden-xs" href="<?php echo URL;?>/admin/orders/pending">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="libre libre-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-calendar libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE status='unconfirmed'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</div>
						<div class="stat">New Bookings!</div>
					</div>
				</div>
			</div>
			<a class="hidden-xs" href="<?php echo URL;?>/admin/bookings">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="libre libre-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-seo-performance libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">
<?php $r=$db->query("SELECT COUNT(DISTINCT vid) as cnt FROM tracker")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</div>
						<div class="stat">Total Visits!</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Today</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time());
$tie=strtotime("tomorrow",$tis)-1;
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Yesterday</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time())-84600;
$tie=strtotime("tomorrow",$tis)-84601;
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Last 7 days</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time())-strtotime("-1 week");
$tie=strtotime("tomorrow",$tis)-1-strtotime("-1 week");
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Last 30 days</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time())-strtotime("-30 days");
$tie=strtotime("tomorrow",$tis)-1-strtotime("-30 days");
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-browser-general libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">
<?php $r=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser!='Unknown'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</div>
						<div class="stat">Unique Browser Visitors!</div>
					</div>
				</div>
			</div>
<?php	$s=$db->query("SELECT browser,COUNT(DISTINCT ip) as cnt FROM tracker WHERE browser IN ('Chrome','Firefox','Safari','Explorer') GROUP BY browser ORDER BY browser DESC");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<div class="panel-footer" title="<?php echo ucfirst($r['browser']);?>">
				<span class="pull-left"><?php echo$r['cnt'];?></span>
				<span class="pull-right"><i class="libre libre-browser-<?php echo strtolower($r['browser']);?>"></i></span>
				<div class="clearfix"></div>
			</div>
<?php	}?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-os-general libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">
<?php $r=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE os!='Unknown'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</div>
						<div class="stat">Operating Systems!</div>
					</div>
				</div>
			</div>
<?php $s=$db->query("SELECT os,COUNT(DISTINCT ip) as cnt FROM tracker WHERE os IN ('linux','apple','windows','Explorer') GROUP BY os ORDER BY os DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<div class="panel-footer" title="<?php echo ucfirst($r['os']);?>">
				<span class="pull-left"><?php echo$r['cnt'];?></span>
				<span class="pull-right"><i class="libre libre-os-<?php echo strtolower($r['os']);?>"></i></span>
				<div class="clearfix"></div>
			</div>
<?php }?>
		</div>
	</div>
<?php if($config['options']{6}==1){?>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="libre libre-seo-target-audience libre-5x"></i>
					</div>
					<div class="col-xs-9 text-right stats">
						<div class="number">&nbsp;</div>
						<div class="stat">
							Random SEO Tip
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
<?php $rss=new DOMDocument();
switch(rand(0,1)){
	case 0:
		$rss->load('http://feeds.feedburner.com/KateToonCopywriter?format=xml');
		break;
	case 1:
		$rss->load('http://www.copywritematters.com.au/feed/');
		break;
}
$feed=array();
foreach($rss->getElementsByTagName('item')as$node){
	$item=array(
		'title'=>$node->getElementsByTagName('title')->item(0)->nodeValue,
		'desc'=>$node->getElementsByTagName('description')->item(0)->nodeValue,
		'link'=>$node->getElementsByTagName('link')->item(0)->nodeValue,
		'date'=>$node->getElementsByTagName('pubDate')->item(0)->nodeValue,
		'creator'=>$node->getElementsByTagName('creator')->item(0)->nodeValue,
		);
	array_push($feed,$item);
}
$x=rand(0,5);
	$author=$feed[$x]['creator'];
	$title=str_replace(' & ',' &amp; ',$feed[$x]['title']);
	$link=$feed[$x]['link'];
	$description=$feed[$x]['desc'];
	$date=date('l F d, Y',strtotime($feed[$x]['date']));?>
				<div><a target="_blank" href="<?php echo$link;?>"><?php echo$title;?></a></div>
				<div><small><?php echo substr(strip_tags($description),0,300);?></small></div>
				<div class="text-right"><small><a target="_blank" href="<?php echo$link;?>"><?php echo$author;?></a></small></div>
			</div>
		</div>
	</div>
<?php }?>
</div>
