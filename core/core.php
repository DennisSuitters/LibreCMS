<?php
ini_set('session.use_cookies',1);
ini_set('session.use_only_cookies',1);
define('DS',DIRECTORY_SEPARATOR);
define('MINIFY',0);
require_once'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('SESSIONID',session_id());
try{
  $config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
}catch(Exception $e){
	require'core/layout/install.php';
	die();
}
if(isset($_GET['theme'])&&file_exists('layout'.DS.$_GET['theme']))$config['theme']=$_GET['theme'];
define('THEME','layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
if(file_exists(THEME.DS.'images'.DS.'favicon.png'))define('FAVICON',THEME.DS.'images'.DS.'favicon.png');elseif(file_exists(THEME.DS.'images'.DS.'favicon.gif'))define('FAVICON',THEME.DS.'images'.DS.'favicon.gif');elseif(file_exists(THEME.DS.'images'.DS.'favicon.jpg'))define('FAVICON',THEME.DS.'images'.DS.'favicon.jpg');elseif(file_exists(THEME.DS.'images'.DS.'favicon.ico'))define('FAVICON',THEME.DS.'images'.DS.'favicon.ico');else define('FAVICON','core'.DS.'images'.DS.'favicon.png');
if(file_exists(THEME.DS.'images'.DS.'noimage.png'))define('NOIMAGE',THEME.DS.'images'.DS.'noimage.png');elseif(file_exists(THEME.DS.'images'.DS.'noimage.gif'))define('NOIMAGE',THEME.DS.'images'.DS.'noimage.gif');elseif(file_exists(THEME.DS.'images'.DS.'noimage.jpg'))define('NOIMAGE',THEME.DS.'images'.DS.'noimage.jpg');else define('NOIMAGE','core'.DS.'images'.DS.'noimage.jpg');
if(file_exists(THEME.DS.'images'.DS.'noavatar.png'))define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.png');elseif(file_exists(THEME.DS.'images'.DS.'noavatar.gif'))define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.gif');elseif(file_exists(THEME.DS.'images'.DS.'noavatar.jpg'))define('NOAVATAR',THEME.DS.'images'.DS.'noavatar.jpg');else define('NOAVATAR','core'.DS.'images'.DS.'noavatar.jpg');
define('YANDEX','trnsl.1.1.20151010T141347Z.abb6d53e6280191b.5decd3b201ae911048617d1869e766124de2023d');
require'login.php';
function rank($txt){
	if($txt==0)return'visitor';
	if($txt==100)return'subscriber';
	if($txt==200)return'member';
	if($txt==300)return'client';
	if($txt==400)return'contributor';
	if($txt==500)return'author';
	if($txt==600)return'editor';
	if($txt==700)return'moderator';
	if($txt==800)return'manager';
	if($txt==900)return'administrator';
	if($txt==1000)return'developer';
}
function svg($svg,$class=null,$size=null,$color=null){
	echo'<i class="libre';
	if($size!=null)echo' libre-'.$size;
	if($color!=null)echo' libre-'.$color;
  if($class!=null)echo' '.$class;
	echo'">';
	include'svg'.DS.'libre-'.$svg.'.svg';
	echo'</i>';
}
function frontsvg($svg){
	return file_get_contents(THEME.DS.'svg'.DS.'libre-'.$svg.'.svg');
}
function microid($identity,$service,$algorithm='sha1'){
	$microid=substr($identity,0,strpos($identity,':'))."+".substr($service,0,strpos($service,':')).":".strtolower($algorithm).":";
	if(function_exists('hash')){
		if(in_array(strtolower($algorithm),hash_algos()))return$microid.=hash($algorithm,hash($algorithm,$identity).hash($algorithm,$service));
	}
	if(function_exists('mhash')){
		$hash_method=@constant('MHASH_'.strtoupper($algorithm));
		if($hash_method!=null){
			$identity_hash=bin2hex(mhash($hash_method,$identity));
			$service_hash=bin2hex(mhash($hash_method,$service));
			return$microid.=bin2hex(mhash($hash_method,$identity_hash.$service_hash));
		}
	}
	if(function_exists($algorithm))return$microid.=$algorithm($algorithm($identity).$algorithm($service));
}
function minify($txt){
	return preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'),array(' ',''),$txt);
}
function _ago($time){
	if($time==0)
		$timeDiff='Never';
	else{
		$fromTime=$time;
		$timeDiff=floor(abs(time()-$fromTime)/60);
		if($timeDiff<2)
			$timeDiff='Just Now';
		elseif($timeDiff>2&&$timeDiff<60)
			$timeDiff=floor(abs($timeDiff)).' Minutes Ago';
		elseif($timeDiff>60&&$timeDiff<120)
			$timeDiff=floor(abs($timeDiff/60)).' Hour Ago';
		elseif($timeDiff<1440)
			$timeDiff=floor(abs($timeDiff/60)).' Hours Ago';
		elseif($timeDiff>1440&&$timeDiff<2880)
			$timeDiff=floor(abs($timeDiff/1440)).' Day Ago';
		elseif($timeDiff>2880)
			$timeDiff=floor(abs($timeDiff/1440)).' Days Ago';
	}
	return$timeDiff;
}
function elapsed_time($b=0,$e=0){
  if($b==0)$b=$_SERVER["REQUEST_TIME_FLOAT"];
  $b=explode(' ',$b);
  if($e==0)$e=microtime();
  $e=explode(' ',$e);
  @$td=($e[0]+$e[1])-($b[0]+$b[1]);
  $b='';
  $tt=array(
    'd'=>(int)($td/86400),
    'h'=>$td/3600%24,
    'm'=>$td/60%60,
    's'=>$td%60
  );
  if((int)$td>30){
    $b='';
    foreach($tt as$u=>$ti){
      if($ti>0)$b.="$ti$u ";
    }
  }else$b=number_format($td,3).'s';
  return trim($b);
}
function url_encode($str){
	$str=str_replace(chr(149),"%2D",$str);
	$str=str_replace(chr(150),"%2D",$str);
	$str=str_replace(chr(151),"%2D",$str);
	$str=str_replace(chr(45),"%2D",$str);
	$str=trim(strtolower($str));
  $ent=array('%21','%2A',"%27","%28","%29","%3B","%3A","%40","%26","%3D","%2B","%24","%2C","%2F","%3F","%23","%5B","%5D");
  $rep=array('!','*',"'","(",")",";",":","@","&","=","+","$",",","/","?","#","[","]");
	$str=str_replace($rep,$ent,$str);
	$str=str_replace(' ','-',$str);
	return$str;
}
function escaper($val){
  $esc=array("\\","/","\"","\n","\r","\t","\x08","\x0c");
  $rep=array("\\\\","\\/","\\\"","\\n","\\r","\\t","\\f","\\b");
  $res=str_replace($esc,$rep,$val);
  return$res;
}
class internal{
	function getconfig($db){
		$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);return$config;
	}
	function humans($args=false){
		require'core'.DS.'humans.php';
	}
	function sitemap($args=false){
		require'core'.DS.'sitemap.php';
	}
	function robots($args=false){
		require'core'.DS.'robots.php';
	}
	function rss($args=false){
		require'core'.DS.'rss.php';
	}
	function unsubscribe($args=false){
		require'core'.DS.'unsubscribe.php';
	}
}
class admin{
	function getconfig($db){
		$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);return$config;
	}
	function favicon(){
		return'core'.DS.'images'.DS.'favicon.png';
	}
	function noimage(){
		return'core'.DS.'images'.DS.'noimage.jpg';
	}
	function noavatar(){
		return'core'.DS.'images'.DS.'noavatar.jpg';
	}
	function accounts($args=false){
		$view='accounts';
		require'admin.php';
	}
	function activity($args=false){
		$view='activity';
		require'admin.php';
	}
	function add($args=false){
		$view='add';
		require'admin.php';
	}
	function bookings($args=false){
		$view='bookings';
		require'admin.php';
	}
	function content($args=false){
		$view='content';
		require'admin.php';
	}
	function dashboard($args=false){
		$view='dashboard';
		require'admin.php';
	}
	function logout($args=false){
		$act='logout';
		$view='';
		require'admin.php';
	}
	function media($args=false){
		$view='media';
		require'admin.php';
	}
	function messages($args=false){
		$view='messages';
		require'admin.php';
	}
	function newsletters($args=false){
		$view='newsletters';
		require'admin.php';
	}
	function orders($args=false){
		$view='orders';
		require'admin.php';
	}
  function rewards($args=false){
    $view='rewards';
    require'admin.php';
  }
	function pages($args=false){
		$view='pages';
		require'admin.php';
	}
	function preferences($args=false){
		$view='preferences';
		require'admin.php';
	}
	function search($args=false){
		$view='search';
		require'admin.php';
	}
}
class front{
	function getconfig($db){
		$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
		return$config;
	}
	function about($args=false){
		$view='aboutus';
		require'process.php';
	}
	function aboutus($args=false){
		$view='aboutus';
		require'process.php';
	}
	function article($args=false){
		$view='article';
		require'process.php';
	}
	function articles($args=false){
		$view='article';
		require'process.php';
	}
	function booking($args=false){
		$view='bookings';
		require'process.php';
	}
	function bookings($args=false){
		$view='bookings';
		require'process.php';
	}
	function cart($args=false){
		$view='cart';
		require'process.php';
	}
	function contactus($args=false){
		$view='contactus';
		require'process.php';
	}
	function error($args=false){
		$view='error';
		require'process.php';
	}
	function event($args=false){
		$view='events';
		require'process.php';
	}
	function events($args=false){
		$view='events';
		require'process.php';
	}
	function gallery($args=false){
		$view='gallery';
		require'process.php';
	}
	function index($args=false){
		$view='index';
		require'process.php';
	}
	function inventory($args=false){
		$view='inventory';
		require'process.php';
	}
	function login($args=false){
		$view='login';
		require'process.php';
	}
	function logout($args=false){
		$act='logout';
		$view='index';
		require'process.php';
	}
	function news($args=false){
		$view='news';
		require'process.php';
	}
	function order($args=false){
		$view='orders';
		require'process.php';
	}
	function orders($args=false){
		$view='orders';
		require'process.php';
	}
	function portfolio($args=false){
		$view='portfolio';
		require'process.php';
	}
	function proof($args=false){
		$view='proofs';
		require'process.php';
	}
	function proofs($args=false){
		$view='proofs';
		require'process.php';
	}
	function search($args=false){
		$view='search';
		require'process.php';
	}
	function service($args=false){
		$view='service';
		require'process.php';
	}
	function services($args=false){
		$view='service';
		require'process.php';
	}
	function settings($args=false){
		$view='settings';
		require'process.php';
	}
	function sitemap($args=false){
		$view='sitemap';
		require'process.php';
	}
	function testimonial($args=false){
		$view='testimonials';
		require'process.php';
	}
	function testimonials($args=false){
		$view='testimonials';
		require'process.php';
	}
	function tos($args=false){
		$view='tos';
		require'process.php';
	}
	function newsletters($args=false){
		$view='newsletters';
		require'process.php';
	}
	function content($args=false){
		$view='';
		require'process.php';
	}
}
/* Router */
$route=new router();
$rts=array(
	$settings['system']['admin'].'/add'=>array('admin','add'),
	$settings['system']['admin'].'/accounts'=>array('admin','accounts'),
	$settings['system']['admin'].'/activity'=>array('admin','activity'),
	$settings['system']['admin'].'/bookings'=>array('admin','bookings'),
	$settings['system']['admin'].'/content'=>array('admin','content'),
	$settings['system']['admin'].'/dashboard'=>array('admin','dashboard'),
	$settings['system']['admin'].'/logout'=>array('admin','logout'),
	$settings['system']['admin'].'/media'=>array('admin','media'),
	$settings['system']['admin'].'/messages'=>array('admin','messages'),
	$settings['system']['admin'].'/newsletters'=>array('admin','newsletters'),
	$settings['system']['admin'].'/orders'=>array('admin','orders'),
  $settings['system']['admin'].'/rewards'=>array('admin','rewards'),
	$settings['system']['admin'].'/pages'=>array('admin','pages'),
	$settings['system']['admin'].'/preferences'=>array('admin','preferences'),
	$settings['system']['admin'].'/search'=>array('admin','search'),
	$settings['system']['admin']=>array('admin','dashboard'),
	'humans.txt'=>array('internal','humans'),
	'sitemap.xml'=>array('internal','sitemap'),
	'robots.txt'=>array('internal','robots'),
	'rss'=>array('internal','rss'),
	'error'=>array('front','error'),
	''=>array('front','index'),
	'index'=>array('front','index'),
	'sitemap'=>array('front','sitemap'),
	'orders'=>array('front','orders'),
	'proofs'=>array('front','proofs'),
	'login'=>array('front','login'),
	'settings'=>array('front','settings')
);
$s=$db->prepare("SELECT * FROM menu WHERE active=1");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	if(method_exists('front',$r['file']))$rts[$r['contentType']]=array('front',$r['contentType']);else$rts[$r['contentType']]=array('front','content');
}
$route->setRoutes($rts);
$route->routeURL(preg_replace("|/$|","",filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)));
class router{
	protected$route_match=false;
	protected$route_call=false;
	protected$route_call_args=false;
	protected$routes=array();
	public function setRoutes($routes){
		$this->routes=$routes;
	}
	public function routeURL($url=false){
		if(isset($this->routes[$url])){
			$this->route_match=$url;
			$this->route_call=$this->routes[$url];
			$this->callRoute();
			return true;
		}
		foreach($this->routes as$path=>$call){
			if(empty($path))continue;
			preg_match("|{$path}/(.*)$|i",$url,$match);
			if(!empty($match[1])){
				$this->route_match=$path;
				$this->route_call=$call;
				$this->route_call_args=explode("/",$match[1]);
				$this->callRoute();
				return true;
			}
		}
		if($this->route_call===false){
			if(!empty($this->routes['error'])){
				$this->route_call=$this->routes['error'];
				$this->callRoute();
				return true;
			}
		}
	}
	private function callRoute(){
		$call=$this->route_call;
		if(is_array($call)){
			$call_obj=new$call[0]();
			$call_obj->$call[1]($this->route_call_args);
		}else
			$call($this->route_call_args);
	}
}
