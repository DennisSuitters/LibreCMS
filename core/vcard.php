<?php
require'db.php';
require'class.vcard.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$username=isset($_GET['u'])?filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING):0;
if($username!=0){
  $s=$db->prepare("SELECT * FROM login WHERE username=:username");
  $s->execute(array(':username'=>$username));
  if($s->rowCount()==1){
    $user=$s->fetch(PDO::FETCH_ASSOC);
    if($user['rank']>899)$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);else$config=array('business'=>NULL,'abn'=>NULL,'address'=>NULL,'suburb'=>NULL,'city'=>NULL,'state'=>NULL,'country'=>NULL,'postcode'=>NULL,'phone'=>NULL,'mobile'=> NULL,'email'=>NULL);
    $n=explode(' ',$user['name']);
    $namefirst=$n[0];
    $namelast=end($n);
    $card=new vCard();
    $card->set(array('display_name'=>$user['name'],'first_name'=>$namefirst,'last_name'=>$namelast,'additional_name'=>$user['username'],'name_prefix'=>NULL,'name_suffix'=>NULL,'nickname'=>$user['username'],'title'=>NULL,'role'=>NULL,'department'=>NULL,'company'=>$user['business'],'work_po_box'=>NULL,'work_extended_address'=>NULL,'work_address'=>$config['address'],'work_city'=>$config['city'],'work_state'=>$config['state'],'work_postal_code'=>$config['postcode'],'work_country'=>$config['country'],'home_po_box'=>NULL,'home_extended_address'=>NULL,'home_address'=>$user['address'],'home_city'=>$user['city'],'home_state'=>$user['state'],'home_postal_code'=>$user['postcode'],'home_country'=>$user['country'],'office_tel'=>$config['phone'],'home_tel'=>$user['phone'],'cell_tel'=>$user['mobile'],'fax_tel'=>NULL,'pager_tel'=>NULL,'email1'=>$user['email'],'email2'=>NULL,'url'=>$user['url'],'photo'=>NULL,'birthday'=>NULL,'timezone'=>NULL,'sort_string'=>NULL,'note'=>$user['notes']));
  }
}else{
  $config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
  $card=new vCard();
  $card->set(array('display_name'=>$config['business'],'first_name'=>NULL,'last_name'=>NULL,'additional_name'=>NULL,'name_prefix'=>NULL,'name_suffix'=>NULL,'nickname'=>NULL,'title'=>NULL,'role'=>NULL,'department'=>NULL,'company'=>$config['business'],'work_po_box'=>NULL,'work_extended_address'=>NULL,'work_address'=>$config['address'],'work_city'=>$config['city'],'work_state'=>$config['state'],'work_postal_code'=>$config['postcode'],'work_country'=>$config['country'],'home_po_box'=>NULL,'home_extended_address'=>NULL,'home_address'=>NULL,'home_city'=>NULL,'home_state'=>NULL,'home_postal_code'=>NULL,'home_country'=>NULL,'office_tel'=>$config['phone'],'home_tel'=>NULL,'cell_tel'=>$config['mobile'],'fax_tel'=>NULL,'pager_tel'=>NULL,'email1'=>$config['email'],'email2'=>NULL,'url'=>URL,'photo'=>NULL,'birthday'=>NULL,'timezone'=>NULL,'sort_string'=>NULL,'note'=>NULL));
}
$card->download();
