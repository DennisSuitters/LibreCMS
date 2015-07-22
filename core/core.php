<?php
require_once'core/db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
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
		return$config;
	}
	function humans($args=false){
		require'core/humans.php';
	}
	function sitemap($args=false){
		require'core/sitemap.php';
	}
	function robots($args=false){
		require'core/robots.php';
	}
	function rss($args=false){
		require'core/rss.php';
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
			$favicon='core/images/favicon.png';
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
		$favicon='core/images/favicon.png';
		return $favicon;
	}
	function noimage(){
		$noimage='core/images/noimage.jpg';
		return $noimage;
	}
	function noavatar(){
		$noavatar='core/images/noavatar.jpg';
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
	function timeline($args=false){
		$view='timeline';
		require'admin.php';
	}
}
class front{
	function getconfig($db){
		$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
		return$config;
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
			$favicon='core/images/favicon.png';
		}
		return$favicon;
	}
	function noimage(){
		if(file_exists(THEME.'/images/noimage.png')){
			$noimage=THEME.'/images/noimage.png';
		}elseif(file_exists(THEME.'/images/noimage.gif')){
			$noimage=THEME.'/images/noimage.gif';
		}elseif(file_exists(THEME.'/images/noimage.jpg')){
			$noimage=THEME.'/images/noimage.jpg';
		}else{
			$noimage='core/images/noimage.jpg';
		}
		return$noimage;
	}
	function noavatar(){
		if(file_exists(THEME.'/images/noavatar.png')){
			$noavatar=THEME.'/images/noavatar.png';
		}elseif(file_exists(THEME.'/images/noavatar.gif')){
			$noavatar=THEME.'/images/noavatar.gif';
		}elseif(file_exists(THEME.'/images/noavatar.jpg')){
			$noavatar=THEME.'/images/noavatar.jpg';
		}else{
			$noavatar='core/images/noavatar.jpg';
		}
		return$noavatar;
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
$route=new router();
$route->setRoutes(
	array(
		'error'				=>array('front','error'),
		''					=>array('front','index'),
		'index'				=>array('front','index'),
		'article'			=>array('front','article'),
		'portfolio'			=>array('front','portfolio'),
		'bookings'			=>array('front','bookings'),
		'events'			=>array('front','events'),
		'news'				=>array('front','news'),
		'testimonials'		=>array('front','testimonials'),
		'inventory'			=>array('front','inventory'),
		'services'			=>array('front','services'),
		'gallery'			=>array('front','gallery'),
		'contactus'			=>array('front','contactus'),
		'cart'				=>array('front','cart'),
		'sitemap'			=>array('front','sitemap'),
		'tos'				=>array('front','tos'),
		'login'				=>array('front','login'),
		'logout'			=>array('front','logout'),
		'proofs'			=>array('front','proofs'),
		'search'			=>array('front','search'),
		'sitemap'			=>array('front','sitemap'),
		'settings'			=>array('front','settings'),
		'admin/add'			=>array('admin','add'),
		'admin/accounts'	=>array('admin','accounts'),
		'admin/bookings'	=>array('admin','bookings'),
		'admin/content'		=>array('admin','content'),
		'admin/article'		=>array('admin','article'),
		'admin/portfolio'	=>array('admin','portfolio'),
		'admin/events'		=>array('admin','events'),
		'admin/news'		=>array('admin','news'),
		'admin/testimonials'=>array('admin','testimonials'),
		'admin/inventory'	=>array('admin','inventory'),
		'admin/services'	=>array('admin','services'),
		'admin/gallery'		=>array('admin','gallery'),
		'admin/proofs'		=>array('admin','proofs'),
		'admin/media'		=>array('admin','media'),
		'admin/messages'	=>array('admin','messages'),
		'admin/orders'		=>array('admin','orders'),
		'admin/pages'		=>array('admin','pages'),
		'admin/preferences'	=>array('admin','preferences'),
		'admin/proofs'		=>array('admin','proofs'),
		'admin/search'		=>array('admin','search'),
		'admin/statistics'	=>array('admin','statistics'),
		'admin/timeline'	=>array('admin','timeline'),
		'admin'				=>array('admin','timeline'),
		'humans.txt'		=>array('internal','humans'),
		'sitemap.xml'		=>array('internal','sitemap'),
		'robots.txt'		=>array('internal','robots'),
		'rss'				=>array('internal','rss')
	));
$route->routeURL(preg_replace("|/$|","",filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)));
function minify($txt){
	return preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'),array(' ',''),$txt);
}
function _ago($time){
	$toTime=time();
	$fromTime=$time;
	$timeDiff=floor(abs($toTime-$fromTime)/60);
	if($timeDiff<2)$timeDiff="Just now";
	elseif($timeDiff>2&&$timeDiff<60)$timeDiff=floor(abs($timeDiff))." minutes ago";
	elseif($timeDiff>60&&$timeDiff<120)$timeDiff=floor(abs($timeDiff/60))." hour ago";
	elseif($timeDiff<1440)$timeDiff=floor(abs($timeDiff/60))." hours ago";
	elseif($timeDiff>1440&& $timeDiff<2880)$timeDiff=floor(abs($timeDiff/1440))." day ago";
	elseif($timeDiff>2880)$timeDiff=floor(abs($timeDiff/1440))." days ago";
	return$timeDiff;
}
class router{
	protected$route_match=false;
	protected$route_call=false;
	protected$route_call_args=false;
	protected$routes=array();
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
