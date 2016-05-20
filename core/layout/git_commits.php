<?php
require'../db.php';
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if($config['git_ti']<time()-86400||$config['git_commits']==''){
    function get_json($url){
        $base="https://api.github.com/";
        $agent='Mozilla/5.0 (compatible; StudioJunkard/LibreCMS)';
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_USERAGENT,$agent);
        curl_setopt($curl,CURLOPT_URL,$base.$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        $content=curl_exec($curl);
        curl_close($curl);
        return$content;
    }
    $commits=get_json('repos/StudioJunkyard/LibreCMS/commits');
    $s=$db->prepare("UPDATE config SET git_commits=:commits,git_ti=:ti WHERE id='1'");
    $s->execute(array(':commits'=>$commits,':ti'=>time()));
    $config['git_commits']=$commits;
}
$commits=json_decode($config['git_commits'],true);
$i=0;
while($i<10){?>
<tr>
<td><img style="width:20px;" src="<?php echo $commits[$i]["author"]["avatar_url"];?>"></td>
<td class="text-center"><?php $time=strtotime($commits[$i]["commit"]["committer"]["date"]);echo date($config['dateFormat'],$time);?></td>
<td class="text-center"><a href="<?php echo$commits[$i]["author"]["html_url"];?>"><?php echo $commits[$i]["commit"]["committer"]["name"];?></a></td>
<td><a href="<?php echo$commits[$i]["html_url"];?>"><?php echo $commits[$i]["commit"]["message"];?></a></td>
</tr>
<?php $i++;
}
