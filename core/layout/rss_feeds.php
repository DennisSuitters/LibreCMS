<?php
require'../db.php';
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$s=$db->prepare("SELECT * FROM choices WHERE contentType='dashrss' ORDER BY ti");
$s->execute();
$cnt=$config['showItems'] / $s->rowCount();
$cnt=round($cnt,0,PHP_ROUND_HALF_UP);
if($cnt==0)$cnt=1;
$cache_time=3600*24*7; // 1 week
while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $cache_file='../../media/cache/feed'.$r['id'].'.rss';
    $timedif=@(time()-filemtime($cache_file));
    if(file_exists($cache_file)&&$timedif<$cache_time){
        $string=file_get_contents($cache_file);
    }else{
        $string=file_get_contents($r['url']);
        if($f=@fopen($cache_file,'w')){
            fwrite($f,$string,strlen($string));
            fclose($f);
        }
    }
    $rss=simplexml_load_string($string);
    $i=0;
    if($rss!=''){
        for($i=0;$i<$cnt;$i++){?>
<div class="media">
    <div class="media-body">
        <h4 class="media-heading"><a target="_blank" href="<?php echo$rss->channel->item[$i]->link;?>"><?php echo$rss->channel->item[$i]->title;?></a></h4>
        <small><small class="text-muted">From: <a target="_blank" href="<?php echo$rss->channel->link;?>"><?php echo$rss->channel->title;?></a></small></small><br>
        <small class="text-muted"><?php $time=strtotime($rss->channel->item[$i]->pubDate);echo date($config['dateFormat'],$time);?></small><br>
        <span class="hidden-xs"><?php echo strip_tags($rss->channel->item[$i]->description);?></small>
    </div>
    <hr class="visible-xs">
</div>
<?php   }
    }
}
