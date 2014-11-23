<?php
$routes=array(
	'error'				=>	array('p_ublic','error'),
	''					=>	array('p_ublic','index'),
	'index'				=>	array('p_ublic','index'),
	'article'			=>	array('p_ublic','article'),
	'portfolio'			=>	array('p_ublic','portfolio'),
	'bookings'			=>	array('p_ublic','bookings'),
	'events'			=>	array('p_ublic','events'),
	'news'				=>	array('p_ublic','news'),
	'testimonials'		=>	array('p_ublic','testimonials'),
	'inventory'			=>	array('p_ublic','inventory'),
	'services'			=>	array('p_ublic','services'),
	'gallery'			=>	array('p_ublic','gallery'),
	'contactus'			=>	array('p_ublic','contactus'),
	'cart'				=>	array('p_ublic','cart'),
	'sitemap'			=>	array('p_ublic','sitemap'),
	'tos'				=>	array('p_ublic','tos'),
	'login'				=>	array('p_ublic','login'),
	'logout'			=>	array('p_ublic','logout'),
	'orders'			=>	array('p_ublic','orders'),
	'proofs'			=>	array('p_ublic','proofs'),
	'search'			=>	array('p_ublic','search'),
	'sitemap'			=>	array('p_ublic','sitemap'),
	'settings'			=>	array('p_ublic','settings'),
	'admin/messages'	=>	array('p_ublic','messages'),
	'admin/orders'		=>	array('p_ublic','orders'),
	'admin/media'		=>	array('p_ublic','media'),
	'admin/accounts'	=>	array('p_ublic','accounts'),
	'admin/proofs'		=>	array('p_ublic','proofs'),
	'admin/preferences'	=>	array('p_ublic','preferences'),
	'sitemap.xml'		=>	array('internal','sitemap'),
	'robots.txt'		=>	array('internal','robots'),
	'rss'				=>	array('internal','rss')
);
$route=new libr8_router();
$route->setRoutes($routes);
$route->routeURL(preg_replace("|/$|","",filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)));
function minify($txt){
	return preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'),array(' ',''),$txt);
}
class libr8_router{
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
