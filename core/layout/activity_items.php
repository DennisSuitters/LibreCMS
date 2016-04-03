<?php
if(isset($_GET['is'])){
    session_start();
    require'../db.php';
    $config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
    $su=$db->prepare("SELECT * FROM login WHERE id=:id");
    $su->execute(array(':id'=>$_SESSION['uid']));
    $user=$su->fetch(PDO::FETCH_ASSOC);
    $is=$_GET['is'];
    $ie=$_GET['ie'];
    $action=$_GET['action'];
    function _ago($time){
        $timeDiff=floor(abs(time()-$time)/60);
        if($timeDiff<2)
            $timeDiff='Just Now';
        elseif($timeDiff>2&&$timeDiff<60)
            $timeDiff=floor(abs($timeDiff)).' Minutes Ago';
        elseif($timeDiff>60&&$timeDiff<120)
            $timeDiff=floor(abs($timeDiff/60)).' Hour ago';
        elseif($timeDiff<1440)
            $timeDiff=floor(abs($timeDiff/60)).' Hours ago';
        elseif($timeDiff>1440&&$timeDiff<2880)
            $timeDiff=floor(abs($timeDiff/1440)).' Day Ago';
        elseif($timeDiff>2880)
            $timeDiff=floor(abs($timeDiff/1440)).' Days Ago';
        return$timeDiff;
    }
}
if($action!=''){
    $s=$db->prepare("SELECT * FROM logs WHERE action=:action ORDER BY ti DESC LIMIT ".$is.",".$ie);
    $s->execute(array(':action'=>$action));
}else{
    $s=$db->prepare("SELECT * FROM logs ORDER BY ti DESC LIMIT ".$is.",".$ie);
    $s->execute();
}
$cnt=$s->rowCount();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if($r['refTable']=='content'){
        $sql=$db->prepare("SELECT * FROM ".$r['refTable']." WHERE id=:id");
        $sql->execute(array(':id'=>$r['id']));
        $c=$sql->fetch(PDO::FETCH_ASSOC);
    }
    $su=$db->prepare("SELECT id,username,name,rank FROM login WHERE id=:id");
    $su->execute(array(':id'=>$r['uid']));
    $u=$su->fetch(PDO::FETCH_ASSOC);?>
<div id="l_<?php echo$r['id'];?>" class="row activity">
    <div class="col-xs-4 col-sm-2">
        <div class="badger badger-left text-shadow-depth-1" data-status="<?php echo$r['action'];?>" data-contenttype="<?php echo$r['action'];?>">
        </div><br>
        <div class="text-muted text-center">
            <?php echo date($config['dateFormat'],$r['ti']);?><br>
            <small><?php echo _ago($r['ti']);?></small>
        </div>
    </div>
    <div class="col-xs-6 break-word">
        <p>
            <strong>Action:</strong> <?php echo ucfirst($r['contentType']);
            if($r['action']=='create')echo' Created';
            if($r['action']=='update')echo' Updated';
            if($r['action']=='purge')echo' Purged';?><br>
<?php if(isset($c['title'])&&$c['title']!=''){
    echo'<strong>Title:</strong> '.$c['title'].'<br>';
    if($r['action']=='update')echo'<strong>Table:</strong> '.$r['refTable'].'<br>';
    echo'<strong>Column:</strong> '.$r['refColumn'].'<br>';
    echo'<strong>Data:</strong> '.strip_tags(substr($r['oldda'],0,300)).'<br>';
    echo'<strong>Changed To:</strong> '.strip_tags(substr($r['newda'],0,300)).'<br>';
    }
    echo'<strong>by</strong> '.$u['username'].':'.$u['name'];?>
        </p>
    </div>
    <div id="controls_<?php echo$r['id'];?>" class="btn-group pull-right shadow-depth-1">
<?php if($r['action']=='update'){?>
        <button class="btn btn-warning btn-sm" onclick="restore('<?php echo$r['id'];?>');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><i class="libre libre-restore"></i></button>
<?php }?>
        <button class="btn btn-danger btn-sm" onclick="purge('<?php echo$r['id'];?>','logs')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><i class="libre libre-trash"></i></button>
    </div>
</div>
<hr>
<?php }
if($cnt==$ie){?>
<div id="more_<?php echo$is+$ie+1;?>">
    <button class="btn btn-default btn-block" onclick="loadMore('activity_items','<?php echo$is+$ie+1;?>','<?php echo$ie;?>','<?php echo$action;?>');">More</button>
</div>
<?php }
