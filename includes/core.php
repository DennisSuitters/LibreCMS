<?php
/* Config */
require_once'includes/db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443) define('PROTOCOL','https://'); else define('PROTOCOL','http://');
require'password.php';
define('SESSIONID',session_id());
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
define('THEME','layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
require'login.php';
/* Controller */
class internal{
	function getconfig($db){
		$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
		return $config;
	}
	function sitemap($args=false){
		require'includes/sitemap.php';
	}
	function robots($args=false){
		require'includes/robots.php';
	}
	function rss($args=false){
		require'includes/rss.php';
	}
	function favicon(){
		if(file_exists(THEME.'/images/favicon.png')){
			$favicon=THEME.'/images/favicon.png';
		}elseif(file_exists(THEME.'/images/favicon.gif')){
			$favicon=THEME.'/images/favicon.gif';
		}elseif(file_exists(THEME.'/images/favicon.jpg')){
			$favicon=THEME.'/images/favicon.jpg';
		}elseif(file_exists(THEME.'/images/favicon.ico')){
			$favicon=THEME.'/images/favicon.ico';
		}else{
			$favicon='includes/images/favicon.png';
		}
		return $favicon;
	}
}
class admin{
	function getconfig($db){
		$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
		return $config;
	}
	function favicon(){
		$favicon='includes/images/favicon.png';
		return $favicon;
	}
	function noimage(){
		$noimage='includes/images/noimage.jpg';
		return $noimage;
	}
	function noavatar(){
		$noavatar='includes/images/noavatar.jpg';
		return $noavatar;
	}

	function add($args=false){
		$view='add';
		require'admin.php';
	}
	function accounts($args=false){
		$view='accounts';
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
	function article($args=false){
		$view='article';
		require'admin.php';
	}
	function portfolio($args=false){
		$view='portfolio';
		require'admin.php';
	}
	function events($args=false){
		$view='events';
		require'admin.php';
	}
	function news($args=false){
		$view='news';
		require'admin.php';
	}
	function testimonials($args=false){
		$view='testimonials';
		require'admin.php';
	}
	function inventory($args=false){
		$view='inventory';
		require'admin.php';
	}
	function services($args=false){
		$view='services';
		require'admin.php';
	}
	function gallery($args=false){
		$view='article';
		require'admin.php';
	}
	function pages($args=false){
		$view='pages';
		require'admin.php';
	}
	function proofs($args=false){
		$view='proofs';
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
	function orders($args=false){
		$view='orders';
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
	function statistics($args=false){
		$view='statistics';
		require'admin.php';
	}
}
class front{
	function getconfig($db){
		$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
		return $config;
	}
	function favicon(){
		if(file_exists(THEME.'/images/favicon.png')){
			$favicon=THEME.'/images/favicon.png';
		}elseif(file_exists(THEME.'/images/favicon.gif')){
			$favicon=THEME.'/images/favicon.gif';
		}elseif(file_exists(THEME.'/images/favicon.jpg')){
			$favicon=THEME.'/images/favicon.jpg';
		}elseif(file_exists(THEME.'/images/favicon.ico')){
			$favicon=THEME.'/images/favicon.ico';
		}else{
			$favicon='includes/images/favicon.png';
		}
		return $favicon;
	}
	function noimage(){
		if(file_exists(THEME.'/images/noimage.png')){
			$noimage=THEME.'/images/noimage.png';
		}elseif(file_exists(THEME.'/images/noimage.gif')){
			$noimage=THEME.'/images/noimage.gif';
		}elseif(file_exists(THEME.'/images/noimage.jpg')){
			$noimage=THEME.'/images/noimage.jpg';
		}else{
			$noimage='includes/images/noimage.jpg';
		}
		return $noimage;
	}
	function noavatar(){
		if(file_exists(THEME.'/images/noavatar.png')){
			$noavatar=THEME.'/images/noavatar.png';
		}elseif(file_exists(THEME.'/images/noavatar.gif')){
			$noavatar=THEME.'/images/noavatar.gif';
		}elseif(file_exists(THEME.'/images/noavatar.jpg')){
			$noavatar=THEME.'/images/noavatar.jpg';
		}else{
			$noavatar='includes/images/noavatar.jpg';
		}
		return $noavatar;
	}
	function tracker(){
		$ip=$_SERVER['REMOTE_ADDR'];
		$httpReferer=$_SERVER['HTTP_REFERER'];
		$httpUserAgent=$_SERVER['HTTP_USER_AGENT'];
		$pageName=$view;
		$queryString=$_SERVER['QUERY_STRING'];
		$currentPage=$view.'/'.$show;
		$bot=is_bot();
		$browser=getBrowser();
		$ti=time();
		if($view==''){$view='index';}
		if($act!='logout'){
			if(isset($_SESSION['tracker'])){
				$vid=isset($_SESSION['vid'])?$_SESSION['vid']:0;
				if($_SESSION['currentPage']!=$current_page){
					$q=$db->prepare("INSERT INTO tracker (vid,contentType,ip,pageName,queryString,httpReferer,httpUserAgent,bot,browser,os,ti) VALUES (:vid,:contentType,:ip,:pageName,:queryString,:httpReferer,:httpUserAgent,:bot,:browser,:os,:ti)");
					$q->execute(array(':vid'=>$vid,':contentType'=>$view,':ip'=>$ip,':pageName'=>$pageName,':queryString'=>$queryString,':httpReferer'=>$httpReferer,':httpUserAgent'=>$httpUserAgent,':bot'=>$bot,':browser'=>$browser['name'],':os'=>$browser['platform'],':ti'=>$ti));
					$_SESSION['currentPage']=$currentPage;
				}
			}else{
				$q=$db->prepare("INSERT INTO tracker (vid,contentType,ip,pageName,queryString,httpReferer,httpUserAgent,bot,browser,os,ti) VALUES (:vid,:contentType,:ip,:pageName,:queryString,:httpReferer,:httpUserAgent,:bot,:browser,:os,:ti)");
				$q->execute(array(':vid'=>$vid,':contentType'=>$view,':ip'=>$ip,':pageName'=>$pageName,':query_string'=>$queryString,':httpReferer'=>$httpReferer,':httpUserAgent'=>$httpUserAgent,':bot'=>$bot,':browser'=>$browser['name'],':os'=>$browser['platform'],':ti'=>$ti));
				$e=$db->errorInfo();
				if(!is_null($e[2])){
					$_SESSION['tracker']=false;
				}else{
					$_SESSION['tracker']=true;
					$lid=$db->lastInsertId();
					$lr=$db->query("SELECT MAX(vid) as next FROM tracker")->fetch(PDO::FETCH_ASSOC);
					$l=$lr['next'];
					if(!isset($l))
						$l=1;
					else
						$l++;
					$q=$db->prepare("UPDATE tracker SET vid=:vid WHERE id=:id");
					$q->execute(array(':vid'=>$l,':id'=>$lid));
					$_SESSION['vid']=$l;
					$_SESSION['currentPage']=$currentPage;
				}
			}
		}
		function is_bot(){
			$botlist=array(
				"Teoma",			"alexa",			"froogle",				"Gigabot",
				"inktomi",			"looksmart",		"URL_Spider_SQL",		"Firefly",
				"NationalDirectory","Ask Jeeves",		"TECNOSEEK",			"InfoSeek",
				"WebFindBot",		"girafabot",		"crawler",				"www.galaxy.com",
				"Googlebot",		"Scooter",			"Slurp",				"msnbot",
				"appie",			"FAST",				"WebBug",				"Spade",
				"ZyBorg",			"rabaz",			"Baiduspider",			"Feedfetcher-Google",
				"TechnoratiSnoop",	"Rankivabot",		"Mediapartners-Google",	"Sogou web spider",
				"WebAlta Crawler",	"TweetmemeBot",		"Butterfly",			"Twitturls",
				"Me.dium",			"Twiceler"
			);
			foreach($botlist as$bot){
				if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false){return$bot;}
			}
			return'visitor';
		}
		function getBrowser(){
			$uagent=$_SERVER['HTTP_USER_AGENT'];
			$bname='Unknown';
			$platform='Unknown';
			$version="";
			if(preg_match('/linux/i',$uagent))
				$platform='linux';
			elseif(preg_match('/macintosh|mac os x/i',$uagent))
				$platform='apple';
			elseif(preg_match('/windows|win32/i',$uagent))
				$platform='windows';
			if(preg_match('/MSIE/i',$uagent)&&!preg_match('/Opera/i',$uagent)){
				$bname='Explorer';
				$ub="MSIE";
			}elseif(preg_match('/Firefox/i',$uagent)){
				$bname='Firefox';
				$ub="Firefox";
			}elseif(preg_match('/Chrome/i',$uagent)){
				$bname='Chrome';
				$ub="Chrome";
			}elseif(preg_match('/Safari/i',$uagent)){
				$bname='Safari';
				$ub="Safari";
			}elseif(preg_match('/Opera/i',$uagent)){
				$bname='Opera';
				$ub="Opera";
			}elseif(preg_match('/Netscape/i',$uagent)){
				$bname='Netscape';
				$ub="Netscape";
			}
			$known=array('Version',$ub,'other');
			$pattern='#(?<browser>'.join('|',$known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if(!preg_match_all($pattern,$uagent,$matches)){}
			$i=count($matches['browser']);
			if($i!=1){
				if(strripos($uagent,"Version")<strripos($uagent,$ub))
					$version=$matches['version'][0];
				else
					$version=$matches['version'][1];
			}else
				$version=$matches['version'][0];
			if($version==null||$version==""){$version="?";}
			return array(
				'userAgent'=>$uagent,	'name'=>$bname,		'version'=>$version,
				'platform'=>$platform,	'pattern'=>$pattern
			);
		}
	}
	function article($args=false){
		$view='article';
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
	function events($args=false){
		$view='events';
		require'process.php';
	}
	function error($args=false){
		$view='error';
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
		require'login.php';
		$view='index';
		require'process.php';
	}
	function news($args=false){
		$view='news';
		require'process.php';
	}
	function portfolio($args=false){
		$view='portfolio';
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
	function services($args=false){
		$view='services';
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
	function testimonials($args=false){
		$view='testimonials';
		require'process.php';
	}
	function tos($args=false){
		$view='tos';
		require'process.php';
	}
}
/* Router */
$routes=array(
	'error'				=>	array('front','error'),
	''					=>	array('front','index'),
	'index'				=>	array('front','index'),
	'article'			=>	array('front','article'),
	'portfolio'			=>	array('front','portfolio'),
	'bookings'			=>	array('front','bookings'),
	'events'			=>	array('front','events'),
	'news'				=>	array('front','news'),
	'testimonials'		=>	array('front','testimonials'),
	'inventory'			=>	array('front','inventory'),
	'services'			=>	array('front','services'),
	'gallery'			=>	array('front','gallery'),
	'contactus'			=>	array('front','contactus'),
	'cart'				=>	array('front','cart'),
	'sitemap'			=>	array('front','sitemap'),
	'tos'				=>	array('front','tos'),
	'login'				=>	array('front','login'),
	'logout'			=>	array('front','logout'),
	'proofs'			=>	array('front','proofs'),
	'search'			=>	array('front','search'),
	'sitemap'			=>	array('front','sitemap'),
	'settings'			=>	array('front','settings'),
	'admin/add'			=>	array('admin','add'),
	'admin/accounts'	=>	array('admin','accounts'),
	'admin/bookings'	=>	array('admin','bookings'),
	'admin/content'		=>	array('admin','content'),
	'admin/article'		=>	array('admin','article'),
	'admin/portfolio'	=>	array('admin','portfolio'),
	'admin/events'		=>	array('admin','events'),
	'admin/news'		=>	array('admin','news'),
	'admin/testimonials'=>	array('admin','testimonials'),
	'admin/inventory'	=>	array('admin','inventory'),
	'admin/services'	=>	array('admin','services'),
	'admin/gallery'		=>	array('admin','gallery'),
	'admin/proofs'		=>	array('admin','proofs'),
	'admin/media'		=>	array('admin','media'),
	'admin/messages'	=>	array('admin','messages'),
	'admin/orders'		=>	array('admin','orders'),
	'admin/pages'		=>	array('admin','pages'),
	'admin/preferences'	=>	array('admin','preferences'),
	'admin/proofs'		=>	array('admin','proofs'),
	'admin/search'		=>	array('admin','search'),
	'admin/statistics'	=>	array('admin','statistics'),
	'admin'				=>	array('admin','statistics'),
	'sitemap.xml'		=>	array('internal','sitemap'),
	'robots.txt'		=>	array('internal','robots'),
	'rss'				=>	array('internal','rss')
);
$route=new router();
$route->setRoutes($routes);
$route->routeURL(preg_replace("|/$|","",filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)));
function minify($txt){
	return preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'),array(' ',''),$txt);
}
class router{
	protected $route_match=false;
	protected $route_call=false;
	protected $route_call_args=false;
	protected $routes=array();
	public function __construct(){
	
	}
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
		foreach($this->routes as $path=>$call){
			if(empty($path)){
				continue;
			}
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
			$call_obj=new $call[0]();
			$call_obj->$call[1]($this->route_call_args);
		}else{
			$call($this->route_call_args);
		}
	}
}
