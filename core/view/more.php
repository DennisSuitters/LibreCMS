<?php
require'..'.DS.'..'.DS.'core'.DS.'db.php';
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('SESSIONID',session_id());
define('THEME','layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$contentType=isset($_POST['c'])?$_POST['c']:$_GET['c'];
$view=isset($_POST['v'])?$_POST['v']:$_GET['v'];
$show='categories';
$i=isset($_POST['i'])?$_POST['i']:$_GET['i'];
if(file_exists('..'.DS.'..'.DS.'layout'.DS.$config['theme'].DS.$view.'.html'))$html=file_get_contents('..'.DS.'..'.DS.'layout'.DS.$config['theme'].DS.$view.'.html');
else$html=file_get_contents('..'.DS.'..'.DS.'layout'.DS.$config['theme'].DS.'content.html');
$itemCount=$config['showItems'];
$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC LIMIT $i,$itemCount");
$s->execute(array(':contentType'=>$contentType,':status'=>'published',':ti'=>time()));
if(stristr($html,'<more')){
  preg_match('/<more>([\w\W]*?)<\/more>/',$html,$matches);
  $more=$matches[1];
  $more=str_replace('<print view>',$view,$more);
  $more=str_replace('<print contentType>',$contentType,$more);
  $more=str_replace('<print config=showItems>',$itemCount+$i,$more);
}else$more='';
if($s->rowCount()<=$itemCount)$more='';
if(stristr($html,'<items>')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $item=$matches[1];
  $output='';
  $si=1;
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $items=$item;
    $contentType=$r['contentType'];
    if($si==1){
      $filechk=basename($r['file']);
      $thumbchk=basename($r['thumb']);
      if($r['file']!=''&&file_exists('media'.DS.$filechk)){
        $shareImage=$r['file'];
        $si++;
      }elseif($r['thumb']!=''&&file_exists('media'.DS.$thumbchk)){
        $shareImage=$r['thumb'];
        $si++;
      }
    }
  if(stristr($items,'<print content=thumb>')){
    $r['thumb']=str_replace(URL,'',$r['thumb']);
    if($r['thumb'])$items=str_replace('<print content=thumb>',$r['thumb'],$items);else$items=str_replace('<print content=thumb>','layout'.DS.$config['theme'].DS.'images'.DS.'noimage.jpg',$items);
  }
  if(stristr($items,'<print content=alttitle>'))$items=str_replace('<print content=alttitle>',$r['title'],$items);
  $r['notes']=strip_tags($r['notes']);
  if($r['contentType']=='testimonials'||$r['contentType']=='testimonial'){
    if(stristr($items,'<controls>'))$items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
    $controls='';
  }else{
    if(stristr($items,'<view>')){
      $items=str_replace('<print content=linktitle>',URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r['title'])),$items);
      $items=str_replace('<print content="title">',$r['title'],$items);
      $items=str_replace('<view>','',$items);
      $items=str_replace('</view>','',$items);
    }
    if($r['contentType']=='service'){
      if($r['bookable']==1){
        if(stristr($items,'<service>')){
          $items=str_replace('<print content=bookservice>',URL.'bookings/'.$r['id'],$items);
          $items=str_replace('<service>','',$items);
          $items=str_replace('</service>','',$items);
          $items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
        }
      }else$items=preg_replace('~<service.*?>.*?<\/service>~is','',$items,1);
    }else$items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
      if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
        if(stristr($items,'<inventory>')){
          $items=str_replace('<inventory>','',$items);
          $items=str_replace('</inventory>','',$items);
          $items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
        }elseif(stristr($items,'<inventory>')&&$r['contentType']!='inventory'&&!is_numeric($r['cost']))$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
      }else$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
      $items=str_replace('<controls>','',$items);
      $items=str_replace('</controls>','',$items);
    }
    require'..'.DS.'parser.php';
    $output.=$items;
  }
  $html=$output;
}
print$html.$more;
