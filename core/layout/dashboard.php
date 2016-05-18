<div class="page-toolbar"></div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Dashboard</h4>
    </div>
    <div class="panel-body">
        <noscript>
            <div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div>
        </noscript>
<?php if($config['maintenance']{0}==1){?>
        <div class="alert alert-warning">Note: Site is currently in <a href="<?php echo URL.$settings['system']['admin'].'/preferences#interface';?>">Maintenance Mode</a></div>
<?php }
$tid=$ti-2592000;
if($config['backup_ti']<$tid){
    if($config['backup_ti']==0){?>
        <div class="alert alert-info">A Backup has yet to be performed.</div>
<?php }else{?>
        <div class="alert alert-danger">It has been more than 30 days since a Backup has been performed.</div>
<?php }
}
?>
        <div class="row">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE status='unapproved'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/content">
                            <?php svg('comments','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Comments!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/messages">
                            <?php svg('envelope','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Messages!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/orders/pending">
                            <?php svg('shopping-cart','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">Pending Orders!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE contentType='booking' AND status!='confirmed'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/bookings">
                            <?php svg('calendar','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Bookings!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php if($config['git_ti']<time()-86400||$config['git_commits']==''){
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
}?>
            <div class="panel panel-body">
                <h4 class="page-header">Latest Github Commits</h4>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width:20px;"></th>
                                <th class="col-xs-2 text-center">Date</th>
                                <th class="col-xs-2 text-center">User</th>
                                <th class="col-xs-8">Commit Message</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $commits=json_decode($config['git_commits'],true);
$i=0;
while($i<10){?>
                            <tr>
                                <td><img style="width:20px;" src="<?php echo $commits[$i]["author"]["avatar_url"];?>"></td>
                                <td class="text-center"><?php $time=strtotime($commits[$i]["commit"]["committer"]["date"]);echo date($config['dateFormat'],$time);?></td>
                                <td class="text-center"><a href="<?php echo$commits[$i]["author"]["html_url"];?>"><?php echo $commits[$i]["commit"]["committer"]["name"];?></a></td>
                                <td><a href="<?php echo$commits[$i]["html_url"];?>"><?php echo $commits[$i]["commit"]["message"];?></a></td>
                            </tr>
<?php $i++;
}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
