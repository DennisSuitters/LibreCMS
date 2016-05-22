<?php
require'../db.php';
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$s=$db->prepare("SELECT * FROM choices WHERE contentType='dashrss' ORDER BY ti");
$s->execute();
$cnt=$config['showItems'] / $s->rowCount();
$cnt=round($cnt,0,PHP_ROUND_HALF_UP);
if($cnt==0)$cnt=1;
while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $rss=simplexml_load_file($r['url']);
    $icon=getFavicon($r['url']);
    $i=0;
    if($rss!=''){
        for($i=0;$i<$cnt;$i++){?>
<div class="media">
    <div class="media-left media-top">
        <a target="_blank" href="<?php echo$rss->channel->item[$i]->link;?>">
            <img class="media-object" src="<?php echo$icon;?>" alt="<?php echo$rss->channel->item[$i]->title;?>">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><a target="_blank" href="<?php echo$rss->channel->item[$i]->link;?>"><?php echo$rss->channel->item[$i]->title;?></a></h4>
        <small class="text-muted"><?php $time=strtotime($rss->channel->item[$i]->pubDate);echo date($config['dateFormat'],$time);?></small><br>
        <?php echo strip_tags($rss->channel->item[$i]->description);?>
    </div>
</div>
<?php   }
    }
}
function getFavicon($url){
    $elems = parse_url($url);
    $url = $elems['scheme'].'://'.$elems['host'];
    $output = file_get_contents($url);
    $regex_pattern = "/rel=\"shortcut icon\" (?:href=[\'\"]([^\'\"]+)[\'\"])?/";
    preg_match_all($regex_pattern, $output, $matches);
    if(isset($matches[1][0])){
        $favicon = $matches[1][0];
        $favicon_elems = parse_url($favicon);
        if(!isset($favicon_elems['host'])){
            $favicon = $url . '/' . $favicon;
        }
        return $favicon;
    }
    return false;
}