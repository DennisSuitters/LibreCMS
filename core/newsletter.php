<script>/*<![CDATA[*/
<?php require'db.php';
define('DS',DIRECTORY_SEPARATOR);
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('THEME','..'.DS.'layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('ADMINURL',URL.$settings['system']['admin'].'/');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.'/theme.ini',true);
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT title,notes FROM content WHERE id=:id");
$s->execute(array(':id'=>$id));
$news=$s->fetch(PDO::FETCH_ASSOC);
$u=$db->prepare("UPDATE content SET status=:status,tis=:tis WHERE id=:id");
$u->execute(array(':status'=>'published',':tis'=>time(),':id'=>$id));
require"class.phpmailer.php";
if($config['email']!=''){
  $mail=new PHPMailer();
  $body=rawurldecode($news['notes']);
  $body=eregi_replace("[\]",'',$body);
  $mail->IsSMTP();
  $mail->isHTML(true);
  $mail->SetFrom($config['email'],$config['business']);
  $mail->Subject=$news['title'];
  $mail->AltBody="To view the message, please use an HTML compatible email viewer!";
  if($config['newslettersEmbedImages']{0}==1){
    preg_match_all('/<img.*?>/',$body,$matches);
    if(isset($matches[0])){
      $i=1001;
      foreach($matches[0] as $img){
        $imgid='img'.($i++);
        preg_match('/src="(.*?)"/',$body,$m);
        if(!isset($m[1]))continue;
        $arr=parse_url($m[1]);
        if(!isset($arr['host'])||!isset($arr['path']))continue;
        $imgname=basename($m[1]);
        $mail->AddEmbeddedImage('../media/'.$imgname,$imgid,$imgname);
        $body=str_replace($img,'<img alt="" src="cid:'.$imgid.'" style="border:none"/>',$body);
      }
    }
  }
  if($config['newslettersSendMax']!=''||$config['newslettersSendMax']==0)
    $betweenDelay=$config['newslettersSendMax'];
  else
    $betweenDelay=50;
  $sendCount=1;
  if($config['newslettersSendDelay']!=''||$config['newslettersSendDelay']==0)
    $sendDelay=$config['newslettersSendDelay'];
  else
    $sendDelay=1;
  ignore_user_abort(true);
  set_time_limit(300);
  $s=$db->prepare("SELECT DISTINCT email,hash FROM subscribers UNION SELECT DISTINCT email,hash FROM login WHERE newsletter=1");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if(($sendCount % $betweenDelay)==0){
      sleep($sendDelay);
    }
    $mail->AddAddress($r['email']);
    $optOut=$config['newslettersOptOutLayout'];
    $optOut=str_replace('{optOutLink}',URL.'newsletters/unsubscribe/'.$r['hash'],$optOut);
    $mail->Body=$body.$optOut;
    if($mail->Send()){
      $mail->clearAllRecipients();
      $sendCount++;
    }
  }
  if(!empty($mail->ErrorInfo)){?>
    window.top.window.$('#notification').html('<div class="alert alert-danger"><?php echo $mail->ErrorInfo;?></div>');
    window.top.window.$('#block').css({'display':'none'});
<?php }else{?>
    window.top.window.$('#notification').html('<div class="alert alert-success">Newsletters Sent Successfully!</div>');
    window.top.window.$('#block').css({'display':'none'});
<?php }
}else{?>
  window.top.window.$('#notification').html('<div class="alert alert-danger">The Sites <a class="alert-link" href="<?php echo ADMINURL;?>preferences#preference-contact">Email</a> hasn\'t been set.</div>');
  window.top.window.$('#block').css({'display':'none'});
<?php }?>
/*]]>*/</script>
